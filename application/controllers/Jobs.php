<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller
{
  protected $metadata = array(
    'title' => null,
    'description' => 'Weelancer is an online job finding platform that helps employers find the right people for their company.'
  );

  public function __construct() {
    parent::__construct();
    $this->load->model('jobs_model');
    $this->load->model('companies_model');
  }

  // Jobs list Page
  public function jobslist() {
    $this->metadata['title'] = 'Browse Jobs';

    $json_data = file_get_contents(base_url('categories.json'));
    $data['categories'] = json_decode($json_data, TRUE);

    $address = $this->input->get('address');
    $lat = $this->input->get('lat');
    $long = $this->input->get('lng');
    $max = $this->input->get('max');
    $search = $this->input->get('search');
    $category = $this->input->get('category');
    $types = str_replace("_", " ", $this->input->get('type'));
    $sort = $this->input->get('sort');
    $per_page = $this->input->get('per_page') ?? 1;
    $limit = 5; // CAUTION! This is the number of jobs showing in each page

    if(!empty($lat) && !empty($long)) {
      $lat_rad = deg2rad($lat);
      $long_rad = deg2rad($long);

      /*if(empty($max)) {\
        $max = 50;
      } */
    } else {
      $lat_rad = NULL;
      $long_rad = NULL;
      //$max = NULL;
    }

    if($category == 'all')
      $category = '';

    if(!empty($types))
      for($i=0; $i<sizeof($types); $i++)
        $types[$i] = ucwords($types[$i]);

    if(empty($sort))
      $sort = "desc";

    $data['filters'] = array(
      'address' => $address,
      'lat' => $lat,
      'long' => $long,
      'lat_rad' => $lat_rad,
      'long_rad' => $long_rad,
      'max' => $max,
      'search' => $search,
      'category' => $category,
      'type' => $types,
      'sort' => $sort,
    );
    
    $total_rows = $this->jobs_model->filtered_jobs($data['filters']);

    $data['filters']['per_page'] = $per_page;
    $data['filters']['limit'] = $limit;

    $data['jobs'] = $this->jobs_model->filtered_jobs($data['filters']);

    $data['pagination'] = $this->joblist_pagination($total_rows, $limit);
    
    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/jobs/jobs-list', $data);
    $this->load->view('public/includes/footer');
  }

  // Job list pagination
  public function joblist_pagination($total_rows, $limit) {
    $this->load->library('pagination');

    $config = array(
      'base_url' => site_url('jobs/jobslist'),
      'reuse_query_string' => TRUE,
      'use_page_numbers' => TRUE,
      'enable_query_strings' => TRUE,
      'page_query_string' => TRUE, //http://example.com/index.php?c=test&m=page&per_page=20
      'uri_segment' => 3,
      'per_page' => $limit,
      'total_rows' => $total_rows,

      'num_tag_open' => '<li>',
      'num_tag_close' => '</li>',

      'cur_tag_open' => '<li class="active"><a href="">',
      'cur_tag_close' => '</a></li>',

      'prev_link' => '<i class="fa fa-angle-left" title="Previous Page"></i>',
      'prev_tag_open' => '<li>',
      'prev_tag_close' => '</li>',

      'next_link' => '<i class="fa fa-angle-right" title="Next Page"></i>',
      'next_tag_open' => '<li>',
      'next_tag_close' => '</li>',

      'first_link' => '<i class="fa fa-angle-double-left" title="First"></i>',
      'first_tag_open' => '<li>',
      'first_tag_close' => '</li>',
      
      'last_link' => '<i class="fa fa-angle-double-right" title="Last"></i>',
      'last_tag_open' => '<li>',
      'last_tag_close' => '</li>'  
    );

    $this->pagination->initialize($config);

    return $this->pagination->create_links();
  }

  // Job details Page
  public function details($id) {
    $job = $this->jobs_model->search($id);

    if(is_null($job)) {
      redirect('jobs/jobslist');
    }

    $this->metadata['title'] = $job['job'].' - '.$job['company'];

    // Αύξηση του view counter
    $views = $job['views'] + 1;
    $job_to_update = array(
      'id' => $job['id'],
      'views' => $views
    );
    
    $this->jobs_model->update_views($job_to_update);
    $updated_job = $this->jobs_model->search($id); 

    $data = array(
      "job_id" => $updated_job['id'],
      "user_id" => $this->session->userdata('user_id')
    );

    $updated_job['application'] = $this->jobs_model->check_application($data); 
    $updated_job['total_applications'] = $this->jobs_model->num_job_applications($data['job_id']);

    // Έλεγχος στοιχείων χρήστη Quick Contact
    $this->form_validation->set_rules('username', 'Name', 'required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('email', 'Email Address', 'required|min_length[5]|max_length[100]|valid_email');
    $this->form_validation->set_rules('message', 'Message', 'required|min_length[2]');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του χρήστη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/jobs/job-details', $updated_job);
      $this->load->view('public/includes/footer');
    } else {
      $contact_data = array(
        'job' => $updated_job['job'],
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'message' => $this->input->post('message')
      );

      $this->job_quick_contact($contact_data, $updated_job);
      redirect('jobs/details/'.$updated_job['id']);
    }
  }

  // Job Quick Contact Form Email
  public function job_quick_contact($contact_data, $updated_job) {
    $email = $this->load->view('public/emails/job_quick_contact', $contact_data, TRUE);

    $this->load->library('email');

    $this->email->from($contact_data['email'], $contact_data['username']);
    $this->email->to($updated_job['email']);
    $this->email->subject('Weelancer - Quick Contact - '.$updated_job['job']);
    $this->email->message($email);

    // Έλεγχος αν έγινε η αποστολή του email
    if($this->email->send()) {
      $this->session->set_flashdata('status', 'The message has been sent!'); 
    } else {
      $this->session->set_flashdata('status', 'Error...The message has not been sent!'); 
    }
  }

  // Αίτηση σε δουλεία
  public function do_application($id) {
    // Έλεγχος αν ο χρήστης έχει κάνει login
    if(!$this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('users/login');
    }

    $job = $this->jobs_model->search($id);

    if(is_null($job)) {
      redirect('jobs/jobslist');
    }

    $data = array(
      "job_id" => $job['id'],
      "user_id" => $this->session->userdata('user_id')
    );


    if($this->jobs_model->do_application($data) == "success") {
      //$this->session->set_flashdata('success', "Successful application.");
    } else {
      //$this->session->set_flashdata('error', "Unsuccessful application."); 
    }

    redirect('jobs/details/'.$job['id']);  
  }

  // Ακύρωηση αίτησης δουλειάς
  public function undo_application($id) {
    // Έλεγχος αν ο χρήστης έχει κάνει login
    if(!$this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('users/login');
    }

    $job = $this->jobs_model->search($id);

    if(is_null($job)) {
      redirect('jobs/jobslist');
    }

    $data = array(
      "job_id" => $job['id'],
      "user_id" => $this->session->userdata('user_id')
    );


    $this->jobs_model->undo_application($data);

    redirect('jobs/details/'.$job['id']);  
  }

  // Company details Page
  public function company($id) {
    $company = $this->companies_model->search($id);
    $jobs = $this->jobs_model->company_jobs($id); 
    $total_jobs = count($jobs);

    if(is_null($company)) {
      redirect('/');
    }

    $this->metadata['title'] = $company['title'];

    $data = array(
      'company' => $company, 
      'jobs' => $jobs, 
       'total_jobs' => $total_jobs
    ); 

    // Έλεγχος στοιχείων χρήστη Quick Contact
    $this->form_validation->set_rules('username', 'Name', 'required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('email', 'Email Address', 'required|min_length[5]|max_length[100]|valid_email');
    $this->form_validation->set_rules('message', 'Message', 'required|min_length[2]');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του χρήστη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/jobs/company-profile', $data);
      $this->load->view('public/includes/footer');
    } else {
      $contact_data = array(
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'message' => $this->input->post('message')
      );

      $this->company_quick_contact($contact_data, $company);
      redirect('jobs/company/'.$company['id']);
    }
  }

  // Company Quick Contact Form Email
  public function company_quick_contact($contact_data, $company) {
    $email = $this->load->view('public/emails/company_quick_contact', $contact_data, TRUE);

    $this->load->library('email');

    $this->email->from($contact_data['email'], $contact_data['username']);
    $this->email->to($company['email']);
    $this->email->subject('Weelancer - Quick Contact');
    $this->email->message($email);

    // Έλεγχος αν έγινε η αποστολή του email
    if($this->email->send()) {
      $this->session->set_flashdata('status', 'The message has been sent!'); 
    } else {
      $this->session->set_flashdata('status', 'Error...The message has not been sent!'); 
    }
  }

  public function alert() {
    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/pages/alert');
    $this->load->view('public/includes/footer');
  }

}
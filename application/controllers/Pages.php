<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Κλάση για απλές σελίδες όπως η αρχική
class Pages extends CI_Controller {
  protected $metadata = array(
    'title' => null,
    'description' => 'Weelancer is an online job finding platform that helps employers find the right people for their company.'
  );

  // Home Page
  public function index() {
    // 404 σφάλμα όταν το view δεν υπάρχει
    if(!file_exists('application/views/public/pages/index.php'))
      show_404();

    $this->metadata['title'] = 'Weelancer';

    $this->load->model('jobs_model');

    $data['total_jobs'] = $this->jobs_model->total_jobs_number();

    $this->load->view('public/includes/header_home', $this->metadata);
    $this->load->view('public/pages/index', $data);
    $this->load->view('public/includes/footer');
  }

  // Contact Us Page
  public function contact() {
    $this->metadata['title'] = 'Contact Us';

    // Έλεγχος στοιχείων χρήστη
    $this->form_validation->set_rules('username', 'Name', 'required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('email', 'Email Address', 'required|min_length[5]|max_length[100]|valid_email');
    $this->form_validation->set_rules('subject', 'Subject', 'required|min_length[2]|max_length[50]');
    $this->form_validation->set_rules('message', 'Message', 'required|min_length[2]');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του χρήστη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/pages/contact');
      $this->load->view('public/includes/footer');
    } else {
      $data = array(
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'subject' => $this->input->post('subject'),
        'message' => $this->input->post('message')
      );

      $this->message_email($data);
      redirect('contact');
    }
  }

  // Αποστολή email με το μήνυμα του χρήστη
  public function message_email($data) {
    $message = $this->load->view('public/emails/contact_message', $data, TRUE);
    
    $this->load->library('email');

    $this->email->from($data['email'], $data['username']);
    $this->email->to('info@weelancer.com');
    $this->email->subject($data['subject']);
    $this->email->message($message);

    // Έλεγχος αν έγινε η αποστολή του email
    if($this->email->send()) {
      $this->session->set_flashdata('status', "The message has been sent!"); 
    } else {
      $this->session->set_flashdata('status', "Error...The message has not been sent!"); 
    }
  }

  // About Us Page
  public function about() {
    // 404 σφάλμα όταν το view δεν υπάρχει
    if(!file_exists('application/views/public/pages/about.php'))
      show_404();

    $this->metadata['title'] = 'About Us';

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/pages/about');
    $this->load->view('public/includes/footer');
  }
  
  public function alert() {
      // 404 σφάλμα όταν το view δεν υπάρχει
      if(!file_exists('application/views/public/pages/alert.php'))
          show_404();

      $this->metadata['title'] = 'Alert';

      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/pages/alert');
      $this->load->view('public/includes/footer');
  }
}
<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Employers extends CI_Controller {
  protected $metadata = array(
    'title' => null,
    'description' => 'Weelancer is an online job finding platform that helps employers find the right people for their company.'
  );

  public function __construct() {
    parent::__construct();
    $this->load->model('companies_model');
    $this->load->model('employers_model');
    $this->load->model('jobs_model');
  }

  // ##########################################################################
  // ##################### SIGN UP AND ACTIVATION (EMAIL) #####################
  // ##########################################################################

  // Εγγραφή Εργοδότη
  public function signup() {
    $this->metadata['title'] = 'Sign Up Company';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if($this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You are already connected!"); 
      redirect('/');
    }

    $currentYear = date("Y");
    $json_data = file_get_contents(base_url('categories.json'));
    $categoriesArray = json_decode($json_data, true);
    $data = array(
      'categories' => $categoriesArray
    );

    // Έλεγχος στοιχείων εταιρείας
    $this->form_validation->set_rules('image', 'Image', 'callback_check_image');
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[2]|max_length[100]');
    $this->form_validation->set_rules('category', 'Category', 'required|callback_check_category');
    $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_email');
    $this->form_validation->set_rules('phone', 'Phone', 'numeric');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('start', 'Start year', 'required|integer|greater_than[1870]|less_than_equal_to['.$currentYear.']');
    $this->form_validation->set_rules('description', 'Description', 'min_length[2]');
    $this->form_validation->set_rules('facebook', 'Facebook', 'valid_url');
    $this->form_validation->set_rules('linkedin', 'Linkedin', 'valid_url');
    $this->form_validation->set_rules('website', 'Website', 'valid_url');
    $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('employer_email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_employer_email');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[100]');
    $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

    // Έλεγχος αν πέτυχε το validation των στοιχείων της εταιριας
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/employers/signup_company', $data);
      $this->load->view('public/includes/footer');
    } else {
      $company = array(
        'title' => $this->input->post('title'),
        'category' => $this->input->post('category'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'address' => $this->input->post('address'),
        'start' => $this->input->post('start'),
        'description' => $this->input->post('description'),
        'facebook' => $this->input->post('facebook'),
        'linkedin' => $this->input->post('linkedin'),
        'website' => $this->input->post('website'),
        'lat' => $this->input->post('lat'),
        'long' => $this->input->post('lng')
      );

      if(isset($_FILES['image']['name']) && $_FILES['image']['name']!="" && $_FILES['image']['size'] != 0) {
        $config['upload_path']          = './assets/img/uploads/companies/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 512;
        $config['max_width']            = 1000;
        $config['max_height']           = 1000;
        $config['overwrite']            = FALSE;
        $config['encrypt_name']         = TRUE;

        $this->load->library('upload', $config);

        if($this->upload->do_upload('image')) {
          $image = $this->upload->data();
        } else {
          $this->session->set_flashdata('error', "Error uploading your image!"); 
          $this->load->view('public/includes/header', $this->metadata);
          $this->load->view('public/pages/alert');
          $this->load->view('public/includes/footer');  
          die(); 
        }
        
        $company['image'] = 'assets/img/uploads/companies/'.$image['file_name'];
      } 

      $resultCompany = $this->companies_model->add($company);

      $employer = array(
        'username' => $this->input->post('username'),
        'company_id' => $resultCompany['comany_id'],
        'email' => $this->input->post('employer_email'),
        'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost' => 10)),
        'hash' => md5(rand(0, 100)),
        'profession' => 'Boss'
      );

      $resultEmployer = $this->employers_model->add($employer);

      if($resultCompany['message'] === 'error' || $resultEmployer === 'error') {
        $this->session->set_flashdata('error', "There was an error with your sign up!"); 
        redirect('employers/signup');
      } else if($resultCompany['message'] === 'success' && $resultEmployer === 'success') {
        $this->activation_email($company, $employer);

        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/employers/activation');
        $this->load->view('public/includes/footer');    
      }
    }
  }

  // Sign up validation rule για το category της εταιρείας 
  public function check_category($category) {
    $json_data = file_get_contents(base_url('categories.json'));
    $categoriesArray = json_decode($json_data, true);
    $categoriesString = "";
    $numberOfCategories = count($categoriesArray);
    $i = 0;

    foreach($categoriesArray as $categoryArray) {
      if(++$i === $numberOfCategories)
        $categoriesString .= $categoryArray;
      else
        $categoriesString .= $categoryArray.", ";
    }

    $this->form_validation->set_message('check_category', 'The <b>{field}</b> must be one of: '.$categoriesString);

    foreach($categoriesArray as $categoryArray)
      if($category == $categoryArray)
        return TRUE;

    return FALSE;
  }

  // Sign up validation rule για το email της εταιρείας 
  public function check_email($email) {
    $this->form_validation->set_message('check_email', 'This <b>{field}</b> already exists. Please use a different one!');

    if($this->companies_model->check_email($email)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  // Sign up validation rule για το email του εργοδότη 
  public function check_employer_email($email) {
    $this->form_validation->set_message('check_employer_email', 'This <b>{field}</b> already exists. Please use a different one!');

    if($this->employers_model->check_email($email)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  // Αποστολή email στο χρήστη για ενεργοποίηση λογαριασμού
  public function activation_email($company, $employer) {
    $data = array(
      'employer' => $employer,
      'company' => $company,
      'year' => date("Y")
    );

    $message = $this->load->view('public/emails/employer_activation', $data, TRUE);
    
    $this->load->library('email');

    $this->email->from('info@weelancer.com', 'Weelancer');
    $this->email->to($employer['email']);
    $this->email->cc($company['email']);
    $this->email->subject('Account Activation');
    $this->email->message($message);

    // Έλεγχος αν έγινε η αποστολή του email
    if($this->email->send()) {
      $this->session->set_flashdata('success_active', "You have successfully created your account.<br>An email has been sent to you, to activate your account!"); 
    } else {
      $this->session->set_flashdata('error_active', "You have successfully created your account.<br>Unfortunately there was a problem sending you the activation email!"); 
    }
  }

  // Μήνυμα ενεργοποίησης λογαριασμού μέσω του link που στάλθηκε σε email στον εργοδότη
  public function activation() {
    $this->metadata['title'] = 'Account Activation';

    $employer = array(
      'email' => $this->input->get('email'),
      'hash' => $this->input->get('hash')
    );

    // Έλεγχος αν στο url υπάρχει email και hash χρήστη
    // Αν δεν υπάρχουν να μην υπάρχει πρόσβαση στη μέθοδο
    if($employer['email'] !== NULL && $employer['hash'] !== NULL) {
      $employerDB = $this->employers_model->search_by_email($employer['email']);

      // Έλεγχος αν υπάρχει το email στη Βάση Δεδομένων
      // Έλεγχος αν το hash που υπάρχει στο url είναι ίδιο με το hash της Βάσης Δεδομένων
      if(is_null($employerDB)) {
        redirect('/');
      } else if($employer['hash'] == $employerDB['hash']) {
        $result = $this->employers_model->activation($employer);

        if($result === 'success') {
          $this->session->set_flashdata('success_active', "The activation of your account was successful.<br>You can now login!"); 
        } else if($result === 'error') {
          $this->session->set_flashdata('error_active', "Your account is already activated.<br>You can now login!"); 
        }
      } else {
        redirect('/');
      }
    } else {
      redirect('/');
    }

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/employers/activation');
    $this->load->view('public/includes/footer');
  }

  // #########################################################################
  // ##################### LOGIN AND FORGOT PASS (EMAIL) #####################
  // #########################################################################

  // Σύνδεση Εργοδότη
  public function login() {
    $this->metadata['title'] = 'Login Employer';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if($this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You are already connected!"); 
      redirect('/');
    }

    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του εργοδότη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/employers/login_employer');
      $this->load->view('public/includes/footer');
    } else {
      $employer = array(
        'email' => $this->input->post('email'),
        'password' => $this->input->post('password')
      );

      // Εύρεση στοιχείων χρήστη στη Βάση Δεδομένων
      $result = $this->employers_model->login($employer);

      if($result['message'] === 'success') {
        $user_id = $result['user_id'];
        $this->session->set_userdata('employer_id', $user_id);
        redirect('/');
      } else if($result['message'] === 'error') {
        $this->session->set_flashdata('error', "Credentials are wrong. Try again!"); 
        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/employers/login_employer');
        $this->load->view('public/includes/footer');
      } else if($result['message'] === 'error_active') {
        $this->session->set_flashdata('error', "You have to activate your account!"); 
        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/employers/login_employer');
        $this->load->view('public/includes/footer');
      }
    } 
  }

  // Forgot και reset κωδικού εργοδότη
  public function forgotpass() {

    $employer = array(
      'email' => $this->input->get('email'),
      'hash' => $this->input->get('hash')
    );

    // Αν στο url δεν υπάρχουν το email και το hash του εργοδότη 
    // να του εμφανίσει την σελίδα για να συμπληρώσει το email του
    // Αν υπάρχουν και ειναι σωστά να αλλαζει ο κωδικός του χρήστη
    if($employer['email'] === NULL && $employer['hash'] === NULL) {
      $this->metadata['title'] = 'Forgot Password';

      // Έλεγχος email εργοδότη
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_email_forgot');

      // Έλεγχος αν πέτυχε το validation των στοιχείων του εργοδότη
      if ($this->form_validation->run() === FALSE) {
        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/employers/forgotpass');
        $this->load->view('public/includes/footer');
      } else {
        $email = $this->input->post('email');
        
        $employerDB = $this->employers_model->search_by_email($email);

        $this->forgotpass_email($employerDB);

        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/employers/forgotpass_message');
        $this->load->view('public/includes/footer');
      }
    } else if($employer['email'] !== NULL && $employer['hash'] !== NULL) {
      $employerDB = $this->employers_model->search_by_email($employer['email']);

      // Έλεγχος αν το hash που υπάρχει στο url είναι ίδιο με το hash της Βάσης Δεδομένων
      if($employer['hash'] == $employerDB['hash']) {
        $this->metadata['title'] = 'Reset Password';

        // Παραμετροι url
        $data['url'] = '?email='.$employerDB['email'].'&'.'hash='.$employerDB['hash'];

        // Έλεγχος password χρήστη
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

        // Έλεγχος αν πέτυχε το validation των password
        if ($this->form_validation->run() === FALSE) {
          $this->load->view('public/includes/header', $this->metadata);
          $this->load->view('public/employers/resetpass', $data);
          $this->load->view('public/includes/footer');
        } else {
          $employerDBnewPass = array(
            'id' => $employerDB['id'],
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost' => 10))
          );
        
          // Εισαγωγή password χρήστη στη Βάση Δεδομένων
          $result = $this->employers_model->update($employerDBnewPass);

          if($result === 'success') {
            $this->session->set_flashdata('success', "You successfully changed your password.<br>You can now login!"); 
          } else if($result === 'error') {
            $this->session->set_flashdata('error', "There was an error reseting your password.<br>Try again!"); 
          }

          $this->load->view('public/includes/header', $this->metadata);
          $this->load->view('public/employers/forgotpass_message');
          $this->load->view('public/includes/footer');
        }
      } else {
        redirect('/');
      }
    }
  }

  // Validation Rule για το email του εργοδότη στο forgot pass
  public function check_email_forgot($email) {
    $this->form_validation->set_message('check_email_forgot', 'This <b>{field}</b> doesn&apos;t exists.');

    if($this->employers_model->check_email($email)) {
      return false;
    } else {
      return true;
    }
  }

  // Αποστολή email στο χρήστη για επαναφορά κωδικού
  public function forgotpass_email($employer) {
    $data = array(
      'employer' => $employer,
      'year' => date("Y")
    );

    $message = $this->load->view('public/emails/employer_forgotpass', $data, TRUE);
    
    $this->load->library('email');

    $this->email->from('info@weelancer.com', 'Weelancer');
    $this->email->to($employer['email']);
    $this->email->subject('Password Reset');
    $this->email->message($message);

    // Έλεγχος αν έγινε η αποστολή του email
    if($this->email->send()) {
      $this->session->set_flashdata('success', "A password reset email was to your email address.<br>Please click the link in that email to reset your password!"); 
    } else {
      $this->session->set_flashdata('error', "There was a problem senting you the password reset email.<br>Try again!"); 
    }
  }

  // ##################################################
  // ##################### LOGOUT #####################
  // ##################################################

  // Αποσύνδεση Εργοδότη
  public function logout() {
    $this->metadata['title'] = 'Logout';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if($this->session->userdata('employer_id')) {
      $this->session->unset_userdata('employer_id');
      redirect('employers/login');
    } else {
      redirect('/');
    }
  }

  // #################################################
  // ###################### ... ######################
  // #################################################

  // Employer Dashboard
  public function dashboard() {
    $this->metadata['title'] = 'Dashboard';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $employer = $this->employers_model->search($this->session->userdata('employer_id'));
    $company = $this->companies_model->search($employer['company_id']);

    $data['company'] = $company;
    $data['employer'] = $employer;
    $data['company']['posted_jobs'] = $this->jobs_model->company_posted_jobs($company['id']);
    $data['company']['jobs_views'] = $this->jobs_model->company_jobs_views($company['id'])->views;
    $data['company']['total_employers'] = count($this->employers_model->select_company($company['id']));
    $data['employer']['approves'] = $this->jobs_model->company_applications_approved($company['id']);
    $data['employer']['rejections'] = $this->jobs_model->company_applications_rejected($company['id']);
    $data['employer']['pending'] = $this->jobs_model->company_applications_pending($company['id']);
    $data['employer']['total'] = $data['employer']['pending'] + $data['employer']['approves'] + $data['employer']['rejections'];

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/includes/employer_menu', $this->metadata);
    $this->load->view('public/employers/dashboard', $data);
    $this->load->view('public/includes/footer');
  }

  // Delete company και employers
  public function deletecompany() {
    $this->metadata['title'] = 'Delete Account/Company';

    // Έλεγχος αν ο χρήστης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $employer = $this->employers_model->search($this->session->userdata('employer_id'));
    $company = $this->companies_model->search($employer['company_id']);

    $this->employers_model->delete($company['id']);
    $this->session->set_flashdata('success', "Account deleted."); 
    $this->logout();
  }

  // Company Profile
  public function profile() {
    $this->metadata['title'] = 'Company Profile';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $employer = $this->employers_model->search($this->session->userdata('employer_id'));
    $company = $this->companies_model->search($employer['company_id']);
    $currentYear = date("Y");
    $json_data = file_get_contents(base_url('categories.json'));
    $categoriesArray = json_decode($json_data, true);
    $data = array(
      'company' => $company,
      'categories' => $categoriesArray
    );

    $this->form_validation->set_rules('image', 'Image', 'callback_check_image');
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[2]|max_length[100]');
    $this->form_validation->set_rules('category', 'Category', 'required|callback_check_category');
    $this->form_validation->set_rules('phone', 'Phone', 'numeric');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('start', 'Start year', 'required|integer|greater_than[1870]|less_than_equal_to['.$currentYear.']');
    $this->form_validation->set_rules('description', 'Description', 'min_length[2]');
    $this->form_validation->set_rules('facebook', 'Facebook', 'valid_url');
    $this->form_validation->set_rules('linkedin', 'Linkedin', 'valid_url');
    $this->form_validation->set_rules('website', 'Website', 'valid_url');

    if($company['email'] != $this->input->post('email')) {
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_email');
    } else {
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email');
    }

    // Έλεγχος αν πέτυχε το validation των στοιχείων της εταιρείας
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/includes/employer_menu', $this->metadata);
      $this->load->view('public/employers/company-profile', $data);
      $this->load->view('public/includes/footer');
    } else {
      $company_inputs = array(
        'id' => $company['id'],
        'title' => $this->input->post('title'),
        'category' => $this->input->post('category'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'address' => $this->input->post('address'),
        'start' => $this->input->post('start'),
        'description' => $this->input->post('description'),
        'facebook' => $this->input->post('facebook'),
        'linkedin' => $this->input->post('linkedin'),
        'website' => $this->input->post('website'),
        'lat' => $this->input->post('lat'),
        'long' => $this->input->post('lng')
      );

      if(isset($_FILES['image']['name']) && $_FILES['image']['name']!="" && $_FILES['image']['size'] != 0) {
        $config['upload_path']          = './assets/img/uploads/companies/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 512;
        $config['max_width']            = 1000;
        $config['max_height']           = 1000;
        $config['overwrite']            = FALSE;
        $config['encrypt_name']         = TRUE;

        $this->load->library('upload', $config);

        if($this->upload->do_upload('image')) {
          $image = $this->upload->data();
        } else {
          $this->session->set_flashdata('error', "Error uploading your image!"); 
          $this->load->view('public/includes/header', $this->metadata);
          $this->load->view('public/pages/alert');
          $this->load->view('public/includes/footer');  
          die(); 
        }
        
        $company_inputs['image'] = 'assets/img/uploads/companies/'.$image['file_name'];
      } 

      // Update στοιχείων χρήστη στη Βάση Δεδομένων
      if($this->companies_model->update($company_inputs) === 'success') {
        $this->session->set_flashdata('success', "Changes registered."); 
      } else {
        $this->session->set_flashdata('error', "No changes to update."); 
      }
      
      redirect('employers/profile');
    }
  }

  // Validation rule για το image του company
  public function check_image($image) {
    //$this->form_validation->set_message('check_image', 'Max image dimensions: 1000x1000px. Max image size: 512KB. Allowed image types: JPG/PNG.');

    if(!empty($_FILES['image']['name']) || $_FILES['image']['name'] != "" || $_FILES['image']['size'] > 0 ) {
      $file = $_FILES["image"]["tmp_name"];
      $info = getimagesize($file);
      $message = '';
      $flag = TRUE;

      if($info[0] > "1000" || $info[1] > "1000") {
        $message .= 'Max image dimensions: 1000x1000px. ';
        $this->form_validation->set_message('check_image', $message);
        $flag = FALSE;
      }
      
      if(filesize($file) > 512000) {
        $message .= 'Max image size: 512KB. ';
        $this->form_validation->set_message('check_image', $message);
        $flag = FALSE;
      } 

      if($info["mime"] != 'image/jpeg' && $info["mime"] != 'image/jpg' && $info["mime"] != 'image/png') {
        $message .= 'Allowed image types: JPG/PNG. ';
        $this->form_validation->set_message('check_image', $message);
        $flag = FALSE;
      } 

      return $flag;
    } else {
      return TRUE;
    }
  }

  // Post Job
  public function postjob() {
    $this->metadata['title'] = 'Post Job';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $json_data = file_get_contents(base_url('categories.json'));
    $categoriesArray = json_decode($json_data, true);
    $data = array(
      'categories' => $categoriesArray
    );

    $this->form_validation->set_rules('title', 'Title', 'required|min_length[2]|max_length[100]');
    $this->form_validation->set_rules('category', 'Category', 'required|callback_check_category');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('type', 'Type', 'required|callback_check_job_type');
    $this->form_validation->set_rules('salary', 'Salary', 'numeric');
    $this->form_validation->set_rules('description', 'Description', 'min_length[2]');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του job
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/includes/employer_menu', $this->metadata);
      $this->load->view('public/employers/postjob', $data);
      $this->load->view('public/includes/footer');
    } else {
      $employer = $this->employers_model->search($this->session->userdata('employer_id'));
      $company = $this->companies_model->search($employer['company_id']);

      $job = array(
        'company_id' => $company['id'],
        'title' => $this->input->post('title'),
        'category' => $this->input->post('category'),
        'address' => $this->input->post('address'),
        'type' => $this->input->post('type'),
        'description' => $this->input->post('description'),
        'lat' => $this->input->post('lat'),
        'long' => $this->input->post('lng')
      );

      if(!is_null($this->input->post('salary'))) {
        $job['salary'] = $this->input->post('salary');
      }

      // Εισαγωγή στοιχείων χρήστη στη Βάση Δεδομένων
      if($this->jobs_model->add($job) === 'success') {
        $this->session->set_flashdata('success', "Job posted."); 
      } else {
        $this->session->set_flashdata('error', "There was an error posting the job. Try again."); 
      }
      
      redirect('employers/managejobs');
    }
  }

  // Edit Job
  public function editjob($id) {
    $this->metadata['title'] = 'Edit Job';

    $job = $this->jobs_model->search($id);

    if(is_null($job)) {
      redirect('employers/managejobs');
    }

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $json_data = file_get_contents(base_url('categories.json'));
    $categoriesArray = json_decode($json_data, true);
    $data = array(
      'job' => $job,
      'categories' => $categoriesArray
    );

    $this->form_validation->set_rules('title', 'Title', 'required|min_length[2]|max_length[100]');
    $this->form_validation->set_rules('category', 'Category', 'required'); //callback_check_job_category
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('type', 'Type', 'required|callback_check_job_type');
    $this->form_validation->set_rules('salary', 'Salary', 'required|numeric');
    $this->form_validation->set_rules('description', 'Description', 'min_length[2]');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του job
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/includes/employer_menu', $this->metadata);
      $this->load->view('public/employers/editjob', $data);
      $this->load->view('public/includes/footer');
    } else {
      $employer = $this->employers_model->search($this->session->userdata('employer_id'));
      $company = $this->companies_model->search($employer['company_id']);

      $job = array(
        'id' => $id,
        'company_id' => $company['id'],
        'title' => $this->input->post('title'),
        'category' => $this->input->post('category'),
        'address' => $this->input->post('address'),
        'type' => $this->input->post('type'),
        'description' => $this->input->post('description'),
        'lat' => $this->input->post('lat'),
        'long' => $this->input->post('lng')
      );

      if(!is_null($this->input->post('salary'))) {
        $job['salary'] = $this->input->post('salary');
      }

      // Εισαγωγή στοιχείων χρήστη στη Βάση Δεδομένων
      if($this->jobs_model->update($job) === 'success') {
        $this->session->set_flashdata('success', "Job updated."); 
      } else {
        $this->session->set_flashdata('error', "There was an error updating the job. Try again."); 
      }
      
      redirect('employers/managejobs');
    }
  }

  // Job validation rule για το type
  public function check_job_type($type) {
    $this->form_validation->set_message('check_job_type', 'The <b>{field}</b> must be one of: Full Time, Freelance, Part Time, Internship.');

    if($type == "Full Time" || $type == "Freelance" || $type == "Part Time" || $type == "Internship") {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  // Delete jobs
  public function deletejob($id) {
    $this->metadata['title'] = 'Delete Jobs';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $this->jobs_model->delete($id);

    $this->session->set_flashdata('success', "Job deleted."); 
  
    redirect('employers/managejobs');
  }

  // Manage Jobs
  public function managejobs() {
    $this->metadata['title'] = 'Manage Jobs';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $employer = $this->employers_model->search($this->session->userdata('employer_id'));
    $company = $this->companies_model->search($employer['company_id']);
    $data['jobs'] = $this->jobs_model->select_company($company['id']);

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/includes/employer_menu', $this->metadata);
    $this->load->view('public/employers/manage-jobs', $data);
    $this->load->view('public/includes/footer');
  }

  // Manage Candidates
  public function managecandidates($id) {
    $this->metadata['title'] = 'Manage Candidates';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    switch($this->input->get('status', TRUE)) {
      case 'pending': 
        $data['flag'] = 'pending';
        $data['candidates'] = $this->jobs_model->job_applications_pending($id);
        break;
      case 'approved':
        $data['flag'] = 'approved';
        $data['candidates'] = $this->jobs_model->job_applications_approved($id);
        break;
      default:
        redirect('employers/managejobs');
    }

    $data['job_id'] = $id;
    
    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/includes/employer_menu', $this->metadata);
    $this->load->view('public/employers/manage-candidates', $data);
    $this->load->view('public/includes/footer');
  }

  // Approved Candidate - Notification Email
  public function candidate_approval($id) {
    $status = array(
      'state' => 'Approved'
    );

    // Ενημέρωση του status στη Βάση Δεδομένων
    if($this->jobs_model->status_application($id, $status) === 'success') {
      $data = $this->jobs_model->job_application_data($id);
      $data['year'] = date("Y");

      $message = $this->load->view('public/emails/candidate_approval', $data, TRUE);
      
      $this->load->library('email');

      $this->email->from('info@weelancer.com', 'Weelancer');
      $this->email->to($data['email']);
      $this->email->subject('Candidate Approval');
      $this->email->message($message);

      // Έλεγχος αν έγινε η αποστολή του email
      if($this->email->send()) {
        $this->session->set_flashdata('success', 'You have successfully approved '.$data['username'].'!'); 
      } else {
        $this->session->set_flashdata('error', 'You have successfully approved '.$data['username'].'!<br>Unfortunately there was a problem sending the notification email to the candidate!'); 
      }
    } else {
      $this->session->set_flashdata('error', "There was an error approving the candidate. Try again."); 
    }

    redirect('employers/managecandidates/'.$data['id'].'?status=pending');
  }

  public function candidate_rejection($id) {
    $status = array(
      'state' => 'Rejected'
    );

    // Ενημέρωση του status στη Βάση Δεδομένων
    if($this->jobs_model->status_application($id, $status) === 'success') {
      $data = $this->jobs_model->job_application_data($id);
      $data['year'] = date("Y");

      $message = $this->load->view('public/emails/candidate_rejection', $data, TRUE);
      
      $this->load->library('email');

      $this->email->from('info@weelancer.com', 'Weelancer');
      $this->email->to($data['email']);
      $this->email->subject('Candidate Rejection');
      $this->email->message($message);

      // Έλεγχος αν έγινε η αποστολή του email
      if($this->email->send()) {
        $this->session->set_flashdata('success', 'You have successfully rejected '.$data['username'].'!'); 
      } else {
        $this->session->set_flashdata('error', 'You have successfully rejected '.$data['username'].'!<br>Unfortunately there was a problem sending the notification email to the candidate!'); 
      }
    } else {
      $this->session->set_flashdata('error', "There was an error rejecting the candidate. Try again."); 
    }

    redirect('employers/managecandidates/'.$data['id'].'?status=pending');
  }

   // View candidate profile
   public function viewcandidate($id) {
    $this->metadata['title'] = 'Candidate Profile';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $candidate = $this->jobs_model->user_application_data($id);

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/includes/employer_menu', $this->metadata);
    $this->load->view('public/employers/user-profile', $candidate);
    $this->load->view('public/includes/footer');
  }

  // Manage employers
  public function manageemployers() {
    $this->metadata['title'] = 'Manage Employers';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $employer = $this->employers_model->search($this->session->userdata('employer_id'));
    $company = $this->companies_model->search($employer['company_id']);
    $data['employers'] = $this->employers_model->select_company($company['id']);

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/includes/employer_menu', $this->metadata);
    $this->load->view('public/employers/manage-employers', $data);
    $this->load->view('public/includes/footer');
  }

  // Add employers
  public function addemployer() {
    $this->metadata['title'] = 'Add Employer';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $this->form_validation->set_rules('username', 'Full Name', 'required|min_length[4]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_employer_email');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[100]');
    $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');
    $this->form_validation->set_rules('profession', 'Profession', 'required|callback_check_profession');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του εργοδότη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/includes/employer_menu', $this->metadata);
      $this->load->view('public/employers/add-employer');
      $this->load->view('public/includes/footer');
    } else {
      $employer = $this->employers_model->search($this->session->userdata('employer_id'));
      $company = $this->companies_model->search($employer['company_id']);

      $employer_inputs = array(
        'username' => $this->input->post('username'),
        'company_id' => $company['id'],
        'email' => $this->input->post('email'),
        'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost' => 10)),
        'hash' => md5(rand(0, 100)),
        'profession' => $this->input->post('profession')
      );

      if(!is_null($this->input->post('active'))) {
        $employer_inputs['active'] = $this->input->post('active');
      }

      // Εισαγωγή στοιχείων χρήστη στη Βάση Δεδομένων
      if($this->employers_model->add($employer_inputs) === 'success') {
        $this->session->set_flashdata('success', "Employer added."); 
      } else {
        $this->session->set_flashdata('error', "There was an error adding the employer. Try again."); 
      }
      
      redirect('employers/manageemployers');
    }
  }

  // Edit employers
  public function editemployer($id) {
    $this->metadata['title'] = 'Edit Employer';

    $employer = $this->employers_model->search($id);

    if(is_null($employer)) {
      redirect('employers/manageemployers');
    }

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $this->form_validation->set_rules('username', 'Full Name', 'required|min_length[4]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('profession', 'Profession', 'required|callback_check_profession');

    if($employer['email'] != $this->input->post('email')) {
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_employer_email');
    } else {
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email');
    }

    if(!empty($this->input->post('password')) || !empty($this->input->post('password_confirm'))) {
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[100]');
      $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');
    }

    // Έλεγχος αν πέτυχε το validation των στοιχείων του εργοδότη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/includes/employer_menu', $this->metadata);
      $this->load->view('public/employers/edit-employer', $employer);
      $this->load->view('public/includes/footer');
    } else {
      $employer_inputs = array(
        'id' => $id,
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'profession' => $this->input->post('profession')
      );

      if(!empty($this->input->post('password'))) {
        $employer_inputs['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost' => 10));
      }

      if(!is_null($this->input->post('active'))) {
        $employer_inputs['active'] = $this->input->post('active');
      } else {
        $employer_inputs['active'] = '0';
      }

      // Update στοιχείων χρήστη στη Βάση Δεδομένων
      if($this->employers_model->update($employer_inputs) === 'success') {
        $this->session->set_flashdata('success', "Changes registered."); 
      } else {
        $this->session->set_flashdata('error', "No changes to update."); 
      }
      
      redirect('employers/editemployer/'.$id);
    }
  }

  // Add/Edit employer validation rule για το profession του employer
  public function check_profession($profession) {
    $this->form_validation->set_message('check_profession', 'The <b>{field}</b> must be one of: Boss, Simple Employer.');

    if($profession == "Boss" || $profession == "Simple Employer") {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  // Delete employers
  public function deleteemployer($id) {
    $this->metadata['title'] = 'Delete Employer';

    // Έλεγχος αν ο εργοδότης έχει κάνει login
    if(!$this->session->userdata('employer_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('employers/login');
    }

    $this->employers_model->delete($id);

    $this->session->set_flashdata('success', "Employer deleted."); 
  
    redirect('employers/manageemployers');
  }
}
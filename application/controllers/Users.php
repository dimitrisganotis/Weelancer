<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
  protected $metadata = array(
    'title' => null,
    'description' => 'Weelancer is an online job finding platform that helps employers find the right people for their company.'
  );

  public function __construct() {
    parent::__construct();
    $this->load->model('users_model');
  }

  // ##########################################################################
  // ##################### SIGN UP AND ACTIVATION (EMAIL) #####################
  // ##########################################################################

  // Εγγραφή χρήστη
  public function signup() {
    $this->metadata['title'] = 'Sign Up';

    // Έλεγχος αν ο χρήστης έχει κάνει login
    if($this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You are already connected!"); 
      redirect('/');
    }

    // Έλεγχος στοιχείων χρήστη
    $this->form_validation->set_rules('username', 'Full Name', 'required|min_length[4]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_email');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[100]');
    $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του χρήστη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/users/signup');
      $this->load->view('public/includes/footer');
    } else {
      $user = array(
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost' => 10)),
        'hash' => md5(rand(0, 100))
      );

      // Εισαγωγή στοιχείων χρήστη στη Βάση Δεδομένων
      $result = $this->users_model->add($user);
      
      if($result['message'] === 'error') {
        $this->session->set_flashdata('error', "There was an error with your sign up!"); 
        redirect('users/signup');
      } else if($result['message'] === 'success') {
        $this->activation_email($user);

        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/users/activation');
        $this->load->view('public/includes/footer');
      }
    }
  }

  // Sign up validation Rule για το email του χρήστη 
  public function check_email($email) {
    $this->form_validation->set_message('check_email', 'This <b>{field}</b> already exists. Please use a different one!');

    if($this->users_model->check_email($email)) {
      return true;
    } else {
      return false;
    }
  }

  // Αποστολή email στο χρήστη για ενεργοποίηση λογαριασμού
  public function activation_email($user) {
    $data = array(
      'user' => $user,
      'year' => date("Y")
    );

    $message = $this->load->view('public/emails/user_activation', $data, TRUE);
    
    $this->load->library('email');

    $this->email->from('info@weelancer.com', 'Weelancer');
    $this->email->to($user['email']);
    $this->email->subject('Account Activation');
    $this->email->message($message);

    // Έλεγχος αν έγινε η αποστολή του email
    if($this->email->send()) {
      $this->session->set_flashdata('success_active', "You have successfully created your account.<br>An email has been sent to you, to activate your account!"); 
    } else {
      $this->session->set_flashdata('error_active', "You have successfully created your account.<br>Unfortunately there was a problem sending you the activation email!"); 
    }
  }

  // Μήνυμα ενεργοποίησης λογαριασμού μέσω του link που στάλθηκε σε email στο χρήστη
  public function activation() {
    $this->metadata['title'] = 'Account Activation';

    $user = array(
      'email' => $this->input->get('email'),
      'hash' => $this->input->get('hash')
    );

    // Έλεγχος αν στο url υπάρχει email και hash χρήστη
    // Αν δεν υπάρχουν να μην υπάρχει πρόσβαση στη μέθοδο
    if($user['email'] !== NULL && $user['hash'] !== NULL) {
      $userDB = $this->users_model->search_by_email($user['email']);

      // Έλεγχος αν υπάρχει το email στη Βάση Δεδομένων
      // Έλεγχος αν το hash που υπάρχει στο url είναι ίδιο με το hash της Βάσης Δεδομένων
      if(is_null($userDB)) {
        redirect('/');
      } else if($user['hash'] == $userDB['hash']) {
        $result = $this->users_model->activation($user);

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
    $this->load->view('public/users/activation');
    $this->load->view('public/includes/footer');
  }

  // #########################################################################
  // ##################### LOGIN AND FORGOT PASS (EMAIL) #####################
  // #########################################################################

  // Σύνδεση χρήστη
  public function login() {
    $this->metadata['title'] = 'Login';

    // Έλεγχος αν ο χρήστης έχει κάνει login
    if($this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You are already connected!"); 
      redirect('/');
    }

    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    // Έλεγχος αν πέτυχε το validation των στοιχείων του χρήστη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/users/login');
      $this->load->view('public/includes/footer');
    } else {
      $user = array(
        'email' => $this->input->post('email'),
        'password' => $this->input->post('password')
      );

      // Εύρεση στοιχείων χρήστη στη Βάση Δεδομένων
      $result = $this->users_model->login($user);

      if($result['message'] === 'success') {
        $user_id = $result['user_id'];
        $this->session->set_userdata('user_id', $user_id);
        redirect('/');
      } else if($result['message'] === 'error') {
        $this->session->set_flashdata('error', "Credentials are wrong. Try again!"); 
        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/users/login');
        $this->load->view('public/includes/footer');
      } else if($result['message'] === 'error_active') {
        $this->session->set_flashdata('error', "You have to activate your account!"); 
        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/users/login');
        $this->load->view('public/includes/footer');
      }
    } 
  }

  // Forgot και reset κωδικού χρήστη
  public function forgotpass() {

    $user = array(
      'email' => $this->input->get('email'),
      'hash' => $this->input->get('hash')
    );

    // Αν στο url δεν υπάρχουν το email και το hash του χρήστη 
    // να του εμφανίσει την σελίδα για να συμπληρώσει το email του
    // Αν υπάρχουν και ειναι σωστά να αλλαζει ο κωδικός του χρήστη
    if($user['email'] === NULL && $user['hash'] === NULL) {
      $this->metadata['title'] = 'Forgot Password';

      // Έλεγχος email χρήστη
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_email_forgot');

      // Έλεγχος αν πέτυχε το validation των στοιχείων του χρήστη
      if ($this->form_validation->run() === FALSE) {
        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/users/forgotpass');
        $this->load->view('public/includes/footer');
      } else {
        $email = $this->input->post('email');
        
        $userDB = $this->users_model->search_by_email($email);

        $this->forgotpass_email($userDB);

        $this->load->view('public/includes/header', $this->metadata);
        $this->load->view('public/users/forgotpass_message');
        $this->load->view('public/includes/footer');
      }
    } else if($user['email'] !== NULL && $user['hash'] !== NULL) {
      $userDB = $this->users_model->search_by_email($user['email']);

      // Έλεγχος αν το hash που υπάρχει στο url είναι ίδιο με το hash της Βάσης Δεδομένων
      if($user['hash'] == $userDB['hash']) {
        $this->metadata['title'] = 'Reset Password';

        // Παραμετροι url
        $data['url'] = '?email='.$userDB['email'].'&'.'hash='.$userDB['hash'];

        // Έλεγχος password χρήστη
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

        // Έλεγχος αν πέτυχε το validation των password
        if ($this->form_validation->run() === FALSE) {
          $this->load->view('public/includes/header', $this->metadata);
          $this->load->view('public/users/resetpass', $data);
          $this->load->view('public/includes/footer');
        } else {
          $userDBnewPass = array(
            'id' => $userDB['id'],
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost' => 10))
          );
        
          // Εισαγωγή password χρήστη στη Βάση Δεδομένων
          $result = $this->users_model->update($userDBnewPass);

          if($result === 'success') {
            $this->session->set_flashdata('success', "You successfully changed your password.<br>You can now login!"); 
          } else if($result === 'error') {
            $this->session->set_flashdata('error', "There was an error reseting your password.<br>Try again!"); 
          }

          $this->load->view('public/includes/header', $this->metadata);
          $this->load->view('public/users/forgotpass_message');
          $this->load->view('public/includes/footer');
        }
      } else {
        redirect('/');
      }
    }
  }

  // Validation Rule για το email του χρήστη στο forgot pass
  public function check_email_forgot($email) {
    $this->form_validation->set_message('check_email_forgot', 'This <b>{field}</b> doesn&apos;t exists.');

    if($this->users_model->check_email($email)) {
      return false;
    } else {
      return true;
    }
  }

  // Αποστολή email στο χρήστη για επαναφορά κωδικού
  public function forgotpass_email($user) {
    $data = array(
      'user' => $user,
      'year' => date("Y")
    );

    $message = $this->load->view('public/emails/user_forgotpass', $data, TRUE);
    
    $this->load->library('email');

    $this->email->from('info@weelancer.com', 'Weelancer');
    $this->email->to($user['email']);
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

  // Αποσύνδεση χρήστη
  public function logout() {
    $this->metadata['title'] = 'Logout';

    // Έλεγχος αν ο χρήστης έχει κάνει ήδη login
    if($this->session->userdata('user_id')) {
      $this->session->unset_userdata('user_id');
      redirect('users/login');
    } else {
      redirect('/');
    }
  }

  // #################################################
  // ###################### ... ######################
  // #################################################

  // User Dashboard
  public function dashboard() {
    $this->metadata['title'] = 'Dashboard';
    $this->load->model('jobs_model');

    // Έλεγχος αν ο χρήστης έχει κάνει login
    if(!$this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('users/login');
    }

    $user = $this->users_model->search($this->session->userdata('user_id'));

    $account_completion = 10; // 10% is the starting point
    $account_level = 'Begginer';

    // Check the user filled data to display the profile level and the %.
    if(!empty($user['phone']))
      $account_completion += 10;
    
    if(!empty($user['address']))
      $account_completion += 10;

    if(!empty($user['birthdate']))
      $account_completion += 10;
    
    if(!empty($user['profession']))
      $account_completion += 20;

    if(!empty($user['native_lang']))
      $account_completion += 10;
    
    if(!empty($user['description']))
      $account_completion += 10;

    if(!empty($user['facebook']))
      $account_completion += 5;
    
    if(!empty($user['linkedin']))
      $account_completion += 5;

    if(!empty($user['cv']))
      $account_completion += 10;

    if($account_completion >= 70)
      $account_level = 'Advanced';
    else if($account_completion >= 25 && $account_level < 70)
      $account_level = 'Intermediate';

    $data['user'] = $user;
    $data['user']['account_completion'] = $account_completion;
    $data['user']['account_level'] = $account_level;
    $data['user']['approves'] = $this->jobs_model->user_applications_approved($this->session->userdata('user_id'));
    $data['user']['rejections'] = $this->jobs_model->user_applications_rejected($this->session->userdata('user_id'));
    $data['user']['pending'] = $this->jobs_model->user_applications_pending($this->session->userdata('user_id'));
    $data['user']['total'] = $data['user']['pending'] + $data['user']['approves'] + $data['user']['rejections'];

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/includes/user_menu', $this->metadata);
    $this->load->view('public/users/dashboard', $data);
    $this->load->view('public/includes/footer');
  }

  // Delete user
  public function deleteuser() {
    $this->metadata['title'] = 'Delete Account';

    // Έλεγχος αν ο χρήστης έχει κάνει login
    if(!$this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('users/login');
    }

    $this->users_model->delete($this->session->userdata('user_id'));
    $this->session->set_flashdata('success', "Account deleted."); 
    $this->logout();
  }

  // User profile
  public function profile() {
    $this->metadata['title'] = 'My Profile';

    // Έλεγχος αν ο χρήστης έχει κάνει login
    if(!$this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('users/login');
    }

    $user = $this->users_model->search($this->session->userdata('user_id'));

    // Έλεγχος στοιχείων χρήστη
    $this->form_validation->set_rules('username', 'Full Name', 'required|min_length[4]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('profession', 'Professional Title', 'min_length[2]|max_length[50]|regex_match[/^[a-zA-Z _-]+$/]');
    $this->form_validation->set_rules('native_lang', 'Native Language', 'callback_check_native_lang');
    $this->form_validation->set_rules('birthdate', 'Birth Date', 'regex_match[/^\d{4}-\d{2}-\d{2}$/]');
    $this->form_validation->set_rules('description', 'Introduce Yourself', 'min_length[2]|max_length[65535]');
    $this->form_validation->set_rules('phone', 'Phone', 'numeric');
    //$this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('facebook', 'Facebook', 'valid_url');
    $this->form_validation->set_rules('linkedin', 'Linkedin', 'valid_url');
    $this->form_validation->set_rules('image', 'Image', 'callback_check_image');
    $this->form_validation->set_rules('cv', 'CV', 'callback_check_cv');

    if($user['email'] != $this->input->post('email')) {
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email|callback_check_email');
    } else {
      $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[100]|valid_email');
    }

    if(!empty($this->input->post('password')) || !empty($this->input->post('password_confirm'))) {
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[100]');
      $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');
    }

    // Έλεγχος αν πέτυχε το validation των στοιχείων του χρήστη
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('public/includes/header', $this->metadata);
      $this->load->view('public/includes/user_menu', $this->metadata);
      $this->load->view('public/users/profile', $user);
      $this->load->view('public/includes/footer');
    } else {
      $user_inputs= array(
        'id' => $this->session->userdata('user_id'),
        'username' => $this->input->post('username'),
        'profession' => $this->input->post('profession'),
        'native_lang' => $this->input->post('native_lang'),
        'birthdate' => $this->input->post('birthdate'),
        'description' => $this->input->post('description'),
        'phone' => $this->input->post('phone'),
        'email' => $this->input->post('email'),
        'address' => $this->input->post('address'),
        'facebook' => $this->input->post('facebook'),
        'linkedin' => $this->input->post('linkedin'),
        'lat' => $this->input->post('lat'),
        'long' => $this->input->post('lng')
      );

      if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "" && $_FILES['image']['size'] != 0) {
        $config['upload_path']          = './assets/img/uploads/users/';
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

        $user_inputs['image'] = 'assets/img/uploads/users/'.$image['file_name'];
      }

      if(isset($_FILES['cv']['name']) && $_FILES['cv']['name'] != "" && $_FILES['cv']['size'] != 0) {
        $config['upload_path']          = './assets/files/uploads/cv/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 5000000;
        $config['overwrite']            = FALSE;
        $config['encrypt_name']         = TRUE;

        $this->load->library('upload', $config);

        if($this->upload->do_upload('cv')) {
          $cv = $this->upload->data();
        } else {
          $this->session->set_flashdata('error', "Error uploading your cv!"); 
          $this->load->view('public/includes/header', $this->metadata);
          $this->load->view('public/pages/alert');
          $this->load->view('public/includes/footer');  
          die();
        }

        $user_inputs['cv'] = 'assets/files/uploads/cv/'.$cv['file_name'];
      }

      if(!empty($this->input->post('password'))) {
        $user_inputs['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost' => 10));
      }

      // Update στοιχείων χρήστη στη Βάση Δεδομένων
      if($this->users_model->update($user_inputs) === 'success') {
        $this->session->set_flashdata('success', "Changes registered."); 
      } else {
        $this->session->set_flashdata('error', "No changes to update."); 
      }
      
      redirect('users/profile');
    }
  }

  // Profile validation rule για το image του χρήστη
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

  // Profile validation rule για το cv του χρήστη
  public function check_cv($cv) {
    //$this->form_validation->set_message('check_image', 'Max image dimensions: 1000x1000px. Max image size: 512KB. Allowed image types: JPG/PNG.');

    if(!empty($_FILES['cv']['name']) || $_FILES['cv']['name'] != "" || $_FILES['cv']['size'] > 0 ) {
      $file = $_FILES["cv"]["tmp_name"];
      $message = '';
      $flag = TRUE;
      
      if(filesize($file) > 5000000) {
        $message .= 'Max file size: 5MB. ';
        $this->form_validation->set_message('check_cv', $message);
        $flag = FALSE;
      }

      if($_FILES['cv']['type'] != 'application/pdf') {
        $message .= 'Allowed file type: PDF. ';
        $this->form_validation->set_message('check_cv', $message);
        $flag = FALSE;
      } 

      return $flag;
    } else {
      return TRUE;
    }
  }

  // Profile validation rule για το native language του χρήστη
  public function check_native_lang($native_lang) {
    $this->form_validation->set_message('check_native_lang', 'The <b>{field}</b> must be one of: Greek, English, Chinese, Spanish, Arabic, Portuguese, Indonesian / Malaysian, Japanese, Russian, French, German, Other.');

    if($native_lang == "" || $native_lang == "Greek" || $native_lang == "English" || $native_lang == "Chinese" || $native_lang == "Spanish" || $native_lang == "Arabic" || $native_lang == "Portuguese" || $native_lang == "Indonesian/Malaysian" || $native_lang == "Japanese" || $native_lang == "Russian" || $native_lang == "French" || $native_lang == "German" || $native_lang == "Other") {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  // Profile validation rule για το email του χρήστη 
  public function check_email_update($email) {
    $this->form_validation->set_message('check_email_update', 'This <b>{field}</b> already exists. Please use a different one!');

    if($this->users_model->check_email_update($email)) {
      return true;
    } else {
      return false;
    }
  }

  // Manage jobs
  public function managejobs() {
    $this->metadata['title'] = 'Manage Jobs';
    $this->load->model('jobs_model');

    // Έλεγχος αν ο χρήστης έχει κάνει login
    if(!$this->session->userdata('user_id')) {
      $this->session->set_flashdata('error', "You must login to your account!"); 
      redirect('users/login');
    }

    $data = array (
      'applications' => $this->jobs_model->user_applications($this->session->userdata('user_id'))
    );

    //var_dump($applications); die();

    $this->load->view('public/includes/header', $this->metadata);
    $this->load->view('public/includes/user_menu', $this->metadata);
    $this->load->view('public/users/manage-jobs', $data);
    $this->load->view('public/includes/footer');
  }

  // Email template
  public function emailtemplate() {
    // 404 σφάλμα όταν το view δεν υπάρχει
    if(!file_exists('application/views/public/pages/email_template.php'))
      show_404();

    $this->metadata['title'] = 'Email';

    $this->load->view('public/pages/email_template');
  }
}

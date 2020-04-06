<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs_model extends CI_Model {

  // Μαζί με το model φορτώνουμε την database
  public function __construct() {
    parent::__construct();
    $this->load->database();
  }

  // Ευρεσή συνολικών posted jobs
  public function total_jobs_number() {
    $query = $this->db->get('jobs');
    return $query->num_rows();
  }

  // Εύρεση Jobs
  public function select_all() {
    $this->db->select('jobs.id, jobs.title, jobs.address, DATE_FORMAT(jobs.created_at, "%d %M %Y") AS created_at, jobs.salary, jobs.type, companies.image');
    $this->db->from('jobs, companies');
    $this->db->where('jobs.company_id = companies.id');

    $query = $this->db->get();
    return $query->result_array();
  }

  // Προβολή Jobs με βάση τα filters
  public function filtered_jobs($filters) {
    $select = 'jobs.id, jobs.title, jobs.address, DATE_FORMAT(jobs.created_at, "%d %M %Y") AS created_at, jobs.salary, jobs.type, companies.image';
    $where = 'jobs.company_id = companies.id';

    // Lat & Long
    if(!is_null($filters['lat_rad']) && !is_null($filters['long_rad'])) {
      $select .= ', ABS(ACOS(SIN(radians(jobs.lat))*SIN('.$filters['lat_rad'].')+COS(radians(jobs.lat))*COS('.$filters['lat_rad'].')*COS('.$filters['long_rad'].'-(radians(jobs.long)))))*6371 AS distance';
      //echo 'hello'; die();
    }

    // Category
    if(!empty($filters['category'])) {
      $where .= " AND jobs.category = '".$filters['category']."'";
    }

    // Type
    if(isset($filters['type']) && !empty($filters['type'])) {
      for($i=0; $i<sizeof($filters['type']); $i++) {
        // Το μοναδικό στοιχείο του πίνακα 
         if($i == 0 && sizeof($filters['type']) == 1) {
          $where .= " AND jobs.type = '".$filters['type'][$i]."'";
          
        // Το πρώτο στοιχείο πίνακα με περισσότερο από 1 στοιχείο
        } else if($i == 0 && sizeof($filters['type']) > 1) {
          $where .= " AND (jobs.type = '".$filters['type'][$i]."' OR ";

        // Το τελευταίο στοιχείο πίνακα με περισσότερο από 1 στοιχείο
        } else if($i == sizeof($filters['type']) - 1) {
          $where .= "jobs.type = '".$filters['type'][$i]."')";

        // Τα ενδιάμεσα στοιχεία πίνακα με περισσότερο από 1 στοιχείο
        } else {
          $where .= "jobs.type = '".$filters['type'][$i]."' OR ";
        }
      }
    }

    $this->db->select($select);
    $this->db->from('jobs, companies');
    $this->db->where($where);

    // Search
    if(!empty($filters['search'])) {
      $this->db->like('jobs.title', $filters['search']);
    }

    // Max
    /*if(!is_null($filters['lat_rad']) && !is_null($filters['long_rad'])) {
      $this->db->having(array('distance <' => $filters['max']));
    }*/

    if(!empty($filters['max'])) {
      $this->db->having(array('distance <' => $filters['max']));
    }

    // Sort By
    if($filters['sort'] == 'asc') {
      $this->db->order_by("id", "asc");
    } else if($filters['sort'] == 'desc') {
      $this->db->order_by("id", "desc");
    } else if($filters['sort'] == 'distance_asc' && !is_null($filters['lat']) && !is_null($filters['long'])) {
      $this->db->order_by("distance", "asc");
    } else if($filters['sort'] == 'distance_desc' && !is_null($filters['lat']) && !is_null($filters['long'])) {
      $this->db->order_by("distance", "desc");
    } 

    // Limit & offset
    if(isset($filters['per_page']) && !empty($filters['per_page'])) {
      $offset = $filters['per_page'] ?? 1;
      $offset -= 1;
      $limit = $filters['limit'];
      $offset *= $limit;
    }

    //echo $this->db->get_compiled_select(); die();

    // Returning results or number of results
    if(isset($filters['per_page']) && !empty($filters['per_page'])) {
      $this->db->limit($limit, $offset);
      return $this->db->get()->result_array();
    } else {
      return $this->db->get()->num_rows();
    }
  }

  // Εύρεση Jobs εταιρίας
  public function select_company($id) {
    $this->db->select('id, title, address, DATE_FORMAT(jobs.created_at, "%d %M %Y") AS created_at, salary, type');
    $query = $this->db->get_where('jobs', array('company_id' => $id));

    return $query->result_array();
  }

  // Εύρεση Job με βάση το ID
  public function search($id) {
    $this->db->select('jobs.id AS id, jobs.title AS job, companies.id AS company_id, companies.title AS company, companies.email AS email, jobs.address, jobs.lat, jobs.long, DATE_FORMAT(jobs.created_at, "%d %M %Y") AS created_at, jobs.description, jobs.salary, jobs.type, jobs.category, jobs.views, companies.image');
    $this->db->from('jobs, companies');

    $where = "jobs.company_id = companies.id AND jobs.id = $id";
    
    $this->db->where($where);

    $query = $this->db->get();
    return $query->row_array();
  }

  // Έλεγχος αν υπάρχει application
  public function check_application($data) {
    $query = $this->db->get_where('applications', array('job_id' => $data['job_id'], 'user_id' => $data['user_id']));
    
    if(empty($query->row_array())){
      return FALSE;
    } else {
      return TRUE;
    }
  }

  // Εύρεση αριθμού applications με βάση το job id
  public function num_job_applications($id) {
    $query = $this->db->get_where('applications', array('job_id' => $id));
    return $query->num_rows();
  }

  // Εύρεση jobs με βάση το company id
  public function company_jobs($id) {
    $query = $this->db->get_where('jobs', array('company_id' => $id));
    return $query->result_array();
  }

  // Εύρεση application με βάση το user id
  public function user_applications($id) {
    $this->db->select('jobs.id, title, jobs.created_at AS j_created_at, applications.created_at AS a_created_at, state');
    $this->db->from('applications');
    $this->db->where('user_id', $id);
    $this->db->join('jobs', 'jobs.id = applications.job_id');
    $query = $this->db->get();

    return $query->result_array();
  }

  // Εύρεση approved applications με βάση το user id
  public function user_applications_approved($id) {
    $this->db->from('applications');
    $this->db->where('user_id', $id);
    $this->db->where('state', 'Approved');
    $query = $this->db->get();

    return $query->num_rows();
  }

  // Εύρεση rejected applications με βάση το user id
  public function user_applications_rejected($id) {
    $this->db->from('applications');
    $this->db->where('user_id', $id);
    $this->db->where('state', 'Rejected');
    $query = $this->db->get();

    return $query->num_rows();
  }

  // Εύρεση pending applications με βάση το user id
  public function user_applications_pending($id) {
    $this->db->from('applications');
    $this->db->where('user_id', $id);
    $this->db->where('state', 'Pending');
    $query = $this->db->get();

    return $query->num_rows();
  }

  // Εύρεση approved applications με βάση το company id
  public function company_applications_approved($id) {
    $this->db->from('applications');
    $this->db->where('company_id', $id);
    $this->db->where('state', 'Approved');
    $this->db->join('jobs', 'jobs.id = applications.job_id');
    $query = $this->db->get();

    return $query->num_rows();
  }

  // Εύρεση rejected applications με βάση το company id
  public function company_applications_rejected($id) {
    $this->db->from('applications');
    $this->db->where('company_id', $id);
    $this->db->where('state', 'Rejected');
    $this->db->join('jobs', 'jobs.id = applications.job_id');
    $query = $this->db->get();

    return $query->num_rows();
  }

  // Εύρεση pending applications με βάση το company id
  public function company_applications_pending($id) {
    $this->db->from('applications');
    $this->db->where('company_id', $id);
    $this->db->where('state', 'Pending');
    $this->db->join('jobs', 'jobs.id = applications.job_id');
    $query = $this->db->get();

    return $query->num_rows();
  }

  // Εύρεση pending users με βάση το job id
  public function job_applications_pending($id) {
    $this->db->select('applications.id AS application_id, username, profession, email, image, applications.created_at AS created_at');
    $this->db->from('applications');
    $this->db->where('job_id', $id);
    $this->db->where('state', 'Pending');
    $this->db->join('users', 'users.id = applications.user_id');
    $query = $this->db->get();

    return $query->result_array();
  }

   // Εύρεση approved users με βάση το job id
   public function job_applications_approved($id) {
    $this->db->select('applications.id AS application_id, username, profession, email, image, applications.created_at AS created_at');
    $this->db->from('applications');
    $this->db->where('job_id', $id);
    $this->db->where('state', 'Approved');
    $this->db->join('users', 'users.id = applications.user_id');
    $query = $this->db->get();

    return $query->result_array();
  }

  // Εύρεση στοιχείων χρήστη με βάση το applications id
  public function user_application_data($id) {
    $this->db->select('applications.id AS application_id, state, username, email, phone, address, birthdate, profession, native_lang, description, facebook, linkedin, cv, gender, image');
    $this->db->from('applications');
    $this->db->where('applications.id', $id);
    $this->db->join('users', 'users.id = applications.user_id');
    $query = $this->db->get();

    return $query->row_array();
  }

  // Εύρεση στοιχείων job και χρήστη με βάση το applications id
  public function job_application_data($id) {
    $this->db->select('jobs.id AS id, title, username, email');
    $this->db->from('applications');
    $this->db->where('applications.id', $id);
    $this->db->join('jobs', 'jobs.id = applications.job_id');
    $this->db->join('users', 'users.id = applications.user_id');
    $query = $this->db->get();

    return $query->row_array();
  }

  // Εύρεση συνολικού αριθμού αγγελιών εταιρείας
  public function company_posted_jobs($id) {
    $query = $this->db->get_where('jobs', array('company_id' => $id));

    return $query->num_rows();
  }

  // Εύρεση συνολικού αριθμού εμφανίσεων αγγελιών εταιρείας από χρήστες
  public function company_jobs_views($id) {
    $this->db->select_sum('views');
    $query = $this->db->get_where('jobs', array('company_id' => $id));

    return $query->row();
  }

  // ############################################################
  // #################### ADD, UPDATE, DELETE ###################
  // ############################################################

  // Δημιουργία Job
  public function add($job) {
    $this->db->insert('jobs', $job);

    if($this->db->affected_rows() > 0) {
      return 'success';
    } else {
      return 'error';
    }
  }

  // Επεξεργασία Job
  public function update($job) {
    $this->db->where('id', $job['id']);
    $this->db->update('jobs', $job);

    if($this->db->affected_rows() > 0) {
      return 'success';
    } else {
      return 'error';
    }
  }

   // Επεξεργασία Jobs Views
   public function update_views($job) {
    $this->db->where('id', $job['id']);
    $this->db->update('jobs', $job);
  }

  // Διαγραφή Job
  public function delete($id) {
    $this->db->where('id', $id);
    $this->db->delete('jobs');
  }

  // Δημιουργία Application
  public function do_application($data) {
    $this->db->insert('applications', $data);

    if($this->db->affected_rows() > 0) {
      return 'success';
    } else {
      return 'error';
    }
  }

  // Επεξεργασία του Status της Application
  public function status_application($id, $status) {
    $this->db->where('id', $id);
    $this->db->update('applications', $status);

    if($this->db->affected_rows() > 0) {
      return 'success';
    } else {
      return 'error';
    }
  }

  // Διαγραφή Application
  public function undo_application($data) {
    $this->db->delete('applications', $data);
  }

  public function fetch_jobs(){
    $this->db->select('jobs.title, (DATE(jobs.created_at)) as createddate, jobs.salary, jobs.type, companies.address, companies.image');
    $this->db->from('jobs');
    $this->db->join('companies', 'jobs.company_id = companies.id');
    $query = $this->db->get();
    return $query;
  }
}

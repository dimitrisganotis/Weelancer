<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Companies_model extends CI_Model {

  // Μαζί με το model φορτώνουμε την database
  public function __construct() {
    parent::__construct();
    $this->load->database();
  }

  // ###########################################################
  // ######################### SEARCHES ########################
  // ###########################################################

  // Εύρεση Εταιρείας με βάση το ID
  public function search($id) {
    $query = $this->db->get_where('companies', array('id' => $id));
    return $query->row_array();
  }

  // !!!
  public function company_jobs($id) {
    $this->db->select('companies.id AS company_id, companies.title AS comapny, companies.category AS company_category, start, companies.address AS company_address, email, website, companies.description AS company_description, phone, facebook, linkedin, image, companies.lat AS company_lat, companies.long AS company_long, jobs.id AS job_id, jobs.title AS job_title, jobs.category AS job_category, jobs.description AS job_description, DATE_FORMAT(jobs.created_at, "%d %M %Y") AS created_at, type, salary, jobs.address AS job_address, jobs.lat AS job_lat, jobs.long AS job_long, views');
    $this->db->from('jobs');
    $this->db->where('company_id', $id);
    $this->db->join('companies', 'companies.id = jobs.company_id', 'left');
    echo  $this->db->get_compiled_select(); die();
    $query = $this->db->get();

    return $query->result_array();
  }

  // Αναζήτηση Email Εταιρείας
  public function check_email($email){
    $query = $this->db->get_where('companies', array('email' => $email));
    
    if(empty($query->row_array())){
      return true;
    } else {
      return false;
    }
  }

  // ############################################################
  // #################### ADD, UPDATE, DELETE ###################
  // ############################################################


  // Δημιουργία Εταιρείας
  public function add($company) {
    $this->db->insert('companies', $company);

    if($this->db->affected_rows() > 0) {
      $result = array(
        'comany_id' => $this->db->insert_id(),
        'message' => 'success'
      );

      return $result;
    } else {
      $result = array(
        'company_id' => 0,
        'message' => 'error'
      );

      return $result;
    }
  }

  // Επεξεργασία Εταιρείας
  public function update($company) {
    $this->db->where('id', $company['id']);
    $this->db->update('companies', $company);

    if($this->db->affected_rows() > 0) {
      return 'success';
    } else {
      return 'error';
    }
  }

  // Διαγραφή Εταιρείας
  public function delete($id) {
    $this->db->where('id', $id);
    $this->db->delete('companies');
  }

  // ############################################
  // #################### ... ###################
  // ############################################


  public function fetch_data(){
      $query = $this->db->get("jobs");
      return $query;
  }
  
}

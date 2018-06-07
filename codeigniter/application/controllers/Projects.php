<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('projects_model');
  }
  
  public function index() {
    $search = $this->input->post('search')
      ? $this->_filter($this->input->post('search'))
      : '';
    
    $where = array();

    $projects = $this->projects_model->getByQuery($search, $where);

    $this->_json(TRUE, 'projects', $projects);
  }

  public function delete() {
    $id = $this->input->post('id');
    $data = array(
      'status' => -1,
      'updated_at' => time()
    );
    $where = array('id' => $id);
    $res = $this->projects_model->update($data, $where);
    $this->_json($res);
  }

  public function manage() {
    $name = $this->input->post('name');
    $group_name = $this->input->post('group_name');
    $description = $this->input->post('description');
    $status = $this->input->post('status');

    // options
    $mode = $this->input->post('mode');

    $TIME = time();

    $data = array(
      'name' => $name,
      'group_name' => $group_name,
      'description' => $description,
      'status' => $status,
      'updated_at' => $TIME
    );

    $res = FALSE;
    if ($mode == 'add') {
      $data['created_at'] = $TIME;
      $res = $this->projects_model->insert($data);
    } else if ($mode == 'edit') {
      $id = $this->input->post('id');
      $res = $this->projects_model->update($data, array('id' => $id));
    }

    $this->_json($res);
  }
}

?>

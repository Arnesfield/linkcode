<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('projects_model');
    $this->load->model('votes_model');
  }
  
  public function index() {
    $uid = $this->session->userdata('user')['id'];
    $search = $this->input->post('search')
      ? $this->_filter($this->input->post('search'))
      : '';
    $id = $this->input->post('id') ? $this->input->post('id') : FALSE;
    $userSpecific = $this->input->post('userSpecific') ? $this->input->post('userSpecific') : FALSE;
    
    $where = array();
    $where_in = array();

    if ($id) {
      $where['id'] = $id;
    }
    if ($userSpecific) {
      // check votes of user and only allow those projects
      $votes = $this->votes_model->get(array(
        'user_id' => $uid
      ));
      
      if (!$votes) {
        $this->_json(TRUE, 'projects', array());
      }
      
      // using $votes, get only project ids
      $where_in = $this->votes_model->_to_col($votes, 'project_id');
      $search = FALSE;
    }

    $projects = $this->projects_model->getByQuery($search, $where, $where_in);

    $this->_json(TRUE, 'projects', $projects);
  }

  public function save() {
    // delete all projects, then insert all
    $projects = $this->input->post('projects');
    $projects = json_decode($projects, TRUE);

    // loop through projects
    $newProj = array();
    foreach ($projects as $key => $value) {
      $newProj[$key] = array();
      $newProj[$key]['name'] = $value['name'];
      $newProj[$key]['group_name'] = $value['group_name'];
      $newProj[$key]['description'] = $value['description'];
      $newProj[$key]['created_at'] = time();
      $newProj[$key]['updated_at'] = time();
      $newProj[$key]['status'] = 1;
    }

    $res = $this->projects_model->reupdate($newProj);
    $this->_json($res);
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

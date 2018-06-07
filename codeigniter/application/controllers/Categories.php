<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('categories_model');
    $this->load->model('votes_model');
  }
  
  public function index() {
    $search = $this->input->post('search')
    ? $this->_filter($this->input->post('search'))
    : '';
    
    $voted = $this->input->post('voted') ? $this->input->post('voted') : FALSE;
    $project_id = $this->input->post('project_id') ? $this->input->post('project_id') : 0;
    $where = array();

    $hasValue = FALSE;
    $votes = array();
    
    if ($voted) {
      // check if uid exists in votes
      $uid = $this->session->userdata('user')['id'];
      $votes = $this->votes_model->get(array(
        'user_id' => $uid,
        'project_id' => $project_id
      ));
      $hasValue = !!$votes;
    }
    
    if (!$hasValue) {
      $categories = $this->categories_model->getByQuery($search, $where);
      $categories = $this->_formatCategories($categories);
    } else {
      $votes = $this->_formatVotes($votes);
      $categories = $votes[0]['content'];
    }

    $this->_json(TRUE, 'categories', $categories);
  }

  public function delete() {
    $id = $this->input->post('id');
    $data = array(
      'status' => -1,
      'updated_at' => time()
    );
    $where = array('id' => $id);
    $res = $this->categories_model->update($data, $where);
    $this->_json($res);
  }

  public function manage() {
    $name = $this->input->post('name');
    $content = $this->input->post('content');
    $status = $this->input->post('status');

    // options
    $mode = $this->input->post('mode');

    $TIME = time();

    $data = array(
      'name' => $name,
      'content' => $content,
      'status' => $status,
      'updated_at' => $TIME
    );

    $res = FALSE;
    if ($mode == 'add') {
      $data['created_at'] = $TIME;
      $res = $this->categories_model->insert($data);
    } else if ($mode == 'edit') {
      $id = $this->input->post('id');
      $res = $this->categories_model->update($data, array('id' => $id));
    }

    $this->_json($res);
  }
}

?>

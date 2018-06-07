<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('votes_model');
  }

  public function index() {
    $uid = $this->session->userdata('user')['id'];

    $project_id = $this->input->post('project_id');
    $content = $this->input->post('content');
    $status = $this->input->post('status');

    // check first if user exists in votes
    $votes = $this->votes_model->get(array(
      'user_id' => $uid,
      'project_id' => $project_id
    ));

    if ($votes) {
      // if exists, mode is update
      $mode = 'edit';
    } else {
      $mode = 'add';
    }

    $TIME = time();

    $data = array(
      'user_id' => $uid,
      'project_id' => $project_id,
      'content' => $content,
      'status' => $status,
      'updated_at' => $TIME
    );

    $res = FALSE;
    if ($mode == 'add') {
      $data['created_at'] = $TIME;
      $res = $this->votes_model->insert($data);
    } else if ($mode == 'edit') {
      $id = $votes[0]['id'];
      $res = $this->votes_model->update($data, array('id' => $id));
    }

    $this->_json($res);
  }
}

?>

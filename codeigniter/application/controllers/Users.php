<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('users_model');
  }
  
  public function index() {
    $search = $this->input->post('search')
      ? $this->_filter($this->input->post('search'))
      : '';

    $noAdmin = $this->input->post('noAdmin') ? $this->input->post('noAdmin') : FALSE;
    $where = array();
    $like = array();
    if ($noAdmin) {
      $like = 3;
    }
    
    $users = $this->users_model->getByQuery($search, $where, $like);

    $this->_json(TRUE, 'users', $users);
  }

  public function delete() {
    $id = $this->input->post('id');
    $data = array(
      'status' => -1,
      'updated_at' => time()
    );
    $where = array('id' => $id);
    $res = $this->users_model->update($data, $where);
    $this->_json($res);
  }

  public function manage() {
    $name = $this->input->post('name');
    $username = $this->input->post('username');
    $password = $this->input->post('password') ? $this->input->post('password') : FALSE;

    // options
    $mode = $this->input->post('mode');

    $TIME = time();

    $data = array(
      'name' => $name,
      'username' => $username,
      'status' => 1,
      'auth' => '[3]',
      'updated_at' => $TIME
    );

    if ($password) {
      $password = password_hash($password, PASSWORD_BCRYPT);
      $data['password'] = $password;
    }

    $res = FALSE;
    if ($mode == 'add') {
      $data['created_at'] = $TIME;
      $res = $this->users_model->insert($data);
    } else if ($mode == 'edit') {
      $id = $this->input->post('id');
      $res = $this->users_model->update($data, array('id' => $id));
    }

    $this->_json($res);
  }
}

?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Custom_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('login_model');
  }

  public function index() {
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    // get user with username
    $user = array('username' => $username);
    $users = $this->login_model->get($user);
    $users = $this->_formatUsers($users);

    // user types
    // 1 = admin
    // 3 = normal

    if (!$users) {
      $this->_json(FALSE, array(
        'error' => 'Invalid username or password.'
      ));
    }

    // if exists
    $user = $users[0];
    // check for password
    $verified = password_verify($password, $user['password']);

    if (!$verified) {
      $this->_json(FALSE, array(
        'error' => 'Invalid username or password.'
      ));
    }

    // check status
    if ($user['status'] == 0) {
      $this->_json(FALSE, array(
        'error' => 'This account has been suspended.'
      ));
    }

    // set session
    $this->session->set_userdata(array(
      'user' => $user,
      'auth' => $user['auth']
    ));

    $this->_json(TRUE, array(
      'user' => $user
    ));
  }
}

?>

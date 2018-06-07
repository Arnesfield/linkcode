<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
  public function __construct() {
    parent::__construct();
  }
}

/**
 * View Controller
 * 
 * Extend to this controller to load views.
 */
class MY_View_Controller extends MY_Controller {
  
  /**
   * Loads URL helper.
   */
  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
  }

  /**
   * Loads a view in the views/ directory.
   *
   * @param mixed $view Name of the view or an array of names of the views in views/ to be loaded
   * @param mixed $data A string title for the view or an associative array to be passed in the $view
   * @param boolean $view_only Loads the $view only; otherwise, header and footer in views/templates/ are also loaded
   * @return void
   */
  protected function _view($view = 'pages/home', $data = array(), $view_only = FALSE) {
    $header = 'templates/header';
    $footer = 'templates/footer';

    // create array of views
    $views = array();

    // add header
    if (!$view_only) {
      array_push($views, $header);
    }

    // turn $view into array
    if (!is_array($title = $view)) {
      $view = array($view);
    }
    // add $view
    $views = array_merge($views, $view);

    // add footer
    if (!$view_only) {
      array_push($views, $footer);
    }

    // turn $data into array with title
    if (is_string($data)) {
      $data = array('title' => $data);
    }

    // set title if data is null or empty
    if (empty($data) && is_string($title)) {
      $data['title'] = ucfirst(basename($title));
    }

    // load $views
    foreach ($views as $index => $view) {
      // check if page exists
      if (!file_exists(APPPATH . 'views/' . $view . '.php')) {
        show_404();
      }
      // load view
      $this->load->view($view, $index === 0 ? $data : NULL);
    }

  }
}

/**
 * My custom controller
 * 
 * Extends MY_View_Controller
 */
class MY_Custom_Controller extends MY_View_Controller {
  public function __construct() {
    parent::__construct();
    // prevent access if not post request
    if ($this->input->method(TRUE) !== 'POST') {
      $this->_redirect();
    }
    // load lib
    $this->load->library('session');
  }

  public function _filter($str) {
    return strip_tags(trim(addslashes($str)));
  }

  public function _redirect($to = '../#/error') {
    redirect(base_url($to));
  }

  public function _json($success, $arr = array(), $val = NULL) {
    // if $arr is string, make it an array with $val
    if (is_string($arr)) {
      $arr = array($arr => $val);
    }

    $master = array_merge($arr, array('success' => $success));

    echo json_encode($master);
    exit;
  }

  // formats
  public function _formatUsers($users, $remove_password = FALSE) {
    if ($users) {
      foreach ($users as $key => $user) {
        if ($remove_password) {
          unset($users[$key]['password']);
        }
        
        // make sure auth is all int
        $auth = json_decode($user['auth'], TRUE);
        $users[$key]['auth'] = is_array($auth) ? array_map('intval', $auth) : array();
      }
    }
    return $users;
  }

  public function _formatCategories($arr) {
    if ($arr) {
      foreach ($arr as $key => $value) {
        $arr[$key]['content'] = json_decode($value['content'], TRUE);
      }
    }
    return $arr;
  }

  public function _formatVotes($arr) {
    if ($arr) {
      foreach ($arr as $key => $value) {
        $arr[$key]['content'] = json_decode($value['content'], TRUE);
      }
    }
    return $arr;
  }

  public function _uploadFile($file_name = 'file', $allowed_types = FALSE, $path = 'uploads/images/') {
    if (!$allowed_types) {
      $allowed_types = 'jpg|png|jpeg';
    }

    $config = array(
      'upload_path' => './../'.$path,
      'allowed_types' => $allowed_types,
      'max_size' => 5*1000*1024,
      'file_name' => 'F_' . time()
    );

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload($file_name)) {
      $error = $this->upload->display_errors();
      return array(
        'success' => FALSE,
        'error' => $error
      );
    }

    return array(
      'success' => TRUE,
      'data' => $this->upload->data()
    );
  }

  public function _updateSess() {
    $this->load->model('users_model');
    $uid = $this->session->userdata('user')['id'];
    $users = $this->users_model->get(array('id' => $uid));
    $user = $this->_formatUsers($users)[0];
    $this->session->set_userdata(array(
      'user' => $user,
      'auth' => $user['auth']
    ));
  }
}

?>
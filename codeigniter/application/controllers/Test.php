<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_View_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->library('session');
  }

  public function index() {
    echo '<pre>';
    print_r($this->session->userdata());
    echo '</pre>';
  }

  public function destroy() {
    session_destroy();
  }
}

?>

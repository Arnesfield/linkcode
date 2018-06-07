<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sess extends MY_Custom_Controller {
  public function index() {
    $this->_json(TRUE, $this->session->userdata());
  }
}

?>

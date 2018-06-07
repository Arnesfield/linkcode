<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends MY_Custom_Model {
  public function get($user) {
    $query = $this->db
      ->from('users')
      ->where($user)
      ->where('status !=', -1)
      ->get();
    return $this->_res($query);
  }
}

?>

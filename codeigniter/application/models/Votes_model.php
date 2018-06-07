<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votes_model extends MY_Custom_Model {

  public function get($where = FALSE) {
    $this->db
      ->from('votes')
      ->where('status !=', -1);

    if ($where) {
      $this->db->where($where);
    }

    $this->db
      ->order_by('updated_at')
      ->order_by('created_at');

    $query = $this->db->get();
    return $this->_res($query);
  }

  public function insert($course) {
    return $this->_create('votes', $course);
  }

  public function update($data, $where) {
    return $this->db
      ->set($data)
      ->where($where)
      ->update('votes');
  }
}

?>
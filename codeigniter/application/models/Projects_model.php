<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends MY_Custom_Model {

  public function getByQuery($search = FALSE, $where = FALSE) {
    $this->db
      ->from('projects')
      ->where('status !=', -1);

    if ($search) {
      $search = strtolower($search);
      $this->db->where("
        (
          (
            LOWER(name) LIKE '%$search%' OR
            LOWER(group_name) LIKE '%$search%' OR
            LOWER(description) LIKE '%$search%'
          ) OR MATCH(name, group_name, description) AGAINST ('*$search*' IN BOOLEAN MODE)
        )
      ", NULL, FALSE);
    }

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
    return $this->_create('projects', $course);
  }

  public function update($data, $where) {
    return $this->db
      ->set($data)
      ->where($where)
      ->update('projects');
  }
}

?>
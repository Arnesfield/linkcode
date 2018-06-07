<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votes extends MY_Custom_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('votes_model');
    $this->load->model('categories_model');
    $this->load->model('projects_model');
    $this->load->model('users_model');
  }
  
  public function index() {
    $votes = $this->votes_model->get();
    $votes = $this->_formatVotes($votes);

    $categories = $this->categories_model->getByQuery();
    $categories = $this->_formatCategories($categories);

    $projects = $this->projects_model->getByQuery();

    $users = $this->users_model->getByQuery(FALSE, array('auth' => '[3]'));

    // convert projects, id => value
    $newProj = array();
    foreach ($projects as $key => $value) {
      $newProj[$value['id']] = $value;
    }

    $this->_json(TRUE, array(
      'votes' => $votes,
      'categories' => $categories,
      'projects' => $newProj,
      'userCount' => count($users)
    ));
  }
}

?>

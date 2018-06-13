<?php 
//security layer to avoid injections
defined('BASEPATH') OR exit('No direct script access allowed');

// class (Controller) Projects inherits from CI_Controller which extends functionality of our projects controller
class Projects extends CI_Controller
{  

  /*construct function blocks entry into the projects other methods if one hasn't logged in* the construct method is called automatically when this object construct is created and one is redirected to base_url/home/index*/
	public function __construct() {
	parent::__construct();	
	if(!$this->session->userdata('logged_in')){

    $this->session->set_flashdata('no_access', 'sorry you are not allowed or not logged in');
    redirect('home/index');

	}
   }
    




//the method that is run first index method. 
	public function index() {


/*Grabs all the projects based on user_id which is grabbed based on project_user_id column*/    

$user_id = $this->session->userdata('user_id');    

$data['projects'] = $this->project_model-> get_all_projects($user_id);

//$data['main_view'] is loaded on the main layout and holds view url of projects/index.
$data['main_view'] = "projects/index";		

$this->load->view('layouts/main', $data);

	}

/*display method*/
 public function display ($id) {

  $data['completed_tasks'] = $this->project_model->get_projects_tasks($id, true);

  $data['not_completed_tasks'] = $this->project_model->get_projects_tasks($id, false);

 $data['project_data'] = $this->project_model-> get_project($id);	
   
   $data['main_view'] = "projects/display";
   $this->load->view('layouts/main', $data);

 } 

public function create () {

  $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');
  $this->form_validation->set_rules('project_body', 'Project Description', 'trim|required');

  if ($this->form_validation->run() == FALSE) {
  
  $data['main_view'] = 'projects/create_project';
  $this->load->view('layouts/main', $data);

  } else {

$data = array(

    'project_user_id' => $this->session->userdata('user_id'),
    'project_name' => $this->input->post('project_name'),
    'project_body' => $this->input->post('project_body'),
);
if($this->project_model->create_project($data)){
	$this->session->set_flashdata('project_created', 'Your Project Has been Created');
	redirect("projects/index");

}



  }

}

public function edit($id) {
   
   $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');
  $this->form_validation->set_rules('project_body', 'Project Description', 'trim|required');

  if ($this->form_validation->run() == FALSE) {
  	$data['project_data'] = $this->project_model->get_projects_info($id);
  
  $data['main_view'] = 'projects/edit_project';
  $this->load->view('layouts/main', $data);

  } else {

$data = array(

    'project_user_id' => $this->session->userdata('user_id'),
    'project_name' => $this->input->post('project_name'),
    'project_body' => $this->input->post('project_body'),
);
if($this->project_model->edit_project($id,$data)){
	$this->session->set_flashdata('project_updated', 'Your Project Has been updated');
	redirect("projects/index");

}



  }

}

public function delete ($id) {

 $this->project_model->delete_project_task($id);
 $this->project_model->delete_project($id);
 $this->session->set_flashdata('project_deleted', 'Your Project Has been deleted');
	redirect("projects/index");


}


}







 ?>
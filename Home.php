<?php 
/*
codeigniter is a php object oriented framework that is best in building web applications.
compared to the raw php it has pre-built functionality. Hence
makes a developers work more easy as long as He sticks to certain standards and conventions.     
*/
          //security layer to avoid injections

defined('BASEPATH') OR exit('No direct script access allowed');

     /*default class (Controller) Home inherits from CI_Controller which extends functionality of our Home controller*/
      class Home extends CI_Controller
{
	// The default method that is first loaded before any other in a given class.


	public function index() {

          //this checks whether logged_in session exist or not using userdata sessions
         if ($this->session->userdata('logged_in')) {

         	 if ($this->session->userdata('user_id') == 1) {
         	 	
         	

// the user_id var stored a session user_id that exist in the column project_user_id in the table projects          	
	$user_id = $this->session->userdata('user_id');
    



 /*

                                       */

	$data['projects'] = $this->project_model-> get_all_projects();

	$data['all_projects'] = $this->project_model->get_all_num_projects();

	

	$data['all_completed'] = $this->task_model->get_all_completed();

	$data['all_not_completed'] = $this->task_model->get_all_not_completed();


//Gets all tasks based on $user_id session derived from project_user_id column.	

	// $data['tasks'] = $this->task_model->get_all_tasks($user_id);


}else {
     
    $user_id = $this->session->userdata('user_id'); 
    $data['tasks'] = $this->task_model->get_my_tasks($user_id);
  



}

}
$data['main_view'] = "home_view";		

$this->load->view('layouts/main', $data);
// the array $data['main_view'] holds homeview.php view which we load on the main layout (layout/main)



	}
}







 ?>
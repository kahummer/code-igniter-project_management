<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {



public function register () {


  $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]');
  $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]');
  $this->form_validation->set_rules('email', 'Email','trim|required|valid_email|min_length[5]');
  $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]');
  $this->form_validation->set_rules('role', 'Role', 'trim|required|min_length[3]');
  $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
  $this->form_validation->set_rules('confirm_password', 'Confirm password','trim|required|min_length[3]|matches[password]');









if($this->form_validation->run() == FALSE) {

  $data = array(

   'errors' => validation_errors()

   );

$this->session->set_flashdata($data);

  $data['main_view'] = 'users/register_view';
  $this->load->view('layouts/main', $data);
  
}
else {

 if ($this->User_model->create_user()){
  $this ->session-> set_flashdata('user_registered', 'User has been registered');
  redirect('Home/index');



}else {



}



}

}



public function login(){

 //$this->input->post('username');
	$this->form_validation->set_rules('username', 'username', 'trim|required|min_length[3]');
  $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[3]');
  $this->form_validation->set_rules('confirm_password', 'Confirm password','trim|required|min_length[3]|matches[password]');

if($this->form_validation->run() == FALSE) {

   $data = array(

   'errors' => validation_errors()

   );

$this->session->set_flashdata($data);
redirect('Home');
}


else{

    $username = $this->input->post('username');
	$password = $this->input->post('password');

	
	$user_id = $this->User_model->login_user($username, $password);


	if($user_id) {
            //echo "<script type = 'text/javascript'>alert('login_user run')</script>";
            $user_data = array(
                
                'user_id' => $user_id,
                 'username' => $username,
                  'logged_in' => true
                   


            	);



        $this->session->set_userdata($user_data);

        $this->session->set_flashdata('login_success', 'You are now logged in');
        //$data['main_view'] = "admin_view";		

     //  $this->load->view('layouts/main', $data);

       redirect('Home/index');    

	}
else {

      $this->session->set_flashdata('login_failed', 'Sorry You are not logged in');
      redirect('Home/index'); 
}


}

}


public function logout() {
  
   $this->session->sess_destroy();
   redirect('Home/index');

}

  
 




public function show() {
     
  //handles show fuctions
  if($this->session->userdata('logged_in')){
  
  $data['users'] = $this->User_model->get_all_users();
     
  $data['main_view'] = 'users/show';
  $this->load->view('layouts/main', $data);
   
   } else {
      
       $this->session->set_flashdata('no_access', 'sorry you are not allowed or not logged in');
    redirect('home/index');

   }


}



public function delete($id) {
 
 if($this->session->userdata('logged_in')){
 
 $this->User_model->delete_user($id);
 $this->session->set_flashdata('user_deleted', 'A User Has been deleted');
 redirect("users/show");
} else {

$this->session->set_flashdata('no_access', 'sorry you are not allowed or not logged in');
    redirect('home/
      index');
    
}


}
  
    }





        











 ?>



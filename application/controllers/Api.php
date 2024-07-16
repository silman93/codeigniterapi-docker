<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
// Include Rest Controller library 
require APPPATH . '/libraries/REST_Controller.php'; 
 
class Api extends REST_Controller { 
 
    public function __construct() {  
        parent::__construct(); 
         
        // Load user model 
        $this->load->model('user'); 
    } 
    public function index_get() { 
      $this->load->view('welcome_message');
    }
     
    public function users_get($id = 0) { 
	// Returns all rows if the id parameter doesn't exist, 
        //otherwise single row will be returned 
        $users = $this->user->getRows($id); 
         
        //check if the user data exists 
        if(!empty($users)){ 
            // Set the response and exit 
            //OK (200) being the HTTP response code 
            $this->response($users, REST_Controller::HTTP_OK); 
        }else{ 
            // Set the response and exit 
            //NOT_FOUND (404) being the HTTP response code 
            $this->response([ 
                'status' => FALSE, 
                'message' => 'No users were found.' 
            ], REST_Controller::HTTP_NOT_FOUND); 
        } 
    } 
     
    public function users_post() { 
        $userData = array( 
            'first_name' => $this->post('first_name'), 
            'last_name' => $this->post('last_name'), 
            'email' => $this->post('email'), 
            'phone' => $this->post('phone') 
        ); 
         
        if(!empty($userData['first_name']) && !empty($userData['last_name']) && !empty($userData['email']) && filter_var($userData['email'], FILTER_VALIDATE_EMAIL)){ 
            // Insert user record in database 
            $insert = $this->user->insert($userData); 
             
            // Check if the user data inserted 
            if($insert){ 
                // Set the response and exit 
                $this->response([ 
                    'status' => TRUE, 
                    'message' => 'User has been added successfully.' 
                ], REST_Controller::HTTP_OK); 
            }else{ 
                // Set the response and exit 
                $this->response("Something went wrong, please try again.", REST_Controller::HTTP_BAD_REQUEST); 
            } 
        }else{ 
            // Set the response and exit 
            //BAD_REQUEST (400) being the HTTP response code 
            $this->response("Provide complete user information to create.", REST_Controller::HTTP_BAD_REQUEST); 
        } 
    } 
     
    public function users_put() { 
        $id = $this->put('id'); 
         
        if(!empty($id)){ 
            $userData = array(); 
            if(!empty($this->put('first_name'))){ 
                $userData['first_name'] = $this->put('first_name'); 
            } 
            if(!empty($this->put('last_name'))){ 
                $userData['last_name'] = $this->put('last_name'); 
            } 
            if(!empty($this->put('email'))){ 
                $userData['email'] = $this->put('email'); 
            } 
            if(!empty($this->put('phone'))){ 
                $userData['phone'] = $this->put('phone'); 
            } 
 
            if(!empty($userData)){ 
                // Update user record in database 
                $update = $this->user->update($userData, $id); 
 
                // Check if the user data updated 
                if($update){ 
                    // Set the response and exit 
                    $this->response([ 
                        'status' => TRUE, 
                        'message' => 'User has been updated successfully.' 
                    ], REST_Controller::HTTP_OK); 
                }else{ 
                    // Set the response and exit 
                    $this->response("Something went wrong, please try again.", REST_Controller::HTTP_BAD_REQUEST); 
                } 
            }else{ 
                $this->response("Provide user information to update.", REST_Controller::HTTP_BAD_REQUEST); 
            } 
        }else{ 
            // Set the response and exit 
            $this->response("Provide the reference ID of the user to be updated.", REST_Controller::HTTP_BAD_REQUEST); 
        } 
    } 
     
    public function users_delete($id){ 
        // Check whether user ID is not empty 
        if($id){ 
            // Delete user record from database 
            $delete = $this->user->delete($id); 
             
            if($delete){ 
                // Set the response and exit 
                $this->response([ 
                    'status' => TRUE, 
                    'message' => 'User has been removed successfully.' 
                ], REST_Controller::HTTP_OK); 
            }else{ 
                // Set the response and exit 
                $this->response("Something went wrong, please try again.", REST_Controller::HTTP_BAD_REQUEST); 
            } 
        }else{ 
            // Set the response and exit 
            $this->response([ 
                'status' => FALSE, 
                'message' => 'No users were found.' 
            ], REST_Controller::HTTP_NOT_FOUND); 
        } 
    }   
} 

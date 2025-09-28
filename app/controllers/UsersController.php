<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UsersController
 */
class UsersController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UsersModel'); // load model once in constructor
    }

    // Show all users
    public function index()
    {
        $data['users'] = $this->UsersModel->all(); // fixed: all() not All()
        $this->call->view('users/index', $data);
    }

    // Create user
    function create(){
        if($this->io->method() == 'post'){
            $fname = $this->io->post('fname');
            $lname = $this->io->post('lname');
            $email = $this->io->post('email');

            $data = [
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email
            ];

            if($this->UsersModel->insert($data)){
                redirect(site_url('/')); // fixed redirect
            }else{
                echo "Error in creating user.";
            }
        }else{
            $this->call->view('users/create');
        }
    }

    // Update user
    function update($id){
        $user = $this->UsersModel->find($id);
        if(!$user){
            echo "User not found.";
            return;
        }

        if($this->io->method() == 'post'){
            $fname = $this->io->post('fname');
            $lname = $this->io->post('lname');
            $email = $this->io->post('email');

            $data = [
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email
            ];

            if($this->UsersModel->update($id, $data)){
                redirect(site_url('/')); // fixed redirect
            }else{
                echo "Error in updating user.";
            }
        }else{
            $data['user'] = $user;
            $this->call->view('users/update', $data);
        }
    }
    
    // Delete user
    function delete($id){
        if($this->UsersModel->delete($id)){
            redirect(site_url('/')); // fixed redirect
        }else{
            echo "Error in deleting user.";
        }
    }
}

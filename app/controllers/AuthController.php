<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UsersModel');
        // session library is autoloaded in app/config/autoload.php
    }

    public function login()
    {
        if ($this->io->method() == 'post') {
            $email = $this->io->post('email');
            $password = $this->io->post('password');

            // find user by email
            $user = $this->UsersModel->filter(['email' => $email])->get();
            if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
                // set session
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('role', isset($user['role']) ? $user['role'] : 'user');
                redirect(site_url(''));
            } else {
                $data['error'] = 'Invalid credentials';
                $this->call->view('auth/login', $data);
            }
        } else {
            $this->call->view('auth/login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'role']);
        redirect(site_url(''));
    }
}

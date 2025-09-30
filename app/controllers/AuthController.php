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
            // Ensure default admin exists (safe check, will not duplicate)
            $this->ensure_default_admin();
            $this->call->view('auth/login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'role']);
        redirect(site_url(''));
    }

    public function register()
    {
        // simple registration: creates a user with role 'user'
        if ($this->io->method() == 'post') {
            $email = $this->io->post('email');
            $fname = $this->io->post('fname');
            $lname = $this->io->post('lname');
            $password = $this->io->post('password');

            if (empty($email) || empty($password)) {
                $data['error'] = 'Email and password are required.';
                $this->call->view('auth/register', $data);
                return;
            }

            // ensure default admin exists
            $this->ensure_default_admin();

            // check if email already exists
            $exists = $this->UsersModel->filter(['email' => $email])->get();
            if ($exists) {
                $data['error'] = 'Email already registered.';
                $this->call->view('auth/register', $data);
                return;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = [
                'email' => $email,
                'fname' => $fname,
                'lname' => $lname,
                'password' => $hash,
                'role' => 'user'
            ];

            $id = $this->UsersModel->insert($insert);
            if ($id) {
                // log the user in
                $this->session->set_userdata('user_id', $id);
                $this->session->set_userdata('role', 'user');
                redirect(site_url(''));
            } else {
                $data['error'] = 'Registration failed. Ensure the students table has password and role columns.';
                $this->call->view('auth/register', $data);
            }
        } else {
            $this->call->view('auth/register');
        }
    }

    protected function ensure_default_admin()
    {
        // default admin credentials
        $admin_email = 'admin';
        $admin_password = 'aldge042224';

        // check if admin exists
        $admin = $this->UsersModel->filter(['email' => $admin_email])->get();
        if ($admin) return; // already exists

        // create with hashed password and role admin
        $hash = password_hash($admin_password, PASSWORD_DEFAULT);
        $this->UsersModel->insert([
            'email' => $admin_email,
            'fname' => 'Admin',
            'lname' => 'User',
            'password' => $hash,
            'role' => 'admin'
        ]);
    }
}

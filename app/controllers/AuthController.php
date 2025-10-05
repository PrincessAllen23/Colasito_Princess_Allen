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
            // safe debug: log attempt (no raw password)
            $logDir = realpath(__DIR__ . '/../../runtime/logs') ?: __DIR__ . '/../../runtime/logs';
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0777, true);
            }
            $logPath = $logDir . '/auth_debug.log';
            $preLog = sprintf("[%s] Login POST received: email=%s, password_len=%d\n", date('c'), $email, is_string($password) ? strlen($password) : 0);
            @file_put_contents($logPath, $preLog, FILE_APPEND | LOCK_EX);

            // find user by email
            $user = $this->UsersModel->filter(['email' => $email])->get();
            $pw_ok = false;
            if ($user && isset($user['password'])) {
                $pw_ok = password_verify($password, $user['password']);
            }

            $postLog = sprintf("[%s] Lookup result: email=%s, user_found=%d, pw_ok=%d, user_id=%s\n", date('c'), $email, $user ? 1 : 0, $pw_ok ? 1 : 0, isset($user['id']) ? $user['id'] : 'null');
            @file_put_contents($logPath, $postLog, FILE_APPEND | LOCK_EX);

            if ($user && $pw_ok) {
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
            $notice = $this->ensure_default_admin();
            if ($notice) {
                $data['notice'] = $notice;
            }
            $this->call->view('auth/login', isset($data) ? $data : []);
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
            $notice = $this->ensure_default_admin();
            if ($notice) {
                $data['notice'] = $notice;
            }
            $this->call->view('auth/register', isset($data) ? $data : []);
        }
    }

    protected function ensure_default_admin()
    {
    // default admin credentials (single admin)
    $admin_email = 'colasito@admin';
    $admin_password = 'c03232005';

        // If required columns are missing, do not attempt DB writes
        if (! $this->UsersModel->has_columns(['password', 'role'])) {
            return 'Database is missing required columns (password, role). Run the migration in migrations/001_add_auth_columns.sql and re-try.';
        }

        $hash = password_hash($admin_password, PASSWORD_DEFAULT);

        // Note: do not demote other admin accounts here. Primary admin is the one with the configured email.

        // Ensure primary admin exists and has the correct password & role
        $existing = $this->UsersModel->filter(['email' => $admin_email])->get();
        if ($existing) {
            // Update password and role if necessary
            $update = [];
            $update['password'] = $hash;
            $update['role'] = 'admin';
            $this->UsersModel->update($existing['id'], $update);
        } else {
            $this->UsersModel->insert([
                'email' => $admin_email,
                'fname' => 'Admin',
                'lname' => 'User',
                'password' => $hash,
                'role' => 'admin'
            ]);
        }

        return null; // success
    }
}

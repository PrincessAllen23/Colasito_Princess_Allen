<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AdminController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UsersModel');
    }

    // Admin dashboard: list users (paginated)
    public function index()
    {
        // only admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect(site_url('auth/login'));
        }

        $per_page = 20;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

        // reuse paginate in Model; pass empty search to get all
        $paginated = $this->UsersModel->paginate($per_page, $page, '');

        $this->call->library('Pagination');
        $pagination = new Pagination();
        $pagination->set_theme('tailwind');
        $pagination->set_options(['page_delimiter' => '?page=']);
        $pagination->initialize($paginated['total'], $per_page, $paginated['current_page'], 'admin', 5);

        $data['users'] = $paginated['data'];
        $data['pagination_html'] = $pagination->paginate();
        $data['pagination_meta'] = [
            'total' => $paginated['total'],
            'per_page' => $paginated['per_page'],
            'current_page' => $paginated['current_page'],
            'last_page' => $paginated['last_page']
        ];

        $this->call->view('admin/users', $data);
    }

    // Set role for a user (POST)
    public function set_role($id)
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect(site_url('auth/login'));
        }

        if ($this->io->method() == 'post') {
            $role = $this->io->post('role');
            if (!in_array($role, ['admin', 'user'])) {
                $role = 'user';
            }

            // If promoting to admin, demote any other admins first so there's only one admin at a time.
            if ($role === 'admin') {
                try {
                    $otherAdmins = $this->UsersModel->filter(['role' => 'admin'])->get_all();
                    if (!empty($otherAdmins)) {
                        foreach ($otherAdmins as $u) {
                            if (isset($u['id']) && $u['id'] != $id) {
                                $this->UsersModel->update($u['id'], ['role' => 'user']);
                            }
                        }
                    }
                } catch (Exception $e) {
                    // ignore DB errors here; we'll still attempt the update
                }
            }

            $this->UsersModel->update($id, ['role' => $role]);
        }

        // preserve page param
        $page = isset($_GET['page']) ? '?page=' . (int)$_GET['page'] : '';
        redirect(site_url('admin') . $page);
    }
}

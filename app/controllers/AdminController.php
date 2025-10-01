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
        // only primary admin (admin@admin) can access admin panel
        $uid = $this->session->userdata('user_id');
        if (!$uid) {
            redirect(site_url('auth/login'));
        }
        $current = $this->UsersModel->find($uid);
        if (!isset($current['email']) || $current['email'] !== 'admin@admin') {
            // not the primary admin -> redirect to login or home
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

            // Allow promoting/demoting - multiple admins allowed. Only the primary admin can access this controller.
            $this->UsersModel->update($id, ['role' => $role]);
        }

        // preserve page param
        $page = isset($_GET['page']) ? '?page=' . (int)$_GET['page'] : '';
        redirect(site_url('admin') . $page);
    }
}

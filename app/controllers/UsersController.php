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
        // Pagination settings
        $per_page = 5; // rows per page

        // Get current page and search query from query string
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';

        // Use model paginate helper (returns data, total, etc.) - pass search query
        $paginated = $this->UsersModel->paginate($per_page, $page, $q);

        // Load Pagination library and initialize
        $this->call->library('Pagination');
        $pagination = new Pagination();
        // use root as base route for pages (routes.php maps '/' to UsersController::index)
        $base_url = '';
    $pagination->set_theme('tailwind');
    // Use query string for page links so controller can read $_GET['page']
        // Keep search query in pagination links if present
        $page_delim = '?page=';
        if (!empty($q)) {
            // preserve q param: ?q=...&page=
            $page_delim = '?q=' . urlencode($q) . '&page=';
        }
        $pagination->set_options(['page_delimiter' => $page_delim]);
        $pagination->initialize($paginated['total'], $per_page, $paginated['current_page'], $base_url, 5);

        $data['users'] = $paginated['data'];
        $data['pagination_html'] = $pagination->paginate();
        $data['pagination_meta'] = [
            'total' => $paginated['total'],
            'per_page' => $paginated['per_page'],
            'current_page' => $paginated['current_page'],
            'last_page' => $paginated['last_page']
        ];
        // pass back search query so view can show it
        $data['q'] = $q;
        // (no debug output in production)

        $this->call->view('users/index', $data);
    }

    // Create user
    function create(){
        // Authorization: only admin can create
        if ($this->session->userdata('role') !== 'admin') {
            redirect(site_url('auth/login'));
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

            if($this->UsersModel->insert($data)){
                $page = $this->io->post('page') ? (int) $this->io->post('page') : 1;
                redirect(site_url('') . '?page=' . $page);
            }else{
                echo "Error in creating user.";
            }
        }else{
            $this->call->view('users/create');
        }
    }

    // Update user
    function update($id){
        // Authorization: only admin can update
        if ($this->session->userdata('role') !== 'admin') {
            redirect(site_url('auth/login'));
        }
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
                $page = $this->io->post('page') ? (int) $this->io->post('page') : 1;
                redirect(site_url('') . '?page=' . $page);
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
        // Authorization: only admin can delete
        if ($this->session->userdata('role') !== 'admin') {
            redirect(site_url('auth/login'));
        }

        if($this->UsersModel->delete($id)){
            // preserve page if provided via GET
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
            redirect(site_url('') . '?page=' . $page);
        }else{
            echo "Error in deleting user.";
        }
    }
}

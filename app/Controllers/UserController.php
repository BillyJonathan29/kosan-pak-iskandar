<?php

class UserController extends Controller {
    
    public function index() {
        $data = [
            'title' => 'Manajemen User',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => BASEURL],
                ['label' => 'User', 'url' => '']
            ],
            'users' => $this->model('User')->getAllUsers()
        ];

        $this->view('user/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah User',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => BASEURL],
                ['label' => 'User', 'url' => BASEURL . '/user'],
                ['label' => 'Tambah', 'url' => '']
            ]
        ];

        $this->view('user/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('User')->addUser($_POST) > 0) {
                // Flasher::setFlash('berhasil', 'ditambahkan', 'success');
                header('Location: ' . BASEURL . '/user');
                exit;
            } else {
                // Flasher::setFlash('gagal', 'ditambahkan', 'danger');
                header('Location: ' . BASEURL . '/user');
                exit;
            }
        }
    }

    public function edit($id) {
        $data = [
            'title' => 'Edit User',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => BASEURL],
                ['label' => 'User', 'url' => BASEURL . '/user'],
                ['label' => 'Edit', 'url' => '']
            ],
            'user' => $this->model('User')->getUserById($id)
        ];

        $this->view('user/edit', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('User')->updateUser($_POST) > 0) {
                header('Location: ' . BASEURL . '/user');
                exit;
            } else {
                header('Location: ' . BASEURL . '/user');
                exit;
            }
        }
    }

    public function delete($id) {
        if ($this->model('User')->deleteUser($id) > 0) {
            header('Location: ' . BASEURL . '/user');
            exit;
        } else {
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }
}

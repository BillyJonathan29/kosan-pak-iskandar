<?php

class UserController extends Controller {
    
    public function __construct()
    {
        $this->requireRole('admin');
    }

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
            $data = $_POST;
            $data['profile_image'] = $this->uploadImage();

            if ($this->model('User')->addUser($data) > 0) {
                header('Location: ' . BASEURL . '/user');
                exit;
            } else {
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
            $data = $_POST;
            
            $image = $this->uploadImage();
            if ($image) {
                $data['profile_image'] = $image;
            }

            if ($this->model('User')->updateUser($data) > 0) {
                header('Location: ' . BASEURL . '/user');
                exit;
            } else {
                header('Location: ' . BASEURL . '/user');
                exit;
            }
        }
    }

    private function uploadImage() {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $namaFile = $_FILES['profile_image']['name'];
            $ukuranFile = $_FILES['profile_image']['size'];
            $error = $_FILES['profile_image']['error'];
            $tmpName = $_FILES['profile_image']['tmp_name'];

            $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
            $ekstensiGambar = explode('.', $namaFile);
            $ekstensiGambar = strtolower(end($ekstensiGambar));

            if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
                return null;
            }

            if ($ukuranFile > 2000000) {
                return null;
            }

            $namaFileBaru = uniqid();
            $namaFileBaru .= '.';
            $namaFileBaru .= $ekstensiGambar;

            $targetDir = 'assets/img/profile/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            move_uploaded_file($tmpName, $targetDir . $namaFileBaru);

            return $namaFileBaru;
        }
        return null;
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

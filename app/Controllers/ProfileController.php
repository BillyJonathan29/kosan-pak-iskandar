<?php

class ProfileController extends Controller {
    
    private function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $this->requireLogin();

        $userId = $_SESSION['user']['id'];
        $user = $this->model('User')->getUserById($userId);

        $data = [
            'title' => 'Profile Saya',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => BASEURL],
                ['label' => 'Setting', 'url' => '#'],
                ['label' => 'Profile', 'url' => '']
            ],
            'user' => $user
        ];

        $this->view('setting/setting_profile', $data);
    }

    public function update() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $data['id'] = $_SESSION['user']['id'];
            
            // Note: role tetap dari session agar user tidak bisa ganti role sendiri via form
            $data['role'] = $_SESSION['user']['role'];

            $image = $this->uploadImage();
            if ($image) {
                $data['profile_image'] = $image;
            }

            if ($this->model('User')->updateUser($data)) {
                // Update session
                $_SESSION['user']['name'] = $data['name'];
                $_SESSION['user']['email'] = $data['email'];
                if ($image) {
                    $_SESSION['user']['profile_image'] = $image;
                }

                $_SESSION['flash'] = [
                    'pesan' => 'Profil berhasil diperbarui!',
                    'tipe' => 'success'
                ];
            } else {
                $_SESSION['flash'] = [
                    'pesan' => 'Gagal memperbarui profil.',
                    'tipe' => 'danger'
                ];
            }
            header('Location: ' . BASEURL . '/profile');
            exit;
        }
    }

    private function uploadImage() {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $namaFile = $_FILES['profile_image']['name'];
            $ukuranFile = $_FILES['profile_image']['size'];
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

            $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
            $targetDir = 'assets/img/profile/';
            
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            move_uploaded_file($tmpName, $targetDir . $namaFileBaru);
            return $namaFileBaru;
        }
        return null;
    }
}

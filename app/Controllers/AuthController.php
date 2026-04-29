<?php

class AuthController extends Controller {
    
    public function index() {
        // Jika sudah login, arahkan ke dashboard
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/katalog');
            exit;
        }

        $data = [
            'title' => 'Login Kosan'
        ];

        // Memanggil view auth/login tanpa memanggil template dashboard
        $this->view('auth/login', $data);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->getUserByEmail($email);

            if ($user) {
                // Verifikasi password
                if (password_verify($password, $user['password'])) {
                    // Set session user
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ];

                    // Redirect berdasarkan role
                    if ($user['role'] === 'admin') {
                        header('Location: ' . BASEURL . '/home');
                    } else {
                        header('Location: ' . BASEURL . '/katalog');
                    }
                    exit;
                } else {
                    // Password salah
                    $_SESSION['flash'] = [
                        'pesan' => 'Password salah!',
                        'tipe' => 'danger'
                    ];
                    header('Location: ' . BASEURL . '/auth');
                    exit;
                }
            } else {
                // User tidak ditemukan
                $_SESSION['flash'] = [
                    'pesan' => 'Email tidak terdaftar!',
                    'tipe' => 'danger'
                ];
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}

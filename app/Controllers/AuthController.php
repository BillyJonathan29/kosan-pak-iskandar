<?php

class AuthController extends Controller
{

    public function index()
    {
        // Jika sudah login, arahkan ke katalog
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/katalog');
            exit;
        }

        $data = [
            'title' => 'Login - Kosan Pak Iskandar'
        ];

        $this->view('auth/login', $data);
    }

    public function register()
    {
        // Jika sudah login, arahkan ke katalog
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/katalog');
            exit;
        }

        $data = [
            'title' => 'Daftar Akun - Kosan Pak Iskandar'
        ];

        $this->view('auth/register', $data);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');

            // Cek apakah email sudah terdaftar
            if ($userModel->getUserByEmail($_POST['email'])) {
                $_SESSION['flash'] = [
                    'pesan' => 'Email sudah terdaftar!',
                    'tipe' => 'danger'
                ];
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            // Hash password
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $_POST['role'] = 'user';
            $_POST['profile_image'] = null;

            if ($userModel->addUser($_POST)) {
                $_SESSION['flash'] = [
                    'pesan' => 'Registrasi berhasil! Silakan login.',
                    'tipe' => 'success'
                ];
                header('Location: ' . BASEURL . '/auth');
                exit;
            } else {
                $_SESSION['flash'] = [
                    'pesan' => 'Registrasi gagal!',
                    'tipe' => 'danger'
                ];
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }
        }
    }

    public function login()
    {
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
                        'role' => $user['role'],
                        'profile_image' => $user['profile_image']
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

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . '/katalog');
        exit;
    }

    // Login with Google
    public function google()
    {
        // var_dump(GOOGLE_CLIENT_ID);
        // die();
        $client = new Google\Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->addScope("email");
        $client->addScope("profile");

        $authUrl = $client->createAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    }

    // Google Callback
    public function callback()
    {
        $client = new Google\Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);

        if (isset($_GET['code'])) {
            try {
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($token);

                // Ambil data profil dari Google
                $googleService = new Google\Service\Oauth2($client);
                $googleUser = $googleService->userinfo->get();

                $email = $googleUser->email;
                $name = $googleUser->name;
                $googleId = $googleUser->id;
                $picture = $googleUser->picture;

                $userModel = $this->model('User');
                $user = $userModel->getUserByEmail($email);

                if (!$user) {
                    // Jika belum terdaftar, buat akun baru otomatis
                    $userData = [
                        'name' => $name,
                        'email' => $email,
                        'phone' => '-', // Placeholder, user bisa update nanti
                        'password' => password_hash($googleId . time(), PASSWORD_DEFAULT), // Random password
                        'role' => 'user',
                        'profile_image' => null // Bisa diupdate dengan $picture jika mau download filenya
                    ];

                    if ($userModel->addUser($userData)) {
                        $user = $userModel->getUserByEmail($email);
                    }
                }

                if ($user) {
                    // Set session user
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'profile_image' => $user['profile_image']
                    ];

                    header('Location: ' . BASEURL . '/katalog');
                    exit;
                } else {
                    $_SESSION['flash'] = ['pesan' => 'Gagal login dengan Google!', 'tipe' => 'danger'];
                    header('Location: ' . BASEURL . '/auth');
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['flash'] = ['pesan' => 'Terjadi kesalahan: ' . $e->getMessage(), 'tipe' => 'danger'];
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }
}

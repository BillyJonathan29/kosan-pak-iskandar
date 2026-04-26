<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $title ?? 'Login - Kosan Pak Iskandar' ?></title>
    
    <!-- CSS Bootstrap dari template -->
    <link href="<?= BASEURL ?>/assets/css/styles.css" rel="stylesheet" />
    <script src="<?= BASEURL ?>/assets/js/all.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h3 {
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1.25rem;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #6c757d;
        }

        .form-control.with-icon {
            border-left: none;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4);
            color: white;
        }

        .logo-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 d-flex justify-content-center">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-home logo-icon"></i>
                        <h3>Selamat Datang</h3>
                        <p>Silakan login untuk mengakses akun Anda</p>
                    </div>

                    <?php if(isset($_SESSION['flash'])): ?>
                        <div class="alert alert-<?= $_SESSION['flash']['tipe'] ?> alert-dismissible fade show shadow-sm" role="alert">
                            <?= $_SESSION['flash']['pesan'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['flash']); ?>
                    <?php endif; ?>

                    <form action="<?= BASEURL ?>/auth/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input class="form-control with-icon" id="email" name="email" type="email" placeholder="name@example.com" required autocomplete="email" autofocus />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input class="form-control with-icon" id="password" name="password" type="password" placeholder="Masukkan password" required />
                                <span class="input-group-text" style="cursor: pointer; border-left: none; border-right: 1px solid #ced4da;" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" id="rememberPasswordCheck" type="checkbox" value="" />
                                <label class="form-check-label small" for="rememberPasswordCheck">Ingat Saya</label>
                            </div>
                            <!-- Jika ada fitur lupa password, uncomment baris di bawah -->
                            <!-- <a class="small text-decoration-none" href="password.html" style="color: #667eea;">Lupa Password?</a> -->
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-login">Login <i class="fas fa-sign-in-alt ms-1"></i></button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <div class="small text-muted">
                            Kosan Pak Iskandar &copy; <?= date('Y') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASEURL ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

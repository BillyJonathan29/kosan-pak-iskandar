<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $title ?? 'Daftar Akun - Kosan Pak Iskandar' ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --dark-color: #2b2d42;
            --light-bg: #f8faff;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 20px 60px rgba(67, 97, 238, 0.1);
            overflow: hidden;
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 650px;
        }

        .auth-side-image {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .auth-side-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1554995207-c18c203602cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            mix-blend-mode: overlay;
        }

        .auth-form-container {
            flex: 1.2;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-logo {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .auth-title {
            font-weight: 800;
            font-size: 2rem;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #64748b;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 1rem;
            padding: 0.8rem 1.2rem;
            border: 2px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            border-radius: 1rem;
            padding: 0.9rem;
            font-weight: 700;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        }

        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .google-btn {
            background-color: white;
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.8rem;
            font-weight: 600;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .google-btn:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: var(--dark-color);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #94a3b8;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider:not(:empty)::before {
            margin-right: 1rem;
        }

        .divider:not(:empty)::after {
            margin-left: 1rem;
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
            color: #64748b;
        }

        .auth-footer a {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 991px) {
            .auth-side-image {
                display: none;
            }

            .auth-card {
                max-width: 500px;
            }
        }

        @media (max-width: 576px) {
            .auth-wrapper {
                padding: 1rem;
            }

            .auth-form-container {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

    <div class="auth-wrapper">
        <div class="auth-card animate__animated animate__zoomIn">
            <!-- Left Side: Image/Info -->
            <div class="auth-side-image">
                <div class="position-relative z-1">
                    <h2 class="display-5 fw-800 mb-4 animate__animated animate__fadeInDown animate__delay-1s">Mulai Perjalananmu <br>Bersama Kami.</h2>
                    <p class="lead opacity-75 mb-5 animate__animated animate__fadeInUp animate__delay-1s">Sistem manajemen kos yang memudahkan segala urusan hunianmu dalam satu genggaman.</p>

                    <div class="d-flex align-items-center gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="bg-white bg-opacity-25 p-3 rounded-4 backdrop-blur">
                            <i class="fas fa-check-double fs-3"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Proses Cepat</div>
                            <div class="small opacity-75">Daftar dan cari kamar dalam 5 menit</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="auth-form-container">
                <a href="<?= BASEURL ?>" class="auth-logo">
                    <i class="fas fa-house-chimney-window"></i>
                    <span>Kosan Pak Iskandar</span>
                </a>

                <h1 class="auth-title">Buat Akun</h1>
                <p class="auth-subtitle">Daftarkan diri Anda untuk mulai mencari hunian.</p>

                <?php if (isset($_SESSION['flash'])): ?>
                    <div class="alert alert-<?= $_SESSION['flash']['tipe'] ?> alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <?= $_SESSION['flash']['pesan'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>

                <form action="<?= BASEURL ?>/auth/store" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" name="phone" class="form-control" placeholder="0812..." required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input id="register-password" type="password" name="password" class="form-control" placeholder="••••••••" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggle-register-password" title="Tampilkan/ Sembunyikan Password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary-custom">
                            Daftar Sekarang <i class="fas fa-user-plus ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="divider">atau daftar dengan</div>

                <a href="<?= BASEURL ?>/auth/google" class="google-btn">
                    <img src="<?= BASEURL ?>/assets/img/google.png" width="20" height="20" alt="Google Logo">
                    Continue with Google
                </a>

                <div class="auth-footer">
                    Sudah punya akun? <a href="<?= BASEURL ?>/auth">Login di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            const pwd = document.getElementById('register-password');
            const btn = document.getElementById('toggle-register-password');
            if (btn && pwd) {
                btn.addEventListener('click', function() {
                    if (pwd.type === 'password') {
                        pwd.type = 'text';
                        btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    } else {
                        pwd.type = 'password';
                        btn.innerHTML = '<i class="fas fa-eye"></i>';
                    }
                });
            }
        })();
    </script>
</body>

</html>
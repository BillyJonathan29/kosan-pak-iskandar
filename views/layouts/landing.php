<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Kosan Pak Iskandar - Hunian nyaman, aman, dan strategis." />
    <title><?= $title ?? 'Kosan Pak Iskandar - Hunian Nyaman & Aman' ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
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
            --light-color: #f8f9fa;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fdfdfd;
            color: var(--dark-color);
            scroll-behavior: smooth;
        }

        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1.2rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar.scrolled {
            padding: 0.8rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.98);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            margin-right: 12px;
            font-size: 1.8rem;
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark-color) !important;
            margin: 0 12px;
            position: relative;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white !important;
            font-weight: 600;
            padding: 0.7rem 1.8rem;
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px 0 rgba(67, 97, 238, 0.39);
        }

        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.23);
        }

        .footer {
            background-color: #0b0c10;
            color: white;
            padding: 5rem 0 2rem;
        }

        .footer h5,
        .footer h6 {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 0.75rem;
        }

        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Micro-animations */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .page-content {
            min-height: 80vh;
        }

        section {
            padding: 80px 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <?php
            $brandUrl = BASEURL;
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
                $brandUrl = BASEURL . '/home';
            }
            ?>
            <a class="navbar-brand animate__animated animate__fadeInLeft" href="<?= $brandUrl ?>">
                <i class="fas fa-house-chimney-window"></i>
                <span>Kosan Pak Iskandar</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center animate__animated animate__fadeInRight">
                    <?php if (isset($title) && $title === 'Katalog Kamar'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASEURL ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#katalog">Katalog Kamar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#fasilitas">Fasilitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimoni">Testimoni</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item ms-lg-4">
                            <div class="dropdown">
                                <a class="btn btn-primary-custom dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <?php
                                    $avatar = !empty($_SESSION['user']['profile_image']) ? BASEURL . '/assets/img/profile/' . $_SESSION['user']['profile_image'] : BASEURL . '/assets/img/default-avatar.jpg';
                                    ?>
                                    <img src="<?= $avatar ?>" class="rounded-circle me-2" width="25" height="25" style="object-fit: cover; border: 1px solid rgba(255,255,255,0.5);">
                                    <?= explode(' ', $_SESSION['user']['name'])[0] ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-2" style="border-radius: 15px;">
                                    <?php if (!isset($title) || $title !== 'Katalog Kamar'): ?>
                                        <li><a class="dropdown-item py-2 rounded-3" href="<?= BASEURL ?>/katalog"><i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard / Katalog</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item py-2 rounded-3" href="<?= BASEURL ?>/katalog"><i class="fas fa-search me-2 text-primary"></i> Cari Kamar</a></li>
                                    <li><a class="dropdown-item py-2 rounded-3" href="<?= BASEURL ?>/booking"><i class="fas fa-calendar-check me-2 text-primary"></i> Riwayat Booking</a></li>
                                    <li><a class="dropdown-item py-2 rounded-3" href="<?= BASEURL ?>/review/my"><i class="fas fa-star me-2 text-primary"></i> Ulasan Saya</a></li>
                                    <li><a class="dropdown-item py-2 rounded-3" href="<?= BASEURL ?>/profile"><i class="fas fa-user-cog me-2 text-primary"></i> Profil Saya</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item py-2 rounded-3 text-danger" href="<?= BASEURL ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-4 d-flex gap-2">
                            <a class="nav-link fw-bold px-3 py-2" href="<?= BASEURL ?>/auth">Masuk</a>
                            <a class="btn btn-primary-custom" href="<?= BASEURL ?>/auth/register">Daftar Sekarang</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-content">
        <?= $content ?? '' ?>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark pt-5 pb-4">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4 col-md-12">
                    <div class="navbar-brand text-white mb-4">
                        <i class="fas fa-house-chimney-window text-primary"></i>
                        <span class="text-white ms-2">Kosan Pak Iskandar</span>
                    </div>
                    <p class="text-light mb-4" style="line-height: 1.8;">
                        Menyediakan hunian yang tidak hanya sekadar tempat tinggal, tapi rumah kedua bagi Anda. Mengutamakan kenyamanan, keamanan, dan kebersihan.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="https://wa.me/628122218062" target="_blank" class="social-btn text-success"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-3">Navigasi</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none footer-link">Beranda</a></li>
                        <li class="mb-2"><a href="#katalog" class="text-light text-decoration-none footer-link">Katalog Kamar</a></li>
                        <li class="mb-2"><a href="#fasilitas" class="text-light text-decoration-none footer-link">Fasilitas</a></li>
                        <li class="mb-2"><a href="#testimoni" class="text-light text-decoration-none footer-link">Testimoni</a></li>
                    </ul>
                </div>

                <div class="col-lg-5 col-md-6">
                    <h6 class="text-white mb-3">Lokasi & Kontak</h6>
                    <ul class="list-unstyled mb-3">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                            <span class="text-light">2FGG+7GC, Jl. Pramuka, Purwawinangun, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45512</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-phone-alt text-primary me-3"></i>
                            <span class="text-light">+62 812-2218-062</span>
                        </li>
                    </ul>

                    <div class="mt-3">
                        <iframe
                            src="https://maps.google.com/maps?q=Jl.+Pramuka,+Purwawinangun,+Kec.+Kuningan,+Kabupaten+Kuningan,+Jawa+Barat+45512&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            width="100%"
                            height="180"
                            style="border:0; border-radius: 8px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <a href="https://maps.app.goo.gl/qJzK9wR1o7n7WbU6A" target="_blank" class="small text-primary text-decoration-none mt-2 d-inline-block">
                            <i class="fas fa-external-link-alt me-1"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>

            </div>

            <div class="pt-4 mt-5 border-top border-secondary text-center text-light small">
                <p class="mb-0">© <?= date('Y') ?> <strong>Kosan Pak Iskandar</strong>. Made with <i class="fas fa-heart text-danger"></i> for Comfort Living.</p>
            </div>
        </div>
    </footer>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            if (window.scrollY > 80) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
    </script>
    <?= $scripts ?? '' ?>
</body>

</html>
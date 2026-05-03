<?php
// =====================================================
// GUARD: Harus login untuk mengakses halaman ini
// =====================================================
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASEURL . '/auth');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $title ?? 'Kos-kosan Pak Iskandar' ?></title>

    <link href="<?= BASEURL ?>/assets/css/style.min.css" rel="stylesheet" />
    <link href="<?= BASEURL ?>/assets/css/styles.css" rel="stylesheet" />
    <script src="<?= BASEURL ?>/assets/js/all.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="<?= BASEURL ?>">Kosan Pak Iskandar</a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li class="text-center px-1">
                        <?php 
                            $avatar = !empty($_SESSION['user']['profile_image']) ? BASEURL . '/assets/img/profile/' . $_SESSION['user']['profile_image'] : BASEURL . '/assets/img/default-avatar.jpg';
                        ?>
                        <img class="img-account-profile rounded-circle mb-2 mt-2"
                            src="<?= $avatar ?>"
                            alt="Avatar" style="width: 80px; height: 80px; object-fit: cover;">

                        <h6 class="mb-0">
                            <?= $_SESSION['user']['name'] ?? 'Guest'; ?>
                        </h6>

                        <small class="text-muted d-block mb-2">
                            <?= ucfirst($_SESSION['user']['role'] ?? 'Pengunjung'); ?>
                        </small>

                        <a href="<?= BASEURL ?>/profile" class="btn btn-sm btn-secondary mb-2">
                            Lihat Profile
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item" href="<?= BASEURL ?>/auth/logout">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <?php
                    include __DIR__ . '/menu.php';
                    ?>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $title ?? 'Dashboard' ?></h1>

                    <?php if (!empty($breadcrumbs)): ?>
                        <ol class="breadcrumb mb-4">
                            <?php foreach ($breadcrumbs as $bc): ?>
                                <?php if (!empty($bc['url'])): ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?= $bc['url'] ?>">
                                            <?= $bc['label'] ?>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active">
                                        <?= $bc['label'] ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>

                <?= $content ?? '' ?>

            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Kosan Pak Iskandar <?= date('Y') ?></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <?= $modal ?? '' ?>

    <script src="<?= BASEURL ?>/assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= BASEURL ?>/assets/js/scripts.js"></script>
    <script src="<?= BASEURL ?>/assets/js/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?= BASEURL ?>/assets/js/simple-datatables.min.js" crossorigin="anonymous"></script>

    <?= $scripts ?? '' ?>

</body>

</html>
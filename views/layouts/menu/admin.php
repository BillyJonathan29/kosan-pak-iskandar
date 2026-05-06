<div class="nav">

    <div class="sb-sidenav-menu-heading">Main</div>
    <a class="nav-link" href="<?= BASEURL ?>/home">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
    </a>

    <div class="sb-sidenav-menu-heading">Manajemen</div>
    <a class="nav-link" href="<?= BASEURL ?>/user">
        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
        Data User
    </a>
    <a class="nav-link" href="<?= BASEURL ?>/kos">
        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
        Data Kos
    </a>

    <!-- Dropdown: Kamar -->
    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKamar"
        aria-expanded="false" aria-controls="collapseKamar">
        <div class="sb-nav-link-icon"><i class="fas fa-door-open"></i></div>
        Kamar
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseKamar" aria-labelledby="headingKamar" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="<?= BASEURL ?>/room">
                <div class="sb-nav-link-icon"><i class="fas fa-bed"></i></div>
                Data Kamar
            </a>
            <a class="nav-link" href="<?= BASEURL ?>/facility">
                <div class="sb-nav-link-icon"><i class="fas fa-concierge-bell"></i></div>
                Data Fasilitas
            </a>
            <a class="nav-link" href="<?= BASEURL ?>/roomfacility">
                <div class="sb-nav-link-icon"><i class="fas fa-link"></i></div>
                Fasilitas Kamar
            </a>
        </nav>
    </div>

    <!-- <a class="nav-link" href="<?= BASEURL ?>/penyewa">
        <div class="sb-nav-link-icon"><i class="fas fa-user-check"></i></div>
        Data Penyewa
    </a> -->
    <a class="nav-link" href="<?= BASEURL ?>/booking">
        <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
        Booking
    </a>
    <a class="nav-link" href="<?= BASEURL ?>/transaction">
        <div class="sb-nav-link-icon"><i class="fas fa-money-bill-wave"></i></div>
        Data Transaksi
    </a>

    <div class="sb-sidenav-menu-heading">Akun</div>
    <a class="nav-link" href="<?= BASEURL ?>/profile">
        <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
        Profil Saya
    </a>
    <a class="nav-link" href="<?= BASEURL ?>/auth/logout">
        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
        Logout
    </a>

</div>
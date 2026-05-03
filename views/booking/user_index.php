<?php ob_start(); ?>

<div class="container py-5" style="margin-top: 50px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-5 animate__animated animate__fadeIn">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASEURL ?>" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Riwayat Booking Saya</li>
        </ol>
    </nav>

    <div class="row mb-4 align-items-center animate__animated animate__fadeInUp">
        <div class="col-md-6">
            <h2 class="fw-800 mb-2">Riwayat Pemesanan</h2>
            <p class="text-muted">Pantau status booking dan pembayaran kamar Anda di sini.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= BASEURL ?>#katalog" class="btn btn-primary-custom">
                <i class="fas fa-plus me-2"></i> Cari Kamar Lagi
            </a>
        </div>
    </div>

    <?php if (empty($bookings)) : ?>
        <div class="card border-0 shadow-sm rounded-5 p-5 text-center animate__animated animate__zoomIn">
            <div class="bg-light rounded-circle d-inline-flex p-4 mb-4 mx-auto">
                <i class="fas fa-calendar-times fa-3x text-muted"></i>
            </div>
            <h4 class="fw-bold">Belum Ada Pesanan</h4>
            <p class="text-muted mb-4">Anda belum melakukan pemesanan kamar apapun saat ini.</p>
            <a href="<?= BASEURL ?>#katalog" class="btn btn-primary-custom btn-lg px-5">Jelajahi Kamar</a>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($bookings as $b) : ?>
                <div class="col-12 animate__animated animate__fadeInUp">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-lift border-start border-4 <?= $b['status'] == 'confirmed' ? 'border-success' : ($b['status'] == 'pending' ? 'border-warning' : 'border-danger') ?>">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-lg-1 col-md-2 mb-3 mb-md-0 text-center">
                                    <div class="bg-primary-subtle text-primary p-3 rounded-4">
                                        <i class="fas fa-bed fs-4"></i>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                    <h5 class="fw-bold mb-1">Kamar <?= htmlspecialchars($b['room_number']); ?></h5>
                                    <p class="text-muted small mb-0"><i class="fas fa-building me-1"></i> <?= htmlspecialchars($b['kos_name']); ?></p>
                                    <div class="mt-2">
                                        <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($b['booking_date'])); ?></span>
                                        <span class="mx-2 text-muted">|</span>
                                        <span class="text-muted small"><i class="far fa-clock me-1"></i> <?= $b['duration']; ?> Bulan</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                                    <div class="text-muted small mb-1">Total Pembayaran</div>
                                    <h5 class="fw-bold text-dark mb-0">Rp <?= number_format($b['total_price'], 0, ',', '.'); ?></h5>
                                </div>
                                <div class="col-lg-2 col-md-6 mb-3 mb-md-0 text-md-center">
                                    <?php
                                        $badgeClass = match($b['status']) {
                                            'pending'   => 'bg-warning-subtle text-warning',
                                            'confirmed' => 'bg-success-subtle text-success',
                                            'cancelled' => 'bg-danger-subtle text-danger',
                                            'completed' => 'bg-primary-subtle text-primary',
                                            default     => 'bg-secondary-subtle text-secondary'
                                        };
                                        $label = match($b['status']) {
                                            'pending'   => 'Menunggu',
                                            'confirmed' => 'Aktif',
                                            'cancelled' => 'Dibatalkan',
                                            'completed' => 'Selesai',
                                            default     => ucfirst($b['status'])
                                        };
                                    ?>
                                    <span class="badge <?= $badgeClass ?> px-3 py-2 rounded-pill fw-bold">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> <?= $label ?>
                                    </span>
                                </div>
                                <div class="col-lg-2 col-md-6 text-md-end">
                                    <div class="d-flex gap-2 justify-content-md-end">
                                        <a href="<?= BASEURL ?>/payment/pay/<?= $b['id'] ?>" class="btn btn-primary btn-sm rounded-pill px-3 <?= $b['status'] != 'confirmed' ? 'disabled' : '' ?>">
                                            <i class="fas fa-wallet me-1"></i> Bayar
                                        </a>
                                        <button class="btn btn-outline-dark btn-sm rounded-circle shadow-none" title="Detail">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();

ob_start();
?>
<style>
    .fw-800 { font-weight: 800; }
    .bg-primary-subtle { background-color: #e0e7ff; }
    .bg-success-subtle { background-color: #dcfce7; }
    .bg-warning-subtle { background-color: #fef9c3; }
    .bg-danger-subtle { background-color: #fee2e2; }
    .bg-secondary-subtle { background-color: #f3f4f6; }
</style>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/landing.php';
?>

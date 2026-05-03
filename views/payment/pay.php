<?php ob_start(); ?>

<div class="container py-5" style="margin-top: 50px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-5 animate__animated animate__fadeIn">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASEURL ?>" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= BASEURL ?>/booking" class="text-decoration-none text-muted">Riwayat Booking</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Checkout Pembayaran</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Kolom Kiri: Detail Booking & Kamar -->
        <div class="col-lg-8 animate__animated animate__fadeInLeft">
            <div class="card border-0 shadow-sm rounded-5 overflow-hidden mb-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="fw-800 mb-0 d-flex align-items-center">
                        <i class="fas fa-receipt text-primary me-3"></i> Detail Booking #<?= $booking['id'] ?>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4">
                            <?php 
                            $imgSrc = !empty($booking['room_image']) 
                                ? BASEURL . '/assets/img/rooms/' . $booking['room_image'] 
                                : 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=400&q=80';
                            ?>
                            <img src="<?= $imgSrc ?>" class="img-fluid rounded-4 shadow-sm" alt="Room" style="width: 100%; height: 180px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <h4 class="fw-800 mb-1">Kamar <?= htmlspecialchars($booking['room_number']) ?></h4>
                            <p class="text-muted mb-3"><i class="fas fa-building me-2"></i> <?= htmlspecialchars($booking['kos_name']) ?></p>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="small text-muted mb-1">Status Booking</div>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                                        <i class="fas fa-check-circle me-1"></i> Terkonfirmasi
                                    </span>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted mb-1">Status Pembayaran</div>
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill fw-bold">
                                        <i class="fas fa-clock me-1"></i> <?= strtoupper($payment['payment_status']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <h6 class="fw-800 mb-3"><i class="fas fa-info-circle text-primary me-2"></i> Ringkasan Sewa</h6>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <div class="small text-muted mb-1">Harga Kamar</div>
                                <div class="fw-bold text-dark">Rp <?= number_format($booking['room_price'], 0, ',', '.') ?> / Bulan</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <div class="small text-muted mb-1">Durasi Sewa</div>
                                <div class="fw-bold text-dark"><?= $booking['duration'] ?> Bulan</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <div class="small text-muted mb-1">Tanggal Mulai</div>
                                <div class="fw-bold text-dark"><?= date('d M Y', strtotime($booking['booking_date'])) ?></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-primary-subtle rounded-4 h-100">
                                <div class="small text-primary mb-1">Total Pembayaran</div>
                                <div class="fw-800 text-primary fs-5">Rp <?= number_format($payment['amount'], 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 p-4 mb-4">
                <h6 class="fw-800 mb-3"><i class="fas fa-sparkles text-warning me-2"></i> Fasilitas Kamar</h6>
                <div class="row g-2">
                    <?php foreach ($facilities as $f): ?>
                        <div class="col-md-4 col-6">
                            <div class="d-flex align-items-center p-2 rounded-3">
                                <i class="<?= $f['icon'] ?? 'fas fa-check' ?> text-primary me-3"></i>
                                <span class="small fw-bold"><?= htmlspecialchars($f['facility_name']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi Pembayaran -->
        <div class="col-lg-4 animate__animated animate__fadeInRight">
            <div class="sticky-top" style="top: 120px;">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary-subtle text-primary p-4 rounded-circle d-inline-flex mb-4">
                            <i class="fas fa-credit-card fa-3x"></i>
                        </div>
                        <h4 class="fw-800 mb-2">Metode Pembayaran</h4>
                        <p class="text-muted small mb-4">Pilih metode pembayaran favorit Anda melalui gerbang pembayaran aman Midtrans.</p>
                        
                        <div class="d-grid gap-3 mb-4">
                            <button id="pay-button" class="btn btn-primary-custom btn-lg py-3 shadow-lg">
                                <i class="fas fa-wallet me-2"></i> Bayar Sekarang
                            </button>
                            <a href="<?= BASEURL ?>/booking/delete/<?= $booking['id'] ?>" class="btn btn-outline-danger btn-lg py-3 border-0 small fw-bold" onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                                <i class="fas fa-times-circle me-2"></i> Batalkan Booking
                            </a>
                        </div>

                        <div class="d-flex justify-content-center gap-3 opacity-50">
                            <i class="fab fa-cc-visa fs-3"></i>
                            <i class="fab fa-cc-mastercard fs-3"></i>
                            <i class="fas fa-university fs-3"></i>
                            <i class="fas fa-mobile-alt fs-3"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 py-3 text-center">
                        <small class="text-muted"><i class="fas fa-lock me-1"></i> Secure 256-bit SSL Encryption</small>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-white shadow-sm rounded-5 border-start border-4 border-warning">
                    <h6 class="fw-bold mb-2 small"><i class="fas fa-info-circle me-2"></i> Informasi Penting</h6>
                    <p class="small text-muted mb-0">Pembayaran yang sudah dilakukan tidak dapat dikembalikan. Pastikan detail booking sudah sesuai sebelum membayar.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

ob_start();
?>
<?php if (MIDTRANS_IS_PRODUCTION): ?>
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
<?php else: ?>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
<?php endif; ?>
<script type="text/javascript">
  var payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', function () {
    window.snap.pay('<?= $payment['snap_token'] ?>', {
      onSuccess: function (result) {
        window.location.href = '<?= BASEURL ?>/payment/finish?order_id=' + result.order_id;
      },
      onPending: function (result) {
        window.location.href = '<?= BASEURL ?>/payment/unfinish?order_id=' + result.order_id;
      },
      onError: function (result) {
        window.location.href = '<?= BASEURL ?>/payment/error?order_id=' + result.order_id;
      },
      onClose: function () {
        // Optional: Do nothing or show message
      }
    });
  });
</script>
<style>
    .fw-800 { font-weight: 800; }
    .bg-primary-subtle { background-color: #e0e7ff; }
    .bg-success-subtle { background-color: #dcfce7; }
    .bg-warning-subtle { background-color: #fef9c3; }
</style>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/landing.php';
?>

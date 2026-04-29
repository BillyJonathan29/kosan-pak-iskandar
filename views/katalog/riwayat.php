<?php ob_start(); ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold">Riwayat Pesanan Saya</h2>
            <p class="text-muted">Pantau status booking kamar Anda di sini.</p>
        </div>
    </div>

    <?php if (empty($bookings)) : ?>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center py-5">
                <div class="bg-white p-5 rounded-4 shadow-sm border">
                    <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                    <h5 class="fw-bold">Belum Ada Pesanan</h5>
                    <p class="text-muted">Anda belum melakukan booking kamar apa pun.</p>
                    <a href="<?= BASEURL ?>/katalog" class="btn btn-primary px-4 rounded-pill">Lihat Katalog</a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($bookings as $b) : ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <?php
                                $imgSrc = !empty($b['image'])
                                    ? BASEURL . '/assets/img/rooms/' . $b['image']
                                    : 'https://placehold.co/600x400/e9ecef/6c757d?text=Room';
                                ?>
                                <img src="<?= $imgSrc ?>" class="img-fluid h-100" style="object-fit: cover; min-height: 180px;" alt="Kamar">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($b['kos_name']) ?></h5>
                                            <p class="text-muted small mb-0">Nomor Kamar: <span class="fw-bold text-dark"><?= htmlspecialchars($b['room_number']) ?></span></p>
                                        </div>
                                        <?php
                                        $statusClass = 'bg-warning text-dark';
                                        if ($b['status'] === 'confirmed') $statusClass = 'bg-success';
                                        if ($b['status'] === 'rejected') $statusClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $statusClass ?> px-3 py-2 rounded-pill text-uppercase" style="font-size: 10px;">
                                            <?= htmlspecialchars($b['status']) ?>
                                        </span>
                                    </div>

                                    <hr class="my-3 opacity-10">

                                    <div class="row text-center">
                                        <div class="col-4 border-end">
                                            <small class="text-muted d-block">Tanggal Booking</small>
                                            <span class="fw-bold"><?= date('d M Y', strtotime($b['booking_date'])) ?></span>
                                        </div>
                                        <div class="col-4 border-end">
                                            <small class="text-muted d-block">Durasi</small>
                                            <span class="fw-bold"><?= $b['duration'] ?> Bulan</span>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted d-block">Total Bayar</small>
                                            <span class="fw-bold text-success">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></span>
                                        </div>
                                    </div>
                                    
                                    <?php if ($b['status'] === 'pending') : ?>
                                        <div class="mt-4 p-2 bg-light rounded text-center small text-muted italic">
                                            <i class="fas fa-clock me-1"></i> Menunggu konfirmasi pembayaran oleh admin.
                                        </div>
                                    <?php endif; ?>
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
require_once __DIR__ . '/../layouts/template.php';
?>

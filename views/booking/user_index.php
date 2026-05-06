<?php ob_start(); ?>

<div class="container py-5" style="margin-top: 50px; min-height: 70vh;">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 animate__animated animate__fadeInDown">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="<?= BASEURL ?>" class="text-decoration-none text-muted"><i class="fas fa-home me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Riwayat Booking Saya</li>
                </ol>
            </nav>
            <h2 class="fw-800 text-dark mb-0 tracking-tight">Perjalanan <span class="text-gradient">Booking Anda</span></h2>
            <p class="text-muted mt-2 mb-0">Kelola dan pantau semua transaksi penyewaan kamar Anda di sini.</p>
        </div>
        <div class="mt-4 mt-md-0">
            <a href="<?= BASEURL ?>/katalog" class="btn btn-gradient-primary rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2 hover-scale">
                <i class="fas fa-compass"></i> Eksplorasi Kamar
            </a>
        </div>
    </div>

    <?php if (empty($bookings)) : ?>
        <!-- Empty State -->
        <div class="card border-0 shadow-sm rounded-5 p-5 text-center animate__animated animate__zoomIn" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
            <div class="empty-state-icon mx-auto mb-4 d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 100px; height: 100px;">
                <i class="fas fa-box-open fa-3x text-muted" style="opacity: 0.5;"></i>
            </div>
            <h4 class="fw-800 text-dark">Ruang Tunggu Kosong</h4>
            <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">Anda belum memiliki riwayat pemesanan. Temukan kamar impian Anda dan mulai cerita baru bersama Kosan Pak Iskandar.</p>
            <a href="<?= BASEURL ?>/katalog" class="btn btn-primary-custom btn-lg px-5 rounded-pill shadow-lg hover-scale">Mulai Mencari</a>
        </div>
    <?php else : ?>
        <!-- Bookings List -->
        <div class="row g-4">
            <?php foreach ($bookings as $b) : ?>
                <?php
                    // Set Status Badges
                    $badgeClass = match($b['status']) {
                        'pending'   => 'badge-warning-glass',
                        'confirmed' => 'badge-success-glass',
                        'cancelled' => 'badge-danger-glass',
                        'completed' => 'badge-primary-glass',
                        default     => 'badge-secondary-glass'
                    };
                    $label = match($b['status']) {
                        'pending'   => 'Menunggu Konfirmasi',
                        'confirmed' => 'Aktif',
                        'cancelled' => 'Dibatalkan',
                        'completed' => 'Selesai',
                        default     => ucfirst($b['status'])
                    };

                    // Set Image Source
                    $imgSrc = !empty($b['image']) 
                        ? BASEURL . '/assets/img/rooms/' . $b['image'] 
                            : 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=400&q=80';
                ?>
                <div class="col-12 animate__animated animate__fadeInUp">
                    <div class="booking-card card border-0 rounded-4 overflow-hidden position-relative">
                        <!-- Dekorasi border kiri -->
                        <div class="status-indicator <?= $b['status'] ?>"></div>
                        
                        <div class="card-body p-0">
                            <div class="row g-0 align-items-center">
                                <!-- Bagian Gambar -->
                                <div class="col-md-3 col-sm-4 p-3">
                                    <div class="img-wrapper rounded-4 overflow-hidden position-relative shadow-sm" style="height: 140px;">
                                        <img src="<?= $imgSrc ?>" alt="Kamar <?= htmlspecialchars($b['room_number']); ?>" class="w-100 h-100 object-fit-cover transition-transform">
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge <?= $badgeClass ?> px-3 py-1 rounded-pill shadow-sm" style="backdrop-filter: blur(4px);">
                                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i> <?= $label ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bagian Info -->
                                <div class="col-md-5 col-sm-8 p-3 p-sm-0 pe-md-3">
                                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                                        Kamar <?= htmlspecialchars($b['room_number']); ?>
                                        <span class="badge bg-light text-secondary border rounded-pill fs-7 fw-normal">#<?= $b['id'] ?></span>
                                    </h4>
                                    <p class="text-muted mb-3 d-flex align-items-center gap-2">
                                        <i class="fas fa-building text-primary"></i> <?= htmlspecialchars($b['kos_name']); ?>
                                    </p>
                                    
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="info-pill">
                                            <i class="far fa-calendar-check text-success"></i>
                                            <span>Mulai: <strong class="text-dark"><?= date('d M Y', strtotime($b['booking_date'])); ?></strong></span>
                                        </div>
                                        <div class="info-pill">
                                            <i class="far fa-clock text-warning"></i>
                                            <span>Durasi: <strong class="text-dark"><?= $b['duration']; ?> Bln</strong></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bagian Harga & Tagihan -->
                                <div class="col-12 border-top bg-light-soft p-4 mt-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Daftar Tagihan Bulanan</h5>
                                        <div class="text-end">
                                            <span class="text-muted small">Total Biaya:</span>
                                            <div class="fw-bold text-dark">Rp <?= number_format($b['total_price'], 0, ',', '.'); ?></div>
                                        </div>
                                    </div>
                                    
                                    <?php if (in_array($b['status'], ['confirmed', 'completed']) && !empty($b['payments'])): ?>
                                        <div class="row g-3">
                                            <?php 
                                            $foundUnpaid = false;
                                            foreach ($b['payments'] as $index => $pay): 
                                                $isPaid = $pay['payment_status'] === 'paid';
                                                $isPayable = !$isPaid && !$foundUnpaid;
                                                if (!$isPaid && !$foundUnpaid) {
                                                    $foundUnpaid = true;
                                                }
                                                
                                                $statusBadge = $isPaid ? '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Lunas</span>' : '<span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>Belum Lunas</span>';
                                                $dueDate = $pay['due_date'] ? date('d M Y', strtotime($pay['due_date'])) : '-';
                                            ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card shadow-sm border-0 <?= $isPaid ? 'bg-light' : '' ?> <?= $isPayable ? 'border-primary' : '' ?>" <?= $isPayable ? 'style="border: 2px solid #4361ee !important;"' : '' ?>>
                                                        <div class="card-body p-3">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span class="fw-bold">Bulan ke-<?= $pay['billing_month'] ?></span>
                                                                <?= $statusBadge ?>
                                                            </div>
                                                            <div class="mb-3 small text-muted">
                                                                Jatuh Tempo: <strong><?= $dueDate ?></strong><br>
                                                                Nominal: <span class="text-primary fw-bold">Rp <?= number_format($pay['amount'], 0, ',', '.') ?></span>
                                                            </div>
                                                            <?php if ($isPayable): ?>
                                                                <a href="<?= BASEURL ?>/payment/pay/<?= $pay['id'] ?>" class="btn btn-sm btn-gradient-primary w-100 rounded-pill hover-scale">
                                                                    <i class="fas fa-wallet me-1"></i> Bayar Sekarang
                                                                </a>
                                                            <?php elseif ($isPaid): ?>
                                                                <button class="btn btn-sm btn-outline-success w-100 rounded-pill" disabled>
                                                                    <i class="fas fa-check"></i> Selesai
                                                                </button>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-secondary w-100 rounded-pill opacity-50" disabled>
                                                                    Menunggu Bulan <?= $pay['billing_month'] - 1 ?> Lunas
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-secondary mb-0 border-0">
                                            <i class="fas fa-info-circle me-2"></i> Tagihan akan muncul setelah admin mengonfirmasi booking Anda.
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

ob_start();
?>
<style>
    /* Typography & Utilities */
    .fw-800 { font-weight: 800; }
    .fs-7 { font-size: 0.75rem; }
    .tracking-tight { letter-spacing: -0.5px; }
    .tracking-wider { letter-spacing: 1px; }
    .text-gradient {
        background: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .bg-light-soft { background-color: rgba(248, 249, 250, 0.5); }
    .border-start-md { border-left: 1px dashed #e9ecef; }
    @media (max-width: 767.98px) {
        .border-start-md { border-left: none; border-top: 1px dashed #e9ecef; }
    }

    /* Cards & Interactions */
    .booking-card {
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.02) !important;
    }
    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(43, 45, 66, 0.08);
    }
    .booking-card:hover .transition-transform {
        transform: scale(1.05);
    }
    .transition-transform { transition: transform 0.5s ease; }
    .hover-scale { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-scale:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(67, 97, 238, 0.15); }

    /* Indicator Line */
    .status-indicator {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        z-index: 10;
    }
    .status-indicator.confirmed { background: linear-gradient(to bottom, #10b981, #34d399); }
    .status-indicator.pending { background: linear-gradient(to bottom, #f59e0b, #fbbf24); }
    .status-indicator.cancelled { background: linear-gradient(to bottom, #ef4444, #f87171); }
    .status-indicator.completed { background: linear-gradient(to bottom, #4361ee, #4cc9f0); }

    /* Buttons */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        color: white;
        border: none;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
        color: white;
    }

    /* Pills & Badges */
    .info-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.85rem;
        color: #6c757d;
    }
    .badge-success-glass { background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-warning-glass { background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-danger-glass { background: rgba(239, 68, 68, 0.15); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    .badge-primary-glass { background: rgba(67, 97, 238, 0.15); color: #4361ee; border: 1px solid rgba(67, 97, 238, 0.2); }
    .badge-secondary-glass { background: rgba(108, 117, 125, 0.15); color: #495057; border: 1px solid rgba(108, 117, 125, 0.2); }
</style>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/landing.php';
?>

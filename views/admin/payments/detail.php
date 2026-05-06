<?php ob_start(); ?>

<div class="container-fluid px-4 pb-4">

    <?php if (empty($payment)): ?>
        <div class="alert alert-warning mt-3">Data transaksi tidak ditemukan.</div>
    <?php else: ?>

    <?php
        $status = strtolower($payment['payment_status'] ?? 'unpaid');
        $badgeConfig = [
            'paid'     => ['bg-success',          'fa-check-circle',    'Lunas'],
            'pending'  => ['bg-warning text-dark', 'fa-hourglass-half',  'Pending'],
            'failed'   => ['bg-danger',            'fa-times-circle',    'Gagal'],
            'expired'  => ['bg-danger',            'fa-calendar-times',  'Kadaluarsa'],
            'unpaid'   => ['bg-secondary',         'fa-minus-circle',    'Belum Bayar'],
            'cancel'   => ['bg-dark',              'fa-ban',             'Dibatalkan'],
        ];
        [$bgClass, $icon, $label] = $badgeConfig[$status] ?? ['bg-secondary', 'fa-question-circle', ucfirst($status)];
    ?>

    <div class="row g-4 mt-1">

        <!-- ── Kolom Kiri: Info Transaksi ──────────────────── -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <span class="fw-semibold">
                        <i class="fas fa-receipt text-primary me-2"></i>Detail Transaksi
                    </span>
                    <span class="badge <?= $bgClass ?> rounded-pill px-3 py-2">
                        <i class="fas <?= $icon ?> me-1"></i><?= $label ?>
                    </span>
                </div>

                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted fw-normal">Order ID</dt>
                        <dd class="col-sm-8">
                            <code class="text-primary"><?= htmlspecialchars($payment['order_id']) ?></code>
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">ID Transaksi</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($payment['transaction_id'] ?? '—') ?>
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Nominal</dt>
                        <dd class="col-sm-8 fw-bold text-success fs-5">
                            Rp <?= number_format($payment['amount'], 0, ',', '.') ?>
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Metode Bayar</dt>
                        <dd class="col-sm-8 text-capitalize">
                            <?= htmlspecialchars($payment['payment_method'] ?? '—') ?>
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge <?= $bgClass ?> rounded-pill px-3">
                                <i class="fas <?= $icon ?> me-1"></i><?= $label ?>
                            </span>
                        </dd>

                        <hr class="my-3">

                        <dt class="col-sm-4 text-muted fw-normal">Tgl. Transaksi</dt>
                        <dd class="col-sm-8">
                            <?= $payment['created_at']
                                ? date('d F Y, H:i', strtotime($payment['created_at'])) . ' WIB'
                                : '—' ?>
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Tgl. Lunas</dt>
                        <dd class="col-sm-8">
                            <?= $payment['paid_at']
                                ? date('d F Y, H:i', strtotime($payment['paid_at'])) . ' WIB'
                                : '<span class="text-muted">Belum dibayar</span>' ?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- ── Kolom Kanan: Info Penyewa & Kamar ───────────── -->
        <div class="col-lg-5">

            <!-- Penyewa -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-semibold">
                    <i class="fas fa-user text-primary me-2"></i>Info Penyewa
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;font-size:1.2rem;flex-shrink:0;">
                            <?= mb_strtoupper(mb_substr($payment['tenant_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="fw-semibold"><?= htmlspecialchars($payment['tenant_name']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($payment['tenant_email']) ?></small>
                        </div>
                    </div>
                    <dl class="row mb-0 small">
                        <dt class="col-5 text-muted fw-normal">No. HP</dt>
                        <dd class="col-7"><?= htmlspecialchars($payment['tenant_phone'] ?? '—') ?></dd>
                    </dl>
                </div>
            </div>

            <!-- Kamar & Booking -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 fw-semibold">
                    <i class="fas fa-door-open text-primary me-2"></i>Info Kamar &amp; Booking
                </div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-5 text-muted fw-normal">Nomor Kamar</dt>
                        <dd class="col-7 fw-bold">Kamar <?= htmlspecialchars($payment['room_number']) ?></dd>

                        <dt class="col-5 text-muted fw-normal">Mulai Sewa</dt>
                        <dd class="col-7">
                            <?= !empty($payment['start_date'])
                                ? date('d M Y', strtotime($payment['start_date']))
                                : '—' ?>
                        </dd>

                        <dt class="col-5 text-muted fw-normal">Selesai Sewa</dt>
                        <dd class="col-7">
                            <?= !empty($payment['end_date'])
                                ? date('d M Y', strtotime($payment['end_date']))
                                : '—' ?>
                        </dd>

                        <dt class="col-5 text-muted fw-normal">Total Harga</dt>
                        <dd class="col-7 fw-bold text-success">
                            Rp <?= number_format($payment['total_price'] ?? 0, 0, ',', '.') ?>
                        </dd>

                        <hr class="my-2">

                        <dt class="col-5 text-muted fw-normal">Status Booking</dt>
                        <dd class="col-7">
                            <?php
                                $bs = strtolower($payment['booking_status'] ?? '');
                                $bookingBadge = [
                                    'pending'   => 'bg-warning text-dark',
                                    'confirmed' => 'bg-info text-white',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                ];
                                $bClass = $bookingBadge[$bs] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $bClass ?> rounded-pill px-3">
                                <?= ucfirst($payment['booking_status'] ?? '—') ?>
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div><!-- /row -->

    <!-- ── Tombol Kembali ──────────────────────────────────── -->
    <div class="mt-4">
        <a href="<?= BASEURL ?>/adminpayment" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pembayaran
        </a>
    </div>

    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/template.php';
?>

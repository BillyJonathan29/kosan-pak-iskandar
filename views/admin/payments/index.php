<?php ob_start(); ?>

<div class="container-fluid px-4">

    <?php /* ── Flash Message ─────────────────────────────────── */ ?>
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['tipe'] ?> alert-dismissible fade show mt-3" role="alert">
            <?= htmlspecialchars($_SESSION['flash']['pesan']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php /* ── Kartu Ringkasan ──────────────────────────────── */ ?>
    <div class="row g-3 my-2">
        <?php
            $totalPaid    = 0;
            $totalPending = 0;
            $totalFailed  = 0;
            $grandTotal   = 0;

            foreach ($payments as $p) {
                if ($p['payment_status'] === 'paid') {
                    $totalPaid++;
                    $grandTotal += $p['amount'];
                } elseif ($p['payment_status'] === 'pending') {
                    $totalPending++;
                } elseif (in_array($p['payment_status'], ['failed', 'expired'])) {
                    $totalFailed++;
                }
            }
        ?>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Lunas (Paid)</div>
                        <div class="fw-bold fs-4"><?= $totalPaid ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Menunggu (Pending)</div>
                        <div class="fw-bold fs-4"><?= $totalPending ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="fas fa-times-circle text-danger fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Gagal / Kadaluarsa</div>
                        <div class="fw-bold fs-4"><?= $totalFailed ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-wallet text-primary fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Pemasukan</div>
                        <div class="fw-bold fs-5">Rp <?= number_format($grandTotal, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php /* ── Tabel Pembayaran ──────────────────────────────── */ ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div class="fw-semibold">
                <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                Riwayat Transaksi Pembayaran
            </div>
            <span class="badge bg-secondary rounded-pill"><?= count($payments) ?> Transaksi</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th>Order ID</th>
                            <th>Penyewa &amp; Kamar</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tgl. Bayar</th>
                            <th class="text-center" style="width: 110px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($payments)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fs-2 mb-2 d-block"></i>
                                    Belum ada data transaksi.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($payments as $payment): ?>
                            <tr>
                                <td class="ps-4 text-muted"><?= $no++ ?></td>

                                <?php /* Order ID */ ?>
                                <td>
                                    <code class="text-primary small"><?= htmlspecialchars($payment['order_id']) ?></code>
                                </td>

                                <?php /* Penyewa & Kamar (digabung) */ ?>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary fw-bold"
                                             style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0;">
                                            <?= mb_strtoupper(mb_substr($payment['tenant_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold lh-sm"><?= htmlspecialchars($payment['tenant_name']) ?></div>
                                            <small class="text-muted">
                                                <i class="fas fa-door-open me-1"></i>Kamar <?= htmlspecialchars($payment['room_number']) ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <?php /* Nominal */ ?>
                                <td class="fw-semibold text-success">
                                    Rp <?= number_format($payment['amount'], 0, ',', '.') ?>
                                </td>

                                <?php /* Metode */ ?>
                                <td>
                                    <?php
                                        $method = strtolower($payment['payment_method'] ?? '');
                                        $methodIcon  = 'fa-credit-card';
                                        $methodLabel = strtoupper($payment['payment_method'] ?? 'N/A');

                                        if (str_contains($method, 'midtrans') || str_contains($method, 'online')) {
                                            $methodIcon = 'fa-globe';
                                        } elseif (str_contains($method, 'transfer') || str_contains($method, 'bank')) {
                                            $methodIcon = 'fa-university';
                                        } elseif (str_contains($method, 'cash') || str_contains($method, 'manual') || str_contains($method, 'tunai')) {
                                            $methodIcon = 'fa-money-bill-wave';
                                            $methodLabel = 'Cash / Manual';
                                        } elseif (str_contains($method, 'gopay') || str_contains($method, 'ovo') || str_contains($method, 'dana')) {
                                            $methodIcon = 'fa-mobile-alt';
                                        }
                                    ?>
                                    <span class="text-muted small">
                                        <i class="fas <?= $methodIcon ?> me-1"></i><?= $methodLabel ?>
                                    </span>
                                </td>

                                <?php /* Status Badge */ ?>
                                <td>
                                    <?php
                                        $status = strtolower($payment['payment_status'] ?? 'unpaid');
                                        $badgeConfig = [
                                            'paid'     => ['bg-success',         'fa-check-circle',       'Lunas'],
                                            'pending'  => ['bg-warning text-dark','fa-hourglass-half',     'Pending'],
                                            'failed'   => ['bg-danger',           'fa-times-circle',       'Gagal'],
                                            'expired'  => ['bg-danger',           'fa-calendar-times',     'Kadaluarsa'],
                                            'unpaid'   => ['bg-secondary',        'fa-minus-circle',       'Belum Bayar'],
                                            'cancel'   => ['bg-dark',             'fa-ban',                'Dibatalkan'],
                                        ];
                                        [$bgClass, $icon, $label] = $badgeConfig[$status] ?? ['bg-secondary', 'fa-question-circle', ucfirst($status)];
                                    ?>
                                    <span class="badge <?= $bgClass ?> rounded-pill px-3 py-2">
                                        <i class="fas <?= $icon ?> me-1"></i><?= $label ?>
                                    </span>
                                </td>

                                <?php /* Tanggal Bayar */ ?>
                                <td class="small text-muted">
                                    <?php if ($payment['paid_at']): ?>
                                        <?= date('d M Y', strtotime($payment['paid_at'])) ?>
                                        <br><span class="text-xs"><?= date('H:i', strtotime($payment['paid_at'])) ?> WIB</span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <?php /* Aksi */ ?>
                                <td class="text-center">
                                    <a href="<?= BASEURL ?>/adminpayment/detail/<?= $payment['id'] ?>"
                                       class="btn btn-sm btn-outline-primary rounded-pill"
                                       title="Lihat Detail Transaksi">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$scripts = '<script>
    window.addEventListener("DOMContentLoaded", function () {
        const el = document.getElementById("datatablesSimple");
        if (el && typeof simpleDatatables !== "undefined") {
            new simpleDatatables.DataTable(el, {
                perPage: 10,
                labels: {
                    placeholder: "Cari transaksi...",
                    perPage: "{select} data per halaman",
                    noRows: "Tidak ada data ditemukan",
                    info: "Menampilkan {start} - {end} dari {rows} transaksi",
                }
            });
        }
    });
</script>';

$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/template.php';
?>

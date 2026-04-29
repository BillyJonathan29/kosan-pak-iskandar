<?php ob_start(); ?>

<div class="container-fluid px-4">

    <!-- ===== STAT CARDS ===== -->
    <div class="row g-4 mb-4">

        <!-- Total Kos -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white shadow-sm h-100" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Total Kos</div>
                        <h3 class="mb-0 fw-bold"><?= $total_kos ?? 0 ?></h3>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-home fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <a class="small text-white text-decoration-none" href="<?= BASEURL ?>/kos">Lihat Detail</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- Total Kamar -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white shadow-sm h-100" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Total Kamar</div>
                        <h3 class="mb-0 fw-bold"><?= $total_kamar ?? 0 ?></h3>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-door-open fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <a class="small text-white text-decoration-none" href="<?= BASEURL ?>/room">Lihat Detail</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- Kamar Terisi -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white shadow-sm h-100" style="background: linear-gradient(135deg, #f7971e, #ffd200);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Kamar Terisi</div>
                        <h3 class="mb-0 fw-bold"><?= $kamar_terisi ?? 0 ?></h3>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-bed fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <a class="small text-white text-decoration-none" href="<?= BASEURL ?>/room">Lihat Detail</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- Kamar Kosong -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white shadow-sm h-100" style="background: linear-gradient(135deg, #cb2d3e, #ef473a);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-white-50 mb-1">Kamar Kosong</div>
                        <h3 class="mb-0 fw-bold"><?= $kamar_kosong ?? 0 ?></h3>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-door-closed fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <a class="small text-white text-decoration-none" href="<?= BASEURL ?>/room">Lihat Detail</a>
                    <i class="fas fa-angle-right text-white"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== BOOKING STATS ===== -->
    <div class="row g-4 mb-4">

        <!-- Total Booking -->
        <div class="col-xl-4 col-md-6">
            <div class="card shadow-sm h-100 border-start border-4 border-info">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted mb-1">Total Booking</div>
                        <h3 class="mb-0 fw-bold text-info"><?= $total_booking ?? 0 ?></h3>
                    </div>
                    <i class="fas fa-calendar-check fa-3x text-info opacity-25"></i>
                </div>
                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                    <a class="small text-decoration-none" href="<?= BASEURL ?>/booking">Lihat Detail</a>
                    <i class="fas fa-angle-right text-muted"></i>
                </div>
            </div>
        </div>

        <!-- Booking Pending -->
        <div class="col-xl-4 col-md-6">
            <div class="card shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted mb-1">Booking Menunggu</div>
                        <h3 class="mb-0 fw-bold text-warning"><?= $booking_pending ?? 0 ?></h3>
                    </div>
                    <i class="fas fa-hourglass-half fa-3x text-warning opacity-25"></i>
                </div>
                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                    <a class="small text-decoration-none" href="<?= BASEURL ?>/booking">Lihat Detail</a>
                    <i class="fas fa-angle-right text-muted"></i>
                </div>
            </div>
        </div>

        <!-- Booking Dikonfirmasi -->
        <div class="col-xl-4 col-md-6">
            <div class="card shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted mb-1">Booking Dikonfirmasi</div>
                        <h3 class="mb-0 fw-bold text-success"><?= $booking_confirmed ?? 0 ?></h3>
                    </div>
                    <i class="fas fa-check-circle fa-3x text-success opacity-25"></i>
                </div>
                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                    <a class="small text-decoration-none" href="<?= BASEURL ?>/booking">Lihat Detail</a>
                    <i class="fas fa-angle-right text-muted"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== ROW 2: Progress Bar + Fasilitas ===== -->
    <div class="row g-4 mb-4">

        <!-- Occupancy Rate -->
        <div class="col-xl-8">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold">
                    <i class="fas fa-chart-bar me-1 text-primary"></i> Tingkat Hunian Kamar
                </div>
                <div class="card-body">
                    <?php
                        $total    = $total_kamar ?? 0;
                        $terisi   = $kamar_terisi ?? 0;
                        $kosong   = $kamar_kosong ?? 0;
                        $pct_terisi = $total > 0 ? round(($terisi / $total) * 100) : 0;
                        $pct_kosong = $total > 0 ? round(($kosong / $total) * 100) : 0;
                    ?>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-semibold">Kamar Terisi</span>
                            <span class="small text-muted"><?= $terisi ?> / <?= $total ?> (<?= $pct_terisi ?>%)</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 6px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: <?= $pct_terisi ?>%; border-radius: 6px;"
                                aria-valuenow="<?= $pct_terisi ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-semibold">Kamar Kosong</span>
                            <span class="small text-muted"><?= $kosong ?> / <?= $total ?> (<?= $pct_kosong ?>%)</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: <?= $pct_kosong ?>%; border-radius: 6px;"
                                aria-valuenow="<?= $pct_kosong ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex gap-4 mt-3">
                        <div class="text-center">
                            <span class="d-block h4 fw-bold text-success"><?= $pct_terisi ?>%</span>
                            <small class="text-muted">Tingkat Hunian</small>
                        </div>
                        <div class="text-center">
                            <span class="d-block h4 fw-bold text-primary"><?= $total_kos ?? 0 ?></span>
                            <small class="text-muted">Lokasi Kos</small>
                        </div>
                        <div class="text-center">
                            <span class="d-block h4 fw-bold text-warning"><?= $total_fasilitas ?? 0 ?></span>
                            <small class="text-muted">Jenis Fasilitas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold">
                    <i class="fas fa-bolt me-1 text-warning"></i> Akses Cepat
                </div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="<?= BASEURL ?>/kos" class="btn btn-outline-primary text-start">
                        <i class="fas fa-home me-2"></i> Kelola Data Kos
                    </a>
                    <a href="<?= BASEURL ?>/room" class="btn btn-outline-success text-start">
                        <i class="fas fa-door-open me-2"></i> Kelola Data Kamar
                    </a>
                    <a href="<?= BASEURL ?>/facility" class="btn btn-outline-warning text-start">
                        <i class="fas fa-concierge-bell me-2"></i> Kelola Fasilitas
                    </a>
                    <a href="<?= BASEURL ?>/roomfacility" class="btn btn-outline-info text-start">
                        <i class="fas fa-link me-2"></i> Fasilitas Kamar
                    </a>
                    <a href="<?= BASEURL ?>/user" class="btn btn-outline-secondary text-start">
                        <i class="fas fa-users me-2"></i> Kelola User
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== ROW 3: Tabel Kamar Terbaru ===== -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center fw-semibold">
                    <div>
                        <i class="fas fa-clock me-1 text-info"></i> Kamar Terbaru Ditambahkan
                    </div>
                    <a href="<?= BASEURL ?>/room" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">No. Kamar</th>
                                    <th>Kos</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Ditambahkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_rooms)) : ?>
                                    <?php foreach ($recent_rooms as $r) : ?>
                                    <tr>
                                        <td class="ps-3 fw-semibold"><?= htmlspecialchars($r['room_number']); ?></td>
                                        <td><?= htmlspecialchars($r['kos_name']); ?></td>
                                        <td>Rp <?= number_format($r['price'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php
                                                $status = strtolower($r['status']);
                                                $badge  = match($status) {
                                                    'terisi'  => 'bg-success',
                                                    'kosong'  => 'bg-danger',
                                                    default   => 'bg-secondary'
                                                };
                                            ?>
                                            <span class="badge <?= $badge ?>">
                                                <?= ucfirst(htmlspecialchars($r['status'])); ?>
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            <?= date('d M Y', strtotime($r['created_at'])); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Belum ada data kamar
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/template.php';
?>
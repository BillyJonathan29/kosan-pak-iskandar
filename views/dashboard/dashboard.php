<?php ob_start(); ?>

<div class="container-fluid px-4">
    <style>
        /* Compact modern dashboard styles */
        .stat-card {
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(22, 28, 45, 0.06);
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 22px;
        }

        .stat-title {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
        }

        .card-ghost {
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(34, 41, 63, 0.04);
        }

        .quick-link {
            border-radius: 999px;
            padding: 6px 14px;
        }

        .recent-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .recent-left {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .room-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #eef2ff, #e6fffa);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 700;
        }

        .muted {
            color: #6b7280;
        }

        @media (max-width:767px) {
            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 18px
            }

            .stat-value {
                font-size: 1.25rem
            }
        }
    </style>

    <!-- Compact: Key Metrics -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card-ghost p-3 stat-card h-100 d-flex gap-3 align-items-center">
                <div class="stat-icon bg-gradient-primary text-white" style="background:linear-gradient(135deg,#4f46e5,#06b6d4);">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <div class="stat-title">Total Kos</div>
                    <div class="stat-value"><?= $total_kos ?? 0 ?></div>
                    <div class="muted small">Lokasi / cabang terdaftar</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card-ghost p-3 stat-card h-100 d-flex gap-3 align-items-center">
                <div class="stat-icon bg-gradient-success text-white" style="background:linear-gradient(135deg,#10b981,#06b6d4);">
                    <i class="fas fa-door-open"></i>
                </div>
                <div>
                    <div class="stat-title">Total Kamar</div>
                    <div class="stat-value"><?= $total_kamar ?? 0 ?></div>
                    <div class="muted small">Termasuk tersedia & terisi</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card-ghost p-3 stat-card h-100 d-flex gap-3 align-items-center justify-content-between">
                <div class="d-flex gap-3 align-items-center">
                    <div class="stat-icon bg-gradient-warning text-white" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="stat-title">Booking Aktif</div>
                        <div class="stat-value"><?= $total_booking ?? 0 ?></div>
                        <div class="muted small">Booking pending / confirmed</div>
                    </div>
                </div>
                <div class="text-end d-none d-md-block">
                    <a href="<?= BASEURL ?>/booking" class="btn btn-sm btn-outline-primary">Lihat</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Occupancy Rate -->
    <div class="row mb-4">
        <div class="col-lg-7">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>Tingkat Hunian</strong>
                            <div class="small muted">Kamar terisi dari total kamar</div>
                        </div>
                        <?php $total = max(1, $total_kamar ?? 0);
                        $terisi = $kamar_terisi ?? 0;
                        $pct = $total > 0 ? round(($terisi / $total) * 100) : 0; ?>
                        <div class="fw-bold fs-4"><?= $pct ?>%</div>
                    </div>
                    <div class="progress" style="height:12px;border-radius:8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $pct ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Akses Cepat</strong>
                        <small class="muted">Shortcut</small>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-light quick-link" href="<?= BASEURL ?>/kos">Kelola Kos</a>
                        <a class="btn btn-light quick-link" href="<?= BASEURL ?>/room">Kelola Kamar</a>
                        <a class="btn btn-light quick-link" href="<?= BASEURL ?>/booking">Booking</a>
                        <a class="btn btn-light quick-link" href="<?= BASEURL ?>/transaction">Transaksi</a>
                        <a class="btn btn-light quick-link" href="<?= BASEURL ?>/user">User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent rooms (top 5 minimal) -->
    <div class="row">
        <div class="col-12">
            <div class="card stat-card">
                <div class="card-header fw-semibold">Kamar Terbaru</div>
                <div class="card-body p-0">
                    <?php if (!empty($recent_rooms)): ?>
                        <?php $i = 0;
                        foreach ($recent_rooms as $r): if ($i++ == 6) break; ?>
                            <div class="recent-item">
                                <div class="recent-left">
                                    <div class="room-avatar"><?= htmlspecialchars($r['room_number']) ?></div>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($r['room_number']) ?> — <?= htmlspecialchars($r['kos_name']) ?></div>
                                        <div class="small muted">Rp <?= number_format($r['price'], 0, ',', '.') ?> • <?= ucfirst(htmlspecialchars($r['status'])) ?></div>
                                    </div>
                                </div>
                                <div class="small muted"><?= date('d M Y', strtotime($r['created_at'])) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center muted">Tidak ada kamar terbaru</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/template.php';
?>
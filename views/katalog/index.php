<?php ob_start(); ?>

<div class="container-fluid px-4">

    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-5 text-center bg-white rounded-4 shadow-sm border" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
                <h1 class="display-5 fw-bold text-dark mb-2">Pilihan Kamar Terbaik</h1>
                <p class="lead text-muted mb-4">Temukan kenyamanan kos-kosan eksklusif dengan fasilitas lengkap di Kosan Pak Iskandar.</p>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="input-group input-group-lg shadow-sm border rounded-pill overflow-hidden bg-white">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-0 py-3" 
                                placeholder="Cari nomor kamar, nama kos, atau lokasi...">
                            <button class="btn btn-primary px-5 fw-bold" type="button">Cari</button>
                        </div>
                        <div class="mt-3 text-muted small">
                            <i class="fas fa-info-circle me-1"></i> <?= count($rooms) ?> kamar tersedia untuk dipesan sekarang.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Kamar -->
    <?php if (empty($rooms)) : ?>
        <div class="text-center py-5">
            <i class="fas fa-door-closed fa-4x text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Belum ada kamar yang tersedia saat ini</h5>
            <p class="text-muted small">Silakan kembali lagi nanti.</p>
        </div>
    <?php else : ?>
        <div class="row g-4" id="roomGrid">
            <?php foreach ($rooms as $r) : ?>
                <?php
                    $imgSrc = !empty($r['image'])
                        ? BASEURL . '/assets/img/rooms/' . $r['image']
                        : 'https://placehold.co/600x350/e9ecef/6c757d?text=No+Image';
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 room-card-wrap"
                    data-search="<?= strtolower(htmlspecialchars($r['room_number'] . ' ' . $r['kos_name'] . ' ' . $r['kos_address'])); ?>">
                    <div class="card h-100 shadow-sm border-0 room-card" style="border-radius: 14px; overflow: hidden; transition: transform .2s, box-shadow .2s;">
                        <!-- Gambar -->
                        <div style="position: relative; height: 200px; overflow: hidden;">
                            <img src="<?= $imgSrc ?>" alt="Kamar <?= htmlspecialchars($r['room_number']); ?>"
                                class="w-100 h-100" style="object-fit: cover; transition: transform .35s;">
                            <span class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2">
                                <i class="fas fa-circle me-1" style="font-size:8px;"></i> Tersedia
                            </span>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($r['kos_name']); ?></h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                <?= htmlspecialchars($r['kos_address']); ?>
                            </p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small">Kamar</span>
                                    <span class="badge bg-light text-dark border ms-1 fw-semibold">
                                        <?= htmlspecialchars($r['room_number']); ?>
                                    </span>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary fs-6">
                                        Rp <?= number_format($r['price'], 0, ',', '.'); ?>
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">per bulan</div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer bg-transparent border-0 pb-3 px-3">
                            <a href="<?= BASEURL; ?>/katalog/detail/<?= $r['id']; ?>"
                                class="btn btn-primary w-100 fw-semibold"
                                style="border-radius: 10px;">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- No Result -->
        <div id="noResult" class="text-center py-5 d-none">
            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Kamar tidak ditemukan</h5>
            <p class="text-muted small">Coba kata kunci lain.</p>
        </div>
    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();

// ─── SCRIPTS ──────────────────────────────────────────────────────────────────
ob_start();
?>
<style>
    .room-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,.12) !important;
    }
    .room-card:hover img {
        transform: scale(1.06);
    }
</style>
<script>
    // Live search
    document.getElementById('searchInput').addEventListener('input', function() {
        const q     = this.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.room-card-wrap');
        let visible = 0;

        cards.forEach(card => {
            const haystack = card.dataset.search;
            const match    = !q || haystack.includes(q);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        document.getElementById('noResult').classList.toggle('d-none', visible > 0);
    });
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/template.php';
?>

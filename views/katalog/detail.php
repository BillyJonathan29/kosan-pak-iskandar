<?php ob_start(); ?>

<div class="container py-5" style="margin-top: 50px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4 animate__animated animate__fadeIn">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASEURL ?>" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= BASEURL ?>#katalog" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Detail Kamar</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Bagian Kiri: Foto Kamar & Fasilitas -->
        <div class="col-lg-8 animate__animated animate__fadeInLeft">
            <?php
            $imgSrc = !empty($room['image'])
                ? BASEURL . '/assets/img/rooms/' . $room['image']
                : 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
            ?>
            <div class="card border-0 shadow-sm rounded-5 overflow-hidden mb-5">
                <div class="position-relative">
                    <img src="<?= $imgSrc ?>" class="img-fluid w-100" alt="Kamar <?= htmlspecialchars($room['room_number']) ?>" style="height: 500px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-4">
                        <span class="badge bg-success px-4 py-2 rounded-pill shadow-lg fw-bold">
                            <i class="fas fa-check-circle me-1"></i> Tersedia Sekarang
                        </span>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <h3 class="fw-800 mb-4 d-flex align-items-center">
                    <i class="fas fa-sparkles text-warning me-3"></i> Fasilitas Kamar Eksklusif
                </h3>
                <div class="row g-4">
                    <?php if (empty($facilities)): ?>
                        <div class="col-12">
                            <div class="alert alert-light border rounded-4 p-4 text-center">
                                <i class="fas fa-info-circle text-muted mb-2 fs-3"></i>
                                <p class="text-muted mb-0">Informasi fasilitas lengkap dapat ditanyakan langsung ke admin.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($facilities as $f): ?>
                            <div class="col-md-4 col-6">
                                <div class="d-flex align-items-center p-3 bg-white border border-light-subtle rounded-4 shadow-sm hover-lift h-100">
                                    <div class="flex-shrink-0 bg-primary-subtle text-primary p-3 rounded-4 me-3">
                                        <i class="<?= $f['icon'] ?? 'fas fa-check' ?> fs-5"></i>
                                    </div>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($f['facility_name']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-5">
                <h3 class="fw-800 mb-4 d-flex align-items-center">
                    <i class="fas fa-file-alt text-primary me-3"></i> Deskripsi Kamar
                </h3>
                <div class="bg-white p-4 rounded-5 shadow-sm border-start border-primary border-5">
                    <p class="mb-0 text-muted fs-5 lh-lg">
                        <?= !empty($room['description']) ? nl2br(htmlspecialchars($room['description'])) : 'Kamar ini didesain khusus untuk memberikan kenyamanan maksimal bagi penghuninya. Terletak di area yang tenang dengan sirkulasi udara yang baik.' ?>
                    </p>
                </div>
            </div>
            
            <div class="mb-5">
                <h3 class="fw-800 mb-4 d-flex align-items-center">
                    <i class="fas fa-shield-halved text-success me-3"></i> Aturan Kos
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush bg-transparent">
                            <li class="list-group-item bg-transparent border-0 px-0 d-flex align-items-center text-muted">
                                <i class="fas fa-check-circle text-success me-3"></i> Tamu menginap lapor admin
                            </li>
                            <li class="list-group-item bg-transparent border-0 px-0 d-flex align-items-center text-muted">
                                <i class="fas fa-check-circle text-success me-3"></i> Dilarang membawa hewan peliharaan
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush bg-transparent">
                            <li class="list-group-item bg-transparent border-0 px-0 d-flex align-items-center text-muted">
                                <i class="fas fa-check-circle text-success me-3"></i> Menjaga ketenangan di atas jam 10 malam
                            </li>
                            <li class="list-group-item bg-transparent border-0 px-0 d-flex align-items-center text-muted">
                                <i class="fas fa-check-circle text-success me-3"></i> Kebersihan adalah tanggung jawab bersama
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Bagian Review -->
            <div class="mb-5">
                <h3 class="fw-800 mb-4 d-flex align-items-center">
                    <i class="fas fa-comments text-info me-3"></i> Ulasan Penghuni (<?= count($reviews) ?>)
                </h3>
                
                <?php if (empty($reviews)): ?>
                    <div class="alert alert-light border rounded-4 p-4 text-center">
                        <i class="far fa-frown text-muted mb-2 fs-3"></i>
                        <p class="text-muted mb-0">Belum ada ulasan untuk kamar ini. Jadilah yang pertama memberikan ulasan!</p>
                    </div>
                <?php else: ?>
                    <div class="review-list">
                        <?php foreach ($reviews as $rev): ?>
                            <div class="review-item bg-white p-4 rounded-4 shadow-sm mb-3 border-start border-info border-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($rev['user_name']) ?>&background=random" class="rounded-circle me-3" width="45" height="45">
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($rev['user_name']) ?></h6>
                                            <small class="text-muted"><?= date('d M Y', strtotime($rev['created_at'])) ?></small>
                                        </div>
                                    </div>
                                    <div class="text-warning">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="<?= $i <= $rev['rating'] ? 'fas' : 'far'; ?> fa-star small"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="mb-0 text-muted italic">"<?= htmlspecialchars($rev['comment']) ?>"</p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bagian Kanan: Detail & Form Booking -->
        <div class="col-lg-4 animate__animated animate__fadeInRight">
            <div class="sticky-top" style="top: 120px;">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="text-uppercase text-primary fw-bold small mb-1 ls-1">Kamar Nomor</h6>
                                <h3 class="fw-800 mb-0"><?= htmlspecialchars($room['room_number']) ?></h3>
                            </div>
                            <div class="text-end">
                                <h6 class="text-uppercase text-muted fw-bold small mb-1 ls-1">Harga Sewa</h6>
                                <h3 class="fw-800 text-success mb-0">Rp <?= number_format($room['price'], 0, ',', '.') ?></h3>
                                <div class="d-flex align-items-center justify-content-end mt-1 text-warning">
                                    <?php 
                                    $avg = round($avg_rating ?? 0);
                                    for($i=1; $i<=5; $i++): ?>
                                        <i class="<?= $i <= $avg ? 'fas' : 'far'; ?> fa-star small"></i>
                                    <?php endfor; ?>
                                    <span class="text-muted small ms-1">(<?= count($reviews) ?>)</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="mb-4">
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <i class="fas fa-building text-primary mt-1"></i>
                                <div>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($room['kos_name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($room['kos_address']) ?></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-bolt text-warning"></i>
                                <span class="text-muted small">Sudah termasuk Listrik & Air</span>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user'])): ?>
                            <form action="<?= BASEURL ?>/katalog/booking" method="POST">
                                <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">Berapa lama Anda akan menyewa?</label>
                                    <div class="input-group input-group-lg overflow-hidden rounded-4 border">
                                        <span class="input-group-text bg-white border-0"><i class="fas fa-calendar-days text-primary"></i></span>
                                        <input type="number" name="duration" class="form-control border-0 shadow-none fs-6" value="1" min="1" max="12" required>
                                        <span class="input-group-text bg-white border-0 fw-bold">Bulan</span>
                                    </div>
                                    <div class="form-text mt-2 small text-muted"><i class="fas fa-info-circle me-1"></i> Minimum sewa adalah 1 bulan.</div>
                                </div>

                                <button type="submit" class="btn btn-primary-custom btn-lg w-100 py-3 shadow-lg mb-3">
                                    Booking Sekarang
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-info border-0 rounded-4 p-4 mb-4">
                                <div class="d-flex gap-3">
                                    <i class="fas fa-user-lock fs-4"></i>
                                    <div>
                                        <div class="fw-bold mb-1">Ingin Booking?</div>
                                        <div class="small mb-3">Silakan masuk atau daftar akun terlebih dahulu untuk melanjutkan pemesanan.</div>
                                        <a href="<?= BASEURL ?>/auth" class="btn btn-primary btn-sm rounded-pill px-4">Masuk Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="text-center">
                            <span class="text-muted small">Butuh bantuan?</span>
                            <a href="https://wa.me/6281234567890" class="text-primary fw-bold text-decoration-none ms-1">Tanya Admin</a>
                        </div>
                    </div>
                </div>

                <!-- Card Host -->
                <div class="card border-0 shadow-sm rounded-5 bg-white p-4">
                    <div class="d-flex align-items-center">
                        <div class="position-relative">
                            <img src="https://ui-avatars.com/api/?name=Admin+Iskandar&background=4361ee&color=fff" class="rounded-circle me-3" width="60" height="60">
                            <span class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle p-1" style="width: 15px; height: 15px; transform: translate(-10px, -2px);"></span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-800">Pak Iskandar</h6>
                            <small class="text-muted">Pemilik Kos (Online)</small>
                        </div>
                        <a href="https://wa.me/6281234567890" class="btn btn-success-subtle text-success rounded-circle ms-auto p-3 shadow-none">
                            <i class="fab fa-whatsapp fs-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

ob_start();
?>
<style>
    .fw-800 { font-weight: 800; }
    .ls-1 { letter-spacing: 1px; }
    .btn-success-subtle {
        background-color: #d1e7dd;
        border: none;
        transition: all 0.3s;
    }
    .btn-success-subtle:hover {
        background-color: #198754;
        color: white !important;
        transform: rotate(15deg);
    }
</style>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/landing.php';
?>

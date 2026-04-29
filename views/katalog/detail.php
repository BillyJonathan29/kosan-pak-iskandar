<?php ob_start(); ?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Bagian Kiri: Foto Kamar -->
        <div class="col-lg-7">
            <?php
            $imgSrc = !empty($room['image'])
                ? BASEURL . '/assets/img/rooms/' . $room['image']
                : 'https://placehold.co/1200x800/e9ecef/6c757d?text=No+Image';
            ?>
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <img src="<?= $imgSrc ?>" class="img-fluid w-100" alt="Kamar <?= htmlspecialchars($room['room_number']) ?>" style="min-height: 400px; object-fit: cover;">
                <div class="card-img-overlay d-flex align-items-start justify-content-end">
                    <span class="badge bg-success px-3 py-2 shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> Tersedia
                    </span>
                </div>
            </div>

            <div class="mt-4">
                <h3 class="fw-bold text-dark mb-3">Fasilitas Kamar</h3>
                <div class="row g-3">
                    <?php if (empty($facilities)): ?>
                        <div class="col-12">
                            <p class="text-muted italic">Tidak ada fasilitas spesifik yang dicantumkan.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($facilities as $f): ?>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center p-3 bg-white border rounded-3 shadow-sm">
                                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-2 rounded-2 me-3">
                                        <i class="<?= $f['icon'] ?? 'fas fa-check' ?> fa-lg"></i>
                                    </div>
                                    <div class="fw-medium text-dark small"><?= htmlspecialchars($f['facility_name']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-5">
                <h3 class="fw-bold text-dark mb-3">Deskripsi & Aturan</h3>
                <div class="bg-light p-4 rounded-4 border-start border-primary border-4 shadow-sm">
                    <p class="mb-0 text-secondary leading-relaxed">
                        <?= !empty($room['description']) ? nl2br(htmlspecialchars($room['description'])) : 'Silakan hubungi pemilik kos untuk informasi lebih lanjut mengenai detail kamar ini.' ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Detail & Form Booking -->
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0 fw-bold">Detail Kos</h5>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-primary mb-1"><?= htmlspecialchars($room['kos_name']) ?></h4>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i> <?= htmlspecialchars($room['kos_address']) ?>
                        </p>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary">Nomor Kamar</span>
                            <span class="badge bg-light text-dark border px-3 py-2 fw-bold"><?= htmlspecialchars($room['room_number']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-secondary">Harga Sewa</span>
                            <span class="h4 mb-0 fw-bold text-success">Rp <?= number_format($room['price'], 0, ',', '.') ?><small class="text-muted fs-6 fw-normal">/bln</small></span>
                        </div>

                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 mb-4 border border-primary border-opacity-25">
                            <div class="d-flex align-items-center text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                <span class="small fw-semibold">Sudah termasuk biaya listrik dasar dan air.</span>
                            </div>
                        </div>

                        <form action="<?= BASEURL ?>/katalog/booking" method="POST">
                            <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Durasi Sewa (Bulan)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-muted"></i></span>
                                    <input type="number" name="duration" class="form-control" value="1" min="1" max="12" required>
                                    <span class="input-group-text bg-white">Bulan</span>
                                </div>
                                <div class="form-text mt-2 small">Minimum sewa 1 bulan.</div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-3" style="border-radius: 12px;">
                                <i class="fas fa-bolt me-2"></i> Booking Sekarang
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-light p-3">
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=Admin+Iskandar&background=0D6EFD&color=fff" class="rounded-circle me-3" width="48">
                        <div>
                            <h6 class="mb-0 fw-bold">Hubungi Pemilik</h6>
                            <small class="text-muted"><?= htmlspecialchars($room['kos_phone'] ?? '08xx-xxxx-xxxx') ?></small>
                        </div>
                        <a href="https://wa.me/<?= str_replace(['-', ' ', '+'], '', $room['phone'] ?? '') ?>" class="btn btn-success btn-sm ms-auto rounded-pill px-3">
                            <i class="fab fa-whatsapp"></i> Chat
                        </a>
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

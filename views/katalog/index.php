<?php ob_start(); ?>

<!-- Hero Section -->
<section class="hero-section py-0 overflow-hidden" style="background: linear-gradient(135deg, #f8faff 0%, #e0e7ff 100%); min-height: 90vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 animate__animated animate__fadeInUp">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3 fw-bold">🏠 Hunian Nyaman & Terpercaya</span>
                <h1 class="display-3 fw-800 mb-4" style="line-height: 1.1; font-weight: 800;">Temukan Kamar <span class="text-primary">Impian</span> Anda di Sini.</h1>
                <p class="lead text-muted mb-5" style="font-size: 1.2rem;">Kosan Pak Iskandar menyediakan berbagai pilihan kamar eksklusif dengan fasilitas lengkap, keamanan 24 jam, dan lokasi yang sangat strategis.</p>
                <div class="d-flex flex-sm-row flex-column gap-3">
                    <a href="#katalog" class="btn btn-primary-custom btn-lg px-5 py-3">Cari Kamar Sekarang</a>
                    <a href="#fasilitas" class="btn btn-outline-dark btn-lg px-5 py-3 rounded-pill fw-bold">Lihat Fasilitas</a>
                </div>
                <div class="mt-5 d-flex align-items-center gap-4">
                    <div class="d-flex -space-x-2">
                        <img src="https://i.pravatar.cc/150?u=1" class="rounded-circle border border-white" width="45" height="45" alt="User">
                        <img src="https://i.pravatar.cc/150?u=2" class="rounded-circle border border-white ms-n2" width="45" height="45" alt="User">
                        <img src="https://i.pravatar.cc/150?u=3" class="rounded-circle border border-white ms-n2" width="45" height="45" alt="User">
                    </div>
                    <div>
                        <div class="fw-bold">100+ Penghuni Puas</div>
                        <div class="text-muted small">Telah bergabung bersama kami</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 animate__animated animate__fadeInRight">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Kamar Kos" class="img-fluid rounded-4 shadow-2xl" style="border-radius: 30px;">
                    <div class="position-absolute bottom-0 start-0 bg-white p-4 shadow-lg m-4 rounded-4 animate__animated animate__bounceIn animate__delay-1s" style="border-radius: 20px;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success-subtle p-3 rounded-3">
                                <i class="fas fa-check-circle text-success fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Harga Terjangkau</div>
                                <div class="text-muted small">Mulai dari Rp 800rb/bulan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search & Catalog Section -->
<section id="katalog" class="bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800 mb-3">Katalog Kamar Tersedia</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Pilih tipe kamar yang sesuai dengan kebutuhan dan budget Anda. Semua kamar dirancang untuk kenyamanan maksimal.</p>
        </div>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="search-box p-3 bg-white shadow-lg rounded-pill d-flex align-items-center border">
                    <i class="fas fa-search text-muted ms-3 me-3"></i>
                    <input type="text" id="searchInput" class="form-control border-0 shadow-none" placeholder="Cari berdasarkan lokasi, tipe, atau nama kos...">
                    <button class="btn btn-primary-custom px-4 ms-2">Cari</button>
                </div>
            </div>
        </div>

        <!-- Grid Kamar -->
        <?php if (empty($rooms)) : ?>
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                    <i class="fas fa-door-closed fa-3x text-muted"></i>
                </div>
                <h4 class="text-dark fw-bold">Maaf, semua kamar sudah terisi</h4>
                <p class="text-muted">Silakan hubungi admin atau cek kembali beberapa hari lagi.</p>
            </div>
        <?php else : ?>
            <div class="row g-4" id="roomGrid">
                <?php foreach ($rooms as $r) : ?>
                    <?php
                    $imgSrc = !empty($r['image'])
                        ? BASEURL . '/assets/img/rooms/' . $r['image']
                        : 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
                    ?>
                    <div class="col-lg-4 col-md-6 room-card-wrap"
                        data-search="<?= strtolower(htmlspecialchars($r['room_number'] . ' ' . $r['kos_name'] . ' ' . $r['kos_address'])); ?>">
                        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden" style="border-radius: 20px;">
                            <div class="position-relative overflow-hidden" style="height: 240px;">
                                <img src="<?= $imgSrc ?>" alt="Kamar <?= htmlspecialchars($r['room_number']); ?>"
                                    class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <?php if ($r['status'] === 'available'): ?>
                                        <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                            <i class="fas fa-check-circle me-1" style="font-size:10px;"></i> Tersedia
                                        </span>
                                    <?php elseif ($r['status'] === 'booked'): ?>
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                            <i class="fas fa-clock me-1" style="font-size:10px;"></i> Dibooking
                                        </span>
                                    <?php elseif ($r['status'] === 'occupied'): ?>
                                        <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">
                                            <i class="fas fa-times-circle me-1" style="font-size:10px;"></i> Terisi
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm">
                                            <i class="fas fa-circle me-1" style="font-size:10px;"></i> <?= ucfirst($r['status']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="position-absolute bottom-0 start-0 m-3">
                                    <div class="bg-white px-3 py-1 rounded-pill text-primary fw-bold shadow-sm">
                                        Rp <?= number_format($r['price'], 0, ',', '.'); ?> <span class="text-muted fw-normal small">/bln</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($r['kos_name']); ?></h5>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                            <?= htmlspecialchars($r['kos_address']); ?>
                                        </p>
                                    </div>
                                    <span class="badge bg-light text-primary border border-primary-subtle rounded-pill px-3">
                                        No. <?= htmlspecialchars($r['room_number']); ?>
                                    </span>
                                </div>

                                <div class="d-flex gap-3 my-3">
                                    <div class="text-muted small"><i class="fas fa-wifi me-1"></i> WiFi</div>
                                    <div class="text-muted small"><i class="fas fa-wind me-1"></i> AC</div>
                                    <div class="text-muted small"><i class="fas fa-bath me-1"></i> KM Dalam</div>
                                </div>

                                <?php if ($r['status'] === 'available'): ?>
                                    <a href="<?= BASEURL; ?>/katalog/detail/<?= $r['id']; ?>"
                                        class="btn btn-outline-primary w-100 py-2 rounded-pill fw-bold transition-all mt-2">
                                        Lihat Detail Kamar
                                    </a>
                                <?php elseif ($r['status'] === 'booked'): ?>
                                    <button type="button" class="btn btn-warning w-100 py-2 rounded-pill fw-bold transition-all mt-2"
                                        onclick="alert('Maaf, kamar ini sedang dibooking. Silakan cek kembali nanti atau hubungi admin untuk info lebih lanjut.')"
                                        title="Kamar sedang dibooking" disabled>
                                        Sudah Dibooking
                                    </button>
                                <?php elseif ($r['status'] === 'occupied'): ?>
                                    <button type="button" class="btn btn-danger w-100 py-2 rounded-pill fw-bold transition-all mt-2"
                                        onclick="alert('Kamar ini sudah terisi. Silakan pilih kamar lain atau hubungi admin.')"
                                        title="Kamar terisi" disabled>
                                        Terisi
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary w-100 py-2 rounded-pill fw-bold transition-all mt-2"
                                        onclick="alert('Status kamar: <?= htmlspecialchars($r['status']); ?>. Silakan hubungi admin.')"
                                        disabled>
                                        Tidak Tersedia
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- No Result -->
            <div id="noResult" class="text-center py-5 d-none">
                <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                <h5 class="text-muted">Kamar tidak ditemukan</h5>
                <p class="text-muted small">Coba kata kunci lain atau filter berbeda.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Facilities Section -->
<section id="fasilitas" class="bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800">Fasilitas Utama</h2>
            <p class="text-muted">Kami menjamin kenyamanan Anda dengan berbagai fasilitas modern.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm hover-lift h-100">
                    <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex p-3 mb-3">
                        <i class="fas fa-wifi fs-4"></i>
                    </div>
                    <h6 class="fw-bold">WiFi Cepat</h6>
                    <p class="text-muted small mb-0">Internet 24 jam untuk kerja & belajar</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm hover-lift h-100">
                    <div class="bg-success-subtle text-success rounded-circle d-inline-flex p-3 mb-3">
                        <i class="fas fa-shield-alt fs-4"></i>
                    </div>
                    <h6 class="fw-bold">Keamanan 24/7</h6>
                    <p class="text-muted small mb-0">CCTV dan penjagaan area kos</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm hover-lift h-100">
                    <div class="bg-warning-subtle text-warning rounded-circle d-inline-flex p-3 mb-3">
                        <i class="fas fa-parking fs-4"></i>
                    </div>
                    <h6 class="fw-bold">Parkir Luas</h6>
                    <p class="text-muted small mb-0">Tersedia untuk motor dan mobil</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm hover-lift h-100">
                    <div class="bg-info-subtle text-info rounded-circle d-inline-flex p-3 mb-3">
                        <i class="fas fa-faucet fs-4"></i>
                    </div>
                    <h6 class="fw-bold">Air Bersih</h6>
                    <p class="text-muted small mb-0">Sumber air lancar dan jernih</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimoni" class="bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800">Apa Kata Mereka?</h2>
            <p class="text-muted">Dengarkan pengalaman langsung dari para penghuni Kosan Pak Iskandar.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 h-100 border border-transparent hover-lift">
                    <div class="d-flex gap-2 text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4">"Kosannya bersih banget, kamarnya juga estetik. Pak Iskandar orangnya ramah dan fast response kalau ada kendala."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://i.pravatar.cc/150?u=a" class="rounded-circle" width="50" height="50" alt="User">
                        <div>
                            <h6 class="fw-bold mb-0">Andini Putri</h6>
                            <span class="text-muted small">Mahasiswi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 h-100 border border-transparent hover-lift">
                    <div class="d-flex gap-2 text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4">"Lokasinya strategis banget buat ke kantor. Fasilitas WiFi-nya kenceng, cocok buat yang sering WFH."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://i.pravatar.cc/150?u=b" class="rounded-circle" width="50" height="50" alt="User">
                        <div>
                            <h6 class="fw-bold mb-0">Budi Santoso</h6>
                            <span class="text-muted small">Karyawan Swasta</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 h-100 border border-transparent hover-lift">
                    <div class="d-flex gap-2 text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4">"Udah 2 tahun ngekos di sini dan betah banget. Keamanan terjamin karena ada CCTV di setiap sudut."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://i.pravatar.cc/150?u=c" class="rounded-circle" width="50" height="50" alt="User">
                        <div>
                            <h6 class="fw-bold mb-0">Rina Wijaya</h6>
                            <span class="text-muted small">Freelancer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="bg-primary rounded-5 p-5 text-center text-white shadow-2xl animate__animated animate__pulse animate__infinite animate__slower">
            <h2 class="display-6 fw-800 mb-3">Siap Menjadi Bagian dari Kami?</h2>
            <p class="lead mb-4 opacity-75">Jangan sampai kehabisan, kamar favorit biasanya cepat terisi!</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?= BASEURL ?>/auth/register" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold text-primary">Daftar Sekarang</a>
                <a href="https://wa.me/6281234567890" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold"><i class="fab fa-whatsapp me-2"></i> Tanya Admin</a>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();

// ─── SCRIPTS ──────────────────────────────────────────────────────────────────
ob_start();
?>
<style>
    .fw-800 {
        font-weight: 800;
    }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .ms-n2 {
        margin-left: -0.75rem;
    }

    .-space-x-2 {
        display: flex;
    }

    .search-box {
        transition: all 0.3s ease;
    }

    .search-box:focus-within {
        box-shadow: 0 10px 30px rgba(67, 97, 238, 0.15) !important;
        border-color: var(--primary-color) !important;
    }

    .room-card-wrap {
        transition: all 0.4s ease;
    }

    .transition-all {
        transition: all 0.3s ease;
    }
</style>
<script>
    // Live search
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.room-card-wrap');
        let visible = 0;

        cards.forEach(card => {
            const haystack = card.dataset.search;
            const match = !q || haystack.includes(q);
            card.style.display = match ? '' : 'none';
            if (match) {
                visible++;
                card.classList.add('animate__animated', 'animate__fadeIn');
            }
        });

        document.getElementById('noResult').classList.toggle('d-none', visible > 0);
    });
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/landing.php';
?>
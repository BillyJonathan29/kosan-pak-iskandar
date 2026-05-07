<?php ob_start(); ?>

<!-- Hero Section -->
<section class="hero-section p-0 m-0">
    <div id="heroCarouselFull" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">

        <div class="carousel-indicators mb-4">
            <button type="button" data-bs-target="#heroCarouselFull" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarouselFull" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarouselFull" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">

            <div class="carousel-item active" style="height: 90vh; min-height: 600px;">
                <img src="<?= BASEURL ?>/assets/img/kos2.jpeg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Kamar Nyaman">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));"></div>

                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 pb-0" style="bottom: 0;">
                    <div class="animate__animated animate__fadeInUp">
                        <span class="badge bg-primary px-4 py-2 rounded-pill mb-4 fw-bold shadow">🏠 Hunian Nyaman & Terpercaya</span>
                        <h1 class="display-3 fw-bolder text-white mb-4" style="line-height: 1.2;">Temukan Kamar <span class="text-info">Impian</span> Anda di Sini.</h1>
                        <p class="lead text-light mb-5 mx-auto" style="max-width: 700px; font-size: 1.2rem;">Kosan Pak Iskandar menyediakan kamar eksklusif dengan fasilitas lengkap, keamanan 24 jam, dan lokasi yang sangat strategis.</p>
                        <div class="d-flex flex-sm-row flex-column justify-content-center gap-3">
                            <a href="#katalog" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">Cari Kamar Sekarang</a>
                            <a href="#fasilitas" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">Lihat Fasilitas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item" style="height: 90vh; min-height: 600px;">
                <img src="<?= BASEURL ?>/assets/img/kos-1.jpeg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Fasilitas Bersih">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));"></div>

                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 pb-0" style="bottom: 0;">
                    <div class="animate__animated animate__fadeInUp">
                        <span class="badge bg-success px-4 py-2 rounded-pill mb-4 fw-bold shadow">✨ Bersih & Terawat</span>
                        <h1 class="display-3 fw-bolder text-white mb-4" style="line-height: 1.2;">Fasilitas Lengkap <span class="text-success">Siap Pakai</span>.</h1>
                        <p class="lead text-light mb-5 mx-auto" style="max-width: 700px; font-size: 1.2rem;">Kamar full-furnished, Wi-Fi super cepat, dan lingkungan yang asri mendukung produktivitas Anda setiap hari.</p>
                        <div class="d-flex flex-sm-row flex-column justify-content-center gap-3">
                            <a href="#katalog" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">Cari Kamar Sekarang</a>
                            <a href="#fasilitas" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">Lihat Fasilitas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item" style="height: 90vh; min-height: 600px;">
                <img src="<?= BASEURL ?>/assets/img/parkir.jpeg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Keamanan Terjamin">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));"></div>

                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 pb-0" style="bottom: 0;">
                    <div class="animate__animated animate__fadeInUp">
                        <span class="badge bg-warning text-dark px-4 py-2 rounded-pill mb-4 fw-bold shadow">🛡️ Keamanan 24 Jam</span>
                        <h1 class="display-3 fw-bolder text-white mb-4" style="line-height: 1.2;">Tenang dan <span class="text-warning">Aman</span> Sepanjang Waktu.</h1>
                        <p class="lead text-light mb-5 mx-auto" style="max-width: 700px; font-size: 1.2rem;">Dilengkapi dengan CCTV di berbagai sudut dan sistem kunci gerbang mandiri untuk privasi dan keamanan Anda.</p>
                        <div class="d-flex flex-sm-row flex-column justify-content-center gap-3">
                            <a href="#katalog" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">Cari Kamar Sekarang</a>
                            <a href="#fasilitas" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">Lihat Fasilitas</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarouselFull" data-bs-slide="prev">
            <span class="carousel-control-prev-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true" style="width: 3.5rem; height: 3.5rem;"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarouselFull" data-bs-slide="next">
            <span class="carousel-control-next-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true" style="width: 3.5rem; height: 3.5rem;"></span>
            <span class="visually-hidden">Next</span>
        </button>

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
                    <input type="text" id="searchInput" class="form-control border-0 shadow-none" placeholder="Cari nomor kamar, lokasi, atau nama kos...">
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
                                    <div class="text-muted small"><i class="fas fa-parking me-1"></i> Parkiran</div>
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
<section id="testimoni" class="py-5 bg-white overflow-hidden">
    <div class="container py-4">
        <div class="text-center mb-5 animate__animated animate__fadeIn">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3 fw-semibold">
                <i class="fas fa-star me-1"></i> Testimoni
            </span>
            <h2 class="fw-800 display-5 mb-3">Apa Kata <span class="text-gradient">Penghuni Kami?</span></h2>
            <p class="text-muted mx-auto fs-5" style="max-width: 700px;">Kepuasan penghuni adalah prioritas utama kami. Berikut adalah pengalaman nyata dari mereka yang telah menetap bersama kami.</p>
        </div>

        <?php if (empty($reviews)) : ?>
            <div class="text-center py-5 opacity-50">
                <p class="fst-italic">Belum ada ulasan untuk saat ini.</p>
            </div>
        <?php else : ?>
            <div class="row g-4 justify-content-center">
                <?php 
                // Ambil maksimal 6 ulasan terbaru untuk ditampilkan di landing page
                $displayReviews = array_slice($reviews, 0, 6);
                foreach ($displayReviews as $rev) : 
                ?>
                    <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp">
                        <div class="testimonial-card p-4 rounded-4 shadow-sm border h-100 bg-white hover-lift transition-all">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-circle bg-primary text-white me-3 shadow-sm">
                                    <?= strtoupper(substr($rev['user_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($rev['user_name']) ?></h6>
                                    <small class="text-muted">Penghuni Kamar <?= htmlspecialchars($rev['room_number']) ?></small>
                                </div>
                            </div>
                            
                            <div class="rating-stars mb-3 text-warning">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i class="<?= $i <= $rev['rating'] ? 'fas' : 'far'; ?> fa-star small"></i>
                                <?php endfor; ?>
                            </div>

                            <div class="testimonial-content position-relative">
                                <!-- <i class="fas fa-quote-left quote-icon opacity-10"></i> -->
                                <p class="mb-0 text-muted fst-italic position-relative" style="line-height: 1.6;">
                                    "<?= htmlspecialchars($rev['comment']) ?>"
                                </p>
                            </div>
                            
                            <div class="mt-4 pt-3 border-top border-light-subtle d-flex justify-content-between align-items-center">
                                <span class="text-primary small fw-bold"><?= htmlspecialchars($rev['kos_name']) ?></span>
                                <small class="text-muted fw-light" style="font-size: 0.75rem;">
                                    <?= date('d M Y', strtotime($rev['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-5">
                <a href="<?= BASEURL ?>/katalog" class="btn btn-outline-primary rounded-pill px-4 py-2 hover-scale">
                    Lihat Semua Ulasan <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<section id="faq" class="bg-white py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3 fw-semibold">
                <i class="fas fa-question-circle me-1"></i> Bantuan
            </span>
            <h2 class="fw-bold mb-3">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-muted">Temukan jawaban cepat seputar fasilitas, aturan, dan pembayaran di Kosan Pak Iskandar.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="accordionFAQ">

                    <div class="accordion-item border rounded-4 mb-3 shadow-sm overflow-hidden">
                        <h2 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button collapsed fw-semibold p-4" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                                Apa saja fasilitas yang didapatkan di dalam kamar?
                            </button>
                        </h2>
                        <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body px-4 pb-4 pt-0 text-muted" style="line-height: 1.7;">
                                Setiap kamar sudah disiapkan full-furnished! Anda akan mendapatkan kasur springbed yang nyaman, lemari pakaian 2 pintu, meja dan kursi belajar, AC/Kipas Angin, serta kamar mandi dalam dengan shower. Tentu saja, Wi-Fi berkecepatan tinggi juga gratis.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border rounded-4 mb-3 shadow-sm overflow-hidden">
                        <h2 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed fw-semibold p-4" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                Apakah biaya sewa sudah termasuk air dan listrik?
                            </button>
                        </h2>
                        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body px-4 pb-4 pt-0 text-muted" style="line-height: 1.7;">
                                Biaya sewa bulanan sudah <strong>termasuk air bersih dan akses Wi-Fi</strong> sepuasnya. Sedangkan untuk listrik, setiap kamar memiliki meteran token prabayar sendiri, sehingga pengeluaran bisa disesuaikan dengan pemakaian pribadi Anda.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border rounded-4 mb-3 shadow-sm overflow-hidden">
                        <h2 class="accordion-header" id="faqHeading3">
                            <button class="accordion-button collapsed fw-semibold p-4" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                Bagaimana sistem pembayaran untuk booking kamar?
                            </button>
                        </h2>
                        <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body px-4 pb-4 pt-0 text-muted" style="line-height: 1.7;">
                                Sistem kami sangat modern. Anda bisa melakukan booking dan pembayaran langsung melalui website ini (terintegrasi dengan Midtrans). Kami menerima transfer bank (Virtual Account), e-Wallet (GoPay, OVO, Dana), hingga pembayaran via minimarket.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border rounded-4 mb-3 shadow-sm overflow-hidden">
                        <h2 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed fw-semibold p-4" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                Apakah ada jam malam atau aturan jam tamu?
                            </button>
                        </h2>
                        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body px-4 pb-4 pt-0 text-muted" style="line-height: 1.7;">
                                Penghuni memegang kunci gerbang utama masing-masing (akses 24 jam). Namun, demi kenyamanan dan keamanan bersama, tamu dari luar dilarang menginap tanpa izin Pak Iskandar, dan batas waktu kunjungan tamu adalah maksimal pukul 22.00 WIB.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border rounded-4 mb-3 shadow-sm overflow-hidden">
                        <h2 class="accordion-header" id="faqHeading5">
                            <button class="accordion-button collapsed fw-semibold p-4" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                                Apakah tersedia area parkir untuk kendaraan?
                            </button>
                        </h2>
                        <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body px-4 pb-4 pt-0 text-muted" style="line-height: 1.7;">
                                Tentu! Kami menyediakan area parkir motor yang luas, aman, dan berkanopi di dalam area kos yang diawasi oleh kamera CCTV 24 jam penuh.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="text-muted mb-3">Masih punya pertanyaan lain yang belum terjawab?</p>
            <a href="https://wa.me/628122218062" target="_blank" class="btn btn-outline-success rounded-pill px-4 py-2">
                <i class="fab fa-whatsapp me-2"></i> Hubungi Pak Iskandar
            </a>
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

    /* Testimonials Styling */
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .quote-icon {
        position: absolute;
        top: -10px;
        left: -15px;
        font-size: 2.5rem;
        color: var(--primary-color);
        pointer-events: none;
    }

    .testimonial-card {
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .testimonial-card:hover {
        border-color: rgba(67, 97, 238, 0.2) !important;
        box-shadow: 0 20px 40px rgba(67, 97, 238, 0.05) !important;
    }

    #accordionFAQ .accordion-item {
        border-bottom: 1px solid #dee2e6 !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Efek hover lembut saat kursor diarahkan ke kotak FAQ */
    #accordionFAQ .accordion-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important;
    }

    /* Matikan background biru default bootstrap saat accordion diklik/aktif */
    .accordion-button:not(.collapsed) {
        background-color: #fff;
        color: #0d6efd;
        box-shadow: none;
    }

    .accordion-button:focus {
        border-color: rgba(0, 0, 0, .125);
        box-shadow: none;
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
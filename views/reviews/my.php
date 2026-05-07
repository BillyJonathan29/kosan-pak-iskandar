<?php ob_start(); ?>

<div class="container py-5 mt-5">
    <!-- Breadcrumb & Header Section -->
    <div class="row mb-5 animate__animated animate__fadeInDown">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="<?= BASEURL ?>" class="text-decoration-none text-muted"><i class="fas fa-home me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Ulasan Saya</li>
                </ol>
            </nav>
            <h1 class="fw-800 text-dark mb-2 tracking-tight">Kesan & <span class="text-gradient">Ulasan Anda</span></h1>
            <p class="text-muted fs-5">Bagikan pengalaman berharga Anda untuk membantu orang lain menemukan hunian impian mereka.</p>
        </div>
        <div class="col-lg-4 d-flex align-items-center justify-content-lg-end mt-4 mt-lg-0">
            <a href="<?= BASEURL ?>/booking" class="btn btn-primary-custom rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2 hover-scale">
                <i class="fas fa-history"></i> Riwayat Booking
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash'])) : ?>
        <div class="alert alert-<?= $_SESSION['flash']['tipe']; ?> alert-dismissible fade show border-0 rounded-4 shadow-sm mb-5 animate__animated animate__fadeIn" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon-circle bg-<?= $_SESSION['flash']['tipe']; ?> text-white me-3">
                    <i class="fas <?= $_SESSION['flash']['tipe'] === 'success' ? 'fa-check' : 'fa-exclamation'; ?>"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold"><?= $_SESSION['flash']['tipe'] === 'success' ? 'Berhasil!' : 'Perhatian'; ?></h6>
                    <span class="small"><?= $_SESSION['flash']['pesan']; ?></span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (empty($reviews)): ?>
        <!-- Modern Empty State -->
        <div class="empty-state-wrapper text-center py-5 animate__animated animate__zoomIn">
            <div class="empty-state-illustration mb-4">
                <div class="blob-bg"></div>
                <i class="fas fa-comment-slash fa-5x text-primary shadow-icon"></i>
            </div>
            <h3 class="fw-800 text-dark">Suara Anda Belum Terdengar</h3>
            <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                Tampaknya Anda belum memberikan ulasan untuk kamar yang Anda sewa. 
                Bagikan cerita Anda sekarang untuk membantu komunitas kami tumbuh lebih baik!
            </p>
            <a href="<?= BASEURL ?>/booking" class="btn btn-gradient-primary btn-lg px-5 rounded-pill shadow-lg hover-scale">
                Beri Ulasan Pertama Anda
            </a>
        </div>
    <?php else: ?>
        <!-- Stats Summary Section -->
        <div class="row g-4 mb-5 animate__animated animate__fadeInUp">
            <div class="col-md-4">
                <div class="stat-card glass-card p-4 rounded-4 text-center h-100">
                    <div class="icon-box bg-primary-soft text-primary mb-3 mx-auto">
                        <i class="fas fa-star"></i>
                    </div>
                    <h2 class="fw-800 mb-1"><?= count($reviews) ?></h2>
                    <p class="text-muted mb-0 small text-uppercase tracking-wider">Total Ulasan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card glass-card p-4 rounded-4 text-center h-100">
                    <div class="icon-box bg-warning-soft text-warning mb-3 mx-auto">
                        <i class="fas fa-award"></i>
                    </div>
                    <?php 
                        $avg = 0;
                        if(count($reviews) > 0) {
                            $totalRating = array_sum(array_column($reviews, 'rating'));
                            $avg = round($totalRating / count($reviews), 1);
                        }
                    ?>
                    <h2 class="fw-800 mb-1"><?= $avg ?></h2>
                    <p class="text-muted mb-0 small text-uppercase tracking-wider">Rata-rata Rating</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card glass-card p-4 rounded-4 text-center h-100">
                    <div class="icon-box bg-info-soft text-info mb-3 mx-auto">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h2 class="fw-800 mb-1">Aktif</h2>
                    <p class="text-muted mb-0 small text-uppercase tracking-wider">Status Kontributor</p>
                </div>
            </div>
        </div>

        <!-- Review Grid -->
        <div class="row g-4">
            <?php foreach ($reviews as $r): ?>
                <div class="col-lg-6 animate__animated animate__fadeInUp">
                    <div class="review-card glass-card border-0 rounded-4 overflow-hidden h-100 transition-all hover-lift">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="room-avatar bg-gradient-primary text-white">
                                        <i class="fas fa-door-open"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($r['kos_name']) ?></h5>
                                        <span class="badge badge-primary-light rounded-pill px-3">Kamar <?= htmlspecialchars($r['room_number']) ?></span>
                                    </div>
                                </div>
                                <div class="rating-badge p-2 px-3 rounded-pill bg-warning-light text-warning fw-bold d-flex align-items-center gap-2">
                                    <i class="fas fa-star"></i> <?= $r['rating'] ?>.0
                                </div>
                            </div>
                            
                            <div class="review-quote-wrapper position-relative py-3">
                                <i class="fas fa-quote-left quote-icon-bg"></i>
                                <p class="review-text text-muted mb-0 fst-italic position-relative">
                                    "<?= htmlspecialchars($r['comment']) ?>"
                                </p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top border-light">
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <i class="far fa-calendar-alt text-primary"></i>
                                    <span>Dikirim pada <?= date('d M Y', strtotime($r['created_at'])) ?></span>
                                </div>
                                <div class="star-rating-display">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="<?= $i <= $r['rating'] ? 'fas' : 'far'; ?> fa-star text-warning small"></i>
                                    <?php endfor; ?>
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
    /* Typography & Core */
    .fw-800 { font-weight: 800; }
    .tracking-tight { letter-spacing: -1px; }
    .tracking-wider { letter-spacing: 1px; }
    
    .text-gradient {
        background: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Cards & Glassmorphism */
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .review-card:hover {
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 25px 50px rgba(67, 97, 238, 0.1);
    }

    .hover-lift {
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
    }

    /* Icon Boxes */
    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .alert-icon-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .bg-primary-soft { background-color: rgba(67, 97, 238, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
    }

    .room-avatar {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
    }

    /* Badges */
    .badge-primary-light {
        background-color: rgba(67, 97, 238, 0.08);
        color: #4361ee;
        font-weight: 600;
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }

    /* Review Text & Quote */
    .review-quote-wrapper {
        min-height: 80px;
    }

    .quote-icon-bg {
        position: absolute;
        top: 0;
        left: -10px;
        font-size: 3rem;
        opacity: 0.05;
        color: #4361ee;
    }

    .review-text {
        line-height: 1.8;
        font-size: 1.05rem;
        color: #4a5568 !important;
    }

    /* Empty State */
    .empty-state-wrapper {
        padding: 4rem 1rem;
    }

    .empty-state-illustration {
        position: relative;
        display: inline-block;
    }

    .blob-bg {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0) 70%);
        border-radius: 50%;
        z-index: -1;
        animation: pulse-blob 4s infinite ease-in-out;
    }

    @keyframes pulse-blob {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
        50% { transform: translate(-50%, -50%) scale(1.3); opacity: 0.8; }
    }

    .shadow-icon {
        filter: drop-shadow(0 10px 15px rgba(67, 97, 238, 0.2));
    }

    /* Buttons & Links */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
    }

    .hover-scale {
        transition: transform 0.2s ease;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }
</style>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/landing.php';
?>

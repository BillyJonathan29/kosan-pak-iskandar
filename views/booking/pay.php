<?php ob_start(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeIn">
                <div class="card-header bg-primary py-4 text-center">
                    <h4 class="text-white fw-bold mb-0">Rincian Pembayaran</h4>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="text-muted small text-uppercase ls-1 fw-bold">Total yang harus dibayar</div>
                        <h2 class="fw-800 text-dark mb-0">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></h2>
                    </div>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span class="text-muted">Nomor Booking</span>
                            <span class="fw-bold">#<?= $booking['id'] ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span class="text-muted">Tanggal Booking</span>
                            <span><?= date('d M Y', strtotime($booking['booking_date'])) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span class="text-muted">Durasi Sewa</span>
                            <span class="fw-bold text-primary"><?= $booking['duration'] ?> Bulan</span>
                        </li>
                    </ul>

                    <div class="alert alert-info border-0 rounded-3 d-flex align-items-start gap-3">
                        <i class="fas fa-info-circle mt-1"></i>
                        <small>Pembayaran Anda akan diproses secara aman melalui Midtrans. Anda dapat memilih berbagai metode pembayaran seperti Bank Transfer, E-Wallet (Gopay/OVO), dll.</small>
                    </div>

                    <button id="pay-button" class="btn btn-primary btn-lg w-100 py-3 rounded-pill fw-bold shadow mt-3">
                        <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                    </button>

                    <div class="text-center mt-4">
                        <a href="<?= BASEURL ?>/katalog/riwayat" class="text-decoration-none text-muted small">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat Pesanan
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-light py-3 text-center border-0">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Midtrans.png" alt="Midtrans" style="height: 20px; opacity: 0.7;">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

ob_start();
?>
<!-- Include Snap.js Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-kyVFB4OGrgueT_LR"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken didapat dari Controller
        snap.pay('<?= $snap_token ?>', {
            // Optional
            onSuccess: function(result){
                /* Anda bisa mengarahkan user ke halaman sukses */
                window.location.href = '<?= BASEURL ?>/katalog/riwayat';
            },
            // Optional
            onPending: function(result){
                /* Menunggu pembayaran */
                window.location.href = '<?= BASEURL ?>/katalog/riwayat';
            },
            // Optional
            onError: function(result){
                /* Gagal */
                alert("Pembayaran gagal!");
            },
            onClose: function(){
                /* Customer menutup popup sebelum bayar */
                alert('Anda belum menyelesaikan pembayaran.');
            }
        });
    };
</script>
<style>
    .fw-800 { font-weight: 800; }
    .ls-1 { letter-spacing: 1px; }
</style>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../../views/layouts/template.php';
?>

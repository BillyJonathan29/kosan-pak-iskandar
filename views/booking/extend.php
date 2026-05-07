<?php ob_start(); ?>
<div class="container py-5" style="margin-top:50px;">
    <div class="card p-4">
        <h4 class="mb-3">Perpanjang Sewa - Kamar #<?= htmlspecialchars($booking['room_number'] ?? $booking['room_id']) ?></h4>
        <form method="post" action="<?= BASEURL ?>/booking/extend">
            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
            <div class="mb-3">
                <label class="form-label">Durasi Saat Ini</label>
                <input class="form-control" value="<?= htmlspecialchars($booking['duration']) ?> bulan" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Tambahkan Bulan</label>
                <input type="number" name="extra_months" class="form-control" min="1" value="1" required>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" type="submit">Perpanjang</button>
                <a href="<?= BASEURL ?>/booking" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/landing.php';
?>
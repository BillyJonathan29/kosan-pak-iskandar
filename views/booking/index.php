<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-check me-1"></i>
                Data Booking
            </div>
            <button type="button" class="btn btn-primary btn-sm tombolTambahData"
                data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="fas fa-plus"></i> Tambah Booking
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penyewa</th>
                        <th>Kamar</th>
                        <th>Tgl Booking</th>
                        <th>Durasi</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($bookings as $b) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($b['user_name']); ?></div>
                            <small class="text-muted"><?= htmlspecialchars($b['user_email']); ?></small>
                        </td>
                        <td>
                            <div class="fw-semibold">Kamar <?= htmlspecialchars($b['room_number']); ?></div>
                            <small class="text-muted"><?= htmlspecialchars($b['kos_name']); ?></small>
                        </td>
                        <td><?= date('d M Y', strtotime($b['booking_date'])); ?></td>
                        <td><?= $b['duration']; ?> Bulan</td>
                        <td>Rp <?= number_format($b['total_price'], 0, ',', '.'); ?></td>
                        <td>
                            <?php
                                $badgeClass = match($b['status']) {
                                    'pending'   => 'bg-warning text-dark',
                                    'confirmed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    'completed' => 'bg-primary',
                                    default     => 'bg-secondary'
                                };
                                $label = match($b['status']) {
                                    'pending'   => 'Menunggu',
                                    'confirmed' => 'Dikonfirmasi',
                                    'cancelled' => 'Dibatalkan',
                                    'completed' => 'Selesai',
                                    default     => ucfirst($b['status'])
                                };
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $label ?></span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm tampilModalUbah"
                                data-bs-toggle="modal" data-bs-target="#formModal"
                                data-id="<?= $b['id']; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm tombolHapus"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="<?= $b['id']; ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

// ─── MODALS ───────────────────────────────────────────────────────────────────
ob_start();
?>

<!-- Form Modal (Create & Edit) -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASEURL; ?>/booking/store" method="post">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Penyewa -->
                        <div class="col-md-6">
                            <label for="user_id" class="form-label">Penyewa</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">-- Pilih Penyewa --</option>
                                <?php foreach ($users as $u) : ?>
                                    <option value="<?= $u['id']; ?>">
                                        <?= htmlspecialchars($u['name']); ?>
                                        (<?= htmlspecialchars($u['email']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Kamar -->
                        <div class="col-md-6">
                            <label for="room_id" class="form-label">Kamar</label>
                            <select class="form-select" id="room_id" name="room_id" required>
                                <option value="">-- Pilih Kamar --</option>
                                <?php foreach ($rooms as $r) : ?>
                                    <option value="<?= $r['id']; ?>"
                                        data-price="<?= $r['price']; ?>">
                                        <?= htmlspecialchars($r['kos_name']); ?> –
                                        Kamar <?= htmlspecialchars($r['room_number']); ?>
                                        (Rp <?= number_format($r['price'], 0, ',', '.'); ?>/bln)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tanggal Booking -->
                        <div class="col-md-6">
                            <label for="booking_date" class="form-label">Tanggal Booking</label>
                            <input type="date" class="form-control" id="booking_date"
                                name="booking_date" required>
                        </div>

                        <!-- Durasi -->
                        <div class="col-md-3">
                            <label for="duration" class="form-label">Durasi (Bulan)</label>
                            <input type="number" class="form-control" id="duration"
                                name="duration" min="1" value="1" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending">Menunggu</option>
                                <option value="confirmed">Dikonfirmasi</option>
                                <option value="cancelled">Dibatalkan</option>
                                <option value="completed">Selesai</option>
                            </select>
                        </div>

                        <!-- Total Harga (readonly, dihitung otomatis) -->
                        <div class="col-12">
                            <label for="total_price_display" class="form-label">
                                Total Harga
                                <small class="text-muted">(dihitung otomatis)</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control bg-light fw-semibold"
                                    id="total_price_display" readonly placeholder="0">
                                <input type="hidden" name="total_price" id="total_price" value="0">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data booking ini?</p>
                <p class="text-danger small">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="" id="btn-confirm-delete" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<?php
$modal = ob_get_clean();

// ─── SCRIPTS ──────────────────────────────────────────────────────────────────
ob_start();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {

    // ── DataTable ────────────────────────────────────────────────────────────
    const tbl = document.getElementById('datatablesSimple');
    if (tbl) new simpleDatatables.DataTable(tbl);

    // ── Hitung Total Harga Otomatis ──────────────────────────────────────────
    function hitungTotal() {
        const harga   = parseFloat($('#room_id option:selected').data('price')) || 0;
        const durasi  = parseInt($('#duration').val()) || 0;
        const total   = harga * durasi;
        $('#total_price').val(total);
        $('#total_price_display').val(total.toLocaleString('id-ID'));
    }

    $('#room_id, #duration').on('change input', hitungTotal);

    // ── Tambah Data ──────────────────────────────────────────────────────────
    $('.tombolTambahData').on('click', function() {
        $('#formModalLabel').text('Tambah Booking');
        $('.modal-footer button[type=submit]').text('Simpan');
        $('.modal-content form').attr('action', '<?= BASEURL; ?>/booking/store');
        $('#id').val('');
        $('#user_id').val('');
        $('#room_id').val('');
        $('#booking_date').val('');
        $('#duration').val(1);
        $('#status').val('pending');
        $('#total_price').val(0);
        $('#total_price_display').val('');
    });

    // ── Ubah Data ────────────────────────────────────────────────────────────
    $('.tampilModalUbah').on('click', function() {
        $('#formModalLabel').text('Ubah Booking');
        $('.modal-footer button[type=submit]').text('Ubah');
        $('.modal-content form').attr('action', '<?= BASEURL; ?>/booking/update');

        const id = $(this).data('id');
        $.ajax({
            url: '<?= BASEURL; ?>/booking/getubah',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.id);
                $('#user_id').val(data.user_id);
                $('#room_id').val(data.room_id);
                $('#booking_date').val(data.booking_date);
                $('#duration').val(data.duration);
                $('#status').val(data.status);
                $('#total_price').val(data.total_price);
                $('#total_price_display').val(
                    parseFloat(data.total_price).toLocaleString('id-ID')
                );
            }
        });
    });

    // ── Hapus Data ───────────────────────────────────────────────────────────
    $('.tombolHapus').on('click', function() {
        const id = $(this).data('id');
        $('#btn-confirm-delete').attr('href', '<?= BASEURL; ?>/booking/delete/' + id);
    });

});
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/template.php';
?>

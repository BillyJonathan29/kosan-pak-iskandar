<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-link me-1"></i>
                Data Fasilitas Kamar
            </div>
            <button type="button" class="btn btn-primary btn-sm tombolTambahData" data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="fas fa-plus"></i> Tambah Fasilitas Kamar
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kos</th>
                        <th>No. Kamar</th>
                        <th>Icon</th>
                        <th>Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($room_facilities as $rf) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($rf['kos_name']); ?></td>
                        <td><?= htmlspecialchars($rf['room_number']); ?></td>
                        <td class="text-center">
                            <?php if (!empty($rf['icon'])): ?>
                                <i class="<?= htmlspecialchars($rf['icon']); ?> fa-lg"></i>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($rf['facility_name']); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm tampilModalUbah"
                                data-bs-toggle="modal" data-bs-target="#formModal"
                                data-id="<?= $rf['id']; ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm tombolHapus"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="<?= $rf['id']; ?>">
                                <i class="fas fa-trash"></i> Hapus
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

// MODALS
ob_start();
?>
<!-- Form Modal (Create & Edit) -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Fasilitas Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASEURL; ?>/roomfacility/store" method="post">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="room_id" class="form-label">Kamar</label>
                        <select class="form-select" id="room_id" name="room_id" required>
                            <option value="">-- Pilih Kamar --</option>
                            <?php foreach ($rooms as $r) : ?>
                                <option value="<?= $r['id']; ?>">
                                    <?= htmlspecialchars($r['kos_name']); ?> - Kamar <?= htmlspecialchars($r['room_number']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="facility_id" class="form-label">Fasilitas</label>
                        <select class="form-select" id="facility_id" name="facility_id" required>
                            <option value="">-- Pilih Fasilitas --</option>
                            <?php foreach ($facilities as $f) : ?>
                                <option value="<?= $f['id']; ?>">
                                    <?= !empty($f['icon']) ? '[' . htmlspecialchars($f['icon']) . '] ' : ''; ?>
                                    <?= htmlspecialchars($f['facility_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                <h5 class="modal-title" id="deleteModalLabel">Hapus Fasilitas Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data fasilitas kamar ini?</p>
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

// SCRIPTS
ob_start();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // Datatables
        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple);
        }

        // Tambah Data
        $('.tombolTambahData').on('click', function() {
            $('#formModalLabel').html('Tambah Fasilitas Kamar');
            $('.modal-footer button[type=submit]').html('Simpan');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/roomfacility/store');
            $('#id').val('');
            $('#room_id').val('');
            $('#facility_id').val('');
        });

        // Ubah Data
        $('.tampilModalUbah').on('click', function() {
            $('#formModalLabel').html('Ubah Fasilitas Kamar');
            $('.modal-footer button[type=submit]').html('Ubah');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/roomfacility/update');

            const id = $(this).data('id');

            $.ajax({
                url: '<?= BASEURL; ?>/roomfacility/getubah',
                data: { id: id },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#room_id').val(data.room_id);
                    $('#facility_id').val(data.facility_id);
                }
            });
        });

        // Hapus Data
        $('.tombolHapus').on('click', function() {
            const id = $(this).data('id');
            $('#btn-confirm-delete').attr('href', '<?= BASEURL; ?>/roomfacility/delete/' + id);
        });
    });
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/template.php';
?>

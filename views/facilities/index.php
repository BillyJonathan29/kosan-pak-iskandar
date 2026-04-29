<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-concierge-bell me-1"></i>
                Data Fasilitas
            </div>
            <button type="button" class="btn btn-primary btn-sm tombolTambahData" data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="fas fa-plus"></i> Tambah Fasilitas
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Icon</th>
                        <th>Nama Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($facilities as $f) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-center">
                            <?php if (!empty($f['icon'])): ?>
                                <i class="<?= htmlspecialchars($f['icon']); ?> fa-lg"></i>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($f['facility_name']); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm tampilModalUbah"
                                data-bs-toggle="modal" data-bs-target="#formModal"
                                data-id="<?= $f['id']; ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm tombolHapus"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="<?= $f['id']; ?>">
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
                <h5 class="modal-title" id="formModalLabel">Tambah Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASEURL; ?>/facility/store" method="post">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="facility_name" class="form-label">Nama Fasilitas</label>
                        <input type="text" class="form-control" id="facility_name" name="facility_name"
                            required placeholder="Contoh: WiFi, AC, Kamar Mandi Dalam">
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">
                            Icon <small class="text-muted">(Class FontAwesome, cth: <code>fas fa-wifi</code>)</small>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="iconPreview"><i id="iconPreviewEl" class="fas fa-question"></i></span>
                            <input type="text" class="form-control" id="icon" name="icon"
                                placeholder="fas fa-wifi">
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
                <h5 class="modal-title" id="deleteModalLabel">Hapus Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus fasilitas ini?</p>
                <p class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Semua data kamar yang menggunakan fasilitas ini juga akan terhapus.</p>
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

        // Live icon preview
        $('#icon').on('input', function() {
            const cls = $(this).val().trim();
            $('#iconPreviewEl').attr('class', cls || 'fas fa-question');
        });

        // Tambah Data
        $('.tombolTambahData').on('click', function() {
            $('#formModalLabel').html('Tambah Fasilitas');
            $('.modal-footer button[type=submit]').html('Simpan');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/facility/store');
            $('#id').val('');
            $('#facility_name').val('');
            $('#icon').val('');
            $('#iconPreviewEl').attr('class', 'fas fa-question');
        });

        // Ubah Data
        $('.tampilModalUbah').on('click', function() {
            $('#formModalLabel').html('Ubah Fasilitas');
            $('.modal-footer button[type=submit]').html('Ubah');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/facility/update');

            const id = $(this).data('id');

            $.ajax({
                url: '<?= BASEURL; ?>/facility/getubah',
                data: { id: id },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#facility_name').val(data.facility_name);
                    $('#icon').val(data.icon);
                    $('#iconPreviewEl').attr('class', data.icon || 'fas fa-question');
                }
            });
        });

        // Hapus Data
        $('.tombolHapus').on('click', function() {
            const id = $(this).data('id');
            $('#btn-confirm-delete').attr('href', '<?= BASEURL; ?>/facility/delete/' + id);
        });
    });
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/template.php';
?>

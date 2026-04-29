<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-home me-1"></i>
                Data Kos
            </div>
            <button type="button" class="btn btn-primary btn-sm tombolTambahData" data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="fas fa-plus"></i> Tambah Kos
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kos</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($kos as $k) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($k['name']); ?></td>
                        <td><?= htmlspecialchars($k['address']); ?></td>
                        <td><?= htmlspecialchars($k['phone']); ?></td>
                        <td><?= htmlspecialchars($k['description']); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm tampilModalUbah" data-bs-toggle="modal" data-bs-target="#formModal" data-id="<?= $k['id']; ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm tombolHapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $k['id']; ?>">
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
                <h5 class="modal-title" id="formModalLabel">Tambah Data Kos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASEURL; ?>/kos/store" method="post">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kos</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Contoh: Kosan Pak Iskandar">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="08123456789">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Kos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data kos ini?</p>
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
            $('#formModalLabel').html('Tambah Data Kos');
            $('.modal-footer button[type=submit]').html('Simpan');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/kos/store');
            $('#id').val('');
            $('#name').val('');
            $('#address').val('');
            $('#phone').val('');
            $('#description').val('');
        });

        // Ubah Data
        $('.tampilModalUbah').on('click', function() {
            $('#formModalLabel').html('Ubah Data Kos');
            $('.modal-footer button[type=submit]').html('Ubah');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/kos/update');

            const id = $(this).data('id');

            $.ajax({
                url: '<?= BASEURL; ?>/kos/getubah',
                data: {id: id},
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#address').val(data.address);
                    $('#phone').val(data.phone);
                    $('#description').val(data.description);
                }
            });
        });

        // Hapus Data
        $('.tombolHapus').on('click', function() {
            const id = $(this).data('id');
            $('#btn-confirm-delete').attr('href', '<?= BASEURL; ?>/kos/delete/' + id);
        });
    });
</script>
<?php 
$scripts = ob_get_clean(); 

require_once __DIR__ . '/../layouts/template.php'; 
?>

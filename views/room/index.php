<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-door-open me-1"></i>
                Data Kamar
            </div>
            <button type="button" class="btn btn-primary btn-sm tombolTambahData" data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="fas fa-plus"></i> Tambah Kamar
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Kos</th>
                        <th>Nomor Kamar</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($rooms as $room) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-center">
                            <?php if ($room['image']): ?>
                                <img src="<?= BASEURL; ?>/assets/img/rooms/<?= $room['image']; ?>" alt="Foto Kamar" style="width: 50px; height: 50px; object-fit: cover;" class="rounded shadow-sm">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded border" style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($room['kos_name']); ?></td>
                        <td><?= htmlspecialchars($room['room_number']); ?></td>
                        <td>Rp <?= number_format($room['price'], 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($room['status'] == 'available'): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php elseif ($room['status'] == 'booked'): ?>
                                <span class="badge bg-warning text-dark">Dipesan</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Terisi</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($room['description']); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm tampilModalUbah" data-bs-toggle="modal" data-bs-target="#formModal" data-id="<?= $room['id']; ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm tombolHapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $room['id']; ?>">
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
                <h5 class="modal-title" id="formModalLabel">Tambah Data Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASEURL; ?>/room/store" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="old_image" id="old_image">
                <div class="modal-body">
                    <div class="mb-3 text-center d-none" id="current_image_container">
                        <label class="form-label d-block text-start">Foto Saat Ini</label>
                        <img src="" id="current_image" alt="Current Image" style="max-width: 150px;" class="img-thumbnail mb-2">
                    </div>
                    <div class="mb-3">
                        <label for="kos_id" class="form-label">Pilih Kos</label>
                        <select class="form-select" id="kos_id" name="kos_id" required>
                            <option value="">-- Pilih Kos --</option>
                            <?php foreach($kos as $k) : ?>
                                <option value="<?= $k['id']; ?>"><?= $k['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="room_number" class="form-label">Nomor Kamar</label>
                        <input type="text" class="form-control" id="room_number" name="room_number" required placeholder="Contoh: A-01">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Bulan)</label>
                        <input type="number" class="form-control" id="price" name="price" required placeholder="Contoh: 1500000">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="available">Tersedia</option>
                            <option value="booked">Dipesan</option>
                            <option value="occupied">Terisi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Kamar</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
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
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data kamar ini beserta fotonya?</p>
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
            $('#formModalLabel').html('Tambah Data Kamar');
            $('.modal-footer button[type=submit]').html('Simpan');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/room/store');
            $('#id').val('');
            $('#old_image').val('');
            $('#kos_id').val('');
            $('#room_number').val('');
            $('#price').val('');
            $('#status').val('available');
            $('#description').val('');
            $('#image').val('');
            $('#current_image_container').addClass('d-none');
        });

        // Ubah Data
        $('.tampilModalUbah').on('click', function() {
            $('#formModalLabel').html('Ubah Data Kamar');
            $('.modal-footer button[type=submit]').html('Ubah');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/room/update');
            $('#image').val('');

            const id = $(this).data('id');

            $.ajax({
                url: '<?= BASEURL; ?>/room/getubah',
                data: {id: id},
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#old_image').val(data.image);
                    $('#kos_id').val(data.kos_id);
                    $('#room_number').val(data.room_number);
                    $('#price').val(data.price);
                    $('#status').val(data.status);
                    $('#description').val(data.description);
                    
                    if(data.image) {
                        $('#current_image').attr('src', '<?= BASEURL; ?>/assets/img/rooms/' + data.image);
                        $('#current_image_container').removeClass('d-none');
                    } else {
                        $('#current_image_container').addClass('d-none');
                    }
                }
            });
        });

        // Hapus Data
        $('.tombolHapus').on('click', function() {
            const id = $(this).data('id');
            $('#btn-confirm-delete').attr('href', '<?= BASEURL; ?>/room/delete/' + id);
        });
    });
</script>
<?php 
$scripts = ob_get_clean(); 

require_once __DIR__ . '/../layouts/template.php'; 
?>

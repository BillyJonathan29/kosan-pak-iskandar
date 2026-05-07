<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-star me-1"></i>
                Data Ulasan Pengguna
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Kos - Kamar</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($reviews as $r) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($r['user_name']); ?></td>
                            <td><?= htmlspecialchars($r['kos_name']); ?> - <?= htmlspecialchars($r['room_number']); ?></td>
                            <td>
                                <div class="text-warning">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="<?= $i <= $r['rating'] ? 'fas' : 'far'; ?> fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($r['comment']); ?></td>
                            <td><?= date('d M Y', strtotime($r['created_at'])); ?></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm tombolHapus"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="<?= $r['id']; ?>">
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
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Ulasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus ulasan ini? Tindakan ini tidak dapat dibatalkan.</p>
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
<script>
    $(function() {
        // Datatables
        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple);
        }

        // Hapus Data
        $('.tombolHapus').on('click', function() {
            const id = $(this).data('id');
            $('#btn-confirm-delete').attr('href', '<?= BASEURL; ?>/review/delete/' + id);
        });
    });
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/template.php';
?>

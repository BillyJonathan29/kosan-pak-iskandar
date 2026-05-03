<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Data User
            </div>
            <a href="<?= BASEURL; ?>/user/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?= !empty($user['profile_image']) ? BASEURL . '/assets/img/profile/' . $user['profile_image'] : BASEURL . '/assets/img/default-avatar.jpg'; ?>" 
                                    class="rounded-circle me-2" width="35" height="35" style="object-fit: cover;">
                                <?= htmlspecialchars($user['name']); ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['phone']); ?></td>
                        <td>
                            <?php if ($user['role'] == 'admin'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-success">User</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASEURL; ?>/user/edit/<?= $user['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="<?= BASEURL; ?>/user/delete/<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
// Datatables script
$scripts = '<script>
    window.addEventListener("DOMContentLoaded", event => {
        const datatablesSimple = document.getElementById("datatablesSimple");
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple);
        }
    });
</script>';

$content = ob_get_clean(); 
require_once __DIR__ . '/../layouts/template.php'; 
?>

<?php ob_start(); ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Form Edit User
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/user/update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        
                        <div class="mb-3 text-center">
                            <?php 
                                $image = !empty($user['profile_image']) ? BASEURL . '/assets/img/profile/' . $user['profile_image'] : BASEURL . '/assets/img/default-avatar.jpg';
                            ?>
                            <img src="<?= $image; ?>" class="rounded-circle mb-2" width="100" height="100" id="img-preview" style="object-fit: cover;">
                            <br>
                            <label for="profile_image" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" onchange="previewImage()">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No Handphone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="<?= BASEURL; ?>/user" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$scripts = '
<script>
    function previewImage() {
        const image = document.querySelector("#profile_image");
        const imgPreview = document.querySelector("#img-preview");

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>';
$content = ob_get_clean(); 
require_once __DIR__ . '/../layouts/template.php'; 
?>

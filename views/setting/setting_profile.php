<?php ob_start(); ?>

<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <?php if (isset($_SESSION['flash'])) : ?>
                <div class="alert alert-<?= $_SESSION['flash']['tipe']; ?> alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
                <form action="<?= BASEURL ?>/profile/update" method="POST" enctype="multipart/form-data">
                    <div class="card-header bg-dark py-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 position-relative profile-image-container" style="cursor: pointer;" onclick="document.getElementById('profile_image').click();">
                                <?php
                                $avatar = !empty($user['profile_image']) ? BASEURL . '/assets/img/profile/' . $user['profile_image'] : BASEURL . '/assets/img/default-avatar.jpg';
                                ?>
                                <img id="img-preview" class="img-account-profile rounded-circle border border-4 border-white shadow"
                                    src="<?= $avatar ?>"
                                    alt="Avatar" style="width: 100px; height: 100px; object-fit: cover;">
                                <div class="profile-image-overlay rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-camera text-white"></i>
                                </div>
                                <input type="file" name="profile_image" id="profile_image" class="d-none" onchange="previewImage()">
                            </div>
                            <div class="ms-4 text-white">
                                <h3 class="mb-1 fw-bold"><?= $user['name'] ?></h3>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-shield-alt me-1"></i> <?= ucfirst($user['role']) ?>
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-envelope me-1"></i> <?= $user['email'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-12 border-bottom pb-3 mb-2">
                                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Informasi Pribadi</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="name" class="form-control border-0 bg-light shadow-none py-2"
                                        value="<?= $user['name'] ?>" required placeholder="Masukkan nama lengkap">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-0 bg-light shadow-none py-2"
                                        value="<?= $user['email'] ?>" required placeholder="nama@email.com">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nomor Telepon / WA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fab fa-whatsapp text-muted"></i></span>
                                    <input type="text" name="phone" class="form-control border-0 bg-light shadow-none py-2"
                                        value="<?= $user['phone'] ?>" placeholder="0812xxxxxx">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role Akun</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-id-badge text-muted"></i></span>
                                    <input type="text" class="form-control border-0 bg-white shadow-none py-2"
                                        value="<?= ucfirst($user['role']) ?>" disabled>
                                </div>
                                <small class="text-muted fst-italic">Role tidak dapat diubah sendiri.</small>
                            </div>

                            <div class="col-12 border-bottom pb-3 mb-2 mt-5">
                                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-key text-primary me-2"></i>Keamanan</h5>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control border-0 bg-light shadow-none py-2"
                                        placeholder="Kosongkan jika tidak ingin ganti">
                                </div>
                                <small class="text-muted">Min. 6 karakter jika ingin mengganti.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" id="confirm_password" class="form-control border-0 bg-light shadow-none py-2"
                                        placeholder="Masukkan kembali password baru">
                                </div>
                                <div id="password-feedback" class="small d-none">Password tidak cocok!</div>
                            </div>

                            <div class="col-12 mt-5 text-end">
                                <hr class="my-4 opacity-10">
                                <button type="reset" class="btn btn-light px-4 py-2 rounded-pill fw-bold me-2">Reset</button>
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow">
                                    Simpan Perubahan <i class="fas fa-save ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

ob_start();
?>
<style>
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid var(--bs-primary) !important;
    }

    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
    }

    .form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }

    .img-account-profile {
        transition: transform 0.3s ease;
    }

    .img-account-profile:hover {
        transform: scale(1.05);
    }

    .profile-image-container:hover .profile-image-overlay {
        opacity: 1;
    }

    .profile-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100px;
        height: 100px;
        background: rgba(0, 0, 0, 0.4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
</style>
<script>
    const password = document.querySelector('input[name="password"]');
    const confirm = document.querySelector('#confirm_password');
    const feedback = document.querySelector('#password-feedback');
    const submitBtn = document.querySelector('button[type="submit"]');

    function validatePassword() {
        if (password.value !== confirm.value) {
            feedback.classList.remove('d-none');
            feedback.classList.add('text-danger');
            submitBtn.disabled = true;
        } else {
            feedback.classList.add('d-none');
            submitBtn.disabled = false;
        }
    }

    function previewImage() {
        const image = document.querySelector("#profile_image");
        const imgPreview = document.querySelector("#img-preview");

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    password.addEventListener('input', validatePassword);
    confirm.addEventListener('input', validatePassword);
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/landing.php';
?>
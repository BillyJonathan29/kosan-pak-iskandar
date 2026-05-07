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
                        <th>Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($room_facilities as $rf) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($rf['kos_name']); ?></td>
                            <td><?= htmlspecialchars($rf['room_number']); ?></td>
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
                        <label class="form-label">Fasilitas</label>
                        <div id="facilityContainer">
                            <div class="input-group mb-2 facility-row">
                                <select class="form-select facility-select" name="facility_id[]" required>
                                    <option value="">-- Pilih Fasilitas --</option>
                                    <?php foreach ($facilities as $f) : ?>
                                        <option value="<?= $f['id']; ?>"><?= !empty($f['icon']) ? '[' . htmlspecialchars($f['icon']) . '] ' : ''; ?><?= htmlspecialchars($f['facility_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-outline-secondary btn-remove-facility" title="Hapus" style="display:none;">&times;</button>
                            </div>
                        </div>
                        <div class="form-text">Pilih satu fasilitas per baris; baris baru akan ditambahkan otomatis setelah Anda memilih.</div>
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

        // facility options rendered from server
        <?php
        $opts = '';
        foreach ($facilities as $f) {
            $label = (!empty($f['icon']) ? '[' . $f['icon'] . '] ' : '') . $f['facility_name'];
            $opts .= '<option value="' . $f['id'] . '">' . htmlspecialchars($label) . '</option>';
        }
        ?>
        const facilityOptionsHtml = <?= json_encode($opts); ?>;

        // Helper to create a facility row
        function createFacilityRow(selectedValue = '', showRemove = false) {
            const removeBtnStyle = showRemove ? '' : 'style="display:none;"';
            const html = `
                <div class="input-group mb-2 facility-row">
                    <select class="form-select facility-select" name="facility_id[]" required>
                        <option value="">-- Pilih Fasilitas --</option>
                        ${facilityOptionsHtml}
                    </select>
                    <button type="button" class="btn btn-outline-secondary btn-remove-facility" title="Hapus" ${removeBtnStyle}>&times;</button>
                </div>`;
            const $row = $(html);
            if (selectedValue) {
                $row.find('select').val(selectedValue);
            }
            return $row;
        }

        function updateRemoveButtons() {
            const rows = $('#facilityContainer .facility-row');
            if (rows.length <= 1) {
                rows.find('.btn-remove-facility').hide();
            } else {
                rows.find('.btn-remove-facility').show();
            }
        }

        // Tambah Data
        $('.tombolTambahData').on('click', function() {
            $('#formModalLabel').html('Tambah Fasilitas Kamar');
            $('.modal-footer button[type=submit]').html('Simpan');
            $('.modal-content form').attr('action', '<?= BASEURL; ?>/roomfacility/store');
            $('#id').val('');
            $('#room_id').val('');
            // reset facility rows to single empty select
            $('#facilityContainer').empty().append(createFacilityRow('', false));
            updateRemoveButtons();
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
                    
                    $('#facilityContainer').empty();
                    
                    let vals = [];
                    if (data.facility_id) {
                        if (Array.isArray(data.facility_id)) {
                            vals = data.facility_id;
                        } else if (typeof data.facility_id === 'string' && data.facility_id.includes(',')) {
                            vals = data.facility_id.split(',').map(v => v.trim());
                        } else {
                            vals = [data.facility_id];
                        }
                    }

                    if (vals.length === 0) {
                        $('#facilityContainer').append(createFacilityRow('', false));
                    } else {
                        vals.forEach((v, idx) => {
                            $('#facilityContainer').append(createFacilityRow(v, idx > 0));
                        });
                    }
                    updateRemoveButtons();
                }
            });
        });

        // Hapus Data
        $(document).on('click', '.tombolHapus', function() {
            const id = $(this).data('id');
            $('#btn-confirm-delete').attr('href', '<?= BASEURL; ?>/roomfacility/delete/' + id);
        });

        // Automatically add a new row when last select gets a non-empty value
        $('#facilityContainer').on('change', '.facility-select', function() {
            const $all = $('#facilityContainer .facility-select');
            const $last = $all.last();
            
            if ($(this).val() !== '' && $(this)[0] === $last[0]) {
                // append a fresh empty row
                $('#facilityContainer').append(createFacilityRow('', true));
                updateRemoveButtons();
            }
        });

        // Delegate remove button click
        $('#facilityContainer').on('click', '.btn-remove-facility', function() {
            $(this).closest('.facility-row').remove();
            updateRemoveButtons();
        });

        // initial state
        updateRemoveButtons();
    });
</script>
<?php
$scripts = ob_get_clean();

require_once __DIR__ . '/../layouts/template.php';
?>
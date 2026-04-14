<?php $this->load->view('admin/sidebar'); ?>
<div class="content">
    <div class="card">

        <!-- HEADER -->
        <div style="display:flex; justify-content:space-between;">
            <h2><i class="fa fa-bed"></i> Manajemen Kamar</h2>

            <button class="btn" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Tambah Kamar
            </button>
        </div>

        <br>

        <!-- TABLE -->
        <table style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nomor</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($kamar as $k): ?>
                <tr>
                    <td><?= $k->id_room ?></td>
                    <td><?= $k->room_number ?></td>
                    <td>Rp <?= number_format($k->price) ?></td>
                    <td>
                        <button class="btn-edit"
                            onclick="openEditModal('<?= $k->id_room ?>','<?= $k->room_number ?>','<?= $k->price ?>')">
                            <i class="fa fa-pen"></i>
                        </button>

                        <a href="<?= base_url('admin/kamar_delete/'.$k->id_room) ?>"
                           class="btn-delete"
                           onclick="return confirm('Yakin hapus?')">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<!-- ================= MODAL ADD ================= -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <h3>Tambah Kamar</h3>

        <form method="post" action="<?= base_url('admin/kamar_store') ?>">
            <input type="text" name="room_number" placeholder="Nomor Kamar" required>
            <input type="number" name="price" placeholder="Harga" required>
            <button class="btn">Simpan</button>
        </form>

        <button onclick="closeModal('addModal')">Tutup</button>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Kamar</h3>

        <form method="post" action="<?= base_url('admin/kamar_update') ?>">
            <input type="hidden" name="id_room" id="edit_id">

            <input type="text" name="room_number" id="edit_room" required>
            <input type="number" name="price" id="edit_price" required>

            <button class="btn">Update</button>
        </form>

        <button onclick="closeModal('editModal')">Tutup</button>
    </div>
</div>

<!-- STYLE -->
<style>
table th, table td { padding:10px; }

.btn {
    background:#007bff; color:white;
    padding:8px 12px; border:none; border-radius:6px;
}

.btn-edit { background:#ffc107; padding:6px; }
.btn-delete { background:#dc3545; padding:6px; color:white; }

.modal {
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
}

.modal-content {
    background:white;
    padding:20px;
    width:300px;
    margin:100px auto;
    border-radius:10px;
}

input {
    width:100%;
    padding:10px;
    margin:10px 0;
}
</style>

<!-- SCRIPT -->
<script>
function openAddModal() {
    document.getElementById('addModal').style.display = 'block';
}

function openEditModal(id, room, price) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_room').value = room;
    document.getElementById('edit_price').value = price;

    document.getElementById('editModal').style.display = 'block';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
</script>

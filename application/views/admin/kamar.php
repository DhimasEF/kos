<?php $this->load->view('admin/sidebar'); ?>
<div class="content">
<div class="card">

<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2><i class="fa fa-bed"></i> Manajemen Kamar</h2>

    <button class="btn" onclick="openAddModal()">
        <i class="fa fa-plus"></i> Tambah Kamar
    </button>
</div>

<br>

<!-- GRID -->
<div class="room-grid">
<?php foreach ($kamar as $k): ?>
    <div class="room-card">

        <!-- IMAGE -->
        <img src="<?= base_url('assets/uploads/content/'.($k->image ? $k->image : 'default.png')) ?>" class="room-img">

        <!-- INFO -->
        <h3>Kamar <?= $k->room_number ?></h3>
        <p class="price">Rp <?= number_format($k->price) ?></p>

        <!-- ACTION -->
        <div class="actions">
            <a href="<?= base_url('admin/kamar_detail/'.$k->id_room) ?>">
                Detail
            </a>

            <button onclick="openEditModal(
                '<?= $k->id_room ?>',
                '<?= $k->room_number ?>',
                '<?= $k->price ?>'
            )">Edit</button>

            <a href="<?= base_url('admin/kamar_delete/'.$k->id_room) ?>" 
               onclick="return confirm('Yakin hapus?')">Hapus</a>
        </div>

    </div>
<?php endforeach; ?>
</div>

</div>
</div>

<div class="modal" id="addModal">
<div class="modal-content">

<h3>Tambah Kamar</h3>

<form method="post" action="<?= base_url('admin/kamar_store') ?>" enctype="multipart/form-data">
    <input type="text" name="room_number" placeholder="Nomor Kamar" required>
    <input type="number" name="price" placeholder="Harga" required>

    <label>Upload Gambar</label>
    <input type="file" name="images[]" multiple onchange="previewImages(event)">

    <div id="preview"></div>

    <button class="btn">Simpan</button>
</form>

<button onclick="closeModal('addModal')">Tutup</button>

</div>
</div>

<div class="modal" id="editModal">
<div class="modal-content">

<h3>Edit Kamar</h3>

<form method="post" action="<?= base_url('admin/kamar_update') ?>" enctype="multipart/form-data">

    <input type="hidden" name="id_room" id="edit_id">

    <input type="text" name="room_number" id="edit_room">
    <input type="number" name="price" id="edit_price">

    <label>Upload Gambar Baru</label>
    <input type="file" name="images[]" multiple onchange="previewImages(event)">

    <div id="previewEdit"></div>

    <button class="btn">Update</button>
</form>

<button onclick="closeModal('editModal')">Tutup</button>

</div>
</div>

<!-- STYLE -->
<style>
table th, table td { padding:10px; }

.room-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(250px,1fr));
    gap:20px;
}

.room-card {
    background:white;
    padding:15px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.room-card:hover {
    transform:translateY(-5px);
}

.room-img {
    width:100%;
    height:150px;
    object-fit:cover;
    border-radius:10px;
}

.price {
    color:#28a745;
    font-weight:bold;
}

.actions {
    display:flex;
    gap:5px;
    margin-top:10px;
}

.actions button, .actions a {
    padding:6px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    background:#007bff;
    color:white;
    text-decoration:none;
}

#preview img, #previewEdit img {
    width:70px;
    margin:5px;
    border-radius:6px;
}

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

function openDetailModal(room, price, img) {
    document.getElementById('detail_room').innerText = room;
    document.getElementById('detail_price').innerText = new Intl.NumberFormat().format(price);
    document.getElementById('detail_img').src = img;

    document.getElementById('detailModal').style.display = 'block';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// PREVIEW MULTI IMAGE
function previewImages(event) {
    let preview = event.target.closest('.modal-content').querySelector('div[id^="preview"]');
    preview.innerHTML = "";

    for (let file of event.target.files) {
        let reader = new FileReader();

        reader.onload = function(e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        }

        reader.readAsDataURL(file);
    }
}
</script>

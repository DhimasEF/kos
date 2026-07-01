<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

    <!-- HEADER -->
    <div class="page-header">
        <div>
            <h2>
                <i class="fa fa-bed"></i>
                Manajemen Kamar
            </h2>

            <p>
                Kelola data kamar, harga, gambar, dan detail kamar kos.
            </p>
        </div>

        <button type="button" class="btn-add" onclick="openAddModal()">
            <i class="fa fa-plus"></i>
            Tambah Kamar
        </button>
    </div>

    <!-- GRID CARD -->
    <div class="room-grid">

        <?php foreach ($kamar as $k): ?>

            <div class="room-card">

                <!-- IMAGE -->
                <div class="room-image">
                    <?php if (!empty($k->image)): ?>
                        <img
                            src="<?= base_url('assets/uploads/content/'.$k->image) ?>"
                            alt="Kamar <?= $k->room_number ?>">
                    <?php else: ?>
                        <img
                            src="<?= base_url('assets/uploads/content/default.png') ?>"
                            alt="Kamar <?= $k->room_number ?>">
                    <?php endif; ?>

                    <div class="room-overlay">
                        <span>#<?= $k->room_number ?></span>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="room-content">

                    <h3>Kamar No. <?= $k->room_number ?></h3>

                    <div class="price">
                        Rp <?= number_format($k->price, 0, ',', '.') ?>
                        <small>/ bulan</small>
                    </div>

                    <div class="room-info">
                        <span><i class="fa fa-wifi"></i> Wifi</span>
                        <span><i class="fa fa-snowflake"></i> AC</span>
                        <span><i class="fa fa-bath"></i> Bathroom</span>
                    </div>

                    <!-- ACTION -->
                    <div class="actions">

                        <a
                            href="<?= base_url('admin/kamar_detail/'.$k->id_room) ?>"
                            class="btn-detail">
                            <i class="fa fa-eye"></i>
                            Detail
                        </a>

                        <button
                            type="button"
                            class="btn-edit"
                            onclick="openEditModal(
                                '<?= $k->id_room ?>',
                                '<?= $k->room_number ?>',
                                '<?= $k->price ?>'
                            )">
                            <i class="fa fa-edit"></i>
                            Edit
                        </button>

                        <a
                            href="<?= base_url('admin/kamar_delete/'.$k->id_room) ?>"
                            class="btn-delete"
                            onclick="return confirm('Yakin hapus kamar ini?')">
                            <i class="fa fa-trash"></i>
                            Hapus
                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<!-- MODAL TAMBAH -->
<div class="modal" id="addModal">
    <div class="modal-content">

        <h3>
            <i class="fa fa-plus"></i>
            Tambah Kamar
        </h3>

        <form method="post" action="<?= base_url('admin/kamar_store') ?>" enctype="multipart/form-data">

            <label>Nomor Kamar</label>
            <input
                type="text"
                name="room_number"
                placeholder="Masukkan nomor kamar"
                required>

            <label>Harga</label>
            <input
                type="number"
                name="price"
                placeholder="Masukkan harga kamar"
                required>

            <label>Upload Gambar</label>
            <input
                type="file"
                name="images[]"
                multiple
                onchange="previewImages(event)">

            <div id="preview" class="preview-wrap"></div>

            <button type="submit" class="btn-save">
                Simpan
            </button>

            <button type="button" class="btn-close" onclick="closeModal('addModal')">
                Tutup
            </button>

        </form>

    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal" id="editModal">
    <div class="modal-content">

        <h3>
            <i class="fa fa-edit"></i>
            Edit Kamar
        </h3>

        <form method="post" action="<?= base_url('admin/kamar_update') ?>" enctype="multipart/form-data">

            <input type="hidden" name="id_room" id="edit_id">

            <label>Nomor Kamar</label>
            <input
                type="text"
                name="room_number"
                id="edit_room"
                required>

            <label>Harga</label>
            <input
                type="number"
                name="price"
                id="edit_price"
                required>

            <label>Upload Gambar Baru</label>
            <input
                type="file"
                name="images[]"
                multiple
                onchange="previewImages(event)">

            <div id="previewEdit" class="preview-wrap"></div>

            <button type="submit" class="btn-save">
                Update
            </button>

            <button type="button" class="btn-close" onclick="closeModal('editModal')">
                Tutup
            </button>

        </form>

    </div>
</div>

<style>
/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:1.5em 0 25px;
    gap:20px;
}

.page-header h2{
    font-size:28px;
    margin:0 0 5px;
    color:#222;
}

.page-header p{
    margin:0;
    color:#777;
}

/* GRID */
.room-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

/* CARD */
.room-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    transition:0.3s ease;
    position:relative;
}

.room-card:hover{
    transform:translateY(-8px);
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* IMAGE */
.room-image{
    position:relative;
    height:220px;
    overflow:hidden;
}

.room-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:0.4s;
}

.room-card:hover .room-image img{
    transform:scale(1.08);
}

/* OVERLAY */
.room-overlay{
    position:absolute;
    top:15px;
    right:15px;
    background:rgba(0,0,0,0.6);
    color:#fff;
    padding:6px 12px;
    border-radius:30px;
    font-size:13px;
}

/* CONTENT */
.room-content{
    padding:20px;
}

.room-content h3{
    margin:0;
    font-size:22px;
    color:#222;
}

/* PRICE */
.price{
    margin-top:10px;
    font-size:24px;
    font-weight:bold;
    color:#28a745;
}

.price small{
    font-size:14px;
    color:#888;
    font-weight:normal;
}

/* INFO */
.room-info{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin:18px 0;
    color:#666;
    font-size:14px;
}

.room-info span{
    background:#f5f5f5;
    padding:6px 12px;
    border-radius:20px;
}

/* ACTION */
.actions{
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:10px;
}

.btn-add,
.btn-detail,
.btn-edit,
.btn-delete,
.btn-save,
.btn-close{
    border:none;
    border-radius:12px;
    padding:12px 14px;
    cursor:pointer;
    text-decoration:none;
    font-weight:bold;
    text-align:center;
    transition:0.3s;
}

.btn-add,
.btn-detail,
.btn-edit,
.btn-save{
    color:#fff;
}

.btn-add{
    background:#007bff;
    white-space:nowrap;
}

.btn-detail{
    background:linear-gradient(135deg,#17a2b8,#138496);
}

.btn-edit{
    background:linear-gradient(135deg,#ffc107,#d39e00);
}

.btn-delete{
    background:#f8d7da;
    color:#721c24;
}

.btn-save{
    width:100%;
    margin-top:10px;
    background:#007bff;
}

.btn-close{
    width:100%;
    margin-top:12px;
    background:#eee;
    color:#333;
}

.btn-add:hover,
.btn-detail:hover,
.btn-edit:hover,
.btn-delete:hover,
.btn-save:hover,
.btn-close:hover{
    transform:translateY(-2px);
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    z-index:999;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.55);
}

.modal-content{
    background:#fff;
    width:430px;
    max-width:92%;
    margin:70px auto;
    padding:25px;
    border-radius:18px;
    animation:fadeIn .3s ease;
}

.modal-content h3{
    margin-top:0;
    margin-bottom:20px;
}

.modal-content label{
    display:block;
    color:#555;
    font-weight:bold;
    margin-bottom:8px;
}

.modal-content input{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
    margin-bottom:18px;
}

.modal-content input:focus{
    outline:none;
    border-color:#007bff;
    box-shadow:0 0 0 4px rgba(0,123,255,0.08);
}

/* PREVIEW */
.preview-wrap{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:10px;
}

.preview-wrap img{
    width:72px;
    height:58px;
    object-fit:cover;
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(-20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* RESPONSIVE */
@media(max-width:768px){

    .page-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .btn-add{
        width:100%;
    }

    .room-image{
        height:200px;
    }

    .page-header h2{
        font-size:24px;
    }

    .actions{
        grid-template-columns:1fr;
    }

}
</style>

<script>
function openAddModal(){
    document.getElementById('addModal').style.display = 'block';
}

function openEditModal(id, room, price){
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_room').value = room;
    document.getElementById('edit_price').value = price;
    document.getElementById('editModal').style.display = 'block';
}

function closeModal(id){
    document.getElementById(id).style.display = 'none';
}

function previewImages(event){
    const preview = event.target
        .closest('.modal-content')
        .querySelector('.preview-wrap');

    preview.innerHTML = '';

    for(const file of event.target.files){
        const reader = new FileReader();

        reader.onload = function(e){
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        }

        reader.readAsDataURL(file);
    }
}

window.onclick = function(e){
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');

    if(e.target == addModal){
        closeModal('addModal');
    }

    if(e.target == editModal){
        closeModal('editModal');
    }
}
</script>
<?php $this->load->view('user/sidebar'); ?>

<div class="content">
    <div class="card">

        <h2><i class="fa fa-file"></i> Detail Pembayaran</h2>

        <p><b>Kamar:</b> <?= $payment->room_number ?></p>
        <p><b>Harga:</b> Rp <?= number_format($payment->amount) ?></p>
        <p><b>Metode:</b> <?= $payment->payment_method ?></p>
        <p><b>Tanggal:</b> <?= $payment->payment_date ?></p>

        <p><b>Status:</b>
            <?php if ($payment->payment_status == 'paid'): ?>
                <span class="status pending"><i class="fa fa-clock"></i> Menunggu Verifikasi</span>
            <?php elseif ($payment->payment_status == 'verified'): ?>
                <span class="status approved"><i class="fa fa-check"></i> Terverifikasi</span>
            <?php else: ?>
                <span class="status rejected"><i class="fa fa-times"></i> Gagal</span>
            <?php endif; ?>
        </p>

        <p><b>Bukti:</b></p>

        <?php if ($payment->proof_of_payment): ?>
            <img 
                src="<?= base_url('assets/uploads/payment/'.$payment->proof_of_payment) ?>" 
                width="200"
                style="cursor:pointer; border-radius:6px;"
                onclick="openImage(this.src)"
            >
        <?php else: ?>
            <p style="color:gray;">Belum ada bukti</p>
        <?php endif; ?>

        <br><br>

        <!-- EDIT BUTTON -->
        <?php if ($payment->payment_status == 'paid'): ?>
            <button class="btn" onclick="openModal()">
                <i class="fa fa-edit"></i> Edit Pembayaran
            </button>
        <?php endif; ?>

        <br><br>
        <a href="<?= base_url('user/payment') ?>" class="btn">Kembali</a>

    </div>
</div>

<!-- MODAL -->

<!-- MODAL IMAGE VIEW -->
<div class="img-modal" id="imgModal">
    <span class="close-img" onclick="closeImage()">&times;</span>
    <img class="img-full" id="imgPreview">
</div>

<div class="modal" id="editModal">
    <div class="modal-content">

        <h3>Edit Pembayaran</h3>

        <form method="post" action="<?= base_url('user/payment_update') ?>" enctype="multipart/form-data">

            <input type="hidden" name="id_payment" value="<?= $payment->id_payment ?>">

            <label>Metode</label>
            <select name="payment_method">
                <option value="transfer" <?= $payment->payment_method=='transfer'?'selected':'' ?>>Transfer</option>
                <option value="ewallet" <?= $payment->payment_method=='ewallet'?'selected':'' ?>>E-Wallet</option>
                <option value="cash" <?= $payment->payment_method=='cash'?'selected':'' ?>>Cash</option>
            </select>

            <label>Upload Ulang Bukti</label>
            <input type="file" name="proof">

            <br><br>
            <button class="btn">Update</button>
        </form>

        <button onclick="closeModal()">Tutup</button>
    </div>
</div>

<style>
/* STATUS */
.status {
    padding:8px 12px;
    border-radius:6px;
    color:white;
    display:inline-block;
}

.status.pending { background:#ffc107; color:black; }
.status.approved { background:#28a745; }
.status.rejected { background:#dc3545; }

/* BUTTON */
.btn {
    background:#007bff;
    color:white;
    padding:8px 12px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* MODAL */
/* IMAGE MODAL */
.img-modal {
    display:none;
    position:fixed;
    z-index:999;
    padding-top:50px;
    left:0; top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.9);
}

.img-full {
    display:block;
    margin:auto;
    max-width:90%;
    max-height:90%;
    border-radius:10px;
    animation:zoomIn 0.3s ease;
}

.close-img {
    position:absolute;
    top:20px;
    right:40px;
    color:white;
    font-size:40px;
    cursor:pointer;
}

@keyframes zoomIn {
    from {transform:scale(0.8); opacity:0;}
    to {transform:scale(1); opacity:1;}
}

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
    width:350px;
    margin:100px auto;
    border-radius:10px;
    animation:fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(-10px);}
    to {opacity:1; transform:translateY(0);}
}
</style>

<script>
function openImage(src) {
    document.getElementById('imgModal').style.display = 'block';
    document.getElementById('imgPreview').src = src;
}

function closeImage() {
    document.getElementById('imgModal').style.display = 'none';
}

// klik luar gambar = close
window.addEventListener('click', function(e) {
    let modal = document.getElementById('imgModal');
    if (e.target === modal) {
        modal.style.display = "none";
    }
});
function openModal() {
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// klik luar modal = close
window.onclick = function(e) {
    let modal = document.getElementById('editModal');
    if (e.target == modal) {
        modal.style.display = "none";
    }
}
</script>
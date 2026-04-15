<?php $this->load->view('user/sidebar'); ?>

<div class="content">
    <div class="card">

        <h2>Detail Kamar</h2>

        <p><b>ID:</b> <?= $kamar->id_room ?></p>
        <p><b>Nomor:</b> <?= $kamar->room_number ?></p>
        <p><b>Harga:</b> Rp <?= number_format($kamar->price) ?></p>

        <br>

        <!-- BUTTON BOOKING -->
        <br>

        <?php if ($booking): ?>

            <!-- STATUS BOOKING -->
            <?php if ($booking->status == 'pending'): ?>
                <div class="status pending">
                    <i class="fa fa-clock"></i> Menunggu Konfirmasi
                </div>

            <?php elseif ($booking->status == 'approved'): ?>
                <div class="status approved">
                    <i class="fa fa-check-circle"></i> Disetujui
                </div>

            <?php elseif ($booking->status == 'rejected'): ?>
                <div class="status rejected">
                    <i class="fa fa-times-circle"></i> Ditolak
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- BUTTON BOOKING -->
            <button class="btn-booking" onclick="openModal()">
                <i class="fa fa-calendar"></i> Booking Sekarang
            </button>

        <?php endif; ?>

        <br><br>

        <a href="<?= base_url('user/kamar') ?>" class="btn">Kembali</a>

    </div>
</div>

<!-- ================= MODAL BOOKING ================= -->
<div class="modal" id="bookingModal">
    <div class="modal-content">
        <h3>Booking Kamar</h3>

        <form method="post" action="<?= base_url('user/booking_store') ?>">

            <!-- AUTO DATA -->
            <input type="hidden" name="id_room" value="<?= $kamar->id_room ?>">
            <input type="hidden" name="id_user" value="<?= $this->session->userdata('id_user') ?>">

            <!-- INPUT -->
            <label>Tanggal Masuk</label>
            <input type="date" name="start_at" required>

            <br><br>

            <button class="btn">Booking</button>
        </form>

        <br>
        <button onclick="closeModal()">Tutup</button>
    </div>
</div>

<style>
.btn {
    background:#007bff;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
}

.btn-booking {
    background:#28a745;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* MODAL */
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
    margin-top:10px;
}
</style>

<script>
function openModal() {
    document.getElementById('bookingModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('bookingModal').style.display = 'none';
}
</script>

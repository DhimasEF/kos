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
                <span class="status pending">Menunggu Verifikasi</span>
            <?php elseif ($payment->payment_status == 'verified'): ?>
                <span class="status approved">Terverifikasi</span>
            <?php else: ?>
                <span class="status rejected">Gagal</span>
            <?php endif; ?>
        </p>

        <p><b>Bukti:</b></p>
        <img src="<?= base_url('uploads/payment/'.$payment->proof_of_payment) ?>" width="200">

        <br><br>

        <!-- EDIT BUTTON -->
        <?php if ($payment->payment_status == 'paid'): ?>
            <button class="btn" onclick="openModal()">Edit Pembayaran</button>
        <?php endif; ?>

        <br><br>
        <a href="<?= base_url('user/payment') ?>" class="btn">Kembali</a>

    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal" id="editModal">
    <div class="modal-content">

        <h3>Edit Pembayaran</h3>

        <form method="post" action="<?= base_url('user/payment_update') ?>" enctype="multipart/form-data">

            <input type="hidden" name="id_payment" value="<?= $payment->id_payment ?>">

            <label>Metode</label>
            <select name="payment_method">
                <option value="transfer">Transfer</option>
                <option value="ewallet">E-Wallet</option>
                <option value="cash">Cash</option>
            </select>

            <label>Upload Ulang Bukti</label>
            <input type="file" name="proof">

            <br><br>
            <button class="btn">Update</button>
        </form>

        <button onclick="closeModal()">Tutup</button>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('editModal').style.display = 'block';
}
function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
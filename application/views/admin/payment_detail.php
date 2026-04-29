<?php $this->load->view('admin/sidebar'); ?>

<h2>Detail Payment</h2>

<p><b>Kamar:</b> <?= $payment->room_number ?></p>
<p><b>Harga:</b> Rp <?= number_format($payment->amount) ?></p>
<p><b>Metode:</b> <?= $payment->payment_method ?></p>
<p><b>Tanggal:</b> <?= $payment->payment_date ?></p>

<p><b>Status:</b>
    <?php if ($payment->payment_status == 'paid'): ?>
        <span style="color:orange;">Menunggu Verifikasi</span>
    <?php elseif ($payment->payment_status == 'verified'): ?>
        <span style="color:green;">Terverifikasi</span>
    <?php else: ?>
        <span style="color:red;">Ditolak</span>
    <?php endif; ?>
</p>

<p><b>Bukti:</b></p>

<?php if ($payment->proof_of_payment): ?>
    <img 
        src="<?= base_url('assets/uploads/payment/'.$payment->proof_of_payment) ?>" 
        width="250"
        style="cursor:pointer"
        onclick="openImage(this.src)"
    >
<?php else: ?>
    <p>Tidak ada bukti</p>
<?php endif; ?>

<br><br>

<!-- ACTION -->
<?php if ($payment->payment_status == 'paid'): ?>
    <a href="<?= base_url('admin/payment_approve/'.$payment->id_payment) ?>" 
       onclick="return confirm('Approve pembayaran?')">
       ✅ Approve
    </a>

    |
    
    <a href="<?= base_url('admin/payment_reject/'.$payment->id_payment) ?>" 
       onclick="return confirm('Tolak pembayaran?')">
       ❌ Reject
    </a>
<?php endif; ?>

<br><br>
<a href="<?= base_url('admin/payment') ?>">Kembali</a>

<!-- IMAGE MODAL -->
<div id="imgModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:black;">
    <span onclick="closeImage()" style="color:white; font-size:30px; cursor:pointer;">X</span>
    <img id="imgPreview" style="display:block; margin:auto; max-width:90%; max-height:90%;">
</div>

<script>
function openImage(src) {
    document.getElementById('imgModal').style.display = 'block';
    document.getElementById('imgPreview').src = src;
}
function closeImage() {
    document.getElementById('imgModal').style.display = 'none';
}
</script>
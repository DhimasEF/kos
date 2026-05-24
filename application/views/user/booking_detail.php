<?php $this->load->view('user/sidebar'); ?>

<div class="content">
<div class="card">

<h2><i class="fa fa-file"></i> Detail Booking</h2>
<hr>

<!-- ================= INFO KAMAR ================= -->
<h3>Informasi Kamar</h3>
<p><b>Nomor Kamar:</b> <?= $booking->room_number ?></p>
<p><b>Harga:</b> Rp <?= number_format($booking->price) ?></p>
<p><b>Tanggal Masuk:</b> <?= $booking->start_at ?></p>
<p><b>Dibuat:</b> <?= $booking->created_at ?></p>

<hr>

<!-- ================= STATUS BOOKING ================= -->
<h3>Status Booking</h3>

<?php if($booking->status=='pending'): ?>
    <div class="status pending">
        <i class="fa fa-clock"></i> Menunggu Approval
    </div>

<?php elseif($booking->status=='approved'): ?>
    <div class="status approved">
        <i class="fa fa-check-circle"></i> Booking Disetujui
    </div>

<?php else: ?>
    <div class="status rejected">
        <i class="fa fa-times-circle"></i> Booking Ditolak
    </div>
<?php endif; ?>


<!-- ================= PAYMENT ================= -->
<hr>
<h3><i class="fa fa-credit-card"></i> Pembayaran</h3>

<?php
$pay_status = isset($payment->payment_status) ? $payment->payment_status : '';
?>

<?php if($booking->status != 'approved'): ?>

    <div class="status rejected">
        Booking belum disetujui
    </div>

<?php else: ?>

    <!-- BELUM BAYAR -->
    <?php if($pay_status == ''): ?>

        <div class="status rejected">
            Belum Ada Pembayaran
        </div>

        <br><br>

        <button class="btn-pay" onclick="openPayModal()">
            <i class="fa fa-credit-card"></i> Bayar Sekarang
        </button>


    <!-- MENUNGGU VERIFIKASI -->
    <?php elseif($pay_status == 'paid'): ?>

        <div class="status pending">
            <i class="fa fa-clock"></i> Menunggu Verifikasi Admin
        </div>

        <br><br>

        <?php if($payment->proof_of_payment): ?>
            <img src="<?= base_url('assets/uploads/payment/'.$payment->proof_of_payment) ?>"
                 class="proof-img"
                 onclick="openImage(this.src)">
        <?php endif; ?>


    <!-- VERIFIED -->
    <?php elseif($pay_status == 'verified'): ?>

        <div class="status approved">
            <i class="fa fa-check"></i> Pembayaran Terverifikasi
        </div>

        <br><br>

        <?php if($payment->proof_of_payment): ?>
            <img src="<?= base_url('assets/uploads/payment/'.$payment->proof_of_payment) ?>"
                 class="proof-img"
                 onclick="openImage(this.src)">
        <?php endif; ?>


    <!-- REJECT -->
    <?php else: ?>

        <div class="status rejected">
            <i class="fa fa-times"></i> Pembayaran Ditolak
        </div>

        <br><br>

        <button class="btn-pay" onclick="openPayModal()">
            Upload Ulang Pembayaran
        </button>

    <?php endif; ?>

<?php endif; ?>



<!-- ================= REVIEW ================= -->
<?php if(
    $booking->status=='approved' &&
    $pay_status=='verified'
): ?>

<hr>
<h3><i class="fa fa-star"></i> Review</h3>

<?php if($review): ?>

    <div class="review-box">
        <div class="star">
            <?= str_repeat('⭐', $review->rating) ?>
        </div>

        <p><?= $review->review ?></p>
        <small><?= $review->created_at ?></small>
    </div>

<?php else: ?>

    <button class="btn-review" onclick="openReviewModal()">
        <i class="fa fa-star"></i> Beri Review
    </button>

<?php endif; ?>

<?php endif; ?>


<br><br>

<a href="<?= base_url('user/booking') ?>" class="btn-back">
    Kembali
</a>

</div>
</div>



<!-- ==================================================
     MODAL PAYMENT
================================================== -->
<div class="modal" id="payModal">
<div class="modal-content">

<h3>Bayar Booking</h3>

<form method="post"
      action="<?= base_url('user/payment_store') ?>"
      enctype="multipart/form-data">

<input type="hidden"
       name="id_booking"
       value="<?= $booking->id_booking ?>">

<label>Total Bayar</label>
<input type="number"
       name="amount"
       value="<?= $booking->price ?>"
       readonly>

<label>Metode Pembayaran</label>
<select name="payment_method" required>
    <option value="">-- Pilih --</option>
    <option value="transfer">Transfer Bank</option>
    <option value="ewallet">E-Wallet</option>
    <option value="cash">Cash</option>
</select>

<label>Bukti Pembayaran</label>
<input type="file" name="proof" required>

<br><br>

<button class="btn-save">
    Kirim Pembayaran
</button>

</form>

<br>
<button onclick="closePayModal()">Tutup</button>

</div>
</div>



<!-- ==================================================
     MODAL REVIEW
================================================== -->
<div class="modal" id="reviewModal">
<div class="modal-content">

<h3>Beri Review</h3>

<form method="post"
      action="<?= base_url('user/review_store') ?>">

<input type="hidden"
       name="id_booking"
       value="<?= $booking->id_booking ?>">

<label>Rating</label>
<select name="rating" required>
    <option value="">Pilih</option>
    <option value="5">⭐⭐⭐⭐⭐</option>
    <option value="4">⭐⭐⭐⭐</option>
    <option value="3">⭐⭐⭐</option>
    <option value="2">⭐⭐</option>
    <option value="1">⭐</option>
</select>

<label>Ulasan</label>
<textarea name="review"
          rows="5"
          required
          placeholder="Tulis pengalaman anda"></textarea>

<br><br>

<button class="btn-save">
    Kirim Review
</button>

</form>

<br>
<button onclick="closeReviewModal()">Tutup</button>

</div>
</div>



<!-- ==================================================
     MODAL IMAGE
================================================== -->
<div class="img-modal" id="imgModal">
    <span class="close-img" onclick="closeImage()">&times;</span>
    <img class="img-full" id="imgPreview">
</div>



<style>
.card{
    background:#fff;
    padding:25px;
    border-radius:14px;
}

/* status */
.status{
    display:inline-block;
    padding:10px 14px;
    border-radius:8px;
    color:#fff;
    font-weight:bold;
}

.pending{background:#ffc107;color:#000;}
.approved{background:#28a745;}
.rejected{background:#dc3545;}

/* button */
.btn-back,.btn-pay,.btn-review,.btn-save{
    padding:10px 15px;
    border:none;
    border-radius:8px;
    color:#fff;
    cursor:pointer;
    text-decoration:none;
}

.btn-back{background:#007bff;}
.btn-pay{background:#17a2b8;}
.btn-review{background:#28a745;}
.btn-save{background:#007bff;}

/* review */
.review-box{
    background:#f8f9fa;
    padding:15px;
    border-radius:10px;
}

.star{
    font-size:22px;
}

/* modal */
.modal{
    display:none;
    position:fixed;
    top:0;left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.55);
    z-index:99;
}

.modal-content{
    background:#fff;
    width:380px;
    padding:20px;
    margin:70px auto;
    border-radius:12px;
    animation:fade .25s;
}

@keyframes fade{
    from{opacity:0;transform:translateY(-10px);}
    to{opacity:1;transform:translateY(0);}
}

input,select,textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
    border:1px solid #ddd;
    border-radius:8px;
}

/* proof image */
.proof-img{
    width:180px;
    border-radius:10px;
    cursor:pointer;
}

/* image modal */
.img-modal{
    display:none;
    position:fixed;
    z-index:999;
    left:0;top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.9);
}

.img-full{
    display:block;
    margin:auto;
    max-width:90%;
    max-height:90%;
    margin-top:40px;
    border-radius:10px;
}

.close-img{
    position:absolute;
    top:20px;
    right:35px;
    color:#fff;
    font-size:38px;
    cursor:pointer;
}
</style>



<script>
function openPayModal(){
    document.getElementById('payModal').style.display='block';
}
function closePayModal(){
    document.getElementById('payModal').style.display='none';
}

function openReviewModal(){
    document.getElementById('reviewModal').style.display='block';
}
function closeReviewModal(){
    document.getElementById('reviewModal').style.display='none';
}

function openImage(src){
    document.getElementById('imgModal').style.display='block';
    document.getElementById('imgPreview').src = src;
}
function closeImage(){
    document.getElementById('imgModal').style.display='none';
}

window.onclick = function(e){

    if(e.target == document.getElementById('payModal')){
        closePayModal();
    }

    if(e.target == document.getElementById('reviewModal')){
        closeReviewModal();
    }

    if(e.target == document.getElementById('imgModal')){
        closeImage();
    }
}
</script>
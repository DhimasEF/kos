<?php $this->load->view('user/sidebar'); ?>

<div class="content">
<div class="card">

<h2><i class="fa fa-file"></i> Detail Booking</h2>
<hr>

<h3>Informasi Kamar</h3>
<p><b>Nomor Kamar:</b> <?= $booking->room_number ?></p>
<p><b>Harga:</b> Rp <?= number_format($booking->price) ?></p>

<hr>

<h3>Status Booking</h3>

<?php if($booking->status=='pending'): ?>
<div class="status pending">Menunggu Approval</div>

<?php elseif($booking->status=='approved'): ?>
<div class="status approved">Booking Disetujui</div>

<?php else: ?>
<div class="status rejected">Booking Ditolak</div>
<?php endif; ?>

<br><br>

<h3>Pembayaran</h3>

<?php if($payment->payment_status=='verified'): ?>
<div class="status approved">Pembayaran Terverifikasi</div>

<?php elseif($payment->payment_status=='paid'): ?>
<div class="status pending">Menunggu Verifikasi</div>

<?php else: ?>
<div class="status rejected">Belum Bayar</div>
<?php endif; ?>


<!-- ================= REVIEW ================= -->

<?php if(
    $booking->status=='approved' &&
    $payment->payment_status=='verified'
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
    Beri Review
</button>

<?php endif; ?>

<?php endif; ?>


<a href="<?= base_url('user/booking') ?>" class="btn-back">
    Kembali
</a>

</div>
</div>



<!-- MODAL REVIEW -->
<div class="modal" id="reviewModal">
<div class="modal-content">

<h3>Beri Review</h3>

<form method="post" action="<?= base_url('user/review_store') ?>">

<input type="hidden" name="id_booking"
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
<textarea name="review" rows="5"
placeholder="Tulis pengalaman anda..." required></textarea>

<br><br>

<button class="btn-save">Kirim Review</button>

</form>

<br>
<button onclick="closeReviewModal()">Tutup</button>

</div>
</div>



<style>
.card{
    background:#fff;
    padding:25px;
    border-radius:12px;
}

.status{
    display:inline-block;
    padding:10px 14px;
    border-radius:8px;
    color:#fff;
}

.pending{background:#ffc107;color:#000;}
.approved{background:#28a745;}
.rejected{background:#dc3545;}

.btn-back,.btn-review,.btn-save{
    background:#007bff;
    color:#fff;
    padding:10px 15px;
    border:none;
    border-radius:8px;
    text-decoration:none;
    cursor:pointer;
}

.btn-review{
    background:#28a745;
}

.review-box{
    background:#f8f9fa;
    padding:15px;
    border-radius:10px;
}

.star{
    font-size:22px;
}

.modal{
    display:none;
    position:fixed;
    top:0;left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.5);
}

.modal-content{
    background:#fff;
    width:400px;
    padding:20px;
    margin:80px auto;
    border-radius:12px;
}

select,textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
}
</style>


<script>
function openReviewModal(){
    document.getElementById('reviewModal').style.display='block';
}

function closeReviewModal(){
    document.getElementById('reviewModal').style.display='none';
}
</script>
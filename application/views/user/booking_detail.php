<?php $this->load->view('user/sidebar'); ?>

<div class="content">

<div class="booking-wrapper">

    <!-- HEADER -->
    <div class="booking-header">

        <div>
            <h2>
                <i class="fa fa-file-alt"></i>
                Detail Booking
            </h2>

            <p>
                Informasi lengkap booking dan pembayaran kamar.
            </p>
        </div>

        <a href="<?= base_url('user/booking') ?>" class="btn-back">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>

    </div>

    <!-- MAIN GRID -->
    <div class="detail-grid">

        <!-- LEFT -->
        <div class="left-side">

            <!-- IMAGE -->
            <div class="room-image">

                <?php if(!empty($booking->image)): ?>

                    <img
                        src="<?= base_url('assets/uploads/content/'.$booking->image) ?>"
                        alt="Room">

                <?php else: ?>

                    <img
                        src="<?= base_url('assets/uploads/content/default.png') ?>"
                        alt="Room">

                <?php endif; ?>

            </div>

            <!-- INFO -->
            <div class="detail-card">

                <div class="section-title">
                    <i class="fa fa-bed"></i>
                    Informasi Kamar
                </div>

                <div class="info-grid">

                    <div class="info-box">
                        <label>Nomor Kamar</label>
                        <p><?= $booking->room_number ?></p>
                    </div>

                    <div class="info-box">
                        <label>Harga</label>
                        <p class="price">
                            Rp <?= number_format($booking->price,0,',','.') ?>
                        </p>
                    </div>

                    <div class="info-box">
                        <label>Tanggal Masuk</label>
                        <p><?= $booking->start_at ?></p>
                    </div>

                    <div class="info-box">
                        <label>Dibuat</label>
                        <p><?= $booking->created_at ?></p>
                    </div>

                </div>

            </div>

            <!-- REVIEW -->
            <?php if(
                $booking->status=='approved' &&
                $pay_status=='verified'
            ): ?>

            <div class="detail-card">

                <div class="section-title">
                    <i class="fa fa-star"></i>
                    Review
                </div>

                <?php if($review): ?>

                    <div class="review-box">

                        <div class="review-star">
                            <?= str_repeat('⭐', $review->rating) ?>
                        </div>

                        <p><?= $review->review ?></p>

                        <small>
                            <?= $review->created_at ?>
                        </small>

                    </div>

                <?php else: ?>

                    <button
                        class="btn-review"
                        onclick="openReviewModal()">

                        <i class="fa fa-star"></i>
                        Beri Review

                    </button>

                <?php endif; ?>

            </div>

            <?php endif; ?>

        </div>

        <!-- RIGHT -->
        <div class="right-side">

            <!-- STATUS -->
            <div class="detail-card">

                <div class="section-title">
                    <i class="fa fa-info-circle"></i>
                    Status Booking
                </div>

                <?php
                $status = trim(strtolower($booking->booking_status));
                ?>

                <?php if($status == 'pending'): ?>

                    <div class="status pending">
                        <i class="fa fa-clock"></i>
                        Menunggu Approval
                    </div>

                <?php elseif($status == 'approved'): ?>

                    <div class="status approved">
                        <i class="fa fa-check-circle"></i>
                        Booking Disetujui
                    </div>

                <?php elseif($status == 'completed'): ?>

                    <div class="status completed">
                        <i class="fa fa-check-circle"></i>
                        Booking Selesai
                    </div>

                <?php elseif($status == 'rejected'): ?>

                    <div class="status rejected">
                        <i class="fa fa-times-circle"></i>
                        Booking Ditolak
                    </div>

                <?php endif; ?>

            </div>

            <!-- PAYMENT -->
            <div class="detail-card">

                <div class="section-title">
                    <i class="fa fa-credit-card"></i>
                    Pembayaran
                </div>

                <?php
                $pay_status = isset($payment->payment_status)
                    ? $payment->payment_status
                    : '';
                ?>

                <?php if(
                    $booking->booking_status != 'approved' &&
                    $booking->booking_status != 'completed'
                ): ?>

                    <div class="status rejected">
                        Booking belum disetujui
                    </div>

                <?php else: ?>

                    <!-- BELUM BAYAR -->
                    <?php if($pay_status == ''): ?>

                        <div class="status rejected">
                            Belum Ada Pembayaran
                        </div>

                        <button
                            class="btn-pay"
                            onclick="openPayModal()">

                            <i class="fa fa-credit-card"></i>
                            Bayar Sekarang

                        </button>

                    <!-- PAID -->
                    <?php elseif($pay_status == 'paid'): ?>

                        <div class="status pending">
                            <i class="fa fa-clock"></i>
                            Menunggu Verifikasi
                        </div>

                        <?php if($payment->proof_of_payment): ?>

                            <img
                                src="<?= base_url('assets/uploads/payment/'.$payment->proof_of_payment) ?>"
                                class="proof-img"
                                onclick="openImage(this.src)">

                        <?php endif; ?>

                    <!-- VERIFIED -->
                    <?php elseif($pay_status == 'verified'): ?>

                        <div class="status approved">
                            <i class="fa fa-check"></i>
                            Pembayaran Terverifikasi
                        </div>

                        <?php if($payment->proof_of_payment): ?>

                            <img
                                src="<?= base_url('assets/uploads/payment/'.$payment->proof_of_payment) ?>"
                                class="proof-img"
                                onclick="openImage(this.src)">

                        <?php endif; ?>

                    <!-- REJECT -->
                    <?php else: ?>

                        <div class="status rejected">
                            <i class="fa fa-times"></i>
                            Pembayaran Ditolak
                        </div>

                        <button
                            class="btn-pay"
                            onclick="openPayModal()">

                            Upload Ulang Pembayaran

                        </button>

                    <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>
</div>

<!-- ================= PAYMENT MODAL ================= -->
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

        <button class="btn-save">
            Kirim Pembayaran
        </button>

    </form>

    <button class="btn-close" onclick="closePayModal()">
        Tutup
    </button>

</div>
</div>

<!-- ================= REVIEW MODAL ================= -->
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

        <textarea
            name="review"
            rows="5"
            required
            placeholder="Tulis pengalaman anda"></textarea>

        <button class="btn-save">
            Kirim Review
        </button>

    </form>

    <button class="btn-close" onclick="closeReviewModal()">
        Tutup
    </button>

</div>
</div>

<!-- ================= IMAGE MODAL ================= -->
<div class="img-modal" id="imgModal">

    <span class="close-img" onclick="closeImage()">
        &times;
    </span>

    <img class="img-full" id="imgPreview">

</div>

<style>

/* WRAPPER */
.booking-wrapper{
    display:flex;
    flex-direction:column;
    gap:5px;
}

/* HEADER */
.booking-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin: 1.5em 0 0 0;
}

.booking-header h2{
    margin:0;
    font-size:28px;
}

.booking-header p{
    margin-top:5px;
    color:#777;
}

/* GRID */
.detail-grid{
    display:grid;
    grid-template-columns:1fr 350px;
    gap:25px;
}

/* IMAGE */
.room-image{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.room-image img{
    width:100%;
    height:420px;
    object-fit:cover;
}

/* CARD */
.detail-card{
    background:#fff;
    border-radius:18px;
    padding:22px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    margin-top:20px;
}

/* SECTION */
.section-title{
    font-size:20px;
    font-weight:bold;
    margin-bottom:20px;
    color:#222;
}

/* INFO GRID */
.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.info-box{
    background:#f8f9fa;
    padding:15px;
    border-radius:12px;
}

.info-box label{
    display:block;
    font-size:13px;
    color:#888;
    margin-bottom:5px;
}

.info-box p{
    margin:0;
    font-weight:600;
    font-size:17px;
}

.price{
    color:#28a745;
}

/* STATUS */
.status{
    padding:14px;
    border-radius:12px;
    font-weight:bold;
}

.pending{
    background:#fff3cd;
    color:#856404;
}

.approved{
    background:#d4edda;
    color:#155724;
}

.completed{
    background:#d1ecf1;
    color:#0c5460;
}

.rejected{
    background:#f8d7da;
    color:#721c24;
}

/* BUTTON */
.btn-back,
.btn-pay,
.btn-review,
.btn-save{
    border:none;
    border-radius:12px;
    padding:13px 18px;
    color:#fff;
    cursor:pointer;
    text-decoration:none;
    font-weight:bold;
    transition:.3s;
}

.btn-back{
    background:#007bff;
}

.btn-pay{
    margin-top:20px;
    width:100%;
    background:linear-gradient(135deg,#17a2b8,#138496);
}

.btn-review{
    background:linear-gradient(135deg,#28a745,#1f8f3a);
}

.btn-save{
    width:100%;
    margin-top:20px;
    background:#007bff;
}

.btn-back:hover,
.btn-pay:hover,
.btn-review:hover,
.btn-save:hover{
    transform:translateY(-2px);
}

/* REVIEW */
.review-box{
    background:#f8f9fa;
    border-radius:12px;
    padding:18px;
}

.review-star{
    font-size:22px;
    margin-bottom:10px;
}

/* PAYMENT IMAGE */
.proof-img{
    width:100%;
    margin-top:18px;
    border-radius:14px;
    cursor:pointer;
    transition:.3s;
}

.proof-img:hover{
    transform:scale(1.02);
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.6);
    z-index:999;
}

.modal-content{
    background:#fff;
    width:420px;
    max-width:92%;
    margin:70px auto;
    padding:25px;
    border-radius:18px;
    animation:fade .25s;
}

@keyframes fade{
    from{
        opacity:0;
        transform:translateY(-15px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.modal-content input,
.modal-content select,
.modal-content textarea{
    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:18px;
    border:1px solid #ddd;
    border-radius:10px;
}

.btn-close{
    margin-top:12px;
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#eee;
    cursor:pointer;
}

/* IMAGE MODAL */
.img-modal{
    display:none;
    position:fixed;
    z-index:9999;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.9);
}

.img-full{
    display:block;
    margin:auto;
    max-width:90%;
    max-height:90%;
    margin-top:30px;
    border-radius:15px;
}

.close-img{
    position:absolute;
    top:20px;
    right:35px;
    color:#fff;
    font-size:40px;
    cursor:pointer;
}

/* RESPONSIVE */
@media(max-width:900px){

    .detail-grid{
        grid-template-columns:1fr;
    }

    .booking-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .room-image img{
        height:280px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

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
<?php $this->load->view('admin/sidebar'); ?>

<div class="content">
    <div class="booking-wrapper">

        <!-- HEADER -->
        <div class="booking-header">
            <div>
                <h2>
                    <i class="fa fa-file"></i>
                    Detail Payment
                </h2>

                <p>
                    Informasi lengkap pembayaran booking kamar pengguna.
                </p>
            </div>

            <a href="<?= base_url('admin/payment') ?>" class="btn-back">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <!-- DETAIL GRID -->
        <div class="detail-grid">

            <!-- LEFT SIDE -->
            <div class="left-side">

                <div class="detail-card">
                    <div class="section-title">
                        <i class="fa fa-credit-card"></i>
                        Informasi Pembayaran
                    </div>

                    <div class="info-grid">

                        <div class="info-box">
                            <label>Nomor Kamar</label>
                            <p><?= $payment->room_number ?></p>
                        </div>

                        <div class="info-box">
                            <label>Harga</label>
                            <p class="price">
                                Rp <?= number_format($payment->amount, 0, ',', '.') ?>
                            </p>
                        </div>

                        <div class="info-box">
                            <label>Metode</label>
                            <p><?= !empty($payment->payment_method) ? $payment->payment_method : '-' ?></p>
                        </div>

                        <div class="info-box">
                            <label>Tanggal Pembayaran</label>
                            <p><?= !empty($payment->payment_date) ? $payment->payment_date : '-' ?></p>
                        </div>

                    </div>
                </div>

                <div class="room-image">
                    <?php if (!empty($payment->proof_of_payment)): ?>

                        <img
                            src="<?= base_url('assets/uploads/payment/'.$payment->proof_of_payment) ?>"
                            onclick="openImage(this.src)"
                            alt="Bukti Pembayaran">

                    <?php else: ?>

                        <img
                            src="<?= base_url('assets/uploads/content/default.png') ?>"
                            alt="Belum Ada Bukti">

                    <?php endif; ?>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="right-side">

                <div class="detail-card">
                    <div class="section-title">
                        <i class="fa fa-info-circle"></i>
                        Status Pembayaran
                    </div>

                    <?php if ($payment->payment_status == 'paid'): ?>

                        <div class="status pending">
                            <i class="fa fa-clock"></i>
                            Menunggu Verifikasi
                        </div>

                    <?php elseif ($payment->payment_status == 'verified'): ?>

                        <div class="status approved">
                            <i class="fa fa-check-circle"></i>
                            Pembayaran Terverifikasi
                        </div>

                    <?php else: ?>

                        <div class="status rejected">
                            <i class="fa fa-times-circle"></i>
                            Pembayaran Ditolak
                        </div>

                    <?php endif; ?>
                </div>

                <?php if ($payment->payment_status == 'paid'): ?>

                    <div class="detail-card">
                        <div class="section-title">
                            <i class="fa fa-edit"></i>
                            Aksi Verifikasi
                        </div>

                        <div class="action-wrap">

                            <a
                                href="<?= base_url('admin/payment_approve/'.$payment->id_payment) ?>"
                                class="btn-approve"
                                onclick="return confirm('Approve pembayaran ini?')">

                                <i class="fa fa-check"></i>
                                Approve

                            </a>

                            <a
                                href="<?= base_url('admin/payment_reject/'.$payment->id_payment) ?>"
                                class="btn-reject"
                                onclick="return confirm('Tolak pembayaran ini?')">

                                <i class="fa fa-times"></i>
                                Reject

                            </a>

                        </div>
                    </div>

                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<!-- MODAL IMAGE VIEW -->
<div class="img-modal" id="imgModal">
    <span class="close-img" onclick="closeImage()">&times;</span>
    <img class="img-full" id="imgPreview" alt="Preview Bukti Pembayaran">
</div>

<style>
.booking-wrapper {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.booking-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 1em 0 0 0;
}

.booking-header h2 {
    font-size: 28px;
    margin: 0;
}

.booking-header p {
    margin-top: 5px;
    color: #777;
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 25px;
}

.room-image {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
}

.room-image img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    cursor: pointer;
}

.detail-card {
    background: #fff;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
    margin: 0 0 20px 0;
}

.section-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #222;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.info-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 12px;
}

.info-box label {
    display: block;
    font-size: 13px;
    color: #888;
    margin-bottom: 5px;
}

.info-box p {
    margin: 0;
    font-weight: 600;
    font-size: 17px;
}

.price {
    color: #28a745;
}

.status {
    padding: 14px;
    border-radius: 12px;
    font-weight: bold;
}

.status.pending {
    background: #fff3cd;
    color: #856404;
}

.status.approved {
    background: #d4edda;
    color: #155724;
}

.status.rejected {
    background: #f8d7da;
    color: #721c24;
}

.btn-back,
.btn-approve,
.btn-reject {
    border: none;
    border-radius: 12px;
    padding: 13px 18px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    transition: .3s;
}

.btn-back {
    background: #007bff;
    color: #fff;
}

.action-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-approve {
    background: linear-gradient(135deg, #28a745, #1f8f3a);
    color: #fff;
    text-align: center;
}

.btn-reject {
    background: #f8d7da;
    color: #721c24;
    text-align: center;
}

.btn-back:hover,
.btn-approve:hover,
.btn-reject:hover {
    transform: translateY(-2px);
}

.img-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    padding-top: 50px;
    background: rgba(0, 0, 0, .9);
}

.img-full {
    display: block;
    margin: auto;
    max-width: 90%;
    max-height: 90%;
    border-radius: 15px;
    animation: zoomIn .3s ease;
}

.close-img {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    cursor: pointer;
}

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(.8);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

@media (max-width: 900px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }

    .booking-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .room-image img {
        height: 280px;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function openImage(src) {
    const imgModal = document.getElementById('imgModal');
    const imgPreview = document.getElementById('imgPreview');

    imgPreview.src = src;
    imgModal.style.display = 'block';
}

function closeImage() {
    document.getElementById('imgModal').style.display = 'none';
}

window.addEventListener('click', function (event) {
    const imgModal = document.getElementById('imgModal');

    if (event.target === imgModal) {
        closeImage();
    }
});
</script>
<?php $this->load->view('user/sidebar'); ?>

<div class="content">
    <div class="booking-wrapper">

        <!-- HEADER -->
        <div class="booking-header">
            <div>
                <h2>
                    <i class="fa fa-file"></i>
                    Detail Pembayaran
                </h2>
                <p>Informasi lengkap pembayaran booking kamar.</p>
            </div>

            <a href="<?= base_url('user/payment') ?>" class="btn-back">
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
                            <p><?= $payment->payment_date ?></p>
                        </div>
                    </div>
                </div>

                <div class="room-image">
                    <?php if (!empty($payment->proof_of_payment)): ?>
                        <img
                            src="<?= base_url('assets/uploads/payment/' . $payment->proof_of_payment) ?>"
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
                            Pembayaran Gagal
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($payment->payment_status == 'paid'): ?>
                    <div class="detail-card">
                        <div class="section-title">
                            <i class="fa fa-edit"></i>
                            Aksi
                        </div>

                        <button type="button" class="btn-pay" onclick="openModal()">
                            <i class="fa fa-edit"></i>
                            Edit Pembayaran
                        </button>
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

<!-- MODAL EDIT PEMBAYARAN -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Pembayaran</h3>

        <form method="post" action="<?= base_url('user/payment_update') ?>" enctype="multipart/form-data">
            <input type="hidden" name="id_payment" value="<?= $payment->id_payment ?>">

            <label>Metode</label>
            <select name="payment_method">
                <option value="transfer" <?= $payment->payment_method == 'transfer' ? 'selected' : '' ?>>
                    Transfer
                </option>
                <option value="ewallet" <?= $payment->payment_method == 'ewallet' ? 'selected' : '' ?>>
                    E-Wallet
                </option>
                <option value="cash" <?= $payment->payment_method == 'cash' ? 'selected' : '' ?>>
                    Cash
                </option>
            </select>

            <label>Upload Ulang Bukti</label>
            <input type="file" name="proof">

            <button type="submit" class="btn-save">Update</button>
            <button type="button" class="btn-close" onclick="closeModal()">Tutup</button>
        </form>
    </div>
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
    margin:0 0 20px 0;
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
.btn-pay,
.btn-save,
.btn-close {
    border: none;
    border-radius: 12px;
    padding: 13px 18px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    transition: .3s;
}

.btn-back,
.btn-pay,
.btn-save {
    color: #fff;
}

.btn-back {
    background: #007bff;
}

.btn-pay {
    width: 100%;
    background: linear-gradient(135deg, #17a2b8, #138496);
}

.btn-save {
    width: 100%;
    margin-top: 10px;
    background: #007bff;
}

.btn-close {
    width: 100%;
    margin-top: 10px;
    background: #eee;
    color: #333;
}

.btn-back:hover,
.btn-pay:hover,
.btn-save:hover,
.btn-close:hover {
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

.modal {
    display: none;
    position: fixed;
    z-index: 999;
    inset: 0;
    background: rgba(0, 0, 0, .6);
}

.modal-content {
    background: #fff;
    width: 420px;
    max-width: 92%;
    margin: 70px auto;
    padding: 25px;
    border-radius: 18px;
    animation: fadeIn .3s ease;
}

.modal-content h3 {
    margin-top: 0;
    margin-bottom: 20px;
}

.modal-content label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
}

.modal-content input,
.modal-content select {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border: 1px solid #ddd;
    border-radius: 10px;
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

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
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

function openModal() {
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

window.addEventListener('click', function (event) {
    const imgModal = document.getElementById('imgModal');
    const editModal = document.getElementById('editModal');

    if (event.target === imgModal) {
        closeImage();
    }

    if (event.target === editModal) {
        closeModal();
    }
});
</script>
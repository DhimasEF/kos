<?php $this->load->view('user/sidebar'); ?>

<div class="content">
    <div class="card">

        <h2><i class="fa fa-file"></i> Detail Booking</h2>

        <hr>

        <!-- INFO KAMAR -->
        <h3>Informasi Kamar</h3>
        <p><b>Nomor Kamar:</b> <?= $booking->room_number ?></p>
        <p><b>Harga:</b> Rp <?= number_format($booking->price) ?></p>

        <br>

        <!-- INFO BOOKING -->
        <h3>Informasi Booking</h3>
        <p><b>Tanggal Masuk:</b> <?= $booking->start_at ?></p>
        <p><b>Dibuat:</b> <?= $booking->created_at ?></p>

        <p><b>Status Booking:</b></p>

        <?php if ($booking->status == 'pending'): ?>
            <div class="status pending">
                <i class="fa fa-clock"></i> Menunggu Konfirmasi Admin
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

        <hr>

        <!-- PAYMENT SECTION -->
        <h3>Pembayaran</h3>

        <?php if ($booking->status == 'approved'): ?>

            <p>Status: <b>Belum Bayar</b></p>

            <button class="btn-pay" onclick="openPaymentModal()">
                <i class="fa fa-credit-card"></i> Bayar Sekarang
            </button>

            <!-- ================= MODAL PAYMENT ================= -->
            <div class="modal" id="paymentModal">
                <div class="modal-content">

                    <h3>Bayar Booking</h3>

                    <form method="post" action="<?= base_url('user/payment_store') ?>" enctype="multipart/form-data">

                        <input type="hidden" name="id_booking" value="<?= $booking->id_booking ?>">

                        <!-- AMOUNT -->
                        <label>Total Bayar</label>
                        <input type="number" name="amount" value="<?= $booking->price ?>" readonly>

                        <!-- METHOD -->
                        <label>Metode Pembayaran</label>
                        <select name="payment_method" required>
                            <option value="">-- Pilih --</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="cash">Cash</option>
                        </select>

                        <!-- UPLOAD -->
                        <label>Bukti Pembayaran</label>
                        <input type="file" name="proof" required>

                        <br><br>

                        <button class="btn">Kirim Pembayaran</button>
                    </form>

                    <br>
                    <button onclick="closePaymentModal()">Tutup</button>

                </div>
            </div>

        <?php elseif ($booking->status == 'pending'): ?>

            <p style="color:orange;">Menunggu approval sebelum pembayaran</p>

        <?php else: ?>

            <p style="color:red;">Booking ditolak, tidak bisa lanjut pembayaran</p>

        <?php endif; ?>

        <br><br>

        <a href="<?= base_url('user/booking') ?>" class="btn">Kembali</a>

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

.btn-pay {
    background:#28a745;
    color:white;
    padding:10px 15px;
    border-radius:6px;
    text-decoration:none;
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
}

select, input {
    width:100%;
    padding:10px;
    margin-top:10px;
}

/* STATUS */
.status {
    padding:10px;
    border-radius:6px;
    color:white;
    display:inline-block;
}

.status.pending {
    background:#ffc107;
    color:black;
}

.status.approved {
    background:#28a745;
}

.status.rejected {
    background:#dc3545;
}
</style>

<script>
function openPaymentModal() {
    document.getElementById('paymentModal').style.display = 'block';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}
</script>
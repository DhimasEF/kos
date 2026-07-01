<?php $this->load->view('user/sidebar'); ?>

<div class="content">

    <!-- HEADER -->
    <div class="page-header">
        <h2>
            <i class="fa fa-credit-card"></i>
            Pembayaran Saya
        </h2>

        <p>
            Riwayat pembayaran booking kamar Anda.
        </p>
    </div>

    <!-- LIST -->
    <div class="booking-list">

        <?php if(!empty($payment)): ?>

            <?php foreach($payment as $p): ?>

                <div class="booking-item">

                    <!-- BODY -->
                    <div class="booking-body">

                        <!-- TOP -->
                        <div class="booking-top">

                            <div>
                                <h3>
                                    Kamar <?= $p->room_number ?>
                                </h3>

                                <span class="booking-id">
                                    Booking #<?= $p->id_booking ?>
                                </span>
                            </div>

                            <!-- STATUS -->
                            <?php if($p->payment_status == 'paid'): ?>

                                <div class="status pending">
                                    <i class="fa fa-clock"></i>
                                    Menunggu Verifikasi
                                </div>

                            <?php elseif($p->payment_status == 'verified'): ?>

                                <div class="status approved">
                                    <i class="fa fa-check-circle"></i>
                                    Terverifikasi
                                </div>

                            <?php else: ?>

                                <div class="status rejected">
                                    <i class="fa fa-times-circle"></i>
                                    Gagal
                                </div>

                            <?php endif; ?>

                        </div>

                        <!-- INFO -->
                        <div class="booking-info">

                            <div class="info-box">
                                <label>
                                    <i class="fa fa-calendar"></i>
                                    Tanggal Pembayaran
                                </label>

                                <p><?= $p->payment_date ?></p>
                            </div>

                            <div class="info-box">
                                <label>
                                    <i class="fa fa-credit-card"></i>
                                    Metode Pembayaran
                                </label>

                                <p><?= !empty($p->payment_method) ? $p->payment_method : '-' ?></p>
                            </div>

                        </div>

                    </div>

                    <!-- ACTION -->
                    <div class="booking-action">

                        <a href="<?= base_url('user/payment_detail/'.$p->id_booking) ?>"
                           class="btn-detail">

                            <i class="fa fa-eye"></i>
                            Detail

                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-payment">

                <i class="fa fa-credit-card"></i>

                <h3>Belum Ada Pembayaran</h3>

                <p>
                    Anda belum memiliki riwayat pembayaran.
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>

<style>

/* HEADER */
.page-header{
    margin-bottom:25px;
}

.page-header h2{
    font-size:28px;
    margin-bottom:5px;
    color:#222;
}

.page-header p{
    color:#777;
}

/* LIST */
.booking-list{
    display:flex;
    flex-direction:column;
    gap:20px;
}

/* CARD */
.booking-item{
    background:#fff;
    border-radius:18px;
    padding:18px;
    display:flex;
    align-items:center;
    gap:20px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    transition:.3s;
}

.booking-item:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

/* BODY */
.booking-body{
    flex:1;
}

/* TOP */
.booking-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:18px;
}

.booking-top h3{
    margin:0;
    font-size:24px;
    color:#222;
}

.booking-id{
    color:#888;
    font-size:14px;
}

/* INFO */
.booking-info{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.info-box{
    background:#f8f9fa;
    padding:12px 16px;
    border-radius:12px;
    min-width:180px;
}

.info-box label{
    display:block;
    font-size:12px;
    color:#888;
    margin-bottom:6px;
}

.info-box label i{
    margin-right:5px;
}

.info-box p{
    margin:0;
    font-size:15px;
    font-weight:600;
    color:#222;
}

/* STATUS */
.status{
    padding:8px 16px;
    border-radius:30px;
    font-size:13px;
    font-weight:bold;
    display:flex;
    align-items:center;
    gap:6px;
}

.pending{
    background:#fff3cd;
    color:#856404;
}

.approved{
    background:#d4edda;
    color:#155724;
}

.rejected{
    background:#f8d7da;
    color:#721c24;
}

/* ACTION */
.booking-action{
    flex-shrink:0;
}

/* BUTTON */
.btn-detail{
    display:inline-block;
    background:linear-gradient(135deg,#17a2b8,#138496);
    color:#fff;
    padding:12px 22px;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
    transition:.3s;
}

.btn-detail:hover{
    transform:translateY(-2px);
    background:linear-gradient(135deg,#138496,#11707f);
}

/* EMPTY */
.empty-payment{
    background:#fff;
    padding:60px 30px;
    border-radius:18px;
    text-align:center;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
}

.empty-payment i{
    font-size:60px;
    color:#ccc;
    margin-bottom:15px;
}

.empty-payment h3{
    margin-bottom:10px;
    color:#444;
}

.empty-payment p{
    color:#777;
}

/* RESPONSIVE */
@media(max-width:900px){

    .booking-item{
        flex-direction:column;
        align-items:flex-start;
    }

    .booking-top{
        flex-direction:column;
        gap:12px;
    }

    .booking-action{
        width:100%;
    }

    .btn-detail{
        width:100%;
        text-align:center;
    }

    .info-box{
        width:100%;
    }

}
</style>
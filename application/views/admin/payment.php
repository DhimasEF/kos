<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

    <!-- HEADER -->
    <div class="page-header">
        <h2>
            <i class="fa fa-credit-card"></i>
            Manajemen Payment
        </h2>

        <p>
            Kelola dan verifikasi pembayaran booking kamar pengguna.
        </p>
    </div>

    <form method="get" action="<?= base_url('admin/payment') ?>" class="filter-card">

        <div class="filter-group">
            <label>Cari Payment</label>
            <input
                type="text"
                name="keyword"
                value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Cari user, kamar, ID booking, metode...">
        </div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status">
                <option value="">Semua Status</option>
                <option value="paid" <?= ($filter_status ?? '') == 'paid' ? 'selected' : '' ?>>
                    Menunggu Verifikasi
                </option>
                <option value="verified" <?= ($filter_status ?? '') == 'verified' ? 'selected' : '' ?>>
                    Terverifikasi
                </option>
                <option value="rejected" <?= ($filter_status ?? '') == 'rejected' ? 'selected' : '' ?>>
                    Ditolak
                </option>
            </select>
        </div>

        <div class="filter-action">
            <button type="submit" class="btn-filter">
                <i class="fa fa-search"></i>
                Cari
            </button>

            <a href="<?= base_url('admin/payment') ?>" class="btn-reset">
                Reset
            </a>
        </div>

    </form>

    <!-- LIST -->
    <div class="booking-list">

        <?php if (!empty($payment)): ?>

            <?php foreach ($payment as $p): ?>

                <div class="booking-item">

                    <!-- BODY -->
                    <div class="booking-body">

                        <!-- TOP -->
                        <div class="booking-top">

                            <div>
                                <h3>
                                    Kamar <?= $p->room_number ?>
                                </h3>

                                <?php if (!empty($p->id_booking)): ?>
                                    <span class="booking-id">
                                        Booking #<?= $p->id_booking ?>
                                    </span>
                                <?php else: ?>
                                    <span class="booking-id">
                                        Payment #<?= $p->id_payment ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- STATUS -->
                            <?php if ($p->payment_status == 'paid'): ?>

                                <div class="status pending">
                                    <i class="fa fa-clock"></i>
                                    Menunggu Verifikasi
                                </div>

                            <?php elseif ($p->payment_status == 'verified'): ?>

                                <div class="status approved">
                                    <i class="fa fa-check-circle"></i>
                                    Terverifikasi
                                </div>

                            <?php else: ?>

                                <div class="status rejected">
                                    <i class="fa fa-times-circle"></i>
                                    Ditolak
                                </div>

                            <?php endif; ?>

                        </div>

                        <!-- INFO -->
                        <div class="booking-info">
                            <div class="info-box">
                                <label>
                                    <i class="fa fa-user"></i>
                                    User
                                </label>

                                <p>
                                    <?= !empty($p->name) ? $p->name : '-' ?>
                                </p>
                            </div>

                            <div class="info-box">
                                <label>
                                    <i class="fa fa-calendar"></i>
                                    Tanggal Pembayaran
                                </label>

                                <p>
                                    <?= !empty($p->payment_date) ? $p->payment_date : '-' ?>
                                </p>
                            </div>

                            <div class="info-box">
                                <label>
                                    <i class="fa fa-credit-card"></i>
                                    Metode Pembayaran
                                </label>

                                <p>
                                    <?= !empty($p->payment_method) ? $p->payment_method : '-' ?>
                                </p>
                            </div>

                            <?php if (!empty($p->amount)): ?>

                                <div class="info-box">
                                    <label>
                                        <i class="fa fa-money-bill"></i>
                                        Total Bayar
                                    </label>

                                    <p class="price">
                                        Rp <?= number_format($p->amount, 0, ',', '.') ?>
                                    </p>
                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <!-- ACTION -->
                    <div class="booking-action">

                        <a
                            href="<?= base_url('admin/payment_detail/'.$p->id_payment) ?>"
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
                    Data pembayaran pengguna akan tampil di sini.
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* HEADER */
.page-header{
    margin:1.5em 0 25px;
}

.page-header h2{
    font-size:28px;
    margin:0 0 5px;
    color:#222;
}

.page-header p{
    margin:0;
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
    gap:15px;
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

.price{
    color:#28a745 !important;
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
    white-space:nowrap;
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

/* FILTER */
.filter-card{
    background:#fff;
    border-radius:18px;
    padding:18px;
    margin-bottom:22px;
    display:grid;
    grid-template-columns:1fr 220px auto;
    gap:15px;
    align-items:end;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
}

.filter-group label{
    display:block;
    font-size:13px;
    color:#777;
    margin-bottom:8px;
    font-weight:bold;
}

.filter-group input,
.filter-group select{
    width:100%;
    padding:13px 14px;
    border:1px solid #ddd;
    border-radius:12px;
    outline:none;
}

.filter-group input:focus,
.filter-group select:focus{
    border-color:#007bff;
    box-shadow:0 0 0 4px rgba(0,123,255,0.08);
}

.filter-action{
    display:flex;
    gap:10px;
}

.btn-filter,
.btn-reset{
    border:none;
    border-radius:12px;
    padding:13px 18px;
    cursor:pointer;
    text-decoration:none;
    font-weight:bold;
    transition:.3s;
    white-space:nowrap;
}

.btn-filter{
    background:#007bff;
    color:#fff;
}

.btn-reset{
    background:#eee;
    color:#333;
}

.btn-filter:hover,
.btn-reset:hover{
    transform:translateY(-2px);
}

@media(max-width:900px){
    .filter-card{
        grid-template-columns:1fr;
    }

    .filter-action{
        flex-direction:column;
    }

    .btn-filter,
    .btn-reset{
        width:100%;
        text-align:center;
    }
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
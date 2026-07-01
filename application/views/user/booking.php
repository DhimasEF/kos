<?php $this->load->view('user/sidebar'); ?>

<div class="content">

    <!-- HEADER -->
    <div class="page-header">
        <h2>
            <i class="fa fa-history"></i>
            Riwayat Booking
        </h2>

        <p>
            Histori booking kamar anda.
        </p>
    </div>

    <!-- LIST -->
    <div class="booking-list">

        <?php foreach ($kamar as $k): ?>

        <div class="booking-item">

            <!-- IMAGE -->
            <div class="booking-image">

                <?php if(!empty($k->image)): ?>

                    <img
                        src="<?= base_url('assets/uploads/content/'.$k->image) ?>"
                        alt="Room">

                <?php else: ?>

                    <img
                        src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1200&auto=format&fit=crop"
                        alt="Room">

                <?php endif; ?>

            </div>

            <!-- CONTENT -->
            <div class="booking-body">

                <!-- TOP -->
                <div class="booking-top">

                    <div>
                        <h3>
                            Kamar <?= $k->room_number ?>
                        </h3>

                        <span class="booking-id">
                            Booking #<?= $k->id_booking ?>
                        </span>
                    </div>

                    <!-- STATUS -->
                    <?php if($k->status == 'pending'): ?>

                        <div class="status pending">
                            <i class="fa fa-clock"></i>
                            Pending
                        </div>

                    <?php elseif($k->status == 'approved'): ?>

                        <div class="status approved">
                            <i class="fa fa-check-circle"></i>
                            Approved
                        </div>

                    <?php elseif($k->status == 'completed'): ?>

                        <div class="status completed">
                            <i class="fa fa-check-circle"></i>
                            Completed
                        </div>

                    <?php elseif($k->status == 'rejected'): ?>

                        <div class="status rejected">
                            <i class="fa fa-times-circle"></i>
                            Rejected
                        </div>

                    <?php endif; ?>

                </div>

                <!-- INFO -->
                <div class="booking-info">

                    <div class="info-box">
                        <label>Harga</label>
                        <p class="price">
                            Rp <?= number_format($k->price,0,',','.') ?>
                        </p>
                    </div>

                    <?php if(!empty($k->start_at)): ?>

                    <div class="info-box">
                        <label>Tanggal Masuk</label>
                        <p><?= $k->start_at ?></p>
                    </div>

                    <?php endif; ?>

                    <?php if(!empty($k->end_at)): ?>

                    <div class="info-box">
                        <label>Berlaku Sampai</label>
                        <p><?= $k->end_at ?></p>
                    </div>

                    <?php endif; ?>

                </div>

            </div>

            <!-- ACTION -->
            <div class="booking-action">

                <a href="<?= base_url('user/booking_detail/'.$k->id_booking) ?>"
                   class="btn-detail">

                    <i class="fa fa-eye"></i>
                    Detail

                </a>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div>

<style>

/* CONTENT */

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

/* ITEM */
.booking-item{
    background:#fff;
    border-radius:18px;
    padding:18px;
    display:flex;
    align-items:center;
    gap:20px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.booking-item:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
}

/* IMAGE */
.booking-image{
    width:170px;
    height:120px;
    border-radius:14px;
    overflow:hidden;
    flex-shrink:0;
}

.booking-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:0.4s;
}

.booking-item:hover .booking-image img{
    transform:scale(1.08);
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
    padding:10px 14px;
    border-radius:10px;
    min-width:140px;
}

.info-box label{
    display:block;
    font-size:12px;
    color:#888;
    margin-bottom:4px;
}

.info-box p{
    margin:0;
    font-weight:600;
    color:#222;
}

.price{
    color:#28a745 !important;
}

/* STATUS */
.status{
    padding:8px 14px;
    border-radius:30px;
    font-size:13px;
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

/* ACTION */
.booking-action{
    flex-shrink:0;
}

/* BUTTON */
.btn-detail{
    display:inline-block;
    background:linear-gradient(135deg,#17a2b8,#138496);
    color:#fff;
    padding:12px 18px;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.btn-detail:hover{
    transform:translateY(-2px);
    background:linear-gradient(135deg,#138496,#11707f);
}

/* RESPONSIVE */
@media(max-width:900px){

    .booking-item{
        flex-direction:column;
        align-items:flex-start;
    }

    .booking-image{
        width:100%;
        height:220px;
    }

    .booking-top{
        flex-direction:column;
        gap:10px;
    }

    .booking-action{
        width:100%;
    }

    .btn-detail{
        width:100%;
        text-align:center;
    }

}

</style>
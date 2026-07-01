<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

    <!-- HEADER -->
    <div class="page-header">
        <h2>
            <i class="fa fa-calendar"></i>
            Manajemen Booking
        </h2>

        <p>
            Kelola pengajuan booking kamar dari pengguna.
        </p>
    </div>

    <!-- LIST -->
    <div class="booking-list">

        <?php if (!empty($booking)): ?>

            <?php foreach ($booking as $b): ?>

                <div class="booking-item">

                    <!-- IMAGE -->
                    <div class="booking-image">

                        <?php if (!empty($b->image)): ?>

                            <img
                                src="<?= base_url('assets/uploads/content/'.$b->image) ?>"
                                alt="Kamar <?= $b->room_number ?>">

                        <?php else: ?>

                            <img
                                src="<?= base_url('assets/uploads/content/default.png') ?>"
                                alt="Kamar <?= $b->room_number ?>">

                        <?php endif; ?>

                    </div>

                    <!-- BODY -->
                    <div class="booking-body">

                        <!-- TOP -->
                        <div class="booking-top">

                            <div>
                                <h3>
                                    Kamar <?= $b->room_number ?>
                                </h3>

                                <span class="booking-id">
                                    Booking #<?= $b->id_booking ?>
                                </span>
                            </div>

                            <!-- STATUS -->
                            <?php if ($b->status == 'pending'): ?>

                                <div class="status pending">
                                    <i class="fa fa-clock"></i>
                                    Pending
                                </div>

                            <?php elseif ($b->status == 'approved'): ?>

                                <div class="status approved">
                                    <i class="fa fa-check-circle"></i>
                                    Approved
                                </div>

                            <?php elseif ($b->status == 'completed'): ?>

                                <div class="status completed">
                                    <i class="fa fa-check-circle"></i>
                                    Completed
                                </div>

                            <?php elseif ($b->status == 'rejected'): ?>

                                <div class="status rejected">
                                    <i class="fa fa-times-circle"></i>
                                    Rejected
                                </div>

                            <?php endif; ?>

                        </div>

                        <!-- INFO -->
                        <div class="booking-info">

                            <div class="info-box">
                                <label>User</label>
                                <p><?= $b->name ?></p>
                            </div>

                            <div class="info-box">
                                <label>Tanggal Masuk</label>
                                <p><?= $b->start_at ?></p>
                            </div>

                            <?php if (!empty($b->end_at)): ?>

                                <div class="info-box">
                                    <label>Berlaku Sampai</label>
                                    <p><?= $b->end_at ?></p>
                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <!-- ACTION -->
                    <div class="booking-action">

                        <?php if ($b->status == 'pending'): ?>

                            <a
                                href="<?= base_url('admin/booking_approve/'.$b->id_booking) ?>"
                                class="btn-approve"
                                onclick="return confirm('Setujui booking ini?')">

                                <i class="fa fa-check"></i>
                                Approve

                            </a>

                            <a
                                href="<?= base_url('admin/booking_reject/'.$b->id_booking) ?>"
                                class="btn-reject"
                                onclick="return confirm('Tolak booking ini?')">

                                <i class="fa fa-times"></i>
                                Reject

                            </a>

                        <?php else: ?>

                            <div class="action-empty">
                                <i class="fa fa-check-circle"></i>
                                Selesai
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-booking">
                <i class="fa fa-calendar-times"></i>
                <h3>Belum Ada Booking</h3>
                <p>Data booking pengguna akan tampil di sini.</p>
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

/* STATUS */
.status{
    padding:8px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:bold;
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
    display:flex;
    flex-direction:column;
    gap:10px;
    min-width:130px;
}

/* BUTTON */
.btn-approve,
.btn-reject,
.action-empty{
    display:block;
    text-align:center;
    border-radius:12px;
    padding:12px 16px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.btn-approve{
    background:linear-gradient(135deg,#28a745,#1f8f3a);
    color:#fff;
}

.btn-reject{
    background:#f8d7da;
    color:#721c24;
}

.action-empty{
    background:#f8f9fa;
    color:#777;
}

.btn-approve:hover,
.btn-reject:hover{
    transform:translateY(-2px);
}

/* EMPTY */
.empty-booking{
    background:#fff;
    border-radius:18px;
    padding:35px;
    text-align:center;
    color:#777;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
}

.empty-booking i{
    font-size:52px;
    color:#ccc;
    margin-bottom:15px;
}

.empty-booking h3{
    margin:0;
    color:#555;
}

.empty-booking p{
    margin:8px 0 0;
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
        flex-direction:row;
    }

    .btn-approve,
    .btn-reject,
    .action-empty{
        flex:1;
    }

}

@media(max-width:520px){

    .booking-action{
        flex-direction:column;
    }

}
</style>
<?php $this->load->view('user/sidebar'); ?>

<div class="content">

    <!-- HEADER -->
    <div class="page-header">
        <h2><i class="fa fa-bed"></i> Daftar Kamar</h2>
        <p>Pilih kamar terbaik untuk booking anda.</p>
    </div>

    <!-- GRID CARD -->
    <div class="room-grid">

        <?php foreach ($kamar as $k): ?>

        <div class="room-card">

            <!-- IMAGE -->
            <div class="room-image">
                <?php if(!empty($k->image)): ?>
                    <img src="<?= base_url('assets/uploads/content/'.$k->image) ?>" alt="Room">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1200&auto=format&fit=crop" alt="Room">
                <?php endif; ?>

                <div class="room-overlay">
                    <span>#<?= $k->room_number ?></span>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="room-content">

                <h3>Kamar No. <?= $k->room_number ?></h3>

                <div class="price">
                    Rp <?= number_format($k->price,0,',','.') ?>
                    <small>/ bulan</small>
                </div>

                <div class="room-info">
                    <span><i class="fa fa-wifi"></i> Wifi</span>
                    <span><i class="fa fa-snowflake"></i> AC</span>
                    <span><i class="fa fa-bath"></i> Bathroom</span>
                </div>

                <!-- BUTTON -->
                <a href="<?= base_url('user/kamar_detail/'.$k->id_room) ?>" class="btn-detail">
                    <i class="fa fa-eye"></i> Lihat Detail
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

/* GRID */
.room-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

/* CARD */
.room-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    transition:0.3s ease;
    position:relative;
}

.room-card:hover{
    transform:translateY(-8px);
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* IMAGE */
.room-image{
    position:relative;
    height:220px;
    overflow:hidden;
}

.room-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:0.4s;
}

.room-card:hover .room-image img{
    transform:scale(1.08);
}

/* OVERLAY */
.room-overlay{
    position:absolute;
    top:15px;
    right:15px;
    background:rgba(0,0,0,0.6);
    color:#fff;
    padding:6px 12px;
    border-radius:30px;
    font-size:13px;
}

/* CONTENT */
.room-content{
    padding:20px;
}

.room-content h3{
    margin:0;
    font-size:22px;
    color:#222;
}

/* PRICE */
.price{
    margin-top:10px;
    font-size:24px;
    font-weight:bold;
    color:#28a745;
}

.price small{
    font-size:14px;
    color:#888;
    font-weight:normal;
}

/* INFO */
.room-info{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin:18px 0;
    color:#666;
    font-size:14px;
}

.room-info span{
    background:#f5f5f5;
    padding:6px 12px;
    border-radius:20px;
}

/* BUTTON */
.btn-detail{
    display:block;
    text-align:center;
    background:linear-gradient(135deg,#17a2b8,#138496);
    color:#fff;
    padding:12px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.btn-detail:hover{
    background:linear-gradient(135deg,#138496,#11707f);
}

/* RESPONSIVE */
@media(max-width:768px){

    .room-image{
        height:200px;
    }

    .page-header h2{
        font-size:24px;
    }

}

</style>
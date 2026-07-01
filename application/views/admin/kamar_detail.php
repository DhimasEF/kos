<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

<div class="booking-wrapper">

    <!-- HEADER -->
    <div class="booking-header">

        <div>
            <h2>
                <i class="fa fa-bed"></i>
                Detail Kamar <?= $kamar->room_number ?>
            </h2>

            <p>
                Informasi lengkap kamar, gambar, harga, rating, dan review pengguna.
            </p>
        </div>

        <a href="<?= base_url('admin/kamar') ?>" class="btn-back">
            <i class="fa fa-arrow-left"></i>
            Kembali
        </a>

    </div>

    <div class="card detail-card">

        <!-- GRID -->
        <div class="detail-grid">

            <!-- LEFT -->
            <div>

                <!-- MAIN IMAGE -->
                <?php if (!empty($kamar->images)): ?>

                    <img
                        id="mainImg"
                        src="<?= base_url('assets/uploads/content/'.$kamar->images[0]->image) ?>"
                        class="main-img"
                        alt="Kamar <?= $kamar->room_number ?>">

                <?php else: ?>

                    <img
                        id="mainImg"
                        src="<?= base_url('assets/uploads/content/default.png') ?>"
                        class="main-img"
                        alt="Kamar <?= $kamar->room_number ?>">

                <?php endif; ?>

                <!-- THUMB -->
                <div class="thumb-wrap">

                    <?php if (!empty($kamar->images)): ?>

                        <?php foreach($kamar->images as $img): ?>

                            <img
                                src="<?= base_url('assets/uploads/content/'.$img->image) ?>"
                                class="thumb"
                                onclick="changeImage(this.src)"
                                alt="Thumbnail Kamar">

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="info-side">

                <div class="info-box">
                    <label>ID Kamar</label>
                    <p>#<?= $kamar->id_room ?></p>
                </div>

                <div class="info-box">
                    <label>Nomor Kamar</label>
                    <p><?= $kamar->room_number ?></p>
                </div>

                <div class="info-box">
                    <label>Harga</label>
                    <p class="price">
                        Rp <?= number_format($kamar->price, 0, ',', '.') ?>
                        <small>/ bulan</small>
                    </p>
                </div>

                <div class="info-box">
                    <label>Rating</label>
                    <p>
                        ⭐ <?= number_format($kamar->avg_rating ?: 0, 1) ?>
                        (<?= $kamar->total_review ?> review)
                    </p>
                </div>

                <div class="admin-action-box">
                    <a
                        href="<?= base_url('admin/kamar') ?>"
                        class="btn-manage">
                        <i class="fa fa-list"></i>
                        Kembali ke Manajemen Kamar
                    </a>
                </div>

            </div>

        </div>

        <!-- REVIEW -->
        <hr>

        <h3>
            <i class="fa fa-comment"></i>
            Review Pengguna
        </h3>

        <?php if ($kamar->reviews): ?>

            <?php foreach($kamar->reviews as $r): ?>

                <div class="review-box">

                    <div class="review-head">
                        <b><?= $r->name ?></b>
                        <span>⭐ <?= $r->rating ?></span>
                    </div>

                    <p><?= $r->review ?></p>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-review">
                Belum ada review.
            </div>

        <?php endif; ?>

    </div>

</div>

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
    margin:1.5em 0 0 0;
}

.booking-header h2{
    margin:0;
    font-size:28px;
}

.booking-header p{
    margin-top:5px;
    color:#777;
}

/* CARD */
.detail-card{
    border-radius:18px;
    padding:25px;
    background:#fff;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* GRID */
.detail-grid{
    display:grid;
    grid-template-columns:1fr 360px;
    gap:35px;
}

/* IMAGE */
.main-img{
    width:100%;
    height:450px;
    object-fit:cover;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.thumb-wrap{
    display:flex;
    gap:12px;
    margin-top:15px;
    flex-wrap:wrap;
}

.thumb{
    width:100px;
    height:75px;
    object-fit:cover;
    border-radius:10px;
    cursor:pointer;
    border:2px solid transparent;
    transition:0.3s;
}

.thumb:hover{
    border-color:#007bff;
    transform:scale(1.05);
}

/* INFO */
.info-side{
    display:flex;
    flex-direction:column;
    gap:15px;
}

.info-box{
    background:#f9f9f9;
    padding:15px;
    border-radius:12px;
}

.info-box label{
    display:block;
    color:#888;
    font-size:13px;
    margin-bottom:5px;
}

.info-box p{
    margin:0;
    font-size:18px;
    font-weight:600;
}

.price{
    color:#28a745;
}

.price small{
    font-size:13px;
    color:#777;
    font-weight:normal;
}

/* ACTION */
.admin-action-box{
    margin-top:5px;
}

.btn-back,
.btn-manage{
    border:none;
    border-radius:12px;
    color:#fff;
    cursor:pointer;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.btn-back{
    background:#007bff;
    padding:13px 18px;
}

.btn-manage{
    display:block;
    text-align:center;
    background:linear-gradient(135deg,#17a2b8,#138496);
    padding:14px;
}

.btn-back:hover,
.btn-manage:hover{
    transform:translateY(-2px);
}

/* REVIEW */
.review-box{
    background:#fafafa;
    padding:18px;
    border-radius:12px;
    margin-top:15px;
}

.review-head{
    display:flex;
    justify-content:space-between;
    margin-bottom:8px;
}

.empty-review{
    padding:20px;
    background:#f5f5f5;
    border-radius:10px;
    text-align:center;
    color:#777;
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

    .main-img{
        height:300px;
    }

}
</style>

<script>
function changeImage(src){
    document.getElementById('mainImg').src = src;
}
</script>
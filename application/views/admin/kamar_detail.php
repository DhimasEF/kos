<?php $this->load->view('admin/sidebar'); ?>

<div class="content">
<div class="card">

<a href="<?= base_url('admin/kamar') ?>" class="btn-back">
← Kembali
</a>

<h2>
<i class="fa fa-bed"></i>
Detail Kamar <?= $kamar->room_number ?>
</h2>

<div class="detail-grid">

    <!-- KIRI -->
    <div>

        <!-- MAIN IMAGE -->
        <?php if (!empty($kamar->images)): ?>
            <img id="mainImg"
                 src="<?= base_url('assets/uploads/content/'.$kamar->images[0]->image) ?>"
                 class="main-img">
        <?php else: ?>
            <img id="mainImg"
                 src="<?= base_url('assets/uploads/content/default.png') ?>"
                 class="main-img">
        <?php endif; ?>

        <!-- THUMBNAIL -->
        <div class="thumb-wrap">
            <?php foreach($kamar->images as $img): ?>
                <img
                    src="<?= base_url('assets/uploads/content/'.$img->image) ?>"
                    class="thumb"
                    onclick="changeImage(this.src)">
            <?php endforeach; ?>
        </div>

    </div>

    <!-- KANAN -->
    <div>

        <p><b>ID:</b> <?= $kamar->id_room ?></p>
        <p><b>Nomor:</b> <?= $kamar->room_number ?></p>
        <p><b>Harga:</b> Rp <?= number_format($kamar->price) ?></p>

        <p>
            <b>Rating:</b>
            ⭐ <?= number_format($kamar->avg_rating ?: 0,1) ?>
            (<?= $kamar->total_review ?> review)
        </p>

        <br>

        <a href="<?= base_url('admin/kamar') ?>" class="btn-back">
            Kembali
        </a>

    </div>

</div>

<hr>

<h3><i class="fa fa-comment"></i> Review Pengguna</h3>

<?php if ($kamar->reviews): ?>
    <?php foreach($kamar->reviews as $r): ?>
        <div class="review-box">
            <b><?= $r->name ?></b>
            <span>⭐ <?= $r->rating ?></span>
            <p><?= $r->review ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Belum ada review.</p>
<?php endif; ?>

</div>
</div>

<style>
.detail-grid{
    display:grid;
    grid-template-columns:1fr 350px;
    gap:30px;
}

.main-img{
    width:100%;
    height:420px;
    object-fit:cover;
    border-radius:12px;
}

.thumb-wrap{
    display:flex;
    gap:10px;
    margin-top:10px;
    flex-wrap:wrap;
}

.thumb{
    width:90px;
    height:70px;
    object-fit:cover;
    border-radius:8px;
    cursor:pointer;
    border:2px solid #eee;
}

.thumb:hover{
    border:2px solid #007bff;
}

.review-box{
    background:#f9f9f9;
    padding:15px;
    margin-bottom:10px;
    border-radius:10px;
}

.btn-back{
    background:#007bff;
    color:white;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
}
</style>

<script>
function changeImage(src){
    document.getElementById('mainImg').src = src;
}
</script>
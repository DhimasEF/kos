<?php $this->load->view('user/sidebar'); ?>

<div class="content">
    <div class="card">

        <h2>Detail Kamar</h2>

        <p><b>ID:</b> <?= $kamar->id_room ?></p>
        <p><b>Nomor:</b> <?= $kamar->room_number ?></p>
        <p><b>Harga:</b> Rp <?= number_format($kamar->price) ?></p>

        <br>

        <a href="<?= base_url('user/kamar') ?>" class="btn">Kembali</a>

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
</style>

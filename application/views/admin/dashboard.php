<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

    <div class="card">
        <h3>Profil Saya</h3>
        <p><b>Nama:</b> <?= $this->session->userdata('name'); ?></p>
        <p><b>Email:</b> <?= $this->session->userdata('email'); ?></p>
        <p><b>Role:</b> <?= $this->session->userdata('role'); ?></p>

        <button class="btn">Edit Profil</button>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3><?= $total_kamar ?></h3>
            <p>Kamar</p>
        </div>

        <div class="stat-box">
            <h3><?= $total_booking ?></h3>
            <p>Booking</p>
        </div>

        <div class="stat-box">
            <h3><?= $total_user ?></h3>
            <p>User</p>
        </div>
    </div>

</div>

<!-- <?php $this->load->view('layout/footer'); ?> -->
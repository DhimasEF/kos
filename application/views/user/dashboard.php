<?php $this->load->view('user/sidebar'); ?>
<h2>Dashboard User</h2>
<div class="content">

    <div class="card">
        <h3>Profil Saya</h3>
        <p><b>Nama:</b> <?= $this->session->userdata('name'); ?></p>
        <p><b>Email:</b> <?= $this->session->userdata('email'); ?></p>
        <p><b>Role:</b> <?= $this->session->userdata('role'); ?></p>

        <button class="btn">Edit Profil</button>
    </div>
</div>
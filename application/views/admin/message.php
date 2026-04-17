<?php $this->load->view('admin/sidebar'); ?>
<?php if (empty($rooms)): ?>
    <p style="color:gray;">Belum ada chat masuk</p>
<?php endif; ?>

<?php foreach ($rooms as $r): ?>
<div class="room">

    <b><?= $r->name ?></b>

    <p style="color:gray;">
        <?= $r->last_message ? $r->last_message : 'Belum ada pesan' ?>
    </p>

    <?php if ($r->unread > 0): ?>
        <span class="badge"><?= $r->unread ?></span>
    <?php endif; ?>

    <a href="<?= base_url('admin/chat/'.$r->id_user) ?>">Buka</a>

</div>
<?php endforeach; ?>
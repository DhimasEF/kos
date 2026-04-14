<?php $this->load->view('admin/sidebar'); ?>
<h2>Manajemen User</h2>

<?php foreach ($user as $u): ?>
<p><?= $u->id_user ?> - <?= $u->email ?></p>
<?php endforeach; ?>
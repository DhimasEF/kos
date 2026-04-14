<?php $this->load->view('admin/sidebar'); ?>
<h2>Manajemen Message</h2>

<?php foreach ($message as $m): ?>
<p><?= $m->id ?> - <?= $m->pesan ?></p>
<?php endforeach; ?>
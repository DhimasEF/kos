<?php $this->load->view('admin/sidebar'); ?>
<h2>Manajemen Payment</h2>

<?php foreach ($payment as $p): ?>
<p><?= $p->id ?> - <?= $p->total ?> - <?= $p->status ?></p>
<?php endforeach; ?>
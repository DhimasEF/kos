<?php $this->load->view('admin/sidebar'); ?>
<h2>Manajemen Booking</h2>

<?php foreach ($booking as $b): ?>
<p><?= $b->id ?> - <?= $b->user_id ?> - <?= $b->status ?></p>
<?php endforeach; ?>
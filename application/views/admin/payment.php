<?php $this->load->view('admin/sidebar'); ?>

<h2>Manajemen Payment</h2>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>Kamar</th>
        <th>Tanggal</th>
        <th>Metode</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($payment as $p): ?>
    <tr>
        <td><?= $p->room_number ?></td>
        <td><?= $p->payment_date ?></td>
        <td><?= $p->payment_method ?></td>

        <td>
            <?php if ($p->payment_status == 'paid'): ?>
                <span style="color:orange;">Menunggu</span>
            <?php elseif ($p->payment_status == 'verified'): ?>
                <span style="color:green;">Terverifikasi</span>
            <?php else: ?>
                <span style="color:red;">Ditolak</span>
            <?php endif; ?>
        </td>

        <td>
            <a href="<?= base_url('admin/payment_detail/'.$p->id_payment) ?>">Detail</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
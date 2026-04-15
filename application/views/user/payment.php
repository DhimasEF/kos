<?php $this->load->view('user/sidebar'); ?>

<div class="content">
    <div class="card">

        <h2><i class="fa fa-credit-card"></i> Pembayaran Saya</h2>

        <table style="width:100%; border-collapse:collapse;">
            <tr style="background:#f1f1f1;">
                <th>Kamar</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($payment as $p): ?>
            <tr style="border-bottom:1px solid #ddd;">
                <td><?= $p->room_number ?></td>
                <td><?= $p->payment_date ?></td>
                <td><?= $p->payment_method ?? '-' ?></td>

                <td>
                    <?php if ($p->payment_status == 'paid'): ?>
                        <span class="status pending">Menunggu Verifikasi</span>
                    <?php elseif ($p->payment_status == 'verified'): ?>
                        <span class="status approved">Terverifikasi</span>
                    <?php else: ?>
                        <span class="status rejected">Gagal</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="<?= base_url('user/payment_detail/'.$p->id_booking) ?>" class="btn">
                        Detail
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>

    </div>
</div>
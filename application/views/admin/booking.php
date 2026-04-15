<?php $this->load->view('admin/sidebar'); ?>

<div class="content">
    <div class="card">

        <h2><i class="fa fa-calendar"></i> Manajemen Booking</h2>

        <br>

        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f1f1f1;">
                    <th>ID</th>
                    <th>User</th>
                    <th>Kamar</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($booking as $b): ?>
                <tr style="border-bottom:1px solid #ddd;">
                    <td><?= $b->id_booking ?></td>
                    <td><?= $b->name ?></td>
                    <td><?= $b->room_number ?></td>
                    <td><?= $b->start_at ?></td>

                    <!-- STATUS -->
                    <td>
                        <?php if ($b->status == 'pending'): ?>
                            <span class="status pending">
                                <i class="fa fa-clock"></i> Pending
                            </span>

                        <?php elseif ($b->status == 'approved'): ?>
                            <span class="status approved">
                                <i class="fa fa-check"></i> Approved
                            </span>

                        <?php else: ?>
                            <span class="status rejected">
                                <i class="fa fa-times"></i> Rejected
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- AKSI -->
                    <td>

                        <?php if ($b->status == 'pending'): ?>

                            <a href="<?= base_url('admin/booking_approve/'.$b->id_booking) ?>" class="btn-approve">
                                <i class="fa fa-check"></i>
                            </a>

                            <a href="<?= base_url('admin/booking_reject/'.$b->id_booking) ?>" class="btn-reject">
                                <i class="fa fa-times"></i>
                            </a>

                        <?php else: ?>
                            <i>-</i>
                        <?php endif; ?>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<style>
table th, table td {
    padding:10px;
    text-align:left;
}

/* STATUS */
.status {
    padding:6px 10px;
    border-radius:6px;
    color:white;
}

.status.pending {
    background:#ffc107;
    color:black;
}

.status.approved {
    background:#28a745;
}

.status.rejected {
    background:#dc3545;
}

/* BUTTON */
.btn-approve {
    background:#28a745;
    color:white;
    padding:6px 8px;
    border-radius:5px;
}

.btn-reject {
    background:#dc3545;
    color:white;
    padding:6px 8px;
    border-radius:5px;
}
</style>

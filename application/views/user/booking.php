<?php $this->load->view('user/sidebar'); ?>
<div class="content">
    <div class="card">

        <!-- HEADER -->
        <h2><i class="fa fa-bed"></i> Daftar Kamar</h2>

        <br>

        <!-- TABLE -->
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f1f1f1;">
                    <th>ID</th>
                    <th>Nomor Kamar</th>
                    <th>Status</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($kamar as $k): ?>
                <tr style="border-bottom:1px solid #ddd;">
                    <td><?= $k->id_room ?></td>
                    <td><?= $k->room_number ?></td>
                    <td><?= $k->status ?></td>
                    <td>Rp <?= number_format($k->price) ?></td>
                    <td>

                        <!-- DETAIL BUTTON -->
                        <a href="<?= base_url('user/booking_detail/'.$k->id_room) ?>" class="btn-detail">
                            <i class="fa fa-eye"></i> Detail
                        </a>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<style>
table th, table td {
    padding: 10px;
    text-align: left;
}

.btn-detail {
    background: #17a2b8;
    color: white;
    padding: 6px 10px;
    border-radius: 5px;
    text-decoration: none;
}
</style>

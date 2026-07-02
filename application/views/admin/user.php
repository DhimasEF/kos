<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

    <!-- HEADER -->
    <div class="page-header">
        <h2>
            <i class="fa fa-users"></i>
            Manajemen User
        </h2>

        <p>
            Kelola dan pantau data pengguna yang terdaftar.
        </p>
    </div>

    <!-- USER GRID -->
    <div class="user-grid">

        <?php if (!empty($users)): ?>

            <?php foreach ($users as $u): ?>

                <?php
                    $default_foto = base_url('assets/uploads/profile/default.jpg');
                    $foto = !empty($u->profil_picture)
                        ? base_url('assets/uploads/profile/'.$u->profil_picture)
                        : $default_foto;
                ?>

                <div class="user-card">

                    <div class="user-main">

                        <img
                            src="<?= $foto ?>"
                            class="user-photo"
                            alt="<?= !empty($u->name) ? $u->name : 'User' ?>">

                        <div class="user-info">
                            <h3>
                                <?= !empty($u->name) ? $u->name : 'User' ?>
                            </h3>

                            <p>
                                <?= $u->email ?>
                            </p>
                        </div>

                    </div>

                    <div class="user-meta">

                        <span class="user-id">
                            #<?= $u->id_user ?>
                        </span>

                        <span class="role">
                            <?= !empty($u->role) ? ucfirst($u->role) : 'User' ?>
                        </span>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-user">
                <i class="fa fa-users-slash"></i>
                <h3>Belum Ada User</h3>
                <p>Data pengguna akan tampil di sini.</p>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* HEADER */
.page-header{
    margin:1.5em 0 25px;
}

.page-header h2{
    font-size:28px;
    margin:0 0 5px;
    color:#222;
}

.page-header p{
    margin:0;
    color:#777;
}

/* GRID */
.user-grid{
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:18px;
}

/* CARD */
.user-card{
    background:#fff;
    border-radius:18px;
    padding:18px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
    transition:.3s;
}

.user-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.user-main{
    display:flex;
    align-items:center;
    gap:15px;
    min-width:0;
}

.user-photo{
    width:64px;
    height:64px;
    border-radius:16px;
    object-fit:cover;
    flex-shrink:0;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.user-info{
    min-width:0;
}

.user-info h3{
    margin:0;
    font-size:18px;
    color:#222;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.user-info p{
    margin:6px 0 0;
    color:#777;
    font-size:14px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.user-meta{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    margin-top:18px;
}

.user-id{
    background:#f8f9fa;
    color:#777;
    padding:8px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:bold;
}

.role{
    display:inline-block;
    background:#f5fbff;
    border-left:4px solid #007bff;
    color:#007bff;
    padding:8px 13px;
    border-radius:10px;
    font-size:13px;
    font-weight:bold;
}

/* EMPTY */
.empty-user{
    grid-column:1 / -1;
    background:#fff;
    padding:60px 30px;
    border-radius:18px;
    text-align:center;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
}

.empty-user i{
    font-size:60px;
    color:#ccc;
    margin-bottom:15px;
}

.empty-user h3{
    margin-bottom:10px;
    color:#444;
}

.empty-user p{
    color:#777;
}

/* RESPONSIVE */
@media(max-width:900px){

    .user-grid{
        grid-template-columns:1fr;
    }

}
</style>
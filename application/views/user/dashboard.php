<div class="content">

    <h2>Dashboard User</h2>

    <?php
        $default_foto = base_url('assets/img/default.png');
        $foto = !empty($user->profil_picture)
            ? base_url('./assets/uploads/profile/'.$user->profil_picture)
            : $default_foto;
    ?>

    <!-- PROFILE CARD -->
    <div class="card profile-card">
        <div class="profile-left">
            <img src="<?= $foto ?>" class="pp">
        </div>

        <div class="profile-right">
            <h3><?= $user->name ?></h3>
            <p><?= $user->email ?></p>
            <span class="role"><?= ucfirst($user->role) ?></span>

            <br><br>

            <button class="btn" onclick="openModal()">Edit Profil</button>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats">

        <div class="stat-box">
            <h2><?= $total_booking ?></h2>
            <p>Total Booking</p>
        </div>

        <div class="stat-box green">
            <h2><?= $booking_active ?></h2>
            <p>Sedang Menyewa</p>
        </div>

    </div>

</div>

<!-- MODAL EDIT -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h3>Edit Profil</h3>

        <form method="post" action="<?= base_url('user/update_profile') ?>" enctype="multipart/form-data">

            <label>Nama</label>
            <input type="text" name="name" value="<?= $user->name ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= $user->email ?>" required>

            <label>Foto</label>
            <input type="file" name="foto">

            <br>

            <button type="submit" class="btn">Simpan</button>
            <button type="button" class="btn danger" onclick="closeModal()">Batal</button>

        </form>
    </div>
</div>

<style>
    /* CARD */
.card {
    background: white;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

/* PROFILE CARD */
.profile-card {
    display: flex;
    align-items: center;
    gap: 20px;
}

.pp {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
}

.role {
    background: #007bff;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
}

/* STATS */
.stats {
    display: flex;
    gap: 20px;
}

.stat-box {
    flex: 1;
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    color: white;
    padding: 25px;
    border-radius: 14px;
    text-align: center;
}

.stat-box.green {
    background: linear-gradient(45deg, #00b09b, #96c93d);
}

/* BUTTON */
.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    background: #007bff;
    color: white;
    cursor: pointer;
}

.btn.danger {
    background: red;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 12px;
    width: 400px;
    margin: 100px auto;
}

.modal-content input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
}
</style>

<script>
function openModal() {
    document.getElementById('modalEdit').style.display = 'block';
}

function closeModal() {
    document.getElementById('modalEdit').style.display = 'none';
}
</script>
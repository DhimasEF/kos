<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

    <div class="dashboard-wrapper">

        <!-- HEADER -->
        <div class="dashboard-header">
            <div>
                <h2>
                    <i class="fa fa-home"></i>
                    Dashboard Admin
                </h2>

                <p>
                    Ringkasan profil admin, data kamar, booking, dan pengguna.
                </p>
            </div>
        </div>

        <?php
            $admin_name  = $this->session->userdata('name') ?: 'Admin';
            $admin_email = $this->session->userdata('email') ?: '-';
            $admin_role  = $this->session->userdata('role') ?: 'admin';
        ?>

        <!-- PROFILE CARD -->
        <div class="card profile-card">

            <div class="profile-left">
                <div class="admin-avatar">
                    <i class="fa fa-user-shield"></i>
                </div>
            </div>

            <div class="profile-right">

                <div>
                    <h3><?= $admin_name ?></h3>
                    <p><?= $admin_email ?></p>

                    <span class="role">
                        <?= ucfirst($admin_role) ?>
                    </span>
                </div>

                <button type="button" class="btn-primary" onclick="openModal()">
                    <i class="fa fa-edit"></i>
                    Edit Profil
                </button>

            </div>

        </div>

        <!-- STATS -->
        <div class="stats">

            <div class="stat-box">
                <div class="stat-icon">
                    <i class="fa fa-bed"></i>
                </div>

                <div>
                    <h2><?= $total_kamar ?></h2>
                    <p>Total Kamar</p>
                </div>
            </div>

            <div class="stat-box green">
                <div class="stat-icon">
                    <i class="fa fa-calendar-check"></i>
                </div>

                <div>
                    <h2><?= $total_booking ?></h2>
                    <p>Total Booking</p>
                </div>
            </div>

            <div class="stat-box purple">
                <div class="stat-icon">
                    <i class="fa fa-users"></i>
                </div>

                <div>
                    <h2><?= $total_user ?></h2>
                    <p>Total User</p>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- MODAL EDIT -->
<div id="modalEdit" class="modal">
    <div class="modal-content">

        <h3>
            <i class="fa fa-user-edit"></i>
            Edit Profil
        </h3>

        <form method="post" action="<?= base_url('admin/update_profile') ?>">

            <label>Nama</label>
            <input
                type="text"
                name="name"
                value="<?= $admin_name ?>"
                required>

            <label>Email</label>
            <input
                type="email"
                name="email"
                value="<?= $admin_email ?>"
                required>

            <button type="submit" class="btn-save">
                Simpan
            </button>

            <button type="button" class="btn-close" onclick="closeModal()">
                Batal
            </button>

        </form>

    </div>
</div>

<style>
/* WRAPPER */
.dashboard-wrapper{
    display:flex;
    flex-direction:column;
    gap:20px;
}

/* HEADER */
.dashboard-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:1.5em 0 0 0;
}

.dashboard-header h2{
    margin:0;
    font-size:28px;
}

.dashboard-header p{
    margin-top:5px;
    color:#777;
}

/* CARD */
.card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* PROFILE */
.profile-card{
    display:flex;
    align-items:center;
    gap:25px;
}

.profile-left{
    flex-shrink:0;
}

.admin-avatar{
    width:105px;
    height:105px;
    border-radius:18px;
    background:linear-gradient(135deg,#007bff,#0056d2);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:42px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.profile-right{
    flex:1;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
}

.profile-right h3{
    margin:0;
    font-size:24px;
}

.profile-right p{
    margin:6px 0 12px;
    color:#777;
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

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
}

.stat-box{
    display:flex;
    align-items:center;
    gap:18px;
    background:linear-gradient(135deg,#007bff,#0056d2);
    color:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.stat-box.green{
    background:linear-gradient(135deg,#28a745,#1f8f3a);
}

.stat-box.purple{
    background:linear-gradient(135deg,#6f42c1,#563d7c);
}

.stat-icon{
    width:58px;
    height:58px;
    border-radius:16px;
    background:rgba(255,255,255,0.18);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.stat-box h2{
    margin:0;
    font-size:32px;
}

.stat-box p{
    margin:5px 0 0;
    opacity:.9;
    font-weight:600;
}

/* BUTTON */
.btn-primary,
.btn-save,
.btn-close{
    border:none;
    border-radius:12px;
    padding:13px 18px;
    cursor:pointer;
    font-weight:bold;
    transition:.3s;
}

.btn-primary,
.btn-save{
    color:#fff;
    background:#007bff;
}

.btn-primary{
    white-space:nowrap;
}

.btn-save{
    width:100%;
    margin-top:10px;
}

.btn-close{
    width:100%;
    margin-top:12px;
    background:#eee;
    color:#333;
}

.btn-primary:hover,
.btn-save:hover,
.btn-close:hover{
    transform:translateY(-2px);
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    z-index:999;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.55);
}

.modal-content{
    background:#fff;
    width:420px;
    max-width:92%;
    margin:80px auto;
    padding:25px;
    border-radius:18px;
    animation:fadeIn .3s ease;
}

.modal-content h3{
    margin-top:0;
    margin-bottom:20px;
}

.modal-content label{
    display:block;
    color:#555;
    font-weight:bold;
    margin-bottom:8px;
}

.modal-content input{
    width:94%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
    margin-bottom:18px;
}

.modal-content input:focus{
    outline:none;
    border-color:#007bff;
    box-shadow:0 0 0 4px rgba(0,123,255,0.08);
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(-20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* RESPONSIVE */
@media(max-width:1000px){
    .stats{
        grid-template-columns:1fr;
    }
}

@media(max-width:768px){

    .dashboard-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .profile-card{
        align-items:flex-start;
    }

    .profile-right{
        flex-direction:column;
        align-items:flex-start;
    }

    .btn-primary{
        width:100%;
    }

}
</style>

<script>
function openModal(){
    document.getElementById('modalEdit').style.display = 'block';
}

function closeModal(){
    document.getElementById('modalEdit').style.display = 'none';
}

window.onclick = function(e){
    const modalEdit = document.getElementById('modalEdit');

    if(e.target == modalEdit){
        closeModal();
    }
}
</script>
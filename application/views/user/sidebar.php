<!DOCTYPE html>
<html>
<head>
    <!-- 🟢 Menggunakan variabel $title secara dinamis pada tab browser -->
    <title><?= isset($title) ? $title : 'User Panel' ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/resources/icon.png') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial;
            display: flex;
            background: #f4f6f9;
        }

        .content {
            margin-left: 260px;
            padding: 0 30px 0 0;
            width: 100%;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #00c6ff, #0072ff);
            color: white;
            padding: 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
            box-sizing: border-box; /* Diselaraskan */
        }

        /* PROFILE */
        .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile img {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
            background: rgba(255,255,255,0.2);
        }

        .profile h3 {
            margin: 10px 0 5px;
        }

        .profile p {
            margin: 0;
            font-size: 14px;
            opacity: 0.85;
        }

        /* MENU */
        .menu {
            margin-top: 20px;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: 0.3s;
        }

        /* Merapikan lebar icon agar sejajar */
        .menu a i {
            width: 22px; 
        }

        .menu a:hover {
            background: rgba(255,255,255,0.2);
        }

        /* 🟢 CSS UNTUK MENU AKTIF / HIGHLIGHT */
        .menu a.active {
            background: rgba(255, 255, 255, 0.25);
            font-weight: bold;
            box-shadow: inset 4px 0 0 white;
            padding-left: 12px;
        }

        /* LOGOUT */
        .logout {
            margin: auto 0 15px 0;
            text-decoration: none;
            color: #ffecec;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s; /* Diselaraskan */
        }

        .logout:hover {
            background: rgba(255,0,0,0.2);
        }

        /* GLOBAL USER UI (Diselaraskan) */
        .card {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

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

        .btn {
            padding: 10px 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>

<?php
    // fallback foto default
    $default_foto = base_url('assets/img/default.png');

    // cek foto dari DB
    if (!empty($user->profil_picture)) {
        $foto = base_url('./assets/uploads/profile/'.$user->profil_picture);
    } else {
        $foto = $default_foto;
    }

    $user_name = !empty($user->name)
        ? $user->name
        : 'User';

    $user_role = !empty($user->role)
        ? ucfirst($user->role)
        : 'User';

    // 🟢 Memecah title untuk mengetahui menu yang aktif saat ini (misal "Kamar | List Kamar" -> diambil "Kamar")
    $current_menu = isset($title) ? explode(' | ', $title)[0] : '';
?>

<div class="sidebar">

    <!-- PROFILE -->
    <div class="profile">
        <img src="<?= $foto ?>" alt="Profile Picture">

        <h3>
            <?= $user_name ?>
        </h3>

        <p>
            <?= $user_role ?>
        </p>
    </div>

    <!-- MENU -->
    <div class="menu">
        <!-- 🟢 Deteksi Class Active menggunakan variabel $current_menu -->
        <a href="<?= base_url('user/dashboard') ?>" class="<?= $current_menu == 'Dashboard' ? 'active' : '' ?>">
            <i class="fa fa-home"></i> 
            Dashboard
        </a>
        
        <a href="<?= base_url('user/kamar') ?>" class="<?= $current_menu == 'Kamar' ? 'active' : '' ?>">
            <i class="fa fa-bed"></i> 
            Kamar
        </a>
        
        <a href="<?= base_url('user/booking') ?>" class="<?= $current_menu == 'Booking' ? 'active' : '' ?>">
            <i class="fa fa-calendar"></i> 
            Booking
        </a>
        
        <a href="<?= base_url('user/payment') ?>" class="<?= $current_menu == 'Payment' ? 'active' : '' ?>">
            <i class="fa fa-credit-card"></i> 
            Payment
        </a>
        
        <a href="<?= base_url('user/message') ?>" class="<?= $current_menu == 'Message' ? 'active' : '' ?>">
            <i class="fa fa-envelope"></i> 
            Message
        </a>
    </div>

    <!-- LOGOUT -->
    <a href="<?= base_url('auth/logout') ?>" class="logout">
        <i class="fa fa-sign-out-alt"></i> 
        Logout
    </a>

</div>
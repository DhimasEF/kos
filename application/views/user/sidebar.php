<!DOCTYPE html>
<html>
<head>
    <title>User Panel</title>

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
            padding: 0 30px 30px 30px;
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

        .menu a:hover {
            background: rgba(255,255,255,0.2);
        }

        /* LOGOUT */
        .logout {
            margin: auto 0 15px 0;
            text-decoration: none;
            color: #ffecec;
            padding: 12px;
            border-radius: 8px;
        }

        .logout:hover {
            background: rgba(255,0,0,0.2);
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
?>

<div class="sidebar">

    <!-- PROFILE -->
    <div class="profile">
        <img src="<?= $foto ?>">

        <h3>
            <?= !empty($user->name) ? $user->name : 'User' ?>
        </h3>

        <p>
            <?= !empty($user->role) ? ucfirst($user->role) : 'User' ?>
        </p>
    </div>

    <!-- MENU -->
    <div class="menu">
        <a href="<?= base_url('user/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
        <a href="<?= base_url('user/kamar') ?>"><i class="fa fa-bed"></i> Kamar</a>
        <a href="<?= base_url('user/booking') ?>"><i class="fa fa-calendar"></i> Booking</a>
        <a href="<?= base_url('user/payment') ?>"><i class="fa fa-credit-card"></i> Payment</a>
        <a href="<?= base_url('user/message') ?>"><i class="fa fa-envelope"></i> Message</a>
    </div>

    <!-- LOGOUT -->
    <a href="<?= base_url('auth/logout') ?>" class="logout">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>

</div>
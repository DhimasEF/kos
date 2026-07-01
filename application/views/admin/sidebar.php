<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

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
            box-sizing: border-box;
        }

        /* PROFILE */
        .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-icon {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            border: 3px solid white;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 38px;
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

        .menu a i {
            width: 22px;
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
            transition: 0.3s;
        }

        .logout:hover {
            background: rgba(255,0,0,0.2);
        }

        /* GLOBAL ADMIN UI */
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
    $admin_name = !empty($user->name)
        ? $user->name
        : 'Admin';

    $admin_role = !empty($user->role)
        ? ucfirst($user->role)
        : 'Admin';
?>

<div class="sidebar">

    <!-- PROFILE -->
    <div class="profile">

        <div class="profile-icon">
            <i class="fa fa-user-shield"></i>
        </div>

        <h3>
            <?= $admin_name ?>
        </h3>

        <p>
            <?= $admin_role ?>
        </p>

    </div>

    <!-- MENU -->
    <div class="menu">
        <a href="<?= base_url('admin/dashboard') ?>">
            <i class="fa fa-home"></i>
            Dashboard
        </a>

        <a href="<?= base_url('admin/kamar') ?>">
            <i class="fa fa-bed"></i>
            Kamar
        </a>

        <a href="<?= base_url('admin/booking') ?>">
            <i class="fa fa-calendar"></i>
            Booking
        </a>

        <a href="<?= base_url('admin/payment') ?>">
            <i class="fa fa-credit-card"></i>
            Payment
        </a>

        <a href="<?= base_url('admin/message') ?>">
            <i class="fa fa-envelope"></i>
            Message
        </a>

        <a href="<?= base_url('admin/user') ?>">
            <i class="fa fa-users"></i>
            User
        </a>
    </div>

    <!-- LOGOUT -->
    <a href="<?= base_url('auth/logout') ?>" class="logout">
        <i class="fa fa-sign-out-alt"></i>
        Logout
    </a>

</div>
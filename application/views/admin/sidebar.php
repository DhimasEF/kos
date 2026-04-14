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
            margin-left: 240px;
            padding: 30px;
            width: 100%;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            gap: 20px;
        }

        .stat-box {
            flex: 1;
            background: #007bff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .btn {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="sidebar" style="width:220px;height:100vh;background:#1e1e2f;color:white;padding:20px;position:fixed;">
    
    <h2 style="text-align:center;">Admin</h2>

    <div class="menu">
        <a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
        <a href="<?= base_url('admin/kamar') ?>"><i class="fa fa-bed"></i> Kamar</a>
        <a href="<?= base_url('admin/booking') ?>"><i class="fa fa-calendar"></i> Booking</a>
        <a href="<?= base_url('admin/payment') ?>"><i class="fa fa-credit-card"></i> Payment</a>
        <a href="<?= base_url('admin/message') ?>"><i class="fa fa-envelope"></i> Message</a>
        <a href="<?= base_url('admin/user') ?>"><i class="fa fa-users"></i> User</a>
    </div>

    <br>

    <a href="<?= base_url('auth/logout') ?>" style="color:red;">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>
</div>

<style>
.menu a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 10px;
    margin-bottom: 8px;
    border-radius: 6px;
}

.menu a:hover {
    background: #007bff;
}
</style>
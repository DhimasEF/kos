<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if($this->session->flashdata('error')): ?>
    <p style="color:red"><?= $this->session->flashdata('error'); ?></p>
<?php endif; ?>

<form method="post" action="<?= base_url('auth/login'); ?>">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

</body>
</html>
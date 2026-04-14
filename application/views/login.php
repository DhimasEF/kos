<!DOCTYPE html>
<html>
<head>
    <title>Auth</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f0f2f5;
        }

        .container {
            width: 800px;
            height: 500px;
            margin: 50px auto;
            position: relative;
            overflow: hidden;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .form-container {
            position: absolute;
            width: 50%;
            height: 100%;
            top: 0;
            transition: 0.5s;
            padding: 40px;
        }

        .login {
            left: 0;
        }

        .register {
            left: 100%;
        }

        .overlay {
            position: absolute;
            width: 50%;
            height: 100%;
            top: 0;
            left: 50%;
            background: #007bff;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: 0.5s;
        }

        .container.active .login {
            left: -100%;
        }

        .container.active .register {
            left: 50%;
        }

        .container.active .overlay {
            left: 0;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .overlay button {
            background: white;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container" id="container">

    <!-- LOGIN -->
    <div class="form-container login">
        <h2>Login</h2>

        <?php if($this->session->flashdata('error')): ?>
            <p style="color:red"><?= $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <form method="post" action="<?= base_url('auth/login'); ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>

    <!-- REGISTER -->
    <div class="form-container register">
        <h2>Register</h2>

        <form method="post" action="<?= base_url('auth/register'); ?>">
            <input type="text" name="name" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>

    <!-- OVERLAY -->
    <div class="overlay">
        <h2 id="overlay-title">Hello, Friend!</h2>
        <p id="overlay-text">Belum punya akun?</p>
        <button onclick="toggle()">Register</button>
    </div>

</div>

<script>
    function toggle() {
        const container = document.getElementById('container');
        container.classList.toggle('active');

        let title = document.getElementById('overlay-title');
        let text = document.getElementById('overlay-text');

        if (container.classList.contains('active')) {
            title.innerText = "Welcome Back!";
            text.innerText = "Sudah punya akun?";
        } else {
            title.innerText = "Hello, Friend!";
            text.innerText = "Belum punya akun?";
        }
    }
</script>

</body>
</html>
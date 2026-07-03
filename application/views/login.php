<!DOCTYPE html>
<html>
<head>
    <title>Auth</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/resources/icon.png') ?>">
    <style>
        *{
            box-sizing:border-box;
        }

        body{
            font-family:Arial, sans-serif;
            margin:0;
            min-height:100vh;
            background:#f0f2f5;
            display:flex;
            justify-content:center;
            align-items:center;
            color:#222;
        }

        .container{
            width:850px;
            max-width:92%;
            min-height:520px;
            position:relative;
            overflow:hidden;
            background:#fff;
            box-shadow:0 5px 18px rgba(0,0,0,0.08);
            border-radius:18px;
        }

        .form-container{
            position:absolute;
            width:50%;
            height:100%;
            top:0;
            transition:0.5s ease;
            padding:55px 45px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            background:#fff;
        }

        .form-container h2{
            font-size:28px;
            margin:0 0 8px;
            color:#222;
        }

        .form-container .subtitle{
            color:#777;
            margin-bottom:25px;
            font-size:14px;
        }

        .login{
            left:0;
        }

        .register{
            left:100%;
        }

        .container.active .login{
            left:-100%;
        }

        .container.active .register{
            left:50%;
        }

        input{
            width:100%;
            padding:13px 15px;
            margin-bottom:15px;
            border:1px solid #ddd;
            border-radius:10px;
            font-size:14px;
            outline:none;
            transition:0.3s;
            background:#f9f9f9;
        }

        input:focus{
            border-color:#17a2b8;
            background:#fff;
            box-shadow:0 0 0 3px rgba(23,162,184,0.12);
        }

        button{
            width:100%;
            padding:13px;
            background:linear-gradient(135deg,#17a2b8,#138496);
            color:#fff;
            border:none;
            border-radius:10px;
            cursor:pointer;
            font-weight:bold;
            font-size:15px;
            transition:0.3s;
        }

        button:hover{
            background:linear-gradient(135deg,#138496,#11707f);
            transform:translateY(-2px);
        }

        .error-message{
            color:#dc3545;
            background:#fff1f1;
            padding:10px 12px;
            border-radius:10px;
            font-size:14px;
            margin-bottom:15px;
        }

        .overlay{
            position:absolute;
            width:50%;
            height:100%;
            top:0;
            left:50%;
            color:#fff;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            text-align:center;
            padding:45px;
            transition:0.5s ease;
            z-index:2;

            background:
                linear-gradient(rgba(19,132,150,0.78), rgba(17,112,127,0.82)),
                url("<?= base_url('assets/resources/bg1.jpg'); ?>");
            background-size:cover;
            background-position:center;
        }

        .container.active .overlay{
            left:0;
        }

        .overlay h2{
            font-size:30px;
            margin:0 0 10px;
        }

        .overlay p{
            font-size:15px;
            line-height:1.6;
            margin:0 0 25px;
            opacity:0.95;
        }

        .overlay button{
            width:auto;
            min-width:150px;
            background:#fff;
            color:#138496;
            border-radius:10px;
            box-shadow:0 5px 15px rgba(0,0,0,0.12);
        }

        .overlay button:hover{
            background:#f5f5f5;
        }

        @media(max-width:768px){
            body{
                padding:25px 0;
                align-items:flex-start;
            }

            .container{
                width:92%;
                min-height:auto;
                overflow:visible;
            }

            .form-container,
            .overlay{
                position:relative;
                width:100%;
                height:auto;
                left:auto !important;
            }

            .form-container{
                padding:35px 25px;
            }

            .register{
                display:none;
            }

            .container.active .login{
                display:none;
            }

            .container.active .register{
                display:flex;
            }

            .overlay{
                padding:30px 25px;
                border-radius:0 0 18px 18px;
            }

            .overlay h2{
                font-size:24px;
            }
        }
    </style>
</head>

<body>

<div class="container" id="container">

    <!-- LOGIN -->
    <div class="form-container login">
        <h2>Login</h2>
        <p class="subtitle">Masuk untuk melanjutkan booking kamar.</p>

        <?php if($this->session->flashdata('error')): ?>
            <p class="error-message"><?= $this->session->flashdata('error'); ?></p>
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
        <p class="subtitle">Buat akun baru untuk mulai booking kamar.</p>

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
        <button type="button" id="overlay-button" onclick="toggle()">Register</button>
    </div>

</div>

<script>
    function toggle() {
        const container = document.getElementById('container');
        container.classList.toggle('active');

        const title = document.getElementById('overlay-title');
        const text = document.getElementById('overlay-text');
        const button = document.getElementById('overlay-button');

        if (container.classList.contains('active')) {
            title.innerText = "Welcome Back!";
            text.innerText = "Sudah punya akun?";
            button.innerText = "Login";
        } else {
            title.innerText = "Hello, Friend!";
            text.innerText = "Belum punya akun?";
            button.innerText = "Register";
        }
    }
</script>

</body>
</html>
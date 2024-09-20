<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require 'app/config/functions.php';
require 'app/model/tb_user.php';
use App\Model\User\User;

$user = new User();
if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
    return header('location:' . getBaseUrl(''));
}
include 'app/views/layout/web_icon.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>linkme - Login</title>
    <?=webIcon()?>
    <!-- this is main css  -->
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/login.css?v=<?= time() ?>">
    <!-- this is box icon  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- this is for icon  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- this is style of swiper  -->
</head>

<body class="scroll-y">
    <!-- this Is content of page  -->
    <main class="web-main over-h">
        <div class="form-head form-head-active">
            <div class="form-body db-c scroll-y">
                <div class="head">
                    <ul class="df-c">
                        <li>
                            <h2>Welcome linkme Login 👋</h2>
                        </li>
                    </ul>
                </div>
                <form action="/login/store" method="POST" class="form-con">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <ul>
                        <li>
                            <label for="#">Username</label>
                            <div class="txt-box df-l">
                                <div class="icon icon-sm">
                                    <i class='bx bx-user'></i>
                                </div>
                                <div class="text-in">
                                    <input type="text" id="txt-email" name="<?= $user->email ?>" required class="db-c"
                                        placeholder="Enter your email or phone">
                                </div>
                                <div class="icon-leader" id="leading-email">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                        </li>
                        <li>
                            <label for="#">Password</label>
                            <div class="txt-box df-l">
                                <div class="icon icon-sm">
                                    <i class='bx bx-lock-alt'></i>
                                </div>
                                <div class="text-in">
                                    <input type="password" name="<?= $user->password ?>" class="db-c" id="txt_password"
                                        maxlength="15" placeholder="Enter your password">
                                </div>
                                <div class="icon-leader icon-leader-active curs-p" id="btn_check_password">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </div>
                            </div>
                        </li>
                        <li class="main-btn">
                            <button type="submit" class="iocn icon-sm btn">Submit</button>
                        </li>
                        <li class="text-signup">
                            <div class="df-l">
                                <p>Create new account?</p>
                                <a href="/signup/" class="left-05">Signup now.</a>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="bg"></div>
        </div>
    </main>
    <script type="text/javascript">
        var btnCheckPassword = document.querySelector('#btn_check_password');
        btnCheckPassword.addEventListener('click', function () {
            var input = document.querySelector('#txt_password');
            input.getAttribute('type') == 'password' ? input.setAttribute('type', 'text') : input.setAttribute('type', 'password');
            btnCheckPassword.classList.toggle('chang_eye');
        });
        document.getElementById('txt-email').addEventListener('input', function () {
            const input = this.value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^[0-9]{10,15}$/;

            const isEmail = emailPattern.test(input);
            const isPhone = phonePattern.test(input);

            const checkIcon = document.getElementById('leading-email');

            if (isEmail || isPhone) {
                checkIcon.classList.add('icon-leader-active');
            } else {
                checkIcon.classList.remove('icon-leader-active');
            }
        });
    </script>
</body>

</html>
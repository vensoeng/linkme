<?php
    session_start();
    require 'app/config/functions.php';
    require 'app/model/user_detail.php';
    require 'app/model/tb_user.php';
    require 'database/ui/index.php';
    use App\Model\User\User as User;
    use App\Model\UserDetail\UserDetail as UserDetail;

    $user = new User();
    $userDetail = new UserDetail();
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        return header('location: /signup');
    }
    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
        return header('location:'.getBaseUrl(''));
    }
    if (!isset($_POST[$user->email]) || !isset($_POST[$user->password]) || !isset($_POST[$user->policy_status])) {
        return header('location: /signup');
    }else{
        if(validateInput($_POST[$user->email]) !== "Email" && validateInput($_POST[$user->email]) !== "Phone"){
            ui('Enter Invalidate data Email or Phone.<br>Return to <a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now.</a>',);
            return;
        }
        if($_POST[$user->password] == ''){
            return header('location: /signup');
        }
    }
    include 'app/views/layout/web_icon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>linkme - Customlinkyours</title>
    <?=webIcon()?>
    <!-- this is main css  -->
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/main.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/login.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/loading_animation.css?v=<?=time()?>">
    <!-- this is box icon  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- this is for icon  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- this is style of swiper  -->
</head>
<body class="scroll-y">
    <!-- this Is content of page  -->
    <form action="/signup/store" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="text" hidden name="<?=$user->email?>" value="<?=$_POST[$user->email]?>" require>
        <input type="password" hidden name="<?=$user->password?>" value="<?=md5($_POST[$user->password])?>" require>
        <input type="number" hidden name="<?=$user->policy_status?>" value="<?=$_POST[$user->policy_status]?>" require>
        <main class="web-main over-h">
            <div class="form-head form-head-active">
                <div class="form-body db-c scroll-y">
                    <div class="head">
                        <ul class="df-l">
                            <li class="left-05">
                                <h2>Customization  Yourlinkme🎉</h2>
                            </li>
                        </ul>
                    </div>
                    <div class="form-con">
                        <ul>
                            <li class="user-profile profile icon iconra data-img">
                                <input type="file" name="profile" onchange="previewImage(event,'.data-img')" name="<?=$userDetail->profile?>" accept=".jpg,.png,.web,.jpeg" required>
                                <div class="profile-img">
                                    <img class="img-c" src="<?=getBaseUrl('')?>storage/upload/profile.png" alt="">
                                </div>
                                <label for="#" class="df-c">
                                    <i class='bx bx-camera'></i>
                                </label>
                            </li>
                            <li>
                                <label for="#">First name</label>
                                <div class="txt-box df-l">
                                    <div class="icon icon-sm">
                                        <i class='bx bx-circle'></i>
                                    </div>
                                    <div class="text-in">
                                        <input type="text" name="<?=$userDetail->first_name?>" class="db-c" placeholder="Enter First name"
                                        oninput="this.value !== '' ? document.querySelector('.i-lead1').classList.add('icon-leader-active') : document.querySelector('.i-lead1').classList.remove('icon-leader-active')"
                                        required>
                                    </div>
                                    <div class="icon-leader i-lead1">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <label for="#">Last name</label>
                                <div class="txt-box df-l">
                                    <div class="icon icon-sm">
                                        <i class='bx bx-circle'></i>
                                    </div>
                                    <div class="text-in">
                                        <input type="text" name="<?=$userDetail->last_name?>" class="db-c" placeholder="Enter Last name" 
                                        oninput="this.value !== '' ? document.querySelector('.i-lead2').classList.add('icon-leader-active') : document.querySelector('.i-lead2').classList.remove('icon-leader-active')"
                                        required>
                                    </div>
                                    <div class="icon-leader i-lead2">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <label for="cover">Image cover</label>
                                <div class="txt-box df-l">
                                    <div class="icon icon-sm" onclick="document.querySelector('#cover').click()">
                                        <i class='bx bx-upload'></i>
                                    </div>
                                    <div class="text-in txt-in-type-file">
                                        <input type="file" id="cover" name="<?=$userDetail->cover?>" class="db-c" accept=".jpg,.png,.web,.jpeg" required>
                                    </div>
                                </div>
                            </li>
                            <li class="main-btn">
                                <button type="submit" class="iocn icon-sm btn">Next</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg"></div>
            </div>
        </main>
    </form>
    <!-- this is for insert image in js  -->
    <script src="<?=getBaseUrl('public/js/function.js')?>"></script>
    <script>
        var form =document.querySelector('form');
        form.addEventListener('submit', function(event){
            if(event){
                laodAnimation();
            }
        });
    </script>
</body>
</html>
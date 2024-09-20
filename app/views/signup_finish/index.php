<?php
    session_start();
    require 'database/index.php';
    require 'app/config/functions.php';
    require 'database/ui/index.php';
    require 'app/model/user_detail.php';
    require 'app/model/tb_user_link.php';
    require 'app/model/tb_icon.php';

    use App\Model\UserDetail\UserDetail as UserDetail;
    use App\Model\UserLink\UserLink as UserLink;
    use App\Model\Icon\Icon as Icon;

    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] == '') {
        ui('CSRF token validation failed.<br>Return to <a href="/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Home now.</a>',);
        die();
    }else{
        $_SESSION['user_login_finish'] = 'logined';
    }
    if(isset($_SESSION['user_login_finish'])){
        return header('location: /you/');
    }
    $userDetail = new UserDetail();
    include 'app/views/layout/web_icon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>linkme - Completed</title>
    <?=webIcon()?>
    <!-- this is main css  -->
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/main.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/login.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/linkme.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/link.css?v=<?=time()?>">
    <!-- this is for icon  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- this is style of swiper  -->
    <style>
        .form-head .head{
            padding-top: 0rem;
        }
        .link-completed-btn{
            position: fixed;
            z-index: 10;
            margin: 0 auto;
            height: 100px;
            max-width: 600px;
            width: 100%;
            top: 97%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
        .web-main::before{
            position: fixed;
            content: '';
            width: 100%;
            height: 100vh;
            z-index: 9;
            background: linear-gradient(
                0deg,
                var(--sg-bglight) 0%,
                transparent
            );
            opacity: 0.8;
        }
    </style>
</head>
<body class="scroll-y">
    <!-- this Is content of page  -->
    <main class="web-main over-h">
        <div class="form-head form-head-active">
            <div class="form-body db-c scroll-y">
                <div class="head">
                    <ul class="df-c">
                        <li class="left-05">
                            <h2>linkyours is generated complete🎉</h2>
                        </li>
                    </ul>
                </div>
                <!-- this is content  -->
                <div class="form-con">
                    <ul>
                        <li class="link-completed">
                            <!-- this is show link of user -->
                            <div class="linkme df-c linkme_root">
                                <div class="linkme-con scroll-y">
                                    <div class="link-head df-r"></div>
                                    <div class="linkme-detail">
                                        <!-- user-detail  -->
                                        <div class="likme-user">
                                            <div class="profile icon icon-ra">
                                                <?php
                                                    if(isset($_SESSION[$userDetail->profile]) && file_exists('storage/upload/'.$_SESSION[$userDetail->profile]))
                                                    { ?>
                                                        <img class="img-c"
                                                            loading="lazy"
                                                            srcset="
                                                            <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=100? 100w, 
                                                            <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=200? 200w, 
                                                            <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=400? 400w, 
                                                            <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=800? 800w, 
                                                            <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=1000? 1000w, 
                                                            <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=1200? 1200w, 
                                                            "
                                                            sizes="(max-width: 800px) 100vw, 50vw" 
                                                            decoding="async"
                                                            fetchPriority = "high"
                                                            effect="blur"
                                                        alt="">
                                                <?php
                                                    }else{ 
                                                    if(isset($_SESSION[$userDetail->first_name]) && isset($_SESSION[$userDetail->last_name])){ ?>
                                                    <h2 class="notfound"><?=substr($_SESSION[$userDetail->first_name].$_SESSION[$userDetail->last_name], 0,1)?></h2>
                                                    <?php }}
                                                ?>    
                                            </div>
                                                <?php 
                                                if(isset($_SESSION[$userDetail->first_name]) && isset($_SESSION[$userDetail->last_name]) && isset($_SESSION[$userDetail->bio])){ ?>
                                                    <div class="text">
                                                        <h2><?=$_SESSION[$userDetail->first_name].$_SESSION[$userDetail->last_name]?></h2>
                                                        <blockquote>
                                                            <p><?=$_SESSION[$userDetail->bio]?></p>
                                                        </blockquote>
                                                    </div>
                                                <?php    
                                                }else{
                                                ?>
                                                    <div class="text">
                                                        <h2>Exaple user</h2>
                                                        <blockquote>
                                                            <p>Learning is like you!</p>
                                                        </blockquote>
                                                    </div>  
                                                <?php
                                                }
                                                ?>
                                            <ul class="df-c">
                                                <li>
                                                    <a href="#" class="icon icon-ra icon-sm"><i class="fa-brands fa-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="icon icon-ra icon-sm"><i class="fa-brands fa-telegram"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="icon icon-ra icon-sm"><i class="fa-brands fa-tiktok"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- this is linkme list  -->
                                        <div class="linkme-list">
                                            <ul>
                                                <?php
                                                    if(isset($_SESSION['id'])){
                                                        $userLink = new UserLink();
                                                        $icon = new Icon();
                                                        $id = $_SESSION['id'];

                                                        $sql = "SELECT * FROM $userLink->model 
                                                        INNER JOIN $icon->model ON $userLink->model.$userLink->link_icon_id = $icon->model.$icon->id
                                                        WHERE $userLink->link_user_id = '$id'";

                                                        $result = $conn->query($sql);
                                                        if($result){
                                                            foreach($result as $item){ ?>
                                                            <li>
                                                                <div class="df-s">
                                                                    <div class="leading df-l">
                                                                        <div class="icon icon-sm icon-ra">
                                                                           <?=$item[$icon->icon]?>
                                                                        </div>
                                                                    </div>
                                                                    <a href="<?=$item[$userLink->link_url]?>" class="text df-c">
                                                                        <h2><?=$item[$userLink->link_name]?></h2>
                                                                    </a>
                                                                    <div class="leading df-l">
                                                                        <div class="icon icon-sm icon-ra">
                                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php
                                                            }
                                                        }
                                                    } 
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="linkme-main-contact df-c">
                                            <a href="#"class="icon icon-ra">
                                                <i class="fa-regular fa-envelope"></i>
                                            </a>
                                        </div>
                                        <div class="main-btn">
                                            <a href="../signup/"class="icon icon-ra">
                                                <i class="fa-solid fa-link"></i>
                                                Join VenSoeng on linkme
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="main-btn link-completed-btn">
                            <button type="submit" onclick="location.href='/you/'" class="iocn icon-sm btn">Next</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg"></div>
        </div>
    </main>
</body>
</html>
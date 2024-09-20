<?php
session_start();

require 'database/index.php';
include 'app/config/functions.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/config/province_array.php';
require 'app/model/tb_follower.php';

if (!isset($item)) {
    require '004/index.php';
    die();
}

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\Follower\Follower as Follower;

$user = new User();
$userDetail = new UserDetail();
$follower = new Follower();

$user_name = $item;

$sql = "SELECT
        u.{$user->id} AS user_id,
        u.*,
        d.*
    FROM {$user->model} u
    INNER JOIN {$userDetail->model} d
        ON u.{$user->id} = d.{$userDetail->user_detail_id}
    WHERE u.{$user->user_name} = '$user_name'";
$getUser = $conn->query($sql);

if (!$getUser) {
    require '004/index.php';
    die();
}

if (mysqli_num_rows($getUser) !== 1) {
    require '004/index.php';
    die();
} else {
    $getUser = $getUser->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkme - <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?></title>
    <!-- this is favicon of website -->
    <!-- this is main style form link  -->
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/post.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/home.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/you.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/edit_profile.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/user.css?v=<?= time() ?>">
    <!-- this is box icon  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- this is for icon  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <!-- this is form for reaction  -->
    <div class="form-reaction df-c form-fix">
        <div class="form-reaction-body">
            <div class="form-reaction-body-con">
                <!-- this is head -->
                <div class="head df-s">
                    <ul class="df-l">
                        <li class="i-reaction i-reaction-active df-l">
                            <div class="btn icon icon-ra icon-sm curs-p">
                                <p>All</p>
                                <span>8</span>
                            </div>
                        </li>
                        <li class="i-reaction df-l">
                            <div class="btn icon icon-ra icon-sm curs-p">
                                <i class='bx bxs-like'></i>
                                <span>5</span>
                            </div>
                        </li>
                        <li class="i-reaction df-l">
                            <div class="btn icon icon-ra icon-sm curs-p">
                                <i class='bx bxs-bookmarks'></i>
                                <span>3</span>
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li class="arrow">
                            <div class="icon icon-ra icon-sm curs-p"
                                onclick="document.querySelector('.form-reaction').classList.remove('form-reaction-active')">
                                <i class='bx bx-x'></i>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- this is content -->
                <div class="reate"></div>
                <div class="foot df-l">
                    <p>This is feature <strong>Linkme</strong></p>
                </div>
            </div>
        </div>
        <div class="reat-bg form-fix"></div>
    </div>
    <!-- this is main -->
    <main>
        <div class="con">
            <!-- this is for user infor profile and cover link and detail -->
            <div class="monk-infor">
                <div class="monk-infor-body">
                    <!-- this is header of user link profile and cover -->
                    <div class="monk-head">
                        <div class="user-cover">
                            <div class="box">
                                <?php
                                if (file_exists('storage/upload/' . $getUser[$userDetail->cover])) { ?>
                                    <img class="img-c" loading="lazy" srcset="
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=100? 100w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=200? 200w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=400? 400w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=800? 800w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=1000? 1000w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=1200? 1200w, 
                                                " sizes="(max-width: 800px) 100vw, 50vw" decoding="async"
                                        fetchPriority="high" effect="blur" alt="">
                                    <?php
                                } else { ?>
                                    <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                        <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                    </h2>
                                <?php }
                                ?>
                            </div>
                        </div>
                        <div class="user-profile icon icon-ra over-h">
                            <div class="box">
                                <?php
                                if (file_exists('storage/upload/' . $getUser[$userDetail->profile])) { ?>
                                    <img class="img-c" loading="lazy" srcset="
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=100? 100w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=200? 200w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=400? 400w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=800? 800w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                " sizes="(max-width: 800px) 100vw, 50vw" decoding="async"
                                        fetchPriority="high" effect="blur" alt="">
                                    <?php
                                } else { ?>
                                    <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                        <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                    </h2>
                                <?php }
                                ?>
                            </div>
                        </div>
                        <div class="text left-05 right-05">
                            <h2 style="width: max-content; max-width:100%;"
                                class="<?= $getUser[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                            </h2>
                            <p>@<?= $getUser[$user->user_name] ?></p>
                            <blockquote>
                                <p>
                                    <?= $getUser[$userDetail->bio] ?>
                                </p>
                            </blockquote>
                        </div>
                    </div>
                    <!-- this is all user detail -->
                    <div class="user-con">
                        <div class="user-infor">
                            <!-- this is intro  -->
                            <section class="infor-section personal_intro">
                                <div class="head">
                                    <ul class="df-s">
                                        <li>
                                            <h2>Detail profile</h2>
                                            <p>see some detail about user</p>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>
                                <div class="box db-c">
                                    <ul>
                                        <li>
                                            <div class="icon icon-ra icon-ra-sm">
                                                <i class="bx bxs-user"></i>
                                            </div>
                                            <p>@<?= $getUser[$user->user_name] ?></p>
                                        </li>
                                        <?php if (validateInput($getUser[$user->email]) === "Email") { ?>
                                            <li>
                                                <div class="icon icon-ra icon-ra-sm">
                                                    <i class='bx bxs-envelope'></i>
                                                </div>
                                                <p>Protect by linkme...</p>
                                            </li>
                                        <?php } ?>
                                        <?php if (validateInput($getUser[$user->email]) === "Phone") { ?>
                                            <li>
                                                <div class="icon icon-ra icon-ra-sm">
                                                    <i class='bx bxs-phone-call'></i>
                                                </div>
                                                <p>Protect by linkme...</p>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <div class="icon icon-ra icon-ra-sm">
                                                <i class='bx bxs-circle-three-quarter'></i>
                                            </div>
                                            <p><?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                            </p>
                                        </li>
                                        <li>
                                            <div class="icon icon-ra icon-ra-sm">
                                                <i class='bx bxs-gift'></i>
                                            </div>
                                            <p>
                                                <?php if ($getUser[$userDetail->user_birthday] !== null) {
                                                    echo $getUser[$userDetail->user_birthday];
                                                } else {
                                                    echo 'No birthday';
                                                }
                                                ?>
                                            </p>
                                        </li>
                                        <li>
                                            <?php
                                            $user_id = $getUser[$userDetail->id];
                                            $sql = "SELECT COUNT(*) AS follower FROM $follower->model
                                                    WHERE $follower->user_follower_id = '$user_id'";
                                            $result = $conn->query($sql);
                                            ?>
                                            <div class="icon icon-ra icon-ra-sm i-wifi">
                                                <i class='bx bx-wifi'></i>
                                            </div>
                                            <p>Follow by
                                                <?php if ($result) {
                                                    $result = $result->fetch_assoc();
                                                    echo $result['follower'];
                                                } else {
                                                    echo '0';
                                                } ?>
                                                people
                                            </p>
                                        </li>
                                        <li>
                                            <div class="icon icon-ra icon-ra-sm">
                                                <i class='bx bx-current-location'></i>
                                            </div>
                                            <p>
                                                <?php if ($getUser[$userDetail->user_address] !== null) {
                                                    if ($arrayProvince) {
                                                        echo $arrayProvince[$getUser[$userDetail->user_address]]['province'];
                                                    }
                                                } else {
                                                    echo 'No provided address';
                                                }
                                                ?>
                                            </p>
                                        </li>
                                        <li>
                                            <div class="icon icon-ra icon-ra-sm">
                                                <i class='bx bxs-calendar-week'></i>
                                            </div>
                                            <p>
                                                <span>Join:</span>
                                                <?php if ($getUser[$user->created_at] !== null || $getUser[$user->created_at] !== '') {
                                                    echo convertDate($getUser[$user->created_at], '');
                                                } else {
                                                    echo 'Error: userJonin';
                                                }
                                                ?>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </section>
                            <!-- this is pesenal id show  -->
                            <?php
                            require 'app/model/tb_user_link.php';
                            require 'app/model/tb_icon.php';

                            use App\Model\UserLink\UserLink as UserLink;
                            use App\Model\Icon\Icon as Icon;

                            $user_id = $getUser[$user->id];
                            $userLink = new UserLink();
                            $icon = new Icon();

                            $sql = "SELECT 
                                    u.{$userLink->id} AS link_id, 
                                    u.*,
                                    i.* 
                                FROM {$userLink->model} u
                                INNER JOIN {$icon->model} i 
                                ON u.{$userLink->link_icon_id} = i.{$icon->id}
                                WHERE u.{$userLink->link_user_id} = '$user_id'
                                AND u.{$userLink->link_status} = 1";

                            $result = $conn->query($sql);
                            if ($result) {
                                if ($result->num_rows > 1) {
                                    ?>
                                    <section class="infor-section personal_intro">
                                        <div class="head">
                                            <ul class="df-s">
                                                <li>
                                                    <h2>Linkme</h2>
                                                    <p>you can cantact to this user by this link</p>
                                                </li>
                                                <li></li>
                                            </ul>
                                        </div>
                                        <div class="box db-c">
                                            <ul>
                                                <?php
                                                foreach ($result as $index => $item) {
                                                    ?>
                                                    <li onclick="location.href='<?=$item[$userLink->link_url]?>'">
                                                        <div class="icon icon-ra icon-ra-sm curs-p">
                                                            <?= $item[$icon->icon] ?>
                                                        </div>
                                                        <p class=""><?= $item[$userLink->link_name] ?></p>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </section>
                                    <?php
                                }
                            }
                            ?>
                            <!-- this is show all user Follow  -->
                            <section class="infor-section personal_intro" style="border-bottom: none;"
                                id="intro_following">
                                <div class="head">
                                    <ul class="df-s">
                                        <li>
                                            <h2>Following</h2>
                                            <p>See all user
                                                <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                                following
                                            </p>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>
                                <div class="box db-c">
                                    <div class="web-post">
                                        <div class="user-post">
                                            <div class="user-post-body">
                                                <!-- this is all follow for user  -->
                                                <nav class="head-user">
                                                    <div class="scroll-x df-l">
                                                        <!-- defules  -->
                                                        <?php
                                                        if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password]) && $_SESSION[$user->id] == $getUser[$userDetail->user_detail_id]) {
                                                            ?>
                                                            <a class="list">
                                                                <div class="icon icon-ra profile curs-p"
                                                                    style="--img: url('<?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>');">
                                                                    <h2 class="notfound df-c" style=""><i
                                                                            class='bx bx-camera'></i></h2>
                                                                </div>
                                                                <h2>You</h2>
                                                                <div class="form">
                                                                    <button type="submit" class="btn">Create new</button>
                                                                </div>
                                                            </a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <a class="list">
                                                                    <div class="icon icon-ra profile curs-p">
                                                                        <img class="img-c"
                                                                            src="<?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>"
                                                                            alt="">
                                                                    </div>
                                                                    <h2>Creator</h2>
                                                                    <form cl action="/login" method="POST" class="form-follow-back form-follow">
                                                                        <button type="submit" class="btn">
                                                                            <span>Follow</span>
                                                                            <span>Follow</span>
                                                                        </button>
                                                                    </form>
                                                                </a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php

                                                        $user_id = $getUser[$userDetail->user_detail_id];

                                                        $sql = "SELECT
                                                                d.{$userDetail->user_detail_id} AS user_id,
                                                                u.{$user->user_name},
                                                                f.{$follower->id} AS follow_id,
                                                                d.{$userDetail->first_name},
                                                                d.{$userDetail->last_name},
                                                                d.{$userDetail->profile},
                                                                f.*
                                                            FROM {$follower->model} f
                                                            INNER JOIN {$userDetail->model} d
                                                            ON f.{$follower->user_follower_id} = d.{$userDetail->user_detail_id}
                                                            INNER JOIN {$user->model} u
                                                            ON f.{$follower->user_follower_id} = u.{$user->id}
                                                            WHERE f.{$follower->user_sand_follower_id} = '$user_id'";

                                                        $result = $conn->query($sql);
                                                        if ($result) {
                                                            foreach ($result as $index => $item) {
                                                                ?>
                                                                <a href="<?= getBaseUrl('user/' . $item[$user->user_name]) ?>"
                                                                    class="list follower-data">
                                                                    <div
                                                                        class="icon icon-ra profile <?= $item[$follower->follower_status] == 0 ? 'following' : 'follower' ?> curs-p">
                                                                        <?php
                                                                        if (file_exists('storage/upload/' . $item[$userDetail->profile])) { ?>
                                                                            <img class="img-c" loading="lazy" srcset="
                                                                                        <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=100? 100w, 
                                                                                        <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=200? 200w, 
                                                                                        <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=400? 400w, 
                                                                                        <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=800? 800w, 
                                                                                        <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                                                        <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                                                        "
                                                                                sizes="(max-width: 800px) 100vw, 50vw"
                                                                                decoding="async" fetchPriority="high" effect="blur"
                                                                                alt="">
                                                                            <?php
                                                                        } else { ?>
                                                                            <h2 class="notfound" style="font-size: 1.3rem">
                                                                                <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                                                            </h2>
                                                                        <?php }
                                                                        ?>
                                                                    </div>
                                                                    <h2><?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                                                    </h2>
                                                                    <form
                                                                        action="<?= getBaseUrl('user/' . $item[$user->user_name]) ?>"
                                                                        method="POST" class="form-follow-back form-follow">
                                                                        <button type="submit" class="btn">
                                                                            <span>See profile</span>
                                                                            <span>See profile</span>
                                                                        </button>
                                                                    </form>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php 
                            if(isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])){
                                if($_SESSION[$user->email] == $getUser[$user->email] && $_SESSION[$user->password] == $getUser[$user->password]){
                                    ?>
                                <section class="infor-section personal_intro" style="border-bottom: none;"
                                    id="intro_following">
                                    <div class="head">
                                        <ul class="df-s">
                                            <li>
                                                <h2>Your follower</h2>
                                                <p>See all user
                                                    <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                                    follower
                                                </p>
                                            </li>
                                            <li></li>
                                        </ul>
                                    </div>
                                    <div class="box db-c">
                                        <div class="web-post">
                                            <div class="user-post">
                                                <div class="user-post-body">
                                                    <!-- this is all follow for user  -->
                                                    <nav class="head-user">
                                                        <div class="scroll-x df-l">
                                                            <!-- defules  -->
                                                            <?php
                                                            $user_id = $getUser[$userDetail->user_detail_id];

                                                            $sql = "SELECT
                                                                d.{$userDetail->user_detail_id} AS user_id,
                                                                u.{$user->user_name},
                                                                f.{$follower->id} AS follow_id,
                                                                d.{$userDetail->first_name},
                                                                d.{$userDetail->last_name},
                                                                d.{$userDetail->profile},
                                                                f.*
                                                            FROM {$follower->model} f
                                                            INNER JOIN {$userDetail->model} d
                                                                ON f.{$follower->user_sand_follower_id} = d.{$userDetail->user_detail_id}
                                                            INNER JOIN {$user->model} u
                                                                ON f.{$follower->user_sand_follower_id} = u.{$user->id}
                                                            WHERE f.{$follower->user_follower_id} = '$user_id'";

                                                            $result = $conn->query($sql);
                                                            if($result && mysqli_num_rows($result) > 0){
                                                                foreach ($result as $index => $item) {
                                                                    ?>
                                                                    <a href="/user/<?=$item[$user->user_name]?>" class="list">
                                                                        <div class="icon icon-ra profile curs-p">
                                                                            <?php 
                                                                             if (file_exists('storage/upload/' . $item[$userDetail->profile])) { ?>
                                                                                <img class="img-c" loading="lazy" srcset="
                                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=100? 100w, 
                                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=200? 200w, 
                                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=400? 400w, 
                                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=800? 800w, 
                                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                                                            "
                                                                                    sizes="(max-width: 800px) 100vw, 50vw"
                                                                                    decoding="async" fetchPriority="high" effect="blur"
                                                                                    alt="">
                                                                                <?php
                                                                            } else { ?>
                                                                                <h2 class="notfound" style="font-size: 1.3rem">
                                                                                    <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                                                                </h2>
                                                                            <?php }
                                                                            ?>
                                                                        </div>
                                                                        <h2><?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?></h2>
                                                                        <form action="/user/<?=$item[$user->user_name]?>" method="POST"
                                                                            class="form-follow-back form-follow">
                                                                            <button type="submit" class="btn">
                                                                                <span>See profile</span>
                                                                                <span>See profile</span>
                                                                            </button>
                                                                        </form>
                                                                    </a>
                                                                    <?php
                                                                }
                                                            }else{
                                                                ?>
                                                                <a class="list">
                                                                    <div class="icon icon-ra profile curs-p"
                                                                        style="--img: url('<?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>');">
                                                                        
                                                                    </div>
                                                                    <h2>Creator</h2>
                                                                    <div class="form">
                                                                        <button type="submit" class="btn">Isyours</button>
                                                                    </div>
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- this is all post of user  -->
            <div class="web-post">
                <div class="user-post">
                    <div class="user-post-body">
                        <ul>
                            <?php
                            require 'app/model/tb_content.php';
                            require 'app/model/tb_reacte.php';
                            require 'app/model/tb_user_activity.php';

                            use App\Model\Content\Content as Content;
                            use App\Model\Reacte\Reacte as Reacte;
                            use App\Model\UserActivity\UserActivity as UserActivity;
                            $content = new Content();
                            $reacte = new Reacte();
                            $userActivity = new UserActivity();

                            $user_id = $getUser[$userDetail->user_detail_id];

                            $sql = "SELECT
                                    d.{$userDetail->first_name},   
                                    d.{$userDetail->last_name},   
                                    d.{$userDetail->profile},     
                                    u.{$user->verify_status},       
                                    u.{$user->user_name}, 
                                    a.{$userActivity->created_at} AS reacte_created_at,
                                    c.{$content->id} AS content_id,  
                                    c.{$content->created_at} AS content_created_at,  
                                    a.*,                           
                                    c.*                            
                                FROM {$userActivity->model} a
                                INNER JOIN {$content->model} c
                                    ON a.{$userActivity->activity_content_id} = c.{$content->id}
                                INNER JOIN {$user->model} u
                                    ON c.{$content->user_post_id} = u.{$user->id} 
                                INNER JOIN {$userDetail->model} d
                                    ON u.{$user->id} = d.{$userDetail->user_detail_id}
                                WHERE a.{$userActivity->activity_user_id} = '$user_id'
                                AND c.{$content->post_status} = '1'
                                
                                ";
                            $result = $conn->query($sql);
                            if ($result) {
                                foreach ($result as $index => $item) {
                                    if ($item[$userActivity->activity_type_id] == 1) {
                                        continue;
                                    }
                                    ?>
                                    <li class="data_list" id="user_post_id_<?=$item['content_id']?>">
                                        <!-- ------------this is all value for edite-----------  -->
                                        <div class="head df-s">
                                            <div class="post-profile df-l">
                                                <div class="profile">
                                                    <?php
                                                    if (file_exists('storage/upload/' . $getUser[$userDetail->profile])) { ?>
                                                        <img class="img-c" loading="lazy" srcset="
                                                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=100? 100w, 
                                                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=200? 200w, 
                                                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=400? 400w, 
                                                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=800? 800w, 
                                                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                            " sizes="(max-width: 800px) 100vw, 50vw" decoding="async"
                                                            fetchPriority="high" effect="blur" alt="">
                                                        <?php
                                                    } else { ?>
                                                        <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                            <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                                        </h2>
                                                    <?php }
                                                    ?>
                                                </div>
                                                <div class="user-name">
                                                    <h2 style="width: max-content; max-width:100%;"
                                                        class="<?= $getUser[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                                        <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                                    </h2>
                                                    <p>
                                                        <?= convertDate($item['reacte_created_at'], '', true) ?>
                                                        <?= $item[$content->post_status] == 1 ? '<i class="fa-solid fa-globe"></i>' : '<i class="fa-solid fa-lock"></i>' ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="icon icon-ra icon-sm" data-name="btn-edit-content">
                                                <?= $item[$userActivity->activity_type_id] == 2 ? '<i class="fa-regular fa-bookmark"></i>' : '<i class="bx bx-camera"></i>' ?>
                                            </div>
                                        </div>
                                        <?php
                                        if ($item[$userActivity->activity_type_id] == 2) {
                                            ?>
                                            <div class="user-content">
                                                <div class="user-content-box">
                                                    <!-- this is head  -->
                                                    <div class="head df-s">
                                                        <div class="post-profile df-l">
                                                            <div class="profile">
                                                                <?php
                                                                if (file_exists('storage/upload/' . $item[$userDetail->profile])) { ?>
                                                                    <img class="img-c" loading="lazy" srcset="
                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=100? 100w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=200? 200w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=400? 400w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=800? 800w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                                            " sizes="(max-width: 800px) 100vw, 50vw"
                                                                        decoding="async" fetchPriority="high" effect="blur" alt="">
                                                                    <?php
                                                                } else { ?>
                                                                    <h2 class="notfound"
                                                                        style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                                        <?= substr($item[$userDetail->first_name] . $item[$userDetail->last_name], 0, 1) ?>
                                                                    </h2>
                                                                <?php }
                                                                ?>
                                                            </div>
                                                            <div class="user-name">
                                                                <h2 style="width: max-content; max-width:100%;"
                                                                    class="<?= $item[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                                                    <?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                                                </h2>
                                                                <p>
                                                                    <?= convertDate($item['content_created_at'], '', true) ?>
                                                                    <?= $item[$content->post_status] == 1 ? '<i class="fa-solid fa-globe"></i>' : '<i class="fa-solid fa-lock"></i>' ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- this is content  -->
                                                    <?php
                                                    if (trim($item[$content->post_title]) !== '' && trim($item[$content->post_img]) !== '') {
                                                        ?>
                                                        <div class="post-title">
                                                            <h2><?= $item[$content->post_title] ?></h2>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="post-img">
                                                        <ul>
                                                            <li>
                                                                <?php
                                                                if (trim($item[$content->post_img]) !== '' && $item[$content->post_img] !== null) {
                                                                    if (file_exists('storage/upload/' . $item[$content->post_img])) {
                                                                        ?>
                                                                        <img loading="lazy" srcset="
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=100? 100w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=200? 200w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=400? 400w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=800? 800w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=1000? 1000w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=1200? 1200w, 
                                                                            " sizes="(max-width: 800px) 100vw, 50vw"
                                                                            decoding="async" fetchPriority="high" effect="blur" alt="">
                                                                        <?php
                                                                    }
                                                                } else if (trim($item[$content->post_title]) !== '') { ?>
                                                                        <div class="post-type-txt">
                                                                            <h2><?= $item[$content->post_title] ?></h2>
                                                                        </div>
                                                                <?php } else {
                                                                    ?>
                                                                        <div class="post-type-txt">
                                                                            <h2><?= sanitizeContent($item[$content->post_des]) ?></h2>
                                                                        </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="post-feature"></div>
                                                    <div class="post-des">
                                                        <blockquote>
                                                            <?php
                                                            $sanitized_output = sanitizeContent($item[$content->post_des]);
                                                            ?>
                                                            <p><?= $sanitized_output ?></p>
                                                        </blockquote>
                                                    </div>
                                                    <?php
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <?php
                                            if (trim($item[$content->post_title]) !== '' && trim($item[$content->post_img]) !== '') {
                                                ?>
                                                <div class="post-title">
                                                    <h2><?= $item[$content->post_title] ?></h2>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="post-img">
                                                <ul>
                                                    <li>
                                                        <?php
                                                        if (trim($item[$content->post_img]) !== '' && $item[$content->post_img] !== null) {
                                                            if (file_exists('storage/upload/' . $item[$content->post_img])) {
                                                                ?>
                                                                <img loading="lazy" srcset="
                                                                <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=100? 100w, 
                                                                <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=200? 200w, 
                                                                <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=400? 400w, 
                                                                <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=800? 800w, 
                                                                <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=1000? 1000w, 
                                                                <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=1200? 1200w, 
                                                                " sizes="(max-width: 800px) 100vw, 50vw"
                                                                    decoding="async" fetchPriority="high" effect="blur" alt="">
                                                                <?php
                                                            }
                                                        } else if (trim($item[$content->post_title]) !== '') { ?>
                                                                <div class="post-type-txt">
                                                                    <h2><?= $item[$content->post_title] ?></h2>
                                                                </div>
                                                        <?php } else {
                                                            ?>
                                                                <div class="post-type-txt">
                                                                    <h2><?= sanitizeContent($item[$content->post_des]) ?></h2>
                                                                </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="post-feature"></div>
                                            <div class="post-des">
                                                <blockquote>
                                                    <?php
                                                    $sanitized_output = sanitizeContent($item[$content->post_des]);
                                                    ?>
                                                    <p><?= $sanitized_output ?></p>
                                                </blockquote>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="post-foot df-l">
                                        <?php 
                                            if(!isset($_SESSION[$user->email]) && !isset($_SESSION[$user->password])){
                                                ?>
                                                 <a href="/login" class="btn icon icon-ra icon-sm curs-p">See reatetion</a>
                                                <?php
                                            } else {
                                                ?>
                                                    <form action="/post/reacte" method="POST" class="see form-seereacte">
                                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                        <input type="text" name="action" class="txt-action" value="getReaction" hidden>
                                                        <input type="number" name="<?=$content->id?>" value="<?= $item['content_id'] ?>" hidden>
                                                        <button class="btn icon icon-ra icon-sm curs-p">See reatetion</button>
                                                    </form>
                                                <?php
                                            }?>
                                        </div>
                                    </li>
                                    <?php
                                }
                            } else {
                                echo mysqli_error($conn);
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- -------------------------- -->
        </div>  
    </main>
    <?php
    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
        ?>
        <script src="<?= getBaseUrl('public/js/function.js?v=' . time()) ?>"></script>
        <script src="<?= getBaseUrl('public/js/user.js?v=' . time()) ?>"></script>
        <?php
    }
    ?>
    <script type="text/javascript">
        <?php 
        if(isset($_POST['user_post_id']) && is_numeric($_POST['user_post_id'])){
            ?>
                var a = document.createElement('a');
                a.setAttribute('href','#user_post_id_<?=$_POST['user_post_id']?>');
                document.body.append(a);
                a.click();
                
                var element =document.querySelector('#user_post_id_<?=$_POST['user_post_id']?>');
                element.setAttribute('style', 'background: var(--sg-bgblack);');
            <?php
        }
        ?>
    </script>
</body>

</html>
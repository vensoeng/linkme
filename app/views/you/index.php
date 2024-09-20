<?php
session_start();

require 'database/index.php';
require 'app/config/functions.php';
require 'app/config/province_array.php';
require 'database/ui/index.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/model/tb_user_link.php';
require 'app/model/tb_icon.php';
require 'app/model/tb_post_type.php';
require 'app/model/tb_content.php';
require 'app/model/tb_reacte.php';
require 'app/model/tb_follower.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\UserLink\UserLink as UserLink;
use App\Model\Icon\Icon as Icon;
use App\Model\Content\Content as Content;
use App\Model\Reacte\Reacte as Reacte;
use App\Model\Follower\Follower as Follower;

$user = new User();
if (!isset($_SESSION[$user->email]) && !isset($_SESSION[$user->password])) {
    return header('location:' . getBaseUrl(''));
}
$userDetail = new UserDetail();
$userLink = new UserLink();
$icon = new Icon();
$content = new Content();
$reacte = new Reacte();
$follower = new Follower();

$user_id = $_SESSION[$user->id];

$sql = "SELECT * FROM $userDetail->model
        INNER JOIN $user->model ON $userDetail->model.$userDetail->user_detail_id = $user->model.$user->id
        WHERE  $userDetail->model.$userDetail->user_detail_id = '$user_id'";

$getUser = $conn->query($sql);
if ($getUser) {
    if (mysqli_num_rows($getUser) == 1) {
        $getUser = $getUser->fetch_assoc();
    } else {
        ui("<p>Sorry myserve an error duplicate data!</p>" . 'Return to: <a style="font-family: var(--sg-fontbrand);color: #1876f2c7;" href="/logout/">Logout</a>');
        die();
    }
} else {
    ui("<h2>Sorry myserve an error!.</h2><p>" . mysqli_error($conn) . $sql . "</p>" . 'Return to: <a style="font-family: var(--sg-fontbrand);color: #1876f2c7;" href="/logout/">Logout</a>');
    die();
}
// ================this is se csrf token not user edit code=========== 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
include 'app/views/layout/web_icon.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>linkme - Yours</title>
    <?=webIcon()?>
    <!-- this is main css  -->
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/home.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/form.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/linkme.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/you.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/post.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/edit_profile.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/loading_animation.css?v=<?= time() ?>">
    <!-- this is box icon  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- this is for icon  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- this is style of swiper  -->
</head>

<body class="scroll-y">
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
                <div class="reate">
                    
                </div>
                <div class="foot df-l">
                    <p>This is feature <strong>Linkme</strong></p>
                </div>
            </div>
        </div>
        <div class="reat-bg form-fix"></div>
    </div>
    <!-- this is form for alert  -->
    <div class="form-alert">
        <div class="form-alert-body">
            <div class="box">
                <div class="head df-s">
                    <div class="icon icon-ra icon-sm">
                        <img class="img-c" src="<?= getBaseUrl('') ?>public/images/favicon.png" alt="">
                    </div>
                    <a class="btn icon icon-ra icon-sm curs-p"
                        onclick="document.querySelector('.form-alert').classList.remove('form-alert-active')">
                        ok
                    </a>
                </div>
                <blockquote>
                    <p></p>
                </blockquote>
            </div>
        </div>
        <div class="form-alert-bg"></div>
    </div>
    <!-- this is form for add new link  -->
    <div class="web-form" id="form-link">
        <form action="/edit/link" method="POST" class="db-c form-add-new-link" enctype="multipart/form-data">
            <input type="text" name="action" class="txt-action" value="addlink" hidden>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
            <div class="web-form-body">
                <!-- this is header  -->
                <div class="head df-s">
                    <h2><span></span></h2>
                    <a><span>Make new linkme</span></a>
                    <div class="icon-ra icon-sm df-c" data-name="btn-close-form-addlink"
                        onclick="document.querySelector('#form-link').classList.toggle('web-form-active')">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <!-- this is content  -->
                <div class="con db-c">
                    <div class="con-body db-c">
                        <div class="form-head"></div>
                        <!-- this is content  -->
                        <div class="main scroll-y" id="taget-height">
                            <div class="box">
                                <!-- this is seclect  -->
                                <div class="txt-select">
                                    <ul>
                                        <label for="#">Choose Link</label>
                                        <div class="txt-select-list-con df-c">
                                            <select name="<?= $userLink->link_icon_id ?>"
                                                onchange="document.querySelector('[data-name=\'txt-link-title\']').value = this.options[this.selectedIndex].text;">
                                                <option value="">Select Media Link</option>
                                                <?php
                                                $sql = "SELECT $icon->id, $icon->icon_name FROM $icon->model";
                                                $result = $conn->query($sql);
                                                $iconOption = "";

                                                if ($result) {
                                                    foreach ($result as $item) {
                                                        $iconOption .= '<option value="' . $item[$icon->id] . '">' . $item[$icon->icon_name] . '</option>';
                                                        ?>
                                                        <option value="<?= $item[$icon->id] ?>"><?= $item[$icon->icon_name] ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </ul>
                                </div>
                                <!-- thi is title  -->
                                <div class="txt-title">
                                    <label for="#">Title</label>
                                    <div class="txt-title-box">
                                        <input type="text" name="<?= $userLink->link_name ?>"
                                            placeholder="Enter Title of link" data-name="txt-link-title">
                                    </div>
                                </div>
                                <div class="txt-title">
                                    <label for="#">Link</label>
                                    <div class="txt-title-box">
                                        <input type="text" name="<?= $userLink->link_url ?>"
                                            placeholder="Enter your medialink">
                                    </div>
                                </div>
                                <!-- this is content photo  -->
                                <input type="file" id="x-file-addlink" hidden="" name="<?= $userLink->link_img ?>"
                                    onchange="previewImage(event,'.x-box-img-add-link')">
                                <div class="txt-photo df-c" onclick="document.querySelector('#x-file-addlink').click()">
                                    <div class="txt-photo-box x-box-img-add-link" id="#">
                                        <ul>
                                            <li class="icon-ra-sm"><i class="fa-solid fa-photo-film"></i></li>
                                            <li>
                                                <h2>Selecte image of content</h2>
                                            </li>
                                            <li>
                                                <p>Size of image2048</p>
                                            </li>
                                        </ul>
                                        <img src="#" class="img-c" alt="soeng">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- this is footer  -->
                        <div class="foot">
                            <div class="foot-body df-s">
                                <h2>Choose other feature</h2>
                                <ul class="df-c">
                                    <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះមាតិការ'"
                                        onclick="hiddenForm('#form-post')">
                                        <i class="fa-regular fa-image"></i>
                                    </li>
                                    <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះលិង'"
                                        onclick="hiddenForm('#form-link')">
                                        <i class="fa-solid fa-link"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- this is footer form  -->
                <div class="submit-form">
                    <div class="box df-c">
                        <button class="btn icon-ra" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="form-b" onclick="document.querySelector('#form-link').classList.toggle('web-form-active')"></div>
    </div>
    <!-- this Is content of page  -->
    <main class="web-main">
        <div class="con">
            <div class="con-box">
                <!-- this is header of the page -->
                <div class="head">
                    <div class="head-top">
                        <div class="df-l">
                            <div class="profile x-profile">
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
                            <div class="text">
                                <h2>
                                    <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                </h2>
                                <h3>Add new linkme for everyone contact.</h3>
                            </div>
                        </div>
                    </div>
                    <div class="icon icon-ra"
                        onclick="document.querySelector('#edit-profile').classList.toggle('web-form-active')">
                        <span>Edit profile</span>
                    </div>
                </div>
                <!-- this is fix header  -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        let lastScrollTop = 0;

                        let header = document.querySelector('.web-main .con-box');
                        let getHieghtHead = header.querySelector('.head').offsetHeight;
                        header.setAttribute('style', '--hieght--: -' + getHieghtHead + 'px');
                        header = header.querySelector('.head');

                        window.addEventListener('scroll', function () {
                            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                            if (scrollTop > lastScrollTop) {
                                header.classList.add('web-header-remove');
                            } else {
                                // User is scrolling up, show the header
                                header.classList.remove('web-header-remove');
                            }

                            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
                        });
                    });
                </script>
                <!-- this is for url of user  and follow and view profile -->
                <div class="scroll-y">
                    <div class="scroll-y-box">
                        <!-- this is header of content  -->
                        <div class="view-linkyou db-c">
                            <div class="view-linkyou-box df-s">
                                <a href="/user/<?= $getUser[$user->user_name] ?>" class="btn icon icon-ra icon-ra-sm">
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
                                    <span></span>
                                </a>
                                <a href="/me/<?= $getUser[$user->user_name] ?>" class="btn icon icon-ra icon-ra-sm">
                                    <i class="fa-solid fa-box-archive"></i>
                                    <span>linkyou</span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- this is user follow and following list item  -->
                        <div class="web-post">
                            <div class="user-post">
                                <div class="user-post-body">
                                    <!-- this is all follow for user  -->
                                    <nav class="head-user">
                                        <div class="scroll-x df-l">
                                            <!-- defules  -->
                                            <a class="list">
                                                <div class="icon icon-ra profile curs-p"
                                                    style="--img: url('<?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>');"
                                                    onclick="document.querySelector('#form-post').classList.add('web-form-active');">
                                                    <h2 class="notfound df-c" style=""><i class='bx bx-camera'></i></h2>
                                                </div>
                                                <h2>You</h2>
                                                <div class="form">
                                                    <button type="submit" class="btn"
                                                        onclick="document.querySelector('#form-post').classList.add('web-form-active');">Create
                                                        new</button>
                                                </div>
                                            </a>
                                            <?php
                                            // this Is for show all user sand follow to this user 
                                            $sql = "SELECT
                                                    d.{$userDetail->user_detail_id} AS user_id,
                                                    f.{$follower->id} AS follow_id,
                                                    d.{$userDetail->first_name},
                                                    d.{$userDetail->last_name},
                                                    d.{$userDetail->profile},
                                                    u.{$user->user_name},
                                                    f.*
                                                FROM {$follower->model} f
                                                INNER JOIN {$userDetail->model} d
                                                    ON f.{$follower->user_sand_follower_id} = d.{$userDetail->user_detail_id}
                                                INNER JOIN {$user->model} u
                                                    ON f.{$follower->user_sand_follower_id} = u.{$user->id}
                                                WHERE f.{$follower->user_follower_id} = '$user_id'";

                                            $result = $conn->query($sql);
                                            if ($result) {
                                                foreach ($result as $index => $item) {
                                                    ?>
                                                    <a class="list follower-data">
                                                        <div onclick="location.href='<?= getBaseUrl('user/' . $item[$user->user_name]) ?>'"
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
                                                                            " sizes="(max-width: 800px) 100vw, 50vw"
                                                                    decoding="async" fetchPriority="high" effect="blur" alt="">
                                                                <?php
                                                            } else { ?>
                                                                <h2 class="notfound" style="font-size: 1.3rem">
                                                                    <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                                                </h2>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                        <h2
                                                            onclick="location.href='<?= getBaseUrl('user/' . $item[$user->user_name]) ?>'">
                                                            <?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                                        </h2>
                                                        <form action="/post/follower" method="POST"
                                                            class="form-follow-back form-follow" data-name="Follwback">
                                                            <input type="text" name="action" value="editFollow" hidden>
                                                            <input type="hidden" name="csrf_token"
                                                                value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                            <input type="number" name="<?= $follower->id ?>"
                                                                value="<?= $item['follow_id'] ?>" hidden>
                                                            <input type="number" name="<?= $follower->follower_status ?>"
                                                                class="txt-status"
                                                                value="<?= $item[$follower->follower_status] ?>" hidden>
                                                            <button type="submit" class="btn">
                                                                <?= $item[$follower->follower_status] == 0 ? '<span>Follback</span><span>UnFollow</span>' : '<span>UnFollow</span><span>Follback</span>' ?>
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
                        <!-- this is list of user  -->
                        <div class="link-list">
                            <ul>
                                <?php
                                if (isset($_SESSION[$user->id])) {
                                    $userLink = new UserLink();
                                    $icon = new Icon();
                                    $id = $_SESSION[$user->id];

                                    $sql = "SELECT 
                                        u.{$userLink->id} AS link_id, 
                                        u.*,
                                        i.* 
                                    FROM {$userLink->model} u
                                    INNER JOIN {$icon->model} i 
                                    ON u.{$userLink->link_icon_id} = i.{$icon->id}
                                    WHERE u.{$userLink->link_user_id} = '$id'";

                                    $result = $conn->query($sql);

                                    if ($result) {
                                        foreach ($result as $index => $item) { ?>
                                            <li>
                                                <div class="box df-l">
                                                    <div class="left"
                                                        onclick="document.querySelector('#form-link_<?= $index ?>').classList.toggle('web-form-active')">
                                                        <a class="icon icon-ra icon-sm"><i
                                                                class="fa-solid fa-grip-vertical"></i></a>
                                                    </div>
                                                    <div class="list-con">
                                                        <div class="head df-s">
                                                            <div class="text df-l">
                                                                <h2><?= $item[$userLink->link_name] ?></h2>
                                                                <i class="fa-regular fa-pen-to-square"
                                                                    onclick="document.querySelector('#form-link_<?= $index ?>').classList.toggle('web-form-active')"></i>
                                                            </div>
                                                            <div class="list-icon df-l">
                                                                <a href="#" class="icon icon-ra icon-sm">
                                                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                                                </a>
                                                                <form action="/edit/link" method="POST"
                                                                    data-name="form-edit-status-link">
                                                                    <input type="text" name="action" class="txt-action"
                                                                        value="chang_status" hidden>
                                                                    <input type="hidden" name="csrf_token"
                                                                        value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                                    <input type="number" name="<?= $userLink->id ?>"
                                                                        value="<?= $item['link_id'] ?>" hidden>
                                                                    <input type="checkbox" class="txt-change"
                                                                        <?= $item[$userLink->link_status] == 1 ? 'checked' : "class=''" ?>>
                                                                    <input type="number" class="txt-status"
                                                                        name="<?= $userLink->link_status ?>"
                                                                        value="<?= $item[$userLink->link_status] ?>" hidden>
                                                                    <button type="submit" hidden></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="url df-l">
                                                            <div class="text">
                                                                <h2><?= filter_var($item[$userLink->link_url], FILTER_VALIDATE_URL) == true ? $item[$userLink->link_url] : 'Error Link: https://web.example.com/you/' ?>
                                                                </h2>
                                                            </div>
                                                            <div class="icon icon-ra icon-sm">
                                                                <i class="fa-regular fa-copy"></i>
                                                            </div>
                                                        </div>
                                                        <div class="foot df-s">
                                                            <div class="list-icon df-l">
                                                                <a href="#" class="icon icon-ra icon-sm active">
                                                                    <?= $item[$icon->icon] ?>
                                                                </a>
                                                                <a class="icon icon-ra icon-sm curs-p"
                                                                    onclick="document.querySelector('#form-link_<?= $index ?>').classList.toggle('web-form-active')">
                                                                    <?php
                                                                    if ($item[$userLink->link_img] !== null && trim($item[$userLink->link_img]) !== '') {
                                                                        ?>
                                                                        <img class="img-c" loading="lazy" srcset="
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=100? 100w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=200? 200w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=400? 400w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=800? 800w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=1000? 1000w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=1200? 1200w, 
                                                                    " sizes="(max-width: 800px) 100vw, 50vw"
                                                                            decoding="async" fetchPriority="hight" effect="blur" alt="">
                                                                        <?php
                                                                    } else {
                                                                        echo '<i class="fa-regular fa-image"></i>';
                                                                    }
                                                                    ?>
                                                                </a>
                                                            </div>
                                                            <div class="delete-icon">
                                                                <form action="/edit/link" method="POST"
                                                                    data-name="form-delete-link">
                                                                    <input type="text" name="action" class="txt-action"
                                                                        value="delete" hidden>
                                                                    <input type="hidden" name="csrf_token"
                                                                        value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                                    <input type="number" name="<?= $userLink->id ?>"
                                                                        value="<?= $item['link_id'] ?>" hidden>
                                                                    <button href="#" class="icon icon-ra icon-sm curs-p bg-n">
                                                                        <i class="fa-regular fa-trash-can"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- this is form for edite  -->
                                            <div class="web-form" id="form-link_<?= $index ?>">
                                                <form action="/edit/link" method="POST" class="db-c" enctype="multipart/form-data"
                                                    data-name="edite-link">

                                                    <input type="text" name="action" class="txt-action"
                                                        value="<?= $userLink->model ?>" hidden>
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>"
                                                        hidden>
                                                    <input type="number" name="<?= $userLink->id ?>" value="<?= $item['link_id'] ?>"
                                                        hidden>

                                                    <div class="web-form-body">
                                                        <!-- this is header  -->
                                                        <div class="head df-s">
                                                            <h2><span></span></h2>
                                                            <a><span>Edit your link</span></a>
                                                            <div class="icon-ra icon-sm df-c"
                                                                onclick="document.querySelector('#form-link_<?= $index ?>').classList.toggle('web-form-active')"
                                                                data-name="btn-close-form-link">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </div>
                                                        </div>
                                                        <!-- this is content  -->
                                                        <div class="con db-c">
                                                            <div class="con-body db-c">
                                                                <div class="form-head"></div>
                                                                <!-- this is content  -->
                                                                <div class="main scroll-y" id="taget-height">
                                                                    <div class="box">
                                                                        <!-- this is seclect  -->
                                                                        <div class="txt-select">
                                                                            <ul>
                                                                                <label for="#">Choose Link</label>
                                                                                <div class="txt-select-list-con df-c">
                                                                                    <select name="<?= $userLink->link_icon_id ?>">
                                                                                        <option
                                                                                            value="<?= $item[$userLink->link_icon_id] ?>">
                                                                                            <?= $item[$icon->icon_name] ?>
                                                                                        </option>
                                                                                        <?php
                                                                                        if ($iconOption) {
                                                                                            echo $iconOption;
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </ul>
                                                                        </div>
                                                                        <!-- thi is title  -->
                                                                        <div class="txt-title">
                                                                            <label for="#">Title</label>
                                                                            <div class="txt-title-box">
                                                                                <input type="text"
                                                                                    name="<?= $userLink->link_name ?>"
                                                                                    value="<?= $item[$userLink->link_name] ?>"
                                                                                    placeholder="Enter Title of link">
                                                                            </div>
                                                                        </div>
                                                                        <div class="txt-title">
                                                                            <label for="#">Link</label>
                                                                            <div class="txt-title-box">
                                                                                <input type="text" name="<?= $userLink->link_url ?>"
                                                                                    value="<?= $item[$userLink->link_url] ?>"
                                                                                    placeholder="Enter your medialink">
                                                                            </div>
                                                                        </div>
                                                                        <!-- this is content photo  -->
                                                                        <input type="file" id="file_img_<?= $index ?>" hidden
                                                                            name="<?= $userLink->link_img ?>"
                                                                            onchange="previewImage(event,'.img_box_insert_<?= $index ?>')">
                                                                        <div class="txt-photo df-c"
                                                                            onclick="document.querySelector('#file_img_<?= $index ?>').click()">
                                                                            <div class="txt-photo-box img_box_insert_<?= $index ?> <?= $item[$userLink->link_img] !== null && $item[$userLink->link_img] !== '' ? 'txt-photo-box-active' : '' ?>"
                                                                                id="#">
                                                                                <ul>
                                                                                    <li class="icon-ra-sm"><i
                                                                                            class="fa-solid fa-photo-film"></i></li>
                                                                                    <li style="background: none;box-shadow:none;">
                                                                                        <h2>Selecte image of content</h2>
                                                                                    </li>
                                                                                    <li style="background: none;box-shadow:none;">
                                                                                        <p>Size of image2048</p>
                                                                                    </li>
                                                                                </ul>
                                                                                <img src="<?= $item[$userLink->link_img] !== null && $item[$userLink->link_img] !== '' ? getBaseUrl('storage/upload/' . $item[$userLink->link_img]) : '#' ?>"
                                                                                    class="img-c" alt="linkme insert photo">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- this is footer  -->
                                                                <div class="foot">
                                                                    <div class="foot-body df-s">
                                                                        <h2>Choose other feature</h2>
                                                                        <ul class="df-c">
                                                                            <li class="icon icon-ra-sm text-be"
                                                                                style="--text-: 'បង្ហោះមាតិការ'"
                                                                                onclick="hiddenForm('#form-post')">
                                                                                <i class="fa-regular fa-image"></i>
                                                                            </li>
                                                                            <li class="icon icon-ra-sm text-be"
                                                                                style="--text-: 'បង្ហោះលិង'"
                                                                                onclick="hiddenForm('#form-link')">
                                                                                <i class="fa-solid fa-link"></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- this is footer form  -->
                                                        <div class="submit-form">
                                                            <div class="box df-c">
                                                                <button class="btn icon-ra" type="submit">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="form-b"
                                                    onclick="document.querySelector('#form-link_<?= $index ?>').classList.toggle('web-form-active')">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- this is show link of user -->
                <div class="linkme df-c linkme_root">
                    <div class="linkme-con scroll-y">
                        <div class="link-head df-r">
                            <div class="icon icon-ra icon-sm"
                                onclick="document.querySelector('.linkme').classList.add('linkme-active')">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        </div>
                        <div class="linkme-detail">
                            <!-- user-detail  -->
                            <div class="likme-user">
                                <div class="profile icon icon-ra">
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
                                    } else {
                                        ?>
                                        <h2 class="notfound">
                                            <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                        </h2>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="text">
                                    <h2><?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?></h2>
                                    <blockquote>
                                        <p><?= $getUser[$userDetail->bio] ?></p>
                                    </blockquote>
                                </div>
                                <ul class="df-c">
                                    <li>
                                        <a href="#" class="icon icon-ra icon-sm"><i
                                                class="fa-brands fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="icon icon-ra icon-sm"><i
                                                class="fa-brands fa-telegram"></i></a>
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
                                    if (isset($_SESSION[$user->id])) {
                                        if ($result) {
                                            foreach ($result as $item) { ?>
                                                <li>
                                                    <div class="df-s">
                                                        <div class="leading df-l">
                                                            <div class="icon icon-sm icon-ra">
                                                                <?= $item[$icon->icon] ?>
                                                            </div>
                                                        </div>
                                                        <a href="<?= $item[$userLink->link_url] ?>" class="text df-c">
                                                            <h2><?= $item[$userLink->link_name] ?></h2>
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
                                <a href="#" class="icon icon-ra">
                                    <i class="fa-regular fa-envelope"></i>
                                </a>
                            </div>
                            <div class="main-btn">
                                <a href="../signup/" class="icon icon-ra">
                                    <i class="fa-solid fa-link"></i>
                                    Join VenSoeng on linkme
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .this is use post content  -->
                <div class="user-post">
                    <div class="user-post-body">
                        <ul>
                            <?php

                            $sql = "SELECT
                                    c.{$content->id} AS content_id,
                                    c.{$content->created_at} AS content_created_at,
                                    c.*,
                                    r.*,
                                    (SELECT COUNT(*) FROM {$reacte->model} r1 WHERE r1.{$reacte->post_id} = c.{$content->id} AND r1.{$reacte->reate_type} = 1) AS reacte_link,
                                    (SELECT COUNT(*) FROM {$reacte->model} r2 WHERE r2.{$reacte->post_id} = c.{$content->id} AND r2.{$reacte->reate_type} = 2) AS reacte_save
                                    FROM {$content->model} c
                                    LEFT JOIN {$reacte->model} r ON r.{$reacte->post_id} = c.{$content->id}
                                    WHERE c.{$content->user_post_id} = '$user_id'
                                    GROUP BY c.{$content->id}
                                    ORDER BY c.{$content->id} DESC";


                            $result = $conn->query($sql);

                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    foreach ($result as $index => $item) {
                                        ?>
                                        <li class="data_list">
                                            <!-- ------------this is all value for edite-----------  -->
                                            <div class="list-input-edite" data-name="list-input-edite" hidden>
                                                <input type="number" class="txt-id" value="<?= $item['content_id'] ?>">
                                                <input type="number" class="txt-status" value="<?= $item[$content->post_status] ?>">
                                                <input type="text" class="txt-title"
                                                    value="<?= htmlspecialchars($item[$content->post_title], ENT_QUOTES, 'UTF-8') ?>">
                                                <input type="text" class="txt-des"
                                                    value="<?= htmlspecialchars($item[$content->post_des], ENT_QUOTES, 'UTF-8') ?>">
                                                <input type="text" class="txt-img" value="<?= $item[$content->post_img] ?>">
                                            </div>
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
                                                                " sizes="(max-width: 800px) 100vw, 50vw"
                                                                decoding="async" fetchPriority="high" effect="blur" alt="">
                                                            <?php
                                                        } else { ?>
                                                            <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                                <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                                            </h2>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                    <div class="user-name">
                                                        <h2 style="width: max-content; max-width: 100%;"
                                                            class="<?= $getUser[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                                            <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                                        </h2>
                                                        <p>
                                                            <?= convertDate($item['content_created_at'], '', true) ?>
                                                            <?= $item[$content->post_status] == 1 ? '<i class="fa-solid fa-globe"></i>' : '<i class="fa-solid fa-lock"></i>' ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="icon icon-ra icon-sm" data-name="btn-edit-content">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                            </div>
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
                                            <div class="post-feature">
                                                <ul class="df-l">
                                                    <li class="df-c">
                                                        <div class="icon icon-ra icon-ra-sm">
                                                            <i class="fa-regular fa-thumbs-up"></i>
                                                        </div>
                                                        <p><?= $item['reacte_link'] ?></p>
                                                    </li>
                                                    <li class="df-c">
                                                        <div class="icon icon-ra icon-ra-sm">
                                                            <i class="fa-regular fa-bookmark"></i>
                                                        </div>
                                                        <p><?= $item['reacte_save'] ?></p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="post-des">
                                                <blockquote>
                                                    <?php
                                                    $sanitized_output = sanitizeContent($item[$content->post_des]);
                                                    ?>
                                                    <p><?= $sanitized_output ?></p>
                                                </blockquote>
                                            </div>
                                            <div class="post-foot df-s">
                                                <form action="/post/reacte" method="POST" class="see form-seereacte">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                    <input type="text" name="action" class="txt-action" value="getReaction" hidden>
                                                    <input type="number" name="<?=$content->id?>" value="<?= $item['content_id'] ?>" hidden>
                                                    <button class="btn icon icon-ra icon-sm curs-p">See reatetion</button>
                                                </form>
                                                <form action="/post/content" method="POST" class="form-delete-content">
                                                    <input type="text" class="txt-action" name="action" value="deleteContent" hidden>
                                                    <input type="number" class="txt-id" name="<?=$content->id?>" value="<?= $item['content_id'] ?>" hidden>
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                    <button type="submit" class="btn icon icon-ra icon-sm curs-p text-be" style="--text-:'delete post.'; --top-: 3.5rem;"><i class="fa-regular fa-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- this is mian btn for add new link  -->
        <div class="main-btn df-c add-a-new-link">
            <div class="btn icon icon-ra" onclick="hiddenForm('#form-link')">
                <i class="fa-solid fa-plus"></i>
                Add new
            </div>
        </div>
    </main>
    <!-- this is form for add new post  -->
    <div class="web-form form-post-content" id="form-post">
        <form action="/post/content" method="post" class="db-c" enctype="multipart/form-data"
            data-name="form-post-content">
            <input type="text" name="action" class="txt-action" value="content" data-name="txt-action" hidden>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
            <input type="number" name="<?= $content->id ?>" class="txt-id" value="" hidden>
            <div class="web-form-body web-form-body-scall">
                <!-- this is header  -->
                <div class="head df-s">
                    <h2><span></span></h2>
                    <a><span>Make new content</span></a>
                    <div class="icon-ra icon-sm df-c btn-close-form-post-content">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <!-- this is content  -->
                <div class="con db-c">
                    <div class="con-body db-c">
                        <!-- this Is head user form  -->
                        <div class="form-head">
                            <ul class="df-s">
                                <li class="profile-user df-l">
                                    <div class="profile profile-img df-c icon icon-ra icon-ra-sm">
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
                                    <div class="profile-name left-05">
                                        <h2><?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                        </h2>
                                        <p class="taget_date"><?= convertDate(date('Y-m-d H:i:s'), '') ?></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="status df-c">
                                        <select name="<?= $content->post_status ?>"
                                            data-name="<?= $content->post_status ?>">
                                            <option value="1">Public</option>
                                            <option value="2">Privete</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- this is content  -->
                        <div class="main scroll-y" id="taget-height">
                            <div class="box">
                                <!-- thi is title  -->
                                <div class="txt-title">
                                    <label for="#">Title</label>
                                    <div class="txt-title-box">
                                        <input type="text" name="<?= $content->post_title ?>"
                                            placeholder="Enter title of content"
                                            data-name="<?= $content->post_title ?>">
                                    </div>
                                </div>
                                <div class="text-caption">
                                    <label for="#">Description</label>
                                    <div class="txt-caption-box" data-replicated-value="null">
                                        <textarea name="<?= $content->post_des ?>" id="data-text" maxlength="500"
                                            placeholder="Descript about your content?"
                                            oninput="document.querySelector('#caption-count').innerText = (this.value).length"
                                            data-name="<?= $content->post_des ?>"></textarea>
                                    </div>
                                    <div class="df-r text-length">
                                        <div class="text df-r">
                                            <span id="caption-count">0</span>
                                            <span>/500</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- this is content photo  -->
                                <input type="file" id="x-file-post" hidden="" name="<?= $content->post_img ?>"
                                    onchange="previewImage(event,'.x-box-post-content')" accept=".jpg,.png,.web,.jpeg">
                                <div class="txt-photo df-c" onclick="document.querySelector('#x-file-post').click()">
                                    <div class="txt-photo-box x-box-post-content" id="#">
                                        <ul>
                                            <li class="icon-ra-sm"><i class="fa-solid fa-photo-film"></i></li>
                                            <li>
                                                <h2>Selecte image of content</h2>
                                            </li>
                                            <li>
                                                <p>Size of image2048</p>
                                            </li>
                                        </ul>
                                        <img src="#" class="img-c" alt="soeng">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- this is footer  -->
                        <div class="foot">
                            <div class="foot-body df-s">
                                <h2>Choose other feature</h2>
                                <ul class="df-c">
                                    <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះមាតិការ'"
                                        onclick="hiddenForm('#form-post')">
                                        <i class="fa-regular fa-image"></i>
                                    </li>
                                    <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះលិង'"
                                        onclick="hiddenForm('#form-link')">
                                        <i class="fa-solid fa-link"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- this is footer form  -->
                <div class="submit-form">
                    <div class="box df-c">
                        <button class="btn icon-ra" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="form-b"></div>
    </div>
    <!-- this is form for edit profile picture -->
    <div class="web-form edit-profile" id="edit-profile">
        <div class="web-form-body edit-profile-body">
            <!-- this is header  -->
            <div class="head df-s">
                <div class="icon-ra icon-sm df-c"
                    onclick="document.querySelector('#edit-profile').classList.toggle('web-form-active')">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </div>
                <a><span>Edit profile</span></a>
                <div class="icon-ra icon-sm df-c bg-n">
                    <!-- <i class="fa-solid fa-xmark"></i> -->
                </div>
            </div>
            <!-- this is content  -->
            <div class="con db-c">
                <div class="con-body db-c">
                    <!-- this is content  -->
                    <div class="main scroll-y" id="taget-height">
                        <div class="box">
                            <!-- this is for update profile picture  -->
                            <form class="form-pro" action="/edit/profile" method="POST" enctype="multipart/form-data">
                                <input type="text" name="action" value="<?= $userDetail->profile ?>" hidden>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                <input type="file" id="in-file1" name="<?= $userDetail->profile ?>"
                                    accept=".jpg,.png,.jpeg,.web" hidden
                                    onchange="document.querySelector('#form-btn-edite-profile').click();previewImage(event,'.x-profile')"
                                    require>
                                <div class="form-pro-body">
                                    <div class="form-head df-s">
                                        <h2>Profile picture</h2>
                                        <label for="in-file1">Edit</label>
                                    </div>
                                    <div class="you-pro df-c">
                                        <div class="profile icon icon-ra x-profile"
                                            onclick="document.querySelector('#in-file1').click()">
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
                                            } else {
                                                if ($getUser[$userDetail->first_name] !== '' || $getUser[$userDetail->last_name] !== '') { ?>
                                                    <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                        <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                                    </h2>
                                                <?php }
                                            }
                                            ?>
                                            <label for="#" class="df-c">
                                                <div class="icon"><i class='bx bxs-camera'></i></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button hidden type="submit" id="form-btn-edite-profile"></button>
                            </form>
                            <!-- this is for update cover image  -->
                            <form class="form-pro" action="/edit/profile" method="POST" enctype="multipart/form-data">
                                <input type="text" name="action" value="<?= $userDetail->cover ?>" hidden>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                <div class="form-pro-body">
                                    <div class="form-head df-s">
                                        <h2>Cover photo</h2>
                                        <label for="x-cover">Edit</label>
                                    </div>
                                    <div class="you-pro">
                                        <div class="you-cover">
                                            <input type="file" id="x-cover" hidden name="<?= $userDetail->cover ?>"
                                                onchange="previewImage(event,'.x-cover');
                                            document.querySelector('#x-btn-cover').click()" require>
                                            <div class="txt-photo df-c x-cover"
                                                onclick="document.querySelector('#x-cover').click()">
                                                <div class="txt-photo-box txt-photo-box-active " id="#">
                                                    <ul>
                                                        <li class="icon-ra-sm"><i class="fa-solid fa-photo-film"></i>
                                                        </li>
                                                        <li>
                                                            <h2>Selecte image of content</h2>
                                                        </li>
                                                        <li>
                                                            <p>Size of image2048</p>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    if (file_exists('storage/upload/' . $getUser[$userDetail->cover])) { ?>
                                                        <img class="img-c" loading="lazy" srcset="
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=100? 100w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=200? 200w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=400? 400w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=800? 800w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=1000? 1000w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->cover]) ?>?width=1200? 1200w, 
                                                                " sizes="(max-width: 800px) 100vw, 50vw"
                                                            decoding="async" fetchPriority="high" effect="blur" alt="">
                                                        <?php
                                                    } else {
                                                        if ($getUser[$userDetail->first_name] && $getUser[$userDetail->last_name]) { ?>
                                                            <h2 class="notfound"
                                                                style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                                <?= substr($getUser[$userDetail->first_name] . $_SESSION[$userDetail->last_name], 0, 1) ?>
                                                            </h2>
                                                        <?php }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button hidden type="submit" id="x-btn-cover"></button>
                            </form>
                            <!-- this is for update bio of user  -->
                            <form action="/edit/profile" method="POST" class="form-pro">
                                <input type="text" name="action" value="<?= $userDetail->bio ?>" hidden>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                <div class="form-pro-body">
                                    <div class="form-head df-s">
                                        <h2>Bio</h2>
                                        <label for="x-bio" id="l-bio" onclick="if(this.innerText.trim() == 'Update'){
                                        document.querySelector('#x-btn-bio').click()}">Edit</label>
                                    </div>
                                    <div class="you-pro">
                                        <div class="you-bio">
                                            <div class="text-caption">
                                                <div class="txt-caption-box" data-replicated-value="null">
                                                    <textarea name="<?= $userDetail->bio ?>" id="x-bio" maxlength="500"
                                                        placeholder="Descript about yours?" oninput="document.querySelector('#x-bio-caption-count').innerText = (this.value).length;
                                                    if(this.value !== ''){ document.querySelector('#l-bio').innerText = 'Update'}else{
                                                    document.querySelector('#l-bio').innerText = 'Edit'};" require
                                                        maxlength="100"><?= $getUser[$userDetail->bio] ?></textarea>
                                                </div>
                                                <div class="df-r text-length">
                                                    <div class="text df-r">
                                                        <span
                                                            id="x-bio-caption-count"><?= strlen($getUser[$userDetail->bio]) ?></span>
                                                        <span>/100</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="x-btn-bio" hidden></button>
                            </form>
                            <!-- this is for update image share link list -->
                            <form class="form-pro" action="/edit/profile" method="POST" enctype="multipart/form-data">
                                <input type="text" name="action" value="<?= $userDetail->img_share ?>" hidden>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                <div class="form-pro-body">
                                    <div class="form-head df-s">
                                        <h2>Share image</h2>
                                        <label for="x-img-share">Edit</label>
                                    </div>
                                    <div class="you-pro">
                                        <div class="you-cover">
                                            <input type="file" id="x-img-share" hidden
                                                name="<?= $userDetail->img_share ?>" onchange="previewImage(event,'.x-share');
                                            document.querySelector('#x-btn-share').click()" require>
                                            <div class="txt-photo df-c x-share"
                                                onclick="document.querySelector('#x-img-share').click()">
                                                <div class="txt-photo-box txt-photo-box-active" id="#">
                                                    <ul>
                                                        <li class="icon-ra-sm"><i class="fa-solid fa-photo-film"></i>
                                                        </li>
                                                        <li>
                                                            <h2>Selecte image of content</h2>
                                                        </li>
                                                        <li>
                                                            <p>Size of image2048</p>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    if (file_exists('storage/upload/' . $getUser[$userDetail->img_share])) { ?>
                                                        <img class="img-c" loading="lazy" srcset="
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=100? 100w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=200? 200w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=400? 400w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=800? 800w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=1000? 1000w, 
                                                                <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=1200? 1200w, 
                                                                " sizes="(max-width: 800px) 100vw, 50vw"
                                                            decoding="async" fetchPriority="high" effect="blur" alt="">
                                                        <?php
                                                    } else {
                                                        if ($getUser[$userDetail->first_name] && $getUser[$userDetail->last_name]) { ?>
                                                            <h2 class="notfound"
                                                                style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                                <?= substr($getUser[$userDetail->first_name] . $_SESSION[$userDetail->last_name], 0, 1) ?>
                                                            </h2>
                                                        <?php }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button hidden type="submit" id="x-btn-share"></button>
                            </form>
                            <!-- this is user profile detail   -->
                            <div class="form-pro">
                                <div class="form-pro-body">
                                    <div class="form-head df-s">
                                        <h2>Detail profile</h2>
                                        <label for="#" onclick="hiddenForm('#form-profile-detail')">Edit</label>
                                    </div>
                                    <div class="you-pro">
                                        <div class="you-detail">
                                            <!-- this is user name  -->
                                            <div class="list-dtail">
                                                <div class="list-detal-box df-l">
                                                    <div class="icon icon-ra icon-sm">
                                                        <i class='bx bxs-user'></i>
                                                    </div>
                                                    <h2>@<?= $getUser[$user->user_name] ?></h2>
                                                </div>
                                            </div>
                                            <!-- this is email user  -->
                                            <?php if (validateInput($getUser[$user->email]) === "Email") { ?>
                                                <div class="list-dtail">
                                                    <div class="list-detal-box df-l">
                                                        <div class="icon icon-ra icon-sm">
                                                            <i class='bx bxs-envelope'></i>
                                                        </div>
                                                        <h2><?= $getUser[$user->email] ?></h2>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- this is phone of user  -->
                                            <?php if (validateInput($getUser[$user->email]) === "Phone") { ?>
                                                <div class="list-dtail">
                                                    <div class="list-detal-box df-l">
                                                        <div class="icon icon-ra icon-sm">
                                                            <i class='bx bxs-phone-call'></i>
                                                        </div>
                                                        <h2><?= $getUser[$user->email] ?></h2>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- this Is fist name and last name of user  -->
                                            <div class="list-dtail">
                                                <div class="list-detal-box df-l">
                                                    <div class="icon icon-ra icon-sm">
                                                        <i class='bx bxs-circle-three-quarter'></i>
                                                    </div>
                                                    <h2>
                                                        <?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?>
                                                    </h2>
                                                </div>
                                            </div>
                                            <!-- this is birthday of user  -->
                                            <div class="list-dtail">
                                                <div class="list-detal-box df-l">
                                                    <div class="icon icon-ra icon-sm">
                                                        <i class='bx bxs-gift'></i>
                                                    </div>
                                                    <h2>
                                                        <?php if ($getUser[$userDetail->user_birthday] !== null) {
                                                            echo $getUser[$userDetail->user_birthday];
                                                        } else {
                                                            echo 'No birthday';
                                                        }
                                                        ?>
                                                    </h2>
                                                </div>
                                            </div>
                                            <!-- this is follower of user  -->
                                            <div class="list-dtail">
                                                <?php
                                                $user_id = $getUser[$userDetail->id];
                                                $sql = "SELECT COUNT(*) AS follower FROM $follower->model
                                                        WHERE $follower->user_follower_id = '$user_id'";
                                                $result = $conn->query($sql);
                                                ?>
                                                <div class="list-detal-box df-l wifi">
                                                    <div class="icon icon-ra icon-sm">
                                                        <i class='bx bx-wifi'></i>
                                                    </div>
                                                    <h2>Follow by
                                                        <?php if ($result) {
                                                            $result = $result->fetch_assoc();
                                                            echo $result['follower'];
                                                        } else {
                                                            echo '0';
                                                        } ?>
                                                        people</h2>
                                                </div>
                                            </div>
                                            <!-- this is address of user  -->
                                            <div class="list-dtail">
                                                <div class="list-detal-box df-l">
                                                    <div class="icon icon-ra icon-sm">
                                                        <i class='bx bx-current-location'></i>
                                                    </div>
                                                    <h2>
                                                        <?php if ($getUser[$userDetail->user_address] !== null) {
                                                            if ($arrayProvince) {
                                                                echo $arrayProvince[$getUser[$userDetail->user_address]]['province'];
                                                            }
                                                        } else {
                                                            echo 'No provided address';
                                                        }
                                                        ?>
                                                    </h2>
                                                </div>
                                            </div>
                                            <div class="list-dtail">
                                                <div class="list-detal-box df-l">
                                                    <div class="icon icon-ra icon-sm">
                                                        <i class='bx bxs-calendar-week'></i>
                                                    </div>
                                                    <h2>
                                                        <span>Join:</span>
                                                        <?php if ($getUser[$user->created_at] !== null || $getUser[$user->created_at] !== '') {
                                                            echo convertDate($getUser[$user->created_at], '');
                                                        } else {
                                                            echo 'Error: userJonin';
                                                        }
                                                        ?>
                                                    </h2>
                                                </div>
                                            </div>
                                            <!-- this Is password  -->
                                            <div class="list-dtail">
                                                <div class="list-detal-box df-l">
                                                    <div class="icon icon-ra icon-sm">
                                                        <i class='bx bx-key'></i>
                                                    </div>
                                                    <h2>Protect by linkme...</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- this is footer  -->
                    <div class="foot">
                        <div class="foot-body df-s">
                            <h2>Choose other feature</h2>
                            <ul class="df-c">
                                <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះមាតិការ'"
                                    onclick="hiddenForm('#form-post')">
                                    <i class="fa-regular fa-image"></i>
                                </li>
                                <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះលិង'"
                                    onclick="hiddenForm('#form-link')">
                                    <i class="fa-solid fa-link"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- this is footer form  -->
            <div class="submit-form">
                <div class="box df-c">
                    <button class="btn icon-ra" type="submit"
                        onclick="document.querySelector('#edit-profile').classList.toggle('web-form-active')">Save</button>
                </div>
            </div>
        </div>
        <div class="form-b" onclick="document.querySelector('#form-post').classList.toggle('web-form-active')"></div>
    </div>
    <!-- this Is form edite profile detail of user  -->
    <form action="/edit/profile" method="POST" id="x-form-detail">
        <div class="web-form edit-profile" id="form-profile-detail">
            <div class="web-form-body edit-profile-body">
                <input type="text" name="action" class="txt-action" value="<?= $userDetail->model ?>" hidden>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                <!-- this is header  -->
                <div class="head df-s">
                    <div class="icon-ra icon-sm df-c"
                        onclick="document.querySelector('#form-profile-detail').classList.toggle('web-form-active')">
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </div>
                    <a><span>Edit profile</span></a>
                    <div class="icon-ra icon-sm df-c bg-n">
                        <!-- <i class="fa-solid fa-xmark"></i> -->
                    </div>
                </div>
                <!-- this is content  -->
                <div class="con db-c">
                    <div class="con-body db-c">
                        <!-- this is content  -->
                        <div class="main scroll-y" id="taget-height" style="hi">
                            <div class="box">
                                <!-- thi is title  -->
                                <div class="txt-title">
                                    <label for="#">Username</label>
                                    <div class="txt-title-box x-username">
                                        <input type="text" name="<?= $user->user_name ?>"
                                            value="<?= $getUser[$user->user_name] ?>" placeholder="Enter your username">
                                    </div>
                                </div>
                                <!-- this is for @email  -->
                                <div class="txt-title">
                                    <label for="#">Email</label>
                                    <div class="txt-title-box x-email">
                                        <input type="text" name="<?= $user->email ?>"
                                            value="<?= $getUser[$user->email] ?>" placeholder="Enter your Email">
                                    </div>
                                </div>
                                <!-- this is password  -->
                                <div class="txt-title">
                                    <label for="#">Password</label>
                                    <div class="txt-title-box">
                                        <input type="password" id="x-password" name="<?= $user->password ?>"
                                            value="<?= $getUser[$user->password] ?>" placeholder="Enter your password">
                                        <div class="lead" onclick="
                                        this.classList.toggle('eye-active');
                                        if(document.querySelector('#x-password').getAttribute('type') == 'password'){
                                            document.querySelector('#x-password').setAttribute('type','text');
                                        }else{
                                            document.querySelector('#x-password').setAttribute('type','password');
                                        }
                                        ;
                                        ">
                                            <div class="icon icon-ra icon-sm">
                                                <i class='bx bxs-low-vision'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- this is seclect gender  -->
                                <div class="txt-select">
                                    <ul>
                                        <li>
                                            <label>Gender</label>
                                            <div class="txt-select-list-con df-c">
                                                <select name="<?= $userDetail->gender ?>">
                                                    <option value='<?= $getUser[$userDetail->gender] ?>'>
                                                        <?= $arrayGender[$getUser[$userDetail->gender]] ?>
                                                    </option>
                                                    <?php
                                                    if ($arrayGender) {
                                                        foreach ($arrayGender as $index => $item) {
                                                            if ($index == $getUser[$userDetail->gender]) {
                                                                continue;
                                                            } else {
                                                                echo "<option value='$index'>" . $item . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- this is for @email  -->
                                <div class="txt-title">
                                    <label for="#">First name</label>
                                    <div class="txt-title-box">
                                        <input type="text" name="<?= $userDetail->first_name ?>"
                                            value="<?= $getUser[$userDetail->first_name] ?>"
                                            placeholder="Enter your first name">
                                    </div>
                                </div>
                                <!-- this is for @email  -->
                                <div class="txt-title">
                                    <label for="#">Last name</label>
                                    <div class="txt-title-box">
                                        <input type="text" name="<?= $userDetail->last_name ?>"
                                            value="<?= $getUser[$userDetail->last_name] ?>"
                                            placeholder="Enter your last name">
                                    </div>
                                </div>
                                <div class="txt-title">
                                    <label for="#">birthday</label>
                                    <div class="txt-title-box">
                                        <input type="date" name="<?= $userDetail->user_birthday ?>"
                                            value="<?= $getUser[$userDetail->user_birthday] ?>"
                                            placeholder="Set your birthday">
                                    </div>
                                </div>
                                <!-- this is select user address  -->
                                <div class="txt-select">
                                    <ul>
                                        <li>
                                            <label for="#">Address</label>
                                            <div class="txt-select-list-con df-c">
                                                <select name="<?= $userDetail->user_address ?>">
                                                    <?php
                                                    $userAdress = $getUser[$userDetail->user_address];
                                                    if ($userAdress !== null) {
                                                        echo "<option value='$userAdress'>" . $arrayProvince[$userAdress]['province'] . "</option>";
                                                    } else {
                                                        echo "<option value=''>Select Address</option>";
                                                    }
                                                    if ($arrayProvince) {
                                                        foreach ($arrayProvince as $index => $item) {
                                                            if ($userAdress !== null) {
                                                                if ($index == $userAdress) {
                                                                    continue;
                                                                } else {
                                                                    echo "<option value='$index'>" . $item['province'] . "</option>";
                                                                }
                                                            } else {
                                                                echo "<option value='$index'>" . $item['province'] . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- this is footer  -->
                        <div class="foot">
                            <div class="foot-body df-s">
                                <h2>Choose other feature</h2>
                                <ul class="df-c">
                                    <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះមាតិការ';--top-:2.8rem;"
                                        onclick="hiddenForm('#form-post')">
                                        <i class="fa-regular fa-image"></i>
                                    </li>
                                    <li class="icon icon-ra-sm text-be" style="--text-: 'បង្ហោះលិង'; --top-:2.8rem;"
                                        onclick="hiddenForm('#form-link')">
                                        <i class="fa-solid fa-link"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- this is footer form  -->
                <div class="submit-form">
                    <div class="box df-c">
                        <button class="btn icon-ra" id="x-btn-edit-detail" type="submit">Save</button>
                    </div>
                </div>
            </div>
            <div class="form-b"
                onclick="document.querySelector('#form-profile-detail').classList.toggle('web-form-active')"></div>
        </div>
    </form>
    <!-- this is all script  -->
    <script>
        function hiddenForm(activeElement, formElement = '.web-form') {
            var form = document.querySelectorAll(formElement);
            var active = document.querySelector(activeElement);
            form.forEach((e, i) => {
                e.classList.remove('web-form-active');
                active.classList.add('web-form-active');
            })
        }
    </script>
    <!-- this is all link  -->
    <script src="<?= getBaseUrl('public/js/function.js?v=' . time()) ?>"></script>
    <script src="<?= getBaseUrl('public/js/you.js?v=' . time()) ?>"></script>
</body>

</html>
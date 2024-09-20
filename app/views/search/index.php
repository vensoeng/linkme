<?php

require 'database/index.php';
require 'database/ui/index.php';
include 'app/config/functions.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/model/tb_post_type.php';
require 'app/model/tb_content.php';
require 'app/model/tb_follower.php';
require 'app/model/tb_reacte.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\Follower\Follower as Follower;
use App\Model\Content\Content as Content;
use App\Model\Reacte\Reacte as Reacte;

$user = new User();
$userDetail = new UserDetail();
$content = new Content();
$reacte = new Reacte();
$follower = new Follower();

if(!isset($_POST['action']) || $_POST['action'] !== 'search'){
    die();
}else if(!isset($_POST['search']) || trim($_POST['search']) == ''){
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
    require 'app/views/layout/head.php'; 
?>
<link rel="stylesheet" href="<?=getBaseUrl('public/css/seemore.css?v='.time())?>">
<style>
    
</style>
<body>
    <?php
        require 'app/views/layout/header.php';
    ?>
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
    <main class="web-main db-c">
        <div class="web-main-body df-l">
            <!-- this is aside left  -->
            <?php
                require 'app/views/layout/aside_left.php';
            ?>
            <!-- this is content with aside -->
            <div class="web-con">
                <div class="web-con-body">
                    <nav class="seemore-head">
                        <div class="box df-l">
                            <div class="icon icon-ra curs-p" onclick="history.back()">
                                <i class='bx bx-arrow-back'></i>
                            </div>
                            <h2>Search result</h2>
                        </div>
                    </nav>
                    <!-- this is user list  -->
                    <ul class="all-user">
                        <?php
                            $txtSearch = $_POST['search'];
                            $sql = "
                                SELECT
                                    u.{$user->user_name},
                                    u.{$user->verify_status},
                                    d.{$userDetail->user_detail_id},
                                    d.{$userDetail->profile},
                                    d.{$userDetail->first_name},
                                    d.{$userDetail->last_name},
                                    CONCAT(d.{$userDetail->first_name}, ' ', d.{$userDetail->last_name}) AS full_name,
                                    d.{$userDetail->bio},
                                    (SELECT COUNT(*) FROM {$content->model} WHERE {$content->user_post_id} = d.{$userDetail->user_detail_id}) AS post_count,
                                    (SELECT COUNT(*) FROM {$follower->model} WHERE {$follower->user_follower_id} = d.{$userDetail->user_detail_id}) AS follower_count,
                                    (SELECT COUNT(*) FROM {$follower->model} WHERE {$follower->user_sand_follower_id} = d.{$userDetail->user_detail_id}) AS following_count
                                FROM {$userDetail->model} d
                                INNER JOIN {$user->model} u
                                    ON d.{$userDetail->user_detail_id} = u.{$user->id}
                                WHERE u.{$user->user_name} LIKE '%$txtSearch%'
                                    OR CONCAT(d.{$userDetail->first_name}, ' ', d.{$userDetail->last_name}) LIKE '%$txtSearch%'
                                ";
                            $userItems = $conn->query($sql);
                            if($userItems && mysqli_num_rows($userItems) > 0){
                                foreach ($userItems as $index => $item) {
                                    ?>
                                    <li class="user-item">
                                        <div class="user-box">
                                            <div class="head df-s">
                                                <div class="row df-l">
                                                    <a href="/user/<?=$item[$user->user_name]?>" class="profile icon icon-ra icon-sm">
                                                        <?php
                                                        if (file_exists('storage/upload/' . $item[$userDetail->profile])) { ?>
                                                            <img class="img-c" loading="lazy" srcset="
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=100? 100w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=200? 200w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=400? 400w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=800? 800w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                                    " sizes="(max-width: 800px) 100vw, 50vw" decoding="async"
                                                                fetchPriority="high" effect="blur" alt="">
                                                            <?php
                                                        } else { ?>
                                                            <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                                <?= substr($item[$userDetail->first_name] . $item[$userDetail->last_name], 0, 1) ?>
                                                            </h2>
                                                        <?php }
                                                        ?>
                                                    </a>
                                                    <div class="list">
                                                        <p>Post</p>
                                                        <h2><?=$item['post_count']?></h2>
                                                    </div>
                                                    <div class="list">
                                                        <p>Follower</p>
                                                        <h2><?=$item['follower_count']?></h2>
                                                    </div>
                                                    <div class="list">
                                                        <p>Following</p>
                                                        <h2><?=$item['following_count']?></h2>
                                                    </div>
                                                </div>
                                                <form action="/user/<?=$item[$user->user_name]?>" method="post">
                                                    <button class="btn icon icon-ra icon-sm">Profile</button>
                                                </form>                                 
                                            </div>
                                            <blockquote>
                                                <div class="user-name">
                                                    <h2><?=$item['full_name']?></h2>
                                                    <p>@<?=$item[$user->user_name]?></p>
                                                </div>
                                                <div class="about">
                                                    <h2>About</h2>
                                                    <p><?=$item[$userDetail->bio]?></p>
                                                </div>
                                            </blockquote>
                                            <div class="foot df-s">
                                                <form action="/" method="post">
                                                    <button class="icon-ra btn icon icon-sm">Profile</button>
                                                </form>
                                                <form action="/user/<?=$item[$user->user_name]?>" method="post">
                                                    <button class="icon-ra btn icon icon-sm">Profile</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                        ?>
                    </ul>
                    <!-- this is for post to user -->
                    <div class="web-post">
                        <div class="user-post">
                            <div class="user-post-body">
                                <ul>
                                    <?php
                                        $txtSearch = $_POST['search'];
                                        $sql = "
                                            SELECT
                                                c.{$content->id} AS content_id,
                                                d.{$userDetail->first_name},
                                                d.{$userDetail->last_name},
                                                d.{$userDetail->profile},
                                                d.{$userDetail->user_detail_id},
                                                c.{$content->created_at} AS content_created_at,
                                                u.{$user->verify_status},
                                                u.{$user->user_name},
                                                c.*,
                                                (SELECT COUNT(*) FROM {$reacte->model} r1 WHERE r1.{$reacte->post_id} = c.{$content->id} AND r1.{$reacte->reate_type} = 1) AS reacte_link,
                                                (SELECT COUNT(*) FROM {$reacte->model} r2 WHERE r2.{$reacte->post_id} = c.{$content->id} AND r2.{$reacte->reate_type} = 2) AS reacte_save
                                            FROM {$content->model} c
                                            INNER JOIN {$userDetail->model} d
                                                ON c.{$content->user_post_id} = d.{$userDetail->user_detail_id}
                                            INNER JOIN {$user->model} u
                                                ON c.{$content->user_post_id} = u.{$user->id}
                                            WHERE c.{$content->post_title} LIKE '%$txtSearch%'
                                                OR c.{$content->post_des} LIKE '%$txtSearch%'
                                        ";

                                        $postResults = $conn->query($sql);
                                        if($postResults && mysqli_num_rows($postResults) > 0){
                                            foreach ($postResults as $index => $item) {
                                                ?>
                                                <li class="data_list">
                                                    <div class="head df-s">
                                                        <div class="post-profile df-l">
                                                            <a href="/user/<?= $item[$user->user_name] ?>" class="profile">
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
                                                            </a>
                                                            <a href="/user/<?= $item[$user->user_name] ?>" class="user-name">
                                                                <h2 style="width: max-content; max-width:100%; color:var(--sg-main-bg);"
                                                                    class="<?= $item[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                                                    <?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                                                </h2>
                                                                <p style="color:var(--sg-main-bg);">
                                                                    <?= convertDate($item['content_created_at'], '', true) ?>
                                                                    <?= $item[$content->post_status] == 1 ? '<i class="fa-solid fa-globe"></i>' : '<i class="fa-solid fa-lock"></i>' ?>
                                                                </p>
                                                            </a>
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
                                                            <li class="df-c" data-name="addreacte">
                                                                    <button class="icon icon-ra icon-ra-sm bg-n like">
                                                                        Like
                                                                    </button>
                                                                    <p class="text"><?= $item['reacte_link'] ?></p>
                                                            </li>
                                                            <li class="df-c" data-name="addreacte">
                                                                    <button class="icon icon-ra icon-ra-sm bg-n save book">
                                                                        Save
                                                                    </button>
                                                                <p class="text"><?= $item['reacte_link'] ?></p>
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
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= getBaseUrl('public/js/function.js?v=' . time()) ?>"></script>
    <script>
        // ======================this Is for see reaction ====================
        var formSeeReactions = document.querySelectorAll('.form-seereacte');
        var formPopup = document.querySelector('.form-reaction');
        formSeeReactions.forEach((element) => {
        element.addEventListener('submit', function (event) {
            event.preventDefault();

            const action =  element.getAttribute("action");
            const method = "POST";
            const formData = new FormData(element);

            fetch(action, {
            method: method,
            body: formData,
            }).then((response) => response.text()).then((data) => {
                if (data.trim() !== "") {
                formPopup.querySelector('.reate').innerHTML = data;

                var uls = formPopup.querySelectorAll('.reate ul');
                var btnReactions = formPopup.querySelectorAll('.i-reaction');
                
                btnReactions.forEach((element, index) => {
                    btnReactions[index].querySelector('span').innerText = uls[index].querySelectorAll('li').length;

                    element.addEventListener('click', function () {
                    uls.forEach((e) => { e.classList.remove('active') });
                    btnReactions.forEach((e) => { e.classList.remove('i-reaction-active') });

                    btnReactions[index].classList.add('i-reaction-active');
                    uls[index].classList.add('active');
                    });
                });

                formPopup.classList.add('form-reaction-active');
                }
            }).catch((error) => {
                if (error.trim !== "") {
                    alertForm(data);
                } else {
                    console.log("data content is empty");
                }
            });
        })

        });
        function toggleClass(mainClass, activeClass, removeClass = "") {
            if(mainClass !== ''){
                var main = document.querySelector(mainClass);
                if(main){
                    main.classList.add(activeClass);
                    removeClass !== "" ? main.classList.remove(removeClass) : (removeClass = "");
                }
            }
        }
    </script>
</body>
</html>
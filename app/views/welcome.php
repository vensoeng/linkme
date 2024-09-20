<?php

session_start();

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

if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
    $user_id = $_SESSION[$user->id];

    $sql = "SELECT * FROM $userDetail->model
        INNER JOIN $user->model ON $userDetail->model.$userDetail->user_detail_id = $user->model.$user->id
        WHERE  $userDetail->model.$userDetail->user_detail_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $getUser = $result->fetch_assoc();
    }
}
// ================this is se csrf token not user edit code=========== 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
    require 'app/views/layout/head.php'; 
?>
<body>
    <?php
        require 'app/views/layout/header.php';
    ?>
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
                    <ul>
                        <li class="df-s">
                            <div class="user-profile df-l">
                                <a href="#" class="profile icon icon-ra">
                                    <img class="img-c" src="<?= getBaseUrl('') ?>public/images/profile.jpg" alt="">
                                </a>
                                <div class="text">
                                    <a href="#">
                                        <h2>VenSoeng</h2>
                                    </a>
                                    <p>@vensoeng001</p>
                                </div>
                            </div>
                            <div class="btn icon icon-ra icon-sm">
                                <i class='bx bxs-like'></i>
                            </div>
                        </li>
                        <li class="df-s">
                            <div class="user-profile df-l">
                                <a href="#" class="profile icon icon-ra">
                                    <img class="img-c" src="<?= getBaseUrl('') ?>public/images/profile.jpg" alt="">
                                </a>
                                <div class="text">
                                    <a href="#">
                                        <h2>VenSoeng</h2>
                                    </a>
                                    <p>@vensoeng001</p>
                                </div>
                            </div>
                            <div class="btn icon icon-ra icon-sm">
                                <i class='bx bxs-bookmarks'></i>
                            </div>
                        </li>
                        <li class="df-s">
                            <div class="user-profile df-l">
                                <a href="#" class="profile icon icon-ra">
                                    <img class="img-c" src="<?= getBaseUrl('') ?>public/images/profile.jpg" alt="">
                                </a>
                                <div class="text">
                                    <a href="#">
                                        <h2>VenSoeng</h2>
                                    </a>
                                    <p>@vensoeng001</p>
                                </div>
                            </div>
                            <div class="btn icon icon-ra icon-sm">
                                <i class='bx bxs-like'></i>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="foot df-l">
                    <p>This is feature <strong>Linkme</strong></p>
                </div>
            </div>
        </div>
        <div class="reat-bg form-fix"></div>
    </div>
    <!-- -------------this  is form popup---------- -->
    <div class="form-pop form-fix df-c">
        <div class="form-pop-body">
            <div class="form-pop-body-con">
                <div class="head df-s">
                    <a class="icon icon-ra icon-sm curs-p" onclick="toggleClassSmall('.form-pop','form-pop-active')">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    <h2>Login linkme to get better</h2>
                </div>
                <blockquote>
                    <p>Logging in unlocks exclusive content, personalized recommendations, and seamless access to all
                        our services. Stay updated and enjoy enhanced security—join our community today!</p>
                </blockquote>
                <div class="foot">
                    <a href="signup/" class="btn icon icon-ra icon-sm">
                        Signup for free
                    </a>
                    <a href="#" class="btn icon icon-ra icon-sm">
                        Find out more
                    </a>
                </div>
            </div>
        </div>
        <div class="form-pop-bg form-fix"></div>
    </div>
    <!-- this is content of page  -->
    <main class="web-main db-c">
        <div class="web-main-body df-l">
            <!-- this is aside left  -->
            <?php
                require 'app/views/layout/aside_left.php';
            ?>
            <!-- this is content with aside -->
            <div class="web-con">
                <div class="web-con-body df-c">
                    <!-- this is for user post  -->
                    <div class="web-post">
                        <div class="user-post">
                            <div class="user-post-body">
                                <!-- this is header of content it show user profile -->
                                <?php
                                if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                                    ?>
                                    <nav class="head-user head-user-active">
                                        <div class="scroll-x df-l">
                                            <?php
                                            if ($getUser) {
                                                ?>
                                                <a class="list" style="--bg-: url('')"
                                                onclick="document.querySelector('#form-post').classList.add('web-form-active');">
                                                    <div class="icon icon-ra profile">
                                                        <!-- <img src="" alt=""> -->
                                                    </div>
                                                    <h2>Create</h2>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                            <?php

                                            $follower = new Follower();

                                            $sql = "
                                                SELECT
                                                    d.{$userDetail->user_detail_id} AS user_id,
                                                    f.{$follower->id} AS follow_id,
                                                    c.{$content->id} AS post_id,
                                                    u.{$user->user_name},
                                                    d.{$userDetail->first_name},
                                                    d.{$userDetail->last_name},
                                                    d.{$userDetail->profile},
                                                    c.{$content->user_post_id},
                                                    c.{$content->post_status},
                                                    c.{$content->post_title},
                                                    c.{$content->post_des},
                                                    c.{$content->post_img},
                                                    c.{$content->created_at},
                                                    c.{$content->updated_at},
                                                    f.*
                                                FROM {$follower->model} f
                                                INNER JOIN {$userDetail->model} d
                                                    ON f.{$follower->user_follower_id} = d.{$userDetail->user_detail_id}
                                                INNER JOIN {$user->model} u
                                                    ON d.{$userDetail->user_detail_id} = u.{$user->id}
                                                INNER JOIN {$content->model} c
                                                    ON c.{$content->user_post_id} = d.{$userDetail->user_detail_id} AND c.{$content->post_status} = 1
                                                WHERE f.{$follower->user_sand_follower_id} = '$user_id'
                                                AND DATE(c.{$content->created_at}) = CURDATE()
                                                ORDER BY (c.{$content->user_post_id} = '$user_id') DESC, c.{$content->created_at} DESC";

                                            $result = $conn->query($sql);

                                            if ($result && mysqli_num_rows($result) == 0) {
                                                $sql = "
                                                    SELECT
                                                        c.{$content->id} AS post_id,
                                                        u.{$user->user_name},
                                                        d.{$userDetail->first_name},
                                                        d.{$userDetail->last_name},
                                                        d.{$userDetail->profile},
                                                        c.{$content->user_post_id},
                                                        c.{$content->post_status},
                                                        c.{$content->post_title},
                                                        c.{$content->post_des},
                                                        c.{$content->post_img},
                                                        c.{$content->created_at},
                                                        c.{$content->updated_at}
                                                    FROM {$content->model} c
                                                    INNER JOIN {$userDetail->model} d
                                                        ON c.{$content->user_post_id} = d.{$userDetail->user_detail_id}
                                                    INNER JOIN {$user->model} u
                                                        ON d.{$userDetail->user_detail_id} = u.{$user->id}
                                                    WHERE (c.{$content->user_post_id} = '$user_id' AND DATE(c.{$content->created_at}) = CURDATE())
                                                ";
                                                $result = $conn->query($sql);
                                            }
                                            if ($result) {
                                                foreach ($result as $index => $item) {
                                                    ?>
                                                    <a class="list data-list" data-name="user-profile">
                                                        <form action="/user/<?=$item[$user->user_name]?>" method="POST">
                                                            <input type="hidden" value="<?=$item['post_id']?>" name="user_post_id">
                                                            <button type="submit" class="icon icon-ra profile curs-p">
                                                                <?php
                                                                if (trim($item[$content->post_img]) !== '' && $item[$content->post_img] !== null) {
                                                                    ?>
                                                                    <img class="img-c" loading="lazy" srcset="
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=100? 100w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=200? 200w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=400? 400w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=800? 800w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=1000? 1000w, 
                                                                            <?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>?width=1200? 1200w, 
                                                                            " sizes="(max-width: 800px) 100vw, 50vw"
                                                                        decoding="async" fetchPriority="high" effect="blur" alt="">
                                                                    <?php
                                                                } else {
                                                                    ?>
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
                                                                }
                                                                ?>
                                                            </button type="submit">
                                                        </form>
                                                        <h2>
                                                            <?= $item[$content->user_post_id] == $user_id ? 'Your post' : $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                                        </h2>
                                                    </a>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <a class="list" href="https://web.facebook.com/profile.php?id=100041547633244"
                                                    style="--bg-: url('')">
                                                    <div class="icon icon-ra profile">
                                                        <h2>Error DB</h2>
                                                    </div>
                                                    <h2>Our Soppurt</h2>
                                                </a>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </nav>
                                    <?php
                                }
                                ?>
                                <!-- ----------------------this is post of user----------------------  -->
                                <ul>
                                    <?php

                                    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
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
                                                    r.*,
                                                    (SELECT COUNT(*) FROM {$reacte->model} r1 WHERE r1.{$reacte->post_id} = c.{$content->id} AND r1.{$reacte->reate_type} = 1) AS reacte_link,
                                                    (SELECT COUNT(*) FROM {$reacte->model} r2 WHERE r2.{$reacte->post_id} = c.{$content->id} AND r2.{$reacte->reate_type} = 2) AS reacte_save
                                                FROM {$content->model} c
                                                LEFT JOIN {$reacte->model} r
                                                    ON r.{$reacte->post_id} = c.{$content->id}
                                                    AND r.{$reacte->user_reacte_id} = '$user_id'
                                                INNER JOIN {$userDetail->model} d
                                                    ON c.{$content->user_post_id} = d.{$userDetail->user_detail_id}
                                                INNER JOIN {$user->model} u
                                                    ON c.{$content->user_post_id} = u.{$user->id}
                                                WHERE r.{$reacte->post_id} IS NULL 
                                                AND c.{$content->post_status} = 1
                                                AND DATE(c.{$content->created_at}) BETWEEN CURDATE() - INTERVAL 2 DAY AND CURDATE()
                                                ORDER BY c.{$content->created_at} DESC
                                            ";

                                        $postResult = $conn->query($sql);

                                        if ($postResult && $postResult->num_rows == 0) {
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
                                                        r.*,
                                                        (SELECT COUNT(*) FROM {$reacte->model} r1 WHERE r1.{$reacte->post_id} = c.{$content->id} AND r1.{$reacte->reate_type} = 1) AS reacte_link,
                                                        (SELECT COUNT(*) FROM {$reacte->model} r2 WHERE r2.{$reacte->post_id} = c.{$content->id} AND r2.{$reacte->reate_type} = 2) AS reacte_save
                                                    FROM {$content->model} c
                                                    LEFT JOIN {$reacte->model} r
                                                        ON r.{$reacte->post_id} = c.{$content->id}
                                                        AND r.{$reacte->user_reacte_id} = '$user_id'
                                                    INNER JOIN {$userDetail->model} d
                                                        ON c.{$content->user_post_id} = d.{$userDetail->user_detail_id}
                                                    INNER JOIN {$user->model} u
                                                        ON c.{$content->user_post_id} = u.{$user->id}
                                                    WHERE r.{$reacte->post_id} IS NULL
                                                    AND c.{$content->post_status} = 1
                                                    ORDER BY c.{$content->created_at} DESC
                                                ";

                                            $postResult = $conn->query($sql);
                                        }
                                    } else {
                                        $sql = "SELECT
                                                c.{$content->id} AS content_id,
                                                c.{$content->created_at} AS content_created_at,
                                                d.{$userDetail->first_name},
                                                d.{$userDetail->last_name},
                                                d.{$userDetail->profile},
                                                d.{$userDetail->user_detail_id},
                                                u.{$user->verify_status},
                                                u.{$user->user_name},
                                                c.*,
                                                r.*,
                                                (SELECT COUNT(*) FROM {$reacte->model} r1 WHERE r1.{$reacte->post_id} = c.{$content->id} AND r1.{$reacte->reate_type} = 1) AS reacte_link,
                                                (SELECT COUNT(*) FROM {$reacte->model} r2 WHERE r2.{$reacte->post_id} = c.{$content->id} AND r2.{$reacte->reate_type} = 2) AS reacte_save
                                                FROM {$content->model} c
                                                LEFT JOIN {$reacte->model} r 
                                                    ON r.{$reacte->post_id} = c.{$content->id}
                                                INNER JOIN {$userDetail->model} d
                                                    ON c.{$content->user_post_id} = d.{$userDetail->user_detail_id}
                                                INNER JOIN {$user->model} u
                                                    ON c.{$content->user_post_id} = u.{$user->id}
                                                WHERE c.{$content->post_status} = '1'
                                                ORDER BY c.{$content->id} DESC";

                                        $postResult = $conn->query($sql);
                                    }
                                    if ($postResult) {
                                        foreach ($postResult as $index => $item) {
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
                                                            <form action="/post/reacte/" method="POST" class="form-reacte">
                                                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                                <input type="text" name="action" class="txt-action" value="addreacte" hidden>
                                                                <input type="number" name="<?= $reacte->post_id ?>" value="<?= $item['content_id'] ?>" hidden>
                                                                <input type="number" name="<?= $userDetail->user_detail_id ?>" value="<?= $item[$userDetail->user_detail_id] ?>" hidden>
                                                                <input type="number" name="<?= $reacte->reate_type ?>" value="1" hidden>
                                                                <button class="icon icon-ra icon-ra-sm bg-n like">
                                                                    <i class='bx bx-like'></i>
                                                                </button>
                                                            </form>
                                                            <p class="text"><?= $item['reacte_link'] ?></p>
                                                        </li>
                                                        <li class="df-c" data-name="addreacte">
                                                            <form action="/post/reacte/" method="POST" class="form-reacte">
                                                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                                <input type="text" name="action" class="txt-action" value="addreacte" hidden>
                                                                <input type="number" name="<?= $reacte->post_id ?>" value="<?= $item['content_id'] ?>" hidden>
                                                                <input type="number" name="<?= $userDetail->user_detail_id ?>" value="<?= $item[$userDetail->user_detail_id] ?>" hidden>
                                                                <input type="number" name="<?= $reacte->reate_type ?>" value="2" hidden>
                                                                <button class="icon icon-ra icon-ra-sm bg-n save book">
                                                                    <i class='bx bx-bookmark'></i>
                                                                </button>
                                                            </form>
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
                                    } else {
                                        // echo mysqli_error($conn);
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- this is aside right  -->
                    <?php
                        require 'app/views/layout/aside_right.php';
                    ?>
                </div>
            </div>
        </div>
    </main>
    <!-- this is for form post content for user -->
    <?php 
    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) 
    {
        ?>
        <div class="web-form" id="form-post">
            <form action="/post/content" method="post" class="db-c form" enctype="multipart/form-data">
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
    <?php
    }
    ?>
    <!-- this is script user not authtion -->
    <?php
    if (!isset($_SESSION[$user->email]) && !isset($_SESSION[$user->password])) {
        ?>
        <script type="text/javascript">
            var formPopUp = document.querySelector('.form-pop');
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    formPopUp.classList.add('form-pop-active');
                }, 4000);
            });
        </script>
        <?php
    } else {
        ?>
        <script src="<?= getBaseUrl('public/js/function.js?v=' . time()) ?>"></script>
        <script src="<?= getBaseUrl('public/js/welcome.js?v=' . time()) ?>"></script>
        <?php
    }
    ?>
    <script type="text/javascript">
        //this is add toggle class
        function toggleClass(mainClass, activeClass, removeClass = "") {
            var main = document.querySelector(mainClass);
            main.classList.add(activeClass);
            removeClass !== "" ? main.classList.remove(removeClass) : (removeClass = "");
        }
        function toggleClassSmall(main, active = "active") {
            document.querySelector(main).classList.toggle(active);
        }
        addActiveClassTolist(".web-tablink .con ul", "li", "i-active");
        
        document.addEventListener('DOMContentLoaded', function(){
            var txtWidth = screen.width;
            if(txtWidth < 950){
                var head = document.head;
                head.innerHTML += `<link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/home_phone_screen.css?v=<?= time() ?>">`;
            }            
        });
    </script>
</body>
</html>
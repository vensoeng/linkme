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
$follower = new Follower();

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
    <main class="web-main db-c">
        <div class="web-main-body df-l">
            <!-- this is aside left  -->
            <?php
                require 'app/views/layout/aside_left.php';
            ?>
            <!-- this is content with aside -->
            <div class="web-con">
                <div class="web-con-body">
                    <!-- this is header  -->
                    <nav class="seemore-head">
                        <div class="box df-l">
                            <div class="icon icon-ra curs-p" onclick="history.back()">
                                <i class='bx bx-arrow-back'></i>
                            </div>
                            <h2>
                                <?php 
                                if(isset($item)){
                                    echo $item == 'user' ? 'Find all user here.' : '';
                                    echo $item == 'foryou' ? 'Foryou result.' : '';
                                    echo $item == 'history' ? 'User reaction.' : '';
                                    echo $item !== 'history' && $item !== 'foryou'  && $item !== 'user' ? 'Find all user here' : '';
                                }else{
                                    echo 'All user';
                                }
                                ?>
                            </h2>
                        </div>
                    </nav>
                    <!-- this is user  -->
                    <?php
                    if($item == 'user' ||  $item !== 'history' && $item !== 'foryou'  && $item !== 'user'){
                        ?>
                        <ul class="all-user">
                        <?php
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
                        <?php
                    }
                    if($item == 'history' && isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])){
                        ?>
                        <aside class="web-asdie">
                            <div class="web-asdie-body scroll-y">
                                <div class="web-asdie-body-con">
                                    <div class="activity">
                                        <div class="activity-body">
                                            <ul>
                                            <?php
                                                $user_id = $getUser[$userDetail->user_detail_id];

                                                $sql = "
                                                        SELECT
                                                            r.{$reacte->id} AS reacte_id,
                                                            d.{$userDetail->profile},
                                                            d.{$userDetail->first_name},
                                                            d.{$userDetail->last_name},
                                                            c.{$content->created_at} AS content_created_at,
                                                            r.*,
                                                            c.*
                                                        FROM {$reacte->model} r
                                                        INNER JOIN {$content->model} c
                                                            ON r.{$reacte->post_id} = c.{$content->id}
                                                        INNER JOIN {$userDetail->model} d
                                                            ON r.{$reacte->user_reacte_id} = d.{$userDetail->user_detail_id}
                                                        WHERE r.{$reacte->user_post_id} = '$user_id'
                                                    ";
                                                $getReacte = $conn->query($sql);
                                                if($getReacte && mysqli_num_rows($getReacte) > 0){
                                                    foreach ($getReacte as $index => $item) {
                                                        ?>
                                                            <a href="#" class="db-c">
                                                                <li class="df-l">
                                                                <div class="user-box">
                                                                        <div class="profile icon icon-ra icon-sm">
                                                                        <?php
                                                                            if (file_exists('storage/upload/' . $item[$userDetail->profile])) { ?>
                                                                                <img class="img-c over-h icon-ra" loading="lazy" srcset="
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
                                                                        <?= $item[$reacte->reate_type] == 1 ? "<i class='bx bxs-like'></i>" : "<i class='bx bxs-bookmark'></i>" ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="txt">
                                                                        <h2><?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?> <span><?= $item[$reacte->reate_type] == 1 ? "like your post." : " save your post." ?></span></h2>
                                                                        <p class="des"><?= $item[$content->post_des] ?></p>
                                                                        <p><?= convertDate($item['content_created_at'], '', true) ?></p>
                                                                    </div>
                                                                </li>
                                                            </a>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <div class="nores">
                                                            <div class="nores-body">
                                                                <div class="icon icon-ra">
                                                                    <i class='bx bxs-hourglass-bottom'></i>
                                                                </div>
                                                                <blockquote>
                                                                    <h2>No result</h2>
                                                                    <p>No results found. Please check your input and try again with different terms.</p>
                                                                </blockquote>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <?php
                    }
                    if($item == 'foryou'){
                        ?>
                           <div class="main" style="display: flex;
                            align-items: center;
                            justify-content: center;
                            height: calc(100vh - 60px);">
                                <div class="nores" style="width: calc(100% - 1rem);background:none;box-shadow: none;">
                                    <div class="nores-body">
                                        <div class="icon icon-ra">
                                            <i class='bx bxs-hourglass-bottom'></i>
                                        </div>
                                        <blockquote>
                                            <h2>No result</h2>
                                            <p>No results. this feature will be able to use in the future.</p>
                                        </blockquote>
                                    </div>
                                </div>
                           </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= getBaseUrl('public/js/function.js?v=' . time()) ?>"></script>
    <script>
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
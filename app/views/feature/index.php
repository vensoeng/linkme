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

if (!isset($_SESSION[$user->email]) && !isset($_SESSION[$user->password])) {
    header('location: /login');
    die();
}
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
<style>
    .web-asdie .item-head{
        top: 51.19px;
    }
    .web-asdie{
        width: 100%;
        max-width: 100%;
        height: initial;
    }
    .web-asdie .head ul li:last-child::before,
    .web-asdie .head ul li:last-child.i-bell::before,
    .web-header ul:last-child li .i-bell-active::before{
        display: none;
    }
    @-webkit-keyframes activity_wait { /* Chrome, Safari */
        100% {opacity: 1; margin-top: 0rem;}
    }
    @-moz-keyframes activity_wait { /* Firefox */
        100% {opacity: 1; margin-top: 0rem;}
    }
    @-o-keyframes activity_wait { /* Opera */
        100% {opacity: 1; margin-top: 0rem;}
    }
    @keyframes activity_wait { /* Standard */
        100% {opacity: 1; margin-top: 0rem;}
    }
    <?php
        if(isset($item) && $item == 'notification'){
    ?>
        .web-asdie .activity{
            order: 0;
            opacity: 0;
            margin-top: 3rem;
            transition: all ease-in-out 0.3s;
            -webkit-animation: activity_wait 0.5s ease-in-out forwards; /* Chrome, Safari */
            -moz-animation: activity_wait 0.5s ease-in-out forwards;    /* Firefox */
            -o-animation: activity_wait 0.5s ease-in-out forwards;      /* Opera */
            animation: activity_wait 0.5s ease-in-out forwards;         /* Standard */
        }
        .web-asdie .activity .activity-body ul{
            padding-bottom: 0rem;
            padding-top: 0rem;
        }
        .web-asdie .follow{
            order: 2;
        }
        .web-asdie .save{
            order: 3;
        }
    <?php
        }else if(isset($item) && $item == 'search'){
            ?>
            .web-asdie .save{
                order: 0;
                opacity: 0;
                margin-top: 3rem;
                transition: all ease-in-out 0.3s;
                -webkit-animation: activity_wait 0.5s ease-in-out forwards; /* Chrome, Safari */
                -moz-animation: activity_wait 0.5s ease-in-out forwards;    /* Firefox */
                -o-animation: activity_wait 0.5s ease-in-out forwards;      /* Opera */
                animation: activity_wait 0.5s ease-in-out forwards;         /* Standard */
            }
            .web-asdie .follow{
                order: 2;
            }
            .web-asdie .activity{
                order: 3;
            }
            .web-asdie .head ul li:last-child::before{
                display: none;
            }
            <?php
        }
    ?>
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
                <div class="web-con-body df-c">
                    <?php
                        require 'app/views/layout/aside_right.php';
                        
                        $user_id = $getUser[$userDetail->user_detail_id];

                        $sql = "UPDATE $reacte->model 
                        SET $reacte->reacte_status = '1' 
                        WHERE $reacte->user_post_id = '$user_id'
                        AND $reacte->reacte_status = '0'";
            
                        $result = $conn->query($sql);
                        if(!$result){
                            ?>
                            <script>
                                alertForm('Error: requestion to get notification.')
                            </script>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= getBaseUrl('public/js/function.js?v=' . time()) ?>"></script>
    <script src="<?= getBaseUrl('public/js/welcome.js?v=' . time()) ?>"></script>
    <script>
        function toggleClass(mainClass, activeClass, removeClass = "") {
            var main = document.querySelector(mainClass);
            main.classList.add(activeClass);
            removeClass !== "" ? main.classList.remove(removeClass) : (removeClass = "");
        }
    </script>
</body>
</html>
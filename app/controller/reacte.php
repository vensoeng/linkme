<?php
session_start();

require 'database/index.php';
require 'app/config/functions.php';
require 'database/ui/index.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/model/tb_reacte.php';
require 'app/model/tb_user_activity.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\Reacte\Reacte as Reacte;
use App\Model\UserActivity\UserActivity as UserActivity;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new User();
    $userDetail = new UserDetail();
    $reacte = new Reacte();
    $userActivity = new UserActivity();

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo 'CSRF token validation failed';
        die();
    }
    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {

        if(isset($_POST['action']) && $_POST['action'] == 'addreacte')
        {
            $user_id = $_SESSION[$user->id];

            if(!isset($_POST[$reacte->post_id])){
                echo 'Error post id';
                return;
            }else if(!is_numeric($_POST[$reacte->post_id])){
                echo 'invalid data post id.';
                return;
            }else if(!isset($_POST[$userDetail->user_detail_id])){
                echo 'Error user content user id.';
                return;
            }else if(!is_numeric($_POST[$userDetail->user_detail_id])){
                echo 'invalid contetn user id.';
                return;
            }else if(!isset($_POST[$reacte->reate_type])){
                echo 'Error reacte type id.';
                return;
            }else if(!is_numeric($_POST[$reacte->reate_type])){
                echo 'invalid type content data.';
                return;
            }else if((int)$_POST[$reacte->reate_type] !== 1 && (int)$_POST[$reacte->reate_type] !== 2){
                echo 'invalid type content data.';
                return;
            }else if($_POST[$userDetail->user_detail_id] == $user_id){
                echo "You can't like or save you contetn.";
                return;
            }
            $contentId = $_POST[$reacte->post_id];
            $userPost = $_POST[$userDetail->user_detail_id];
            $typeId = $_POST[$reacte->reate_type];
            $created_at = date('Y-m-d H:i:s');

            $sql = "SELECT * FROM $reacte->model
                WHERE $reacte->reate_type = '$typeId'
                AND $reacte->post_id = '$contentId'
                AND $reacte->user_reacte_id = '$user_id'
                AND $reacte->user_post_id = '$userPost'";
            $result = $conn->query($sql);

            if($result && mysqli_num_rows($result) > 0){
                return;
            }
            $sql = "INSERT INTO $reacte->model(
                $reacte->reate_type,
                $reacte->post_id,
                $reacte->user_reacte_id,
                $reacte->user_post_id,
                $reacte->created_at,
                $reacte->updated_at)
            VALUES(
                '$typeId',
                '$contentId',
                '$user_id',
                '$userPost',
                '$created_at',
                '$created_at'
            )";

            $result = $conn->query($sql);

            if ($result) {
                $sql = "INSERT INTO $userActivity->model (
                    $userActivity->activity_user_id,
                    $userActivity->activity_content_id,
                    $userActivity->activity_type_id,
                    $userActivity->created_at,
                    $userActivity->updated_at
                )
                VALUES (
                    '$user_id',
                    '$contentId',
                    '$typeId',
                    '$created_at',
                    '$created_at'
                )";
            
                $result = $conn->query($sql);
                if (!$result) {
                    echo "<b>Error inserting your action</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact our support if you think this is my problem.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                }
            } else {
                echo "<b>Error inserting your action</b><br>"
                . "There seems to be an issue with the query.<br>"
                . "Please contact our support if you think this is my problem.<br>"
                . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }            
        }else if(isset($_POST['action']) && $_POST['action'] == 'deletereacte')
        {
            $user_id = $_SESSION[$user->id];

            if(!isset($_POST[$reacte->post_id])){
                echo 'Error post id';
                return;
            }else if(!is_numeric($_POST[$reacte->post_id])){
                echo 'invalid data post id.';
                return;
            }else if(!isset($_POST[$userDetail->user_detail_id])){
                echo 'Error user content user id.';
                return;
            }else if(!is_numeric($_POST[$userDetail->user_detail_id])){
                echo 'invalid contetn user id.';
                return;
            }else if(!isset($_POST[$reacte->reate_type])){
                echo 'Error reacte type id.';
                return;
            }else if(!is_numeric($_POST[$reacte->reate_type])){
                echo 'invalid type content data.';
                return;
            }else if((int)$_POST[$reacte->reate_type] !== 1 && (int)$_POST[$reacte->reate_type] !== 2){
                echo 'invalid type content data.';
                return;
            }else if($_POST[$userDetail->user_detail_id] == $user_id){
                echo "You can't like or save you contetn.";
                return;
            }
            $contentId = $_POST[$reacte->post_id];
            $userPost = $_POST[$userDetail->user_detail_id];
            $typeId = $_POST[$reacte->reate_type];
            $created_at = date('Y-m-d H:i:s');

            $sql = "DELETE FROM $reacte->model
                WHERE $reacte->user_reacte_id = '$user_id'
                AND $reacte->post_id = '$contentId'
                AND $reacte->reate_type = '$typeId'
                AND $reacte->user_post_id = '$userPost'";
            
            $result = $conn->query($sql);
            if($result){

                $sql = "DELETE FROM $userActivity->model
                WHERE $userActivity->activity_user_id = '$user_id'
                AND $userActivity->activity_content_id = '$contentId'
                AND $userActivity->activity_type_id = '$typeId'";

                $resutl = $conn->query($sql);
                if(!$resutl){
                    echo "<b>Error insert your action</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact our support if you think this my problem.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                }
            }else{
                echo "<b>Error insert your action</b><br>"
                . "There seems to be an issue with the query.<br>"
                . "Please contact our support if you think this my problem.<br>"
                . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }
        }else if(isset($_POST['action']) && $_POST['action'] == "getReaction"){
            if (!isset($_POST['id'])) {
                echo "";
                return;
            } else if (!is_numeric($_POST['id'])) {
                echo "";
                return;
            }
            $content_id = $_POST['id'];
            $sql = "
            SELECT
                u.{$user->user_name},
                u.{$user->verify_status},
                d.{$userDetail->user_detail_id},
                d.{$userDetail->first_name},
                d.{$userDetail->last_name},
                d.{$userDetail->profile},
                r.*
            FROM {$reacte->model} r
            INNER JOIN {$user->model} u
                ON r.{$reacte->user_reacte_id} = u.{$user->id}
            INNER JOIN {$userDetail->model} d
                ON r.{$reacte->user_reacte_id} = d.{$userDetail->user_detail_id}
            WHERE r.{$reacte->post_id} = '$content_id'";

            $result = $conn->query($sql);
            if($result && mysqli_num_rows($result) > 0){
                ?>
                <ul class="active">
                <?php
                    foreach ($result as $item) {
                        ?>
                        <li class="df-s">
                            <div class="user-profile df-l">
                                <a href="#" class="profile icon icon-ra">
                                    <img class="img-c" src="<?= getBaseUrl('storage/upload/'.$item[$userDetail->profile]) ?>" alt="">
                                </a>
                                <div class="text">
                                    <a href="#">
                                        <h2 style="width: max-content; max-width:100%; color:var(--sg-main-bg);"
                                            class="<?= $item[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                            <?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                        </h2>
                                    </a>
                                    <p><?=$item[$user->user_name]?></p>
                                </div>
                            </div>
                            <div class="btn icon icon-ra icon-sm">
                                <?=$item[$reacte->reate_type] == 1 ? "<i class='bx bxs-like'></i>": "<i class='bx bxs-bookmarks'></i>"?>
                            </div>
                        </li>
                <?php
                    }
                ?>
                </ul>

                <ul>
                <?php
                    foreach ($result as $item) {
                        if($item[$reacte->reate_type] !== '1'){
                            continue;
                        }
                        ?>
                        <li class="df-s">
                            <div class="user-profile df-l">
                                <a href="#" class="profile icon icon-ra">
                                    <img class="img-c" src="<?= getBaseUrl('storage/upload/'.$item[$userDetail->profile]) ?>" alt="">
                                </a>
                                <div class="text">
                                    <a href="#">
                                        <h2 style="width: max-content; max-width:100%; color:var(--sg-main-bg);"
                                            class="<?= $item[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                            <?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                        </h2>
                                    </a>
                                    <p><?=$item[$user->user_name]?></p>
                                </div>
                            </div>
                            <div class="btn icon icon-ra icon-sm">
                                <?=$item[$reacte->reate_type] == 1 ? "<i class='bx bxs-like'></i>": "<i class='bx bxs-bookmarks'></i>"?>
                            </div>
                        </li>
                <?php
                    }
                ?>
                </ul>

                <ul>
                <?php
                    foreach ($result as $item) {
                        if($item[$reacte->reate_type] == '1'){
                            continue;
                        }
                        ?>
                        <li class="df-s">
                            <div class="user-profile df-l">
                                <a href="#" class="profile icon icon-ra">
                                    <img class="img-c" src="<?= getBaseUrl('storage/upload/'.$item[$userDetail->profile]) ?>" alt="">
                                </a>
                                <div class="text">
                                    <a href="#">
                                        <h2 style="width: max-content; max-width:100%; color:var(--sg-main-bg);"
                                            class="<?= $item[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                            <?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?>
                                        </h2>
                                    </a>
                                    <p><?=$item[$user->user_name]?></p>
                                </div>
                            </div>
                            <div class="btn icon icon-ra icon-sm">
                                <?=$item[$reacte->reate_type] == 1 ? "<i class='bx bxs-like'></i>": "<i class='bx bxs-bookmarks'></i>"?>
                            </div>
                        </li>
                <?php
                    }
                ?>
                </ul>
                <?php
            }
        }else{
            echo "can't find action for insert, update or delete.";
        }
    }else{
        echo "Please signup or login for user all feature here.";
    }
}
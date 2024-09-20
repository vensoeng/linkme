<?php
session_start();

require 'database/index.php';
require 'app/config/functions.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/model/tb_reacte.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\Reacte\Reacte as Reacte;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new User();
    $userDetail = new UserDetail();
    $reacte = new Reacte();

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo 'CSRF token validation failed';
        die();
    }
    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
        if(isset($_POST['action']) && $_POST['action'] == 'notification'){
            $user_id = $_SESSION[$user->id];

            $sql = "UPDATE $reacte->model 
            SET $reacte->reacte_status = '1' 
            WHERE $reacte->user_post_id = '$user_id'
            AND $reacte->reacte_status = '0'";

            $result = $conn->query($sql);
            if(!$result){
                echo 'Error: requestion to get notification.';
            }
        }
    }
} 
<?php
session_start();

require 'database/index.php';
require 'app/config/functions.php';
require 'database/ui/index.php';
require 'app/model/tb_follower.php';
require 'app/model/tb_user.php';

use App\Model\User\User as User;
use App\Model\Follower\Follower as Follower;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new User();
    $follower = new Follower();

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo 'CSRF token validation failed';
        die();
    }
    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {

        if (isset($_POST['action']) && $_POST['action'] == "addfollow") {
            if (!isset($_POST[$follower->id])) {
                echo "Make sure you were not edit our form. we can't find item of follow.";
                return;
            } else if (!is_numeric($_POST[$follower->id])) {
                echo "Make sure you were not edit our form. Invalid data item of follow.";
                return;
            }
            $user_id = $_SESSION[$user->id];
            $user_follower_id = $_POST[$follower->id];
            $created_at = date('Y-m-d H:i:s');

            $sql = "SELECT * FROM $follower->model 
                WHERE $follower->user_follower_id = '$user_follower_id' 
                AND $follower->user_sand_follower_id = '$user_id'";
            $result = $conn->query($sql);

            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    return;
                }
            } else {
                echo "Error sand follower";
            }

            $sql = "INSERT INTO $follower->model(
                $follower->user_follower_id,
                $follower->user_sand_follower_id,
                $follower->created_at,
                $follower->updated_at)
            VALUES(
               '$user_follower_id',
               '$user_id',
               '$created_at',
                '$created_at'
            )";

            $result = $conn->query($sql);
            if (!$result) {
                echo "<b>Error add follower</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact our support if you think this my problem.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }
        } else if (isset($_POST['action']) && $_POST['action'] == "editFollow") {

            if (!isset($_POST[$follower->id])) {
                echo "Make sure you were not edit our form. we can't find item of follow.";
                return;
            } else if (!is_numeric($_POST[$follower->id])) {
                echo "Make sure you were not edit our form. Invalid data item of follow.";
                return;
            } else if (!isset($_POST[$follower->follower_status])) {
                echo "Make sure you were not edit our form. we can't find status input follow.";
                return;
            } else if (!is_numeric($_POST[$follower->follower_status])) {
                echo "Make sure you were not edit our form. Invalid data item of follow.";
                return;
            } else if ((int) $_POST[$follower->follower_status] !== 0 && (int) $_POST[$follower->follower_status] !== 1) {
                echo "Make sure you were not edit our form. Invalid data item of follow.";
                return;
            }
            $user_id = $_SESSION[$user->id];
            $follow_id = $_POST[$follower->id];
            $status = $_POST[$follower->follower_status];
            $created_at = date('Y-m-d H:i:s');

            $sql = "UPDATE $follower->model SET 
                $follower->follower_status = '$status',
                $follower->updated_at = '$created_at'
                WHERE $follower->user_follower_id = '$user_id'
                AND $follower->id = '$follow_id'";

            $result = $conn->query($sql);

            if (!$result) {
                echo "<b>Error update follower</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact our support if you think this my problem.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }
        } else if (isset($_POST['action']) && $_POST['action'] == "deletefollower") {
            if (!isset($_POST[$follower->id])) {
                echo "Make sure you were not edit our form. we can't find item of follow.";
                return;
            } else if (!is_numeric($_POST[$follower->id])) {
                echo "Make sure you were not edit our form. Invalid data item of follow.";
                return;
            }
            $user_id = $_SESSION[$user->id];
            $user_follower_id = $_POST[$follower->id];

            $sql = "DELETE FROM $follower->model
                WHERE $follower->user_follower_id = '$user_follower_id'
                AND $follower->user_sand_follower_id = '$user_id'";

            $result = $conn->query($sql);
            if (!$result) {
                echo "<b>Error delete follower</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact our support if you think this my problem.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }
        } else {
            echo "Cant' find action for insert, update or delate";
        }
    }

} else {

}
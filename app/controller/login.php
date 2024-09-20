<?php
session_start();
require 'database/index.php';
require 'database/ui/index.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/config/functions.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        ui('CSRF token validation failed.<br>You are not persone?.<br><a href="/login" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login</a>');
        die();
    }
    $user = new User();
    if ($_POST[$user->email] !== '' && $_POST[$user->password] !== '') {
        if (validateInput($_POST[$user->email]) === "Email" || validateInput($_POST[$user->email]) == "Phone") {
            $email = testInput($_POST[$user->email]);
            $password = md5(testInput($_POST[$user->password]));

            $sql = "SELECT * FROM $user->model WHERE $user->email = '$email' AND $user->password = '$password'";
            $result = $conn->query($sql);

            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $userDetail = new UserDetail();
                    $result = $result->fetch_assoc();
                    $user_id = $result[$user->id];

                    $sql = "SELECT * FROM $userDetail->model WHERE $userDetail->user_detail_id = '$user_id'";
                    $userDatailResult = $conn->query($sql);

                    if ($userDatailResult) {
                        if (mysqli_num_rows($userDatailResult) == 1) {
                            $userDatailResult = $userDatailResult->fetch_assoc();

                            $_SESSION[$user->id] = $result[$user->id];
                            $_SESSION[$user->user_role] = $result[$user->user_role];
                            $_SESSION[$user->email] = $result[$user->email];
                            $_SESSION[$user->password] = $result[$user->password];
                            $_SESSION[$user->user_status] = $result[$user->user_status];
                            $_SESSION[$user->user_name] = $result[$user->user_name];
                            $_SESSION[$user->policy_status] = $result[$user->policy_status];

                            $_SESSION[$userDetail->first_name] = $userDatailResult[$userDetail->first_name];
                            $_SESSION[$userDetail->user_detail_id] = $userDatailResult[$userDetail->user_detail_id];
                            $_SESSION[$userDetail->last_name] = $userDatailResult[$userDetail->last_name];
                            $_SESSION[$userDetail->profile] = $userDatailResult[$userDetail->profile];
                            $_SESSION[$userDetail->cover] = $userDatailResult[$userDetail->cover];
                            $_SESSION[$userDetail->bio] = $userDatailResult[$userDetail->bio];
                            $_SESSION[$userDetail->img_share] = $userDatailResult[$userDetail->img_share];
                            $_SESSION[$userDetail->user_birthday] = $userDatailResult[$userDetail->user_birthday];
                            $_SESSION[$userDetail->user_address] = $userDatailResult[$userDetail->user_address];

                            $_SESSION['user_login_finish'] = 'logined';
                            $_SESSION['user_login'] = 'logined';

                            header('location: /you/');
                        } else {
                            ui('<h2>Sorry Myserver an erorr duplicate.</h2>' . mysqli_error($conn) . '<br>Return to: <a href="/login/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login again.</a>');
                        }
                    } else {
                        ui('<h2>Sorry Myserver an erorr qurey data.</h2>' . mysqli_error($conn) . '<br>Return to: <a href="/login/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login again.</a>');
                    }
                } else {
                    ui('
                        <h2>Your account could not be found.</h2>
                        <p>Make sure you have entered the email or phone number and password correctly.</p>
                        Return to: <a href="/login/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login again.</a>
                    ');
                }
            } else {
                ui('<h2>Sorry Myserver an erorr.</h2>' . mysqli_error($conn) . '<br>Return to: <a href="/login/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login again.</a>');
            }
        } else {
            ui('You input invalid Email or Phone.<br>Return to: <a href="/login/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login again.</a>');
        }
    } else {
        ui('Password and Email or Phone is Empty.<br>Please Enter value: <a href="/login/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login again.</a>');
    }

} else {
    header('location: /');
}
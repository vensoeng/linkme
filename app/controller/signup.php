<?php
session_start();
require 'database/index.php';
require 'app/config/functions.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'database/ui/index.php';
require 'app/config/compress_images.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\User\RequestionItem as UserRequestionItem;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
    $user = new User();
    $userDetail = new UserDetail();
    // =====================thisIs for store data to database =======================
    if (isset($_POST[$user->email]) && isset($user->password) && isset($user->policy_status)) {
        if ($_POST[$user->email] !== '' && $_POST[$user->password] !== '' && $_POST[$user->policy_status] !== '') {
            if (validateInput($_POST[$user->email]) === "Email" || validateInput($_POST[$user->email]) == "Phone") {
                $email = testInput($_POST[$user->email]);
                $password = testInput($_POST[$user->password]);
                $policy = $_POST[$user->policy_status];

                if ($_POST[$userDetail->first_name] !== '' && $_POST[$userDetail->last_name] !== '') {
                    $created_at = date('Y-m-d H:i:s');
                    $first_name = $_POST[$userDetail->first_name];
                    $last_name = $_POST[$userDetail->last_name];
                    $user_name = testInput($first_name . $last_name);
                    $user_name = str_replace(' ', '', $user_name);
                    $user_name = strtolower($user_name);

                    $sql = "SELECT $user->user_name FROM $user->model WHERE $user->user_name = '$user_name'";
                    $result = $conn->query($sql);

                    if ($result) {
                        if (mysqli_num_rows($result) == 1) {
                            $user_name = testInput($first_name . '' . $last_name . '' . date('Y-m-d H:i:s'));
                            $user_name = str_replace(' ', '', $user_name);
                            $user_name = strtolower($user_name);
                        }
                    }

                    // ===================this Is check email in database have or not ===========
                    $sql = "SELECT $user->email FROM $user->model WHERE $user->email = '$email'";
                    $resule = $conn->query($sql);
                    if (mysqli_num_rows($resule) > 0) {
                        ui('This Email has been using on Application.<br>Return to: <a href="/login" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Login now</a>');
                        return;
                    }

                    $sql = "INSERT INTO 
                        $user->model(
                        $user->email,
                        $user->password,
                        $user->policy_status,
                        $user->user_name,
                        $user->created_at,
                        $user->updated_at
                        )
                        VALUES(
                        '$email',
                        '$password',
                        '$policy',
                        '$user_name',
                        '$created_at',
                        '$created_at'
                        )";
                    $result = $conn->query($sql);
                    if ($result) {
                        $userRequestItem = new UserRequestionItem($conn, "SELECT * FROM $user->model WHERE $user->created_at = '$created_at'");
                        if ($userRequestItem) {
                            require 'app/config/compress_images.php';

                            $profile_ext = pathinfo($_FILES[$userDetail->profile]['name'], PATHINFO_EXTENSION);
                            $cover_ext = pathinfo($_FILES[$userDetail->cover]['name'], PATHINFO_EXTENSION);

                            $profile_name = uniqid() . '.' . $profile_ext;
                            $cover = uniqid() . '.' . $cover_ext;

                            $sql = "INSERT INTO $userDetail->model(
                                $userDetail->user_detail_id,
                                $userDetail->first_name,
                                $userDetail->last_name,
                                $userDetail->profile,
                                $userDetail->cover)
                                VALUES(
                                '$userRequestItem->id',
                                '$first_name',
                                '$last_name',
                                '$profile_name',
                                '$cover'
                            )";
                            $result = $conn->query($sql);
                            if ($result) {

                                if (validateImagesEX($_FILES[$userDetail->profile]['name'])) {
                                    uploadAndCompressImage($_FILES[$userDetail->profile], $profile_name);
                                }
                                if (validateImagesEX($_FILES[$userDetail->cover]['name'])) {
                                    uploadAndCompressImage($_FILES[$userDetail->cover], $cover);
                                }

                                $_SESSION[$user->id] = $userRequestItem->id;
                                $_SESSION[$user->user_role] = $userRequestItem->user_role;
                                $_SESSION[$user->email] = $userRequestItem->email;
                                $_SESSION[$user->password] = $userRequestItem->password;
                                $_SESSION[$user->user_status] = $userRequestItem->user_status;
                                $_SESSION[$user->user_name] = $userRequestItem->user_name;
                                $_SESSION[$user->policy_status] = $userRequestItem->policy_status;

                                $_SESSION[$userDetail->user_detail_id] = $userRequestItem->id;
                                $_SESSION[$userDetail->first_name] = $first_name;
                                $_SESSION[$userDetail->last_name] = $last_name;
                                $_SESSION[$userDetail->profile] = $profile_name;
                                $_SESSION[$userDetail->cover] = $cover;
                                $_SESSION[$userDetail->user_birthday] = 'Null';
                                $_SESSION[$userDetail->user_address] = 'Null';

                                header('location: /signup/detail/link');
                            } else {
                                ui('Sorry My serve is an Error Requestion to user datail data!.<br>Please back to signup a agian.<br><a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now</a>');
                            }
                        } else {
                            $sql = "DELETE FROM $user->model WHERE $user->created_at = '$created_at'";
                            $result = $conn->query($sql);
                            if (!$result) {
                                header('location: /signup');
                                return;
                            }
                            ui('Sorry My serve is an Error Requestion to user data!.<br>Please back to signup a agian.<br><a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now</a>');
                        }
                    } else {
                        ui('Sorry My serve is an Error!.<br>Please back to signup a letter.<br><a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now</a>');
                    }
                } else {
                    ui('First name or Last name must be valuable.<br>Return to <a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now</a>', true);
                }

            } else {
                ui('Enter Invalidate data Email or Phone.<br>Return to <a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now</a>', true);
            }
        } else {
            ui('Password and Email or Phone is Empty.<br>Please Enter value: <a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now</a>', true);
        }
    } else {
        ui('Email or Phone, Password and Accept Mypolicy.<br>Must be has valuable?<br>Return to <a href="/signup/" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Signup now</a>', true);
    }
} else {
    header('location: /signup');
}
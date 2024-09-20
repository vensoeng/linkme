<?php
session_start();

require 'database/index.php';
require 'app/config/functions.php';
require 'database/ui/index.php';
require 'app/model/tb_user.php';
require 'app/config/compress_images.php';
require 'app/model/tb_content.php';
require 'app/model/tb_user_activity.php';

use App\Model\User\User as User;
use App\Model\Content\Content as Content;
use App\Model\UserActivity\UserActivity as UserActivity;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new User();
    $content = new Content();
    $userActivity = new UserActivity();

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo 'CSRF token validation failed';
        die();
    }
    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {

        if (isset($_POST['action']) && $_POST['action'] == "content") {//this is for add new item 
            if (!isset($_POST[$content->post_status])) {
                echo "Make sure you were not edit our form. we can't status of your post";
                return;
            } else if ((int) $_POST[$content->post_status] !== 1 && (int) $_POST[$content->post_status] !== 2) {
                echo "Make sure you were not edit our form. Invalid data post status.";
                return;
            }
            if (!isset($_POST[$content->post_title])) {
                echo "Make sure you were not edit our form. we can't find title of your post";
                return;
            } else if (mb_strlen($_POST[$content->post_title], 'UTF-8') > 250) {
                echo "<b>Your title is too long.</b><br>"
                    . "Please shorten it to 250 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (!isset($_POST[$content->post_des])) {
                echo "Make sure you were not edit our form. we can't find decription of your post";
                return;
            } else if (mb_strlen($_POST[$content->post_des], 'UTF-8') > 500) {
                echo "<b>Your decription is too long.</b><br>"
                    . "Please shorten it to 400 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (trim($_POST[$content->post_des]) == '') {
                echo "<b>Please provide a description for your post.</b><br>"
                    . "Your post description is currently empty, which is required to give context and meaning to your content.<br>"
                    . "A detailed description helps others understand the purpose of your post.<br>"
                    . "If you need ideas on what to include, consider answering questions like:<br>"
                    . "- What is this post about?<br>"
                    . "- Why is this topic important?<br>"
                    . "- How does it relate to your audience?<br>"
                    . "Once you've added a description, please try submitting the form again.";
                return;
            } else if (!isset($_FILES[$content->post_img])) {
                echo "Make sure you were not edit our form. we can't find input file of your post";
                return;
            }

            $user_id = $_SESSION[$user->id];
            $postType = 1;
            $status = $_POST[$content->post_status];
            $title = $conn->real_escape_string($_POST[$content->post_title]);
            $description = $conn->real_escape_string($_POST[$content->post_des]);
            $created_at = date('Y-m-d H:i:s');

            $file_name = "";
            if ($_FILES[$content->post_img]['name'] !== '') {
                $img_ext = pathinfo($_FILES[$content->post_img]['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $img_ext;
            }

            $sql = "INSERT INTO $content->model(
                $content->user_post_id,
                $content->post_type,
                $content->post_status,
                $content->post_title,
                $content->post_des,
                $content->post_img,
                $content->created_at,
                $content->updated_at
                )
                VALUES(
                '$user_id',
                '$postType',
                '$status',
                '$title',
                '$description',
                '$file_name',
                '$created_at',
                '$created_at'
                )";
            $result = $conn->query($sql);

            if ($result) {
                if (isset($_FILES[$content->post_img]) && $_FILES[$content->post_img]['name'] !== '') {

                    if (validateImagesEX($_FILES[$content->post_img]['name'])) {
                        uploadAndCompressImage($_FILES[$content->post_img], $file_name);
                    } else {
                        echo "Make sure your images extension is .jpg,.jpeg,.png,.web.";
                        return;
                    }
                }
                echo "<b>Your content has been post!</b><br>"
                    . "<p>Refresh your page for see updating. Thank you for using our service. If you need further assistance, feel free to contact support.</p>";

                $sql = "SELECT $content->id FROM $content->model 
                    WHERE $content->created_at = '$created_at'";
                $result = $conn->query($sql);

                if ($result && mysqli_num_rows($result) == 1) {

                    $result = $result->fetch_assoc();
                    $contentId = $result[$content->id];
                    $activityType = 4;

                    $sql = "INSERT INTO $userActivity->model(
                            $userActivity->activity_user_id,
                            $userActivity->activity_content_id,
                            $userActivity->activity_type_id,
                            $userActivity->created_at,
                            $userActivity->updated_at
                        )
                        VALUES(
                            '$user_id',
                            '$contentId',
                            '$activityType',
                            '$created_at',
                            '$created_at'
                        )";
                    $result = $conn->query($sql);
                }
            } else {
                echo "<b>Error: Sorry, we can't post your content.</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact support if the problem persists.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }
        } else if (isset($_POST['action']) && $_POST['action'] == "editContent") { // this is for edit item

            if (!isset($_POST[$content->id])) {
                echo "Make sure you were not edit our form. we can't item for edit.";
                return;
            } else if (!is_numeric($_POST[$content->id])) {
                echo "Make sure you were not edit our form. Invalid data find item for edit.";
                return;
            } else if (!isset($_POST[$content->post_status])) {
                echo "Make sure you were not edit our form. we can't status of your post.";
                return;
            } else if (!is_numeric($_POST[$content->post_status])) {
                echo "Make sure you were not edit our form. Invalid data post status.";
                return;
            } else if ((int) $_POST[$content->post_status] !== 1 && (int) $_POST[$content->post_status] !== 2) {
                echo "Make sure you were not edit our form. Invalid data post status.";
                return;
            }
            if (!isset($_POST[$content->post_title])) {
                echo "Make sure you were not edit our form. we can't find title of your edit post.";
                return;
            } else if (mb_strlen($_POST[$content->post_title], 'UTF-8') > 250) {
                echo "<b>Your title is too long.</b><br>"
                    . "Please shorten it to 250 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (!isset($_POST[$content->post_des])) {
                echo "Make sure you were not edit our form. we can't find decription of your edit post.";
                return;
            } else if (mb_strlen($_POST[$content->post_des], 'UTF-8') > 500) {
                echo "<b>Your decription is too long.</b><br>"
                    . "Please shorten it to 400 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (trim($_POST[$content->post_des]) == '') {
                echo "<b>Please provide a description for your post.</b><br>"
                    . "Your post description is currently empty, which is required to give context and meaning to your content.<br>"
                    . "A detailed description helps others understand the purpose of your post.<br>"
                    . "If you need ideas on what to include, consider answering questions like:<br>"
                    . "- What is this post about?<br>"
                    . "- Why is this topic important?<br>"
                    . "- How does it relate to your audience?<br>"
                    . "Once you've added a description, please try submitting the form again.";
                return;
            } else if (!isset($_FILES[$content->post_img])) {
                echo "Make sure you were not edit our form. we can't find input file of your post";
                return;
            }

            $user_id = $_SESSION[$user->id];
            $post_id = $_POST[$content->id];
            $status = $_POST[$content->post_status];
            $title = $conn->real_escape_string($_POST[$content->post_title]);
            $description = $conn->real_escape_string($_POST[$content->post_des]);
            $created_at = date('Y-m-d H:i:s');

            $sql = "SELECT 
                $content->id,
                $content->user_post_id,
                $content->post_img 
                FROM $content->model
                WHERE $content->user_post_id = '$user_id'
                AND $content->id = '$post_id'";
            $result = $conn->query($sql);

            if ($result) {
                if (mysqli_num_rows($result) == 1) {

                    $postItem = $result->fetch_assoc();

                    $file_name = $postItem[$content->post_img];
                    if ($_FILES[$content->post_img]['name'] !== '') {
                        $img_ext = pathinfo($_FILES[$content->post_img]['name'], PATHINFO_EXTENSION);
                        $file_name = uniqid() . '.' . $img_ext;
                    }

                    $sql = "UPDATE $content->model SET
                            $content->post_status = '$status',
                            $content->post_title = '$title',
                            $content->post_des = '$description',
                            $content->post_img = '$file_name',
                            $content->updated_at = '$created_at'
                        WHERE $content->user_post_id = '$user_id'
                        AND $content->id = '$post_id'";
                    $result = $conn->query($sql);

                    if ($result) {
                        if (isset($_FILES[$content->post_img]) && $_FILES[$content->post_img]['name'] !== '') {
                            if (validateImagesEX($_FILES[$content->post_img]['name'])) {
                                uploadAndCompressImage($_FILES[$content->post_img], $file_name);
                            } else {
                                echo "Make sure your images extension is .jpg,.jpeg,.png,.web.";
                                return;
                            }
                            if ($postItem[$content->post_img] !== null && trim($postItem[$content->post_img]) !== '') {
                                if (file_exists('storage/upload/' . $postItem[$content->post_img])) {
                                    delete_file($postItem[$content->post_img]);
                                }
                            }
                        }
                        echo "<b>Your content has been updated!</b><br>"
                            . "<p>Refresh your page for see updating. Thank you for using our service. If you need further assistance, feel free to contact support.</p>";
                    } else {
                        echo "<b>Error update</b><br>"
                            . "Sorry, we can't update your content."
                            . "There seems to be an issue with the query.<br>"
                            . "Please contact support if the problem persists.<br>"
                            . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                    }
                } else {
                    echo "<b>Error: Sorry, we can't update your content.</b><br>"
                        . "Make sure you were not edit our form.<br>"
                        . "Please contact to our support if you think this my problem.<br>"
                        . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                }
            } else {
                echo mysqli_error($conn) . $sql . "<b>Error: Sorry, we can't update your content.</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact support if the problem persists.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }

        }else if(isset($_POST['action']) && $_POST['action'] == "deleteContent"){
            if (!isset($_POST[$content->id])) {
                echo "Make sure you were not edit our form. we can't item for edit.";
                return;
            } else if (!is_numeric($_POST[$content->id])) {
                echo "Make sure you were not edit our form. Invalid data find item for edit.";
                return;
            }

            $user_id = $_SESSION[$user->id];
            $post_id = $_POST[$content->id];
            
            $sql = "SELECT 
                $content->id,
                $content->post_img 
                FROM $content->model
                WHERE $content->user_post_id = '$user_id'
                AND $content->id = '$post_id'";
            $result = $conn->query($sql);
            if($result && mysqli_num_rows($result) == 1){
                $item = $result->fetch_assoc();

                $sql = "DELETE FROM $content->model
                WHERE $content->user_post_id = '$user_id'
                AND $content->id = '$post_id'";

                $result = $conn->query($sql);
                if(!$result){
                    echo mysqli_error($conn) . $sql . "<b>Error: Sorry, we can't dalete your content.</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact support if the problem persists.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                }else{
                    if(trim($item[$content->post_img]) !== '' && $item[$content->post_img] !== null){
                        if(file_exists('storage/upload/'.$item[$content->post_img])){
                            delete_file($item[$content->post_img]);
                        }
                    }
                }
            }
        } else {
            echo "<b>We can't find the action you were trying to perform, such as editing, updating, or inserting data.</b><br>"
                . "This could be due to an incorrect request or a missing action parameter.<br>"
                . "Please make sure you're performing the action correctly:<br>"
                . "- If you intended to edit or update an item, ensure that you've selected the correct item and filled out all required fields.<br>"
                . "- If you were trying to insert new data, verify that all the necessary information has been provided.<br>"
                . "If the problem persists, try refreshing the page and attempting the action again.<br>"
                . "If you continue to encounter issues, please contact support for further assistance.";
        }
    }

}
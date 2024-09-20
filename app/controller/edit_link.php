<?php
session_start();

require 'database/index.php';
require 'app/config/functions.php';
require 'database/ui/index.php';
require 'app/model/tb_user.php';
require 'app/config/compress_images.php';
require 'app/model/tb_user_link.php';
require 'app/model/tb_icon.php';

use App\Model\UserLink\UserLink as UserLink;
use App\Model\Icon\Icon as Icon;
use App\Model\User\User as User;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new User();
    $userLink = new UserLink();
    $icon = new Icon();

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        return 'CSRF token validation failed';
    }

    if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {

        if (isset($_POST['action']) && $_POST['action'] == $userLink->model) { //edit link 
            if (!isset($_POST[$userLink->id])) {
                echo "Make sure you were not edit our form. we can't find id for edit your link.";
                return;
            } else if (!isset($_POST[$userLink->link_icon_id])) {
                echo "Make sure you were not edit our form. we can't find link type for edit your link.";
                return;
            } else if (!isset($_POST[$userLink->link_url])) {
                echo "Make sure you were not edit our form. we can't find url for edit your link.";
                return;
            } else if (!isset($_POST[$userLink->link_name])) {
                echo "Make sure you were not edit our form. we can't find input name of link.";
                return;
            } else if (strlen($_POST[$userLink->link_name]) > 100) {
                echo "<b>Your link name is too long.</b> "
                    . "Please shorten it to 100 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (!isset($_POST[$userLink->link_url])) {
                echo "Make sure you were not edit our form. we can't find input url of link.";
                return;
            } else if (strlen($_POST[$userLink->link_url]) > 250) {
                echo "<b>Your link url is too long.</b> "
                    . "Please shorten it to 250 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (!isset($_FILES[$userLink->link_img])) {
                echo "Make sure you were not edit our form. we can't find input file image of link.";
                return;
            }

            $user_id = $_SESSION[$user->id];
            $link_id = $_POST[$userLink->id];

            $sql = "SELECT $userLink->id, $userLink->link_img FROM $userLink->model 
                WHERE $userLink->link_user_id = '$user_id' 
                AND $userLink->id = '$link_id'";

            $result = $conn->query($sql);

            if ($result && mysqli_num_rows($result) == 1) {

                $resulteGetLink = $result->fetch_assoc();

                $icon_id = $_POST[$userLink->link_icon_id];
                $url = $_POST[$userLink->link_url];
                $title = $_POST[$userLink->link_name];
                $created_at = date('Y-m-d H:i:s');

                $file_name = $resulteGetLink[$userLink->link_img];

                if (isset($_FILES[$userLink->link_img]) && $_FILES[$userLink->link_img]['name'] !== '') {

                    $img_ext = pathinfo($_FILES[$userLink->link_img]['name'], PATHINFO_EXTENSION);
                    $file_name = uniqid() . '.' . $img_ext;
                }

                $sql = "UPDATE $userLink->model SET 
                    $userLink->link_user_id = '$user_id',
                    $userLink->link_icon_id = '$icon_id',
                    $userLink->link_name = '$title',
                    $userLink->link_url = '$url',
                    $userLink->link_img = '$file_name',
                    $userLink->updated_at = '$created_at'
                    WHERE $userLink->id = '$link_id'";
                $result = $conn->query($sql);

                if ($result) {
                    if (isset($_FILES[$userLink->link_img]) && $_FILES[$userLink->link_img]['name'] !== '') {

                        if ($resulteGetLink[$userLink->link_img] !== null && trim($resulteGetLink[$userLink->link_img]) !== '') {
                            if (file_exists('storage/upload/' . $resulteGetLink[$userLink->link_img])) {
                                delete_file($resulteGetLink[$userLink->link_img]);
                            }
                        }

                        if (validateImagesEX($_FILES[$userLink->link_img]['name'])) {
                            uploadAndCompressImage($_FILES[$userLink->link_img], $file_name);
                        } else {
                            echo "Make sure your images extension is .jpg,.jpeg,.png,.web.";
                            return;
                        }
                    }
                    echo "<b>Your link has been updated and is now live!</b><br>"
                        . "<p>Refresh your page for see updating. Thank you for using our service. If you need further assistance, feel free to contact support.</p>";
                } else {
                    echo "<b>Error: Sorry, we can't edit.</b><br>"
                        . "There seems to be an issue with the query.<br>"
                        . "Please contact support if the problem persists.<br>"
                        . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a><br>';
                    return;
                }
            } else {
                echo "<b>Error: Sorry, we can't edit.</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact support if the problem persists.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                return;
            }
        } else if (isset($_POST['action']) && $_POST['action'] == 'addlink') {

            if (!isset($_POST[$userLink->link_icon_id])) {
                echo "Make sure you were not edit our form. we can't find link type for edit your link.";
                return;
            } else if (trim($_POST[$userLink->link_icon_id]) == '') {
                echo "Link type is required. please Choose Link.";
                return;
            } else if (!isset($_POST[$userLink->link_name])) {
                echo "Make sure you were not edit our form. we can't find input name of link.";
                return;
            } else if (trim($_POST[$userLink->link_name]) == '') {
                echo "Title of link is required";
                return;
            } else if (strlen($_POST[$userLink->link_name]) > 100) {
                echo "<b>Your link name is too long.</b> "
                    . "Please shorten it to 100 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (!isset($_POST[$userLink->link_url])) {
                echo "Make sure you were not edit our form. we can't find input url of link.";
                return;
            } else if (strlen($_POST[$userLink->link_url]) > 250) {
                echo "<b>Your link url is too long.</b> "
                    . "Please shorten it to 250 characters or less.<br>"
                    . "Consider using a more concise description.";
                return;
            } else if (trim($_POST[$userLink->link_url]) == '') {
                echo "Url of link is required";
                return;
            } else if (!isset($_FILES[$userLink->link_img])) {
                echo "Make sure you were not edit our form. we can't find input file image of link.";
                return;
            }

            $file_name = null;
            if ($_FILES[$userLink->link_img]['name'] !== '') {
                $img_ext = pathinfo($_FILES[$userLink->link_img]['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $img_ext;
            }

            $user_id = $_SESSION[$user->id];
            $iconId = $_POST[$userLink->link_icon_id];
            $title = $_POST[$userLink->link_name];
            $url = $_POST[$userLink->link_url];
            $created_at = date('Y-m-d H:i:s');

            $sql = "INSERT INTO $userLink->model(
                $userLink->link_user_id,
                $userLink->link_icon_id,
                $userLink->link_name,
                $userLink->link_url,
                $userLink->link_img,
                $userLink->created_at,
                $userLink->updated_at)
                VALUES(
                '$user_id',
                '$iconId',
                '$title',
                '$url',
                '$file_name',
                '$created_at',
                '$created_at')";
            $result = $conn->query($sql);

            if ($result) {
                if (isset($_FILES[$userLink->link_img]) && $_FILES[$userLink->link_img]['name'] !== '') {

                    if (validateImagesEX($_FILES[$userLink->link_img]['name'])) {
                        uploadAndCompressImage($_FILES[$userLink->link_img], $file_name);
                    } else {
                        echo "Make sure your images extension is .jpg,.jpeg,.png,.web.";
                        return;
                    }
                }
                echo "<b>Your link has been updated and is now live!</b><br>"
                    . "<p>Refresh your page for see updating. Thank you for using our service. If you need further assistance, feel free to contact support.</p>";
            } else {
                echo "<b>Error: Sorry, we can't edit.</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact support if the problem persists.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
            }

        } else if (isset($_POST['action']) && $_POST['action'] == 'delete') {

            if (!isset($_POST[$userLink->id])) {
                echo "Make sure you were not edit our form. we can't find id for edit your link.";
                return;
            }

            $user_id = $_SESSION[$user->id];
            $link_id = $_POST[$userLink->id];

            $sql = "SELECT $userLink->id, $userLink->link_img FROM $userLink->model 
                WHERE $userLink->link_user_id = '$user_id' 
                AND $userLink->id = '$link_id'";

            $result = $conn->query($sql);

            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $result = $result->fetch_assoc();

                    $sql = "DELETE FROM $userLink->model WHERE $userLink->link_user_id = '$user_id' 
                    AND $userLink->id = '$link_id'";
                    $delete = $conn->query($sql);

                    if ($delete) {
                        echo "<b>Your link has been deleted!</b><br>"
                            . "<p>Refresh your page for see updating.</p>";
                    } else {
                        "<b>Error: Sorry, we can't delete.</b><br>"
                            . "There seems to be an issue with the query.<br>"
                            . "Please contact support if the problem persists.<br>"
                            . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                    }
                    if ($result[$userLink->link_img] !== null && trim($result[$userLink->link_img]) !== '') {
                        if (file_exists('storage/upload/' . $result[$userLink->link_img])) {
                            delete_file($result[$userLink->link_img]);
                        }
                    }
                } else {
                    echo "<b>Error: Sorry, we can't delete.</b><br>"
                        . "There seems to be an issue with the query.<br>"
                        . "Please contact support if the problem persists.<br>"
                        . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                    return;
                }
            } else {
                echo "<b>Error: Sorry, we can't delete.</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact support if the problem persists.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                return;
            }
        } else if (isset($_POST['action']) && $_POST['action'] == 'chang_status') {

            if (!isset($_POST[$userLink->id])) {
                echo "Make sure you were not edit our form. We can't find id for edit your link.";
                return;
            } else if (!isset($_POST[$userLink->link_status])) {
                echo "Make sure you were not edit our form. We can't find status input for edit your link.";
                return;
            }
            if ($_POST[$userLink->link_status] !== '1' && $_POST[$userLink->link_status] !== '0') {
                echo "Make sure you were not edit our form. You try with invalid data status.";
                return;
            }
            $status = $_POST[$userLink->link_status] == '1' ? 0 : 1;
            $link_id = $_POST[$userLink->id];
            $user_id = $_SESSION[$user->id];

            $sql = "UPDATE $userLink->model SET
                $userLink->link_status = '$status'
                WHERE $userLink->link_user_id = '$user_id' 
                AND $userLink->id = '$link_id'";
            $result = $conn->query($sql);

            if (!$result) {
                echo "<b>Error: Sorry, we can't update stuatus link.</b><br>"
                    . "There seems to be an issue with the query.<br>"
                    . "Please contact support if the problem persists.<br>"
                    . '<a href="https://web.facebook.com/profile.php?id=100041547633244">linkme.support.com</a>';
                return;
            }

        } else {
            echo "We can't find the action you were trying to perform, such as editing, updating, or inserting data.<br>"
                . "This could be due to an incorrect request or a missing action parameter.<br>"
                . "Please make sure you're performing the action correctly:<br>"
                . "- If you intended to edit or update an item, ensure that you've selected the correct item and filled out all required fields.<br>"
                . "- If you were trying to insert new data, verify that all the necessary information has been provided.<br>"
                . "If the problem persists, try refreshing the page and attempting the action again.<br>"
                . "If you continue to encounter issues, please contact support for further assistance.";
        }

    } else {
        echo "You can't access to this page.";
    }
} else {
    echo "<b>Please submit the form using the provided form.</b><br>"
        . "It seems that you are trying to access this page directly without submitting the form.<br>"
        . "To proceed, please fill out and submit the form from the previous page.<br>"
        . "If you need help, you can contact our support team or go back to the <a class='curs-p' onclick='history.back()'>form page</a>.";
}
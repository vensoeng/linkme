<?php
session_start();

require 'database/index.php';
require 'app/config/functions.php';
require 'database/ui/index.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/config/compress_images.php';
require 'app/config/province_array.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        ui('<h2>CSRF token validation failed</h2>You are not accetp our permission.<br>Return back: <a onclick="history.back()" class="aui">history page.</a>');
        die();
    }

    $user = new User();
    $userDetail = new UserDetail();

    if(isset($_SESSION[$user->email]) && isset($_SESSION[$user->password]))
    {
        $user_id = $_SESSION[$user->id];

        if(isset($_POST['action']) && $_POST['action'] == $userDetail->profile){ //this is for profile picture

            $profile_name = "";
            if(isset($_FILES[$userDetail->profile])){

                $img_ext = pathinfo($_FILES[$userDetail->profile]['name'], PATHINFO_EXTENSION);
                $profile_name = uniqid() . '.' . $img_ext;

                $sql = "SELECT $userDetail->profile FROM $userDetail->model WHERE $userDetail->user_detail_id = '$user_id'";
                $userProfile = $conn->query($sql);
                
                if($userProfile && mysqli_num_rows($userProfile) == 1){
                    $userProfile = $userProfile->fetch_assoc();

                    $sql = "UPDATE $userDetail->model
                    SET $userDetail->profile = '$profile_name' 
                    WHERE $userDetail->user_detail_id = '$user_id'";

                    $result = $conn->query($sql);
                
                    if($result){
                        if(validateImagesEX($_FILES[$userDetail->profile]['name']))
                        {
                            uploadAndCompressImage($_FILES[$userDetail->profile],$profile_name);
                        }else{
                            echo "Make sure your images extension is .jpg,.jpeg,.png,.web.";
                            return;
                        }
                        if(file_exists('storage/upload/'.$userProfile[$userDetail->profile])){
                            delete_file($userProfile[$userDetail->profile]);
                        }
                        echo "You edited your profile picture successfully";
                    }else
                    {
                        echo "Sorry myserver an error.<br>please try one more time";
                    }

                }else
                {
                    echo "Sorry myserver an error.<br>please try one more time".$sql;
                }
                
            }else
            {
                echo "Sorry, We can't find input profile name.";
            }

        }else if(isset($_POST['action']) && $_POST['action'] == $userDetail->cover)//tis is for cover photo
        {
            $cover_name = "";

            if(isset($_FILES[$userDetail->cover])){
                $img_ext = pathinfo($_FILES[$userDetail->cover]['name'], PATHINFO_EXTENSION);
                $cover_name = uniqid() . '.' . $img_ext;

                $sql = "SELECT $userDetail->cover FROM $userDetail->model WHERE $userDetail->user_detail_id = '$user_id'";
                $userCover = $conn->query($sql);
                
                if($userCover && mysqli_num_rows($userCover) == 1){
                    $userCover = $userCover->fetch_assoc();

                    $sql = "UPDATE $userDetail->model SET $userDetail->cover = '$cover_name' 
                    WHERE $userDetail->user_detail_id = '$user_id'";

                    $result = $conn->query($sql);
                
                    if($result){
                        if(validateImagesEX($_FILES[$userDetail->cover]['name']))
                        {
                            uploadAndCompressImage($_FILES[$userDetail->cover],$cover_name);
                        }else{
                            echo "Make sure your images extension is .jpg,.jpeg,.png,.web.";
                            return;
                        }
                        if(file_exists('storage/upload/'.$userCover[$userDetail->cover])){
                            delete_file($userCover[$userDetail->cover]);
                        }
                        echo "You edited your cover photo successfully";
                    }else
                    {
                        echo "Sorry myserver an error.<br>please try one more time";
                    }

                }else
                {
                    echo "Sorry myserver an error.<br>please try one more time.";
                }
                
            }else
            {
                echo "Sorry, We can't find input file cover name.";
            }
        }else if(isset($_POST['action']) && $_POST['action'] == $userDetail->img_share)//this is for image share
        {
            $img_share_name = "";

            if(isset($_FILES[$userDetail->img_share])){

                $img_ext = pathinfo($_FILES[$userDetail->img_share]['name'], PATHINFO_EXTENSION);
                $img_share_name = uniqid() . '.' . $img_ext;

                $sql = "SELECT $userDetail->img_share FROM $userDetail->model WHERE $userDetail->user_detail_id = '$user_id'";
                $userImgShare = $conn->query($sql);
                
                if($userImgShare && mysqli_num_rows($userImgShare) == 1){
                    $userImgShare = $userImgShare->fetch_assoc();

                    $sql = "UPDATE $userDetail->model SET $userDetail->img_share = '$img_share_name' 
                    WHERE $userDetail->user_detail_id = '$user_id'";

                    $result = $conn->query($sql);
                
                    if($result){
                        if(validateImagesEX($_FILES[$userDetail->img_share]['name']))
                        {
                            uploadAndCompressImage($_FILES[$userDetail->img_share],$img_share_name);
                        }else{
                            echo "Make sure your images extension is .jpg,.jpeg,.png,.web.";
                            return;
                        }
                        if(file_exists('storage/upload/'.$userImgShare[$userDetail->img_share])){
                            delete_file($userImgShare[$userDetail->img_share]);
                        }
                        echo "You edited your share image successfully";
                    }else
                    {
                        echo "Sorry myserver an error.<br>please try one more time";
                    }

                }else
                {
                    echo "Sorry myserver an error.<br>please try one more time.";
                }
                
            }else
            {
                echo "Sorry, We can't find input file image share.";
            }
        }else if(isset($_POST['action']) && $_POST['action'] == $userDetail->bio)//this is for bio 
        {
            if(isset($_POST[$userDetail->bio])){
                
                if(!empty($_POST[$userDetail->bio]) && !empty(trim($_POST[$userDetail->bio])) && strlen($_POST[$userDetail->bio]) < 100){

                    $escapedBio = $conn->real_escape_string($_POST[$userDetail->bio]);

                    $sql = "UPDATE $userDetail->model SET $userDetail->bio = '$escapedBio' 
                    WHERE $userDetail->user_detail_id = '$user_id'";

                    $result = $conn->query($sql);
                
                    if($result){
                        echo "You edited your bio successfully";
                    }else
                    {
                        echo "Sorry myserver an error.<br>please try one more time";
                    }

                }else
                {
                    echo "Please Describe your autobiography, at most 100 characters.";
                }
                
            }else
            {
                echo "Sorry, We can't find input bio.";
            }
        }else if(isset($_POST['action']) && $_POST['action'] == 'checkusername')//this Is for check username
        {
            if(isset($_POST[$user->user_name])){

                if(trim($_POST[$user->user_name]) !== ''){

                    $username = $_POST[$user->user_name];
                    $username = trim($username);
                    $username = str_replace(' ', '', $username);
                    $username = strtolower($username);

                    if(strlen($username) < 3 || strlen($username) > 20){
                        return "Username must be between 3 and 20 characters long.";
                    }else{
                        if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
                            echo "Username can only contain letters, numbers, and underscores.";
                            return;
                        }

                        $sql = "SELECT $user->user_name 
                            FROM $user->model 
                            WHERE $user->user_name = '$username'
                            AND $user->id != '$user_id'";
                    
                            $result = $conn->query($sql);

                        if($result){
                            if(mysqli_num_rows($result) == 1){
                                echo 'This username has been used on application. So please try to use on another username.';
                            }else{
                                echo 'Happy to you🥰. You can use this username.';
                            }
                        }else{
                            echo 'Error: '.mysqli_error($conn);
                        }
                    }
                }else{  
                    echo 'Please Enter your username.';
                }
            }else{
                echo "I can't find action for update or insert";
            }
        }else if(isset($_POST['action']) && $_POST['action'] == 'checkemail'){
            if(isset($_POST[$user->email])){

                $email = $_POST[$user->email];
                $email = trim($email);

                if($email !== ''){
                    if(validateInput($email) === "Email" || validateInput($email) === "Phone"){
                        $sql = "SELECT $user->user_name 
                        FROM $user->model 
                        WHERE $user->email = '$email'
                        AND $user->id != '$user_id'";
                
                        $result = $conn->query($sql);
    
                        if($result){
                            if(mysqli_num_rows($result) == 1){
                                echo 'This email or phone has been used on application. So please try to use on another email or phone.';
                            }else{
                                echo 'Happy to you🥰 You can use this email or phone.';
                            }
                        }else{
                            echo 'Error: '.mysqli_error($conn);
                        }
                    }else{
                        echo 'Email or phone invalid data. please enter valid Email or Phone';
                    }
                }else{  
                    echo 'Please input in Email or Phone number';
                }
            }else{
                echo "I can't find action for update or insert";
            }
        }else if(isset($_POST['action']) && isset($_POST['action']) == $userDetail->model){
            $username = trim($_POST[$user->user_name]);
            $username = str_replace(' ', '', $username);
            $username = strtolower($username);
            $email = trim($_POST[$user->email]);
            $password = trim($_POST[$user->password]);
            $gender = $_POST[$userDetail->gender];
            $firstname = $_POST[$userDetail->first_name];
            $lastname = $_POST[$userDetail->last_name];
            $birthday = $_POST[$userDetail->user_birthday];
            $address = $_POST[$userDetail->user_address];
            //this is for validate data username
            if($username == ''){
                echo "Please enter user name.";
                return;
            }else if(strlen($username) < 3 || strlen($username) > 20){
                echo "Username must be between 3 and 20 characters long.";
                return;
            }else if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
                echo "Username can only contain letters, numbers, and underscores.";
                return;
            }else{
                $sql = "SELECT $user->user_name 
                    FROM $user->model 
                    WHERE $user->user_name = '$username'
                    AND $user->id != '$user_id'";
                    
                $result = $conn->query($sql);

                if($result){
                    if(mysqli_num_rows($result) == 1)
                    {
                        echo 'This username has been used on application. So please try to use on another username.';
                        return;
                    }
                }else{
                    echo 'Error:'.mysqli_error($conn);
                    return;
                }
            }
            if($email == ''){
                echo 'Please enter email before submit form.';
            }else if(validateInput($email) !== "Email" && validateInput($email) !== "Phone"){
                echo 'Email or phone invalid data. please enter valid Email or Phone';
                return;
            }else{
                $sql = "SELECT $user->user_name 
                FROM $user->model 
                WHERE $user->email = '$email'
                AND $user->id != '$user_id'";
        
                $result = $conn->query($sql);

                if($result){
                    if(mysqli_num_rows($result) == 1){
                        echo 'This email or phone has been used on application. So please try to use on another email or phone.';
                        return;
                    }
                }else{
                    echo 'Error: '.mysqli_error($conn);
                    return;
                }
            }
            if($password == ''){
                echo 'Please enter your password';
                return;
            }else if($password !== $_SESSION[$user->password]){
                $password = md5($password);
            }else if(!is_numeric($gender)){
                echo "Make sure you are not edit our form. We can't find this gender in database.";
                return;
            }else if($gender !== '0' && $gender !== '1' && $gender !== '2'){
                echo "Make sure you are not edit our form. We can't find this gender in database.";
                return;
            }else if($firstname == ''){
                echo "Please input your first name";
                return;
            }else if($lastname == ''){
                echo "Please input your last name";
                return;
            }else if($birthday !== ''){
                $dateComponents = explode('-', $birthday);
                if (count($dateComponents) === 3) {
                    $year = (int)$dateComponents[0];
                    $month = (int)$dateComponents[1];
                    $day = (int)$dateComponents[2];
                
                    if (!checkdate($month, $day, $year)) {
                        echo "Please enter a valid date.";
                        return;
                    }
                } else {
                    echo "Invalid date format.";
                    return;
                }
            }else if($address !== ''){
                if(!is_numeric($address)){
                    echo "Make sure you are not edit our form. We can't find this address in database.";
                    return;
                }
            }else if($address < 0 && $address > count($arrayProvince)){
                echo "Make sure you are not edit our form. We can't find this address in database.";
                return;
            }
            
            $sql = "UPDATE $user->model SET 
                $user->user_name = '$username',
                $user->email = '$email',
                $user->password = '$password'
                WHERE $user->id = '$user_id'";
                $result = $conn->query($sql);

            if(!$result){
                echo "
                    <h2 style='font-size: 1.1rem; font-family: var(--sg-fontbrand);text-align: center;'>Sorry myserver an error</h2>
                    ".mysqli_error($conn).""."<br>
                    Report about it: <a href='https://t.me/vensoeng' style='font-family: var(--sg-fontbrand);color: #1876f2c7;'>linkme.Support.com</a>
                    ";
                return;
            }else{
                $sql = "UPDATE $userDetail->model SET 
                $userDetail->gender = '$gender',
                $userDetail->first_name = '$firstname',
                $userDetail->last_name = '$lastname',
                $userDetail->user_birthday = '$birthday',
                $userDetail->user_address = '$address'
                WHERE $userDetail->user_detail_id = '$user_id'";
                $result = $conn->query($sql);
                if(!$result){
                    echo "
                        <h2 style='font-size: 1.1rem; font-family: var(--sg-fontbrand);text-align: center;'>Sorry myserver an error</h2>
                        ".mysqli_error($conn).""."<br>
                        Report about it: <a href='https://t.me/vensoeng' style='font-family: var(--sg-fontbrand);color: #1876f2c7;'>linkme.Support.com</a>
                        ";
                    return;
                }else{
                    echo 'Your profile detail edit completed';
                }
            }
        }else
        {
            echo 'We can find action for start to update or insert.';
        }
    }else
    {
        ui('Please singup or login to Application before you do it.<br>Return to: <a class="aui" href="/login/">Login</a>');
        die();
    }
}else{
    ui("<h2>Not found 004.</h2>404 and other response status codes are part of the web's Hypertext Transfer Protocol response codes. The 404 code means that a server could not find a client-requested webpage..<br>Return back: <a onclick='history.back()' class='aui'>history page.</a>");
}
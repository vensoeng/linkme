<?php
require 'database/ui/index.php'; //for user ui
require 'database/index.php'; // for use database 

class CheckTable{
    function checkTable($tablename)
    {
        global $conn;
        $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$tablename' AND TABLE_SCHEMA = DATABASE()";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            die("Error executing query: " . mysqli_error($conn));
        }
        return mysqli_num_rows($result) > 0;
    }
}
$checkTable = new CheckTable();
// ----------------------this is using class---------------------
require 'app/model/tb_icon.php'; 
require 'app/model/tb_role.php'; 
require 'app/model/tb_icon_type.php';
require 'app/model/tb_store_list_icon_type.php';
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/model/tb_status.php';
require 'app/model/tb_user_link.php';
require 'app/model/tb_post_type.php';
require 'app/model/tb_content.php';
require 'app/model/tb_reacte_type.php';
require 'app/model/tb_reacte.php';
require 'app/model/tb_follower.php';
require 'app/model/tb_user_activity.php';

use App\Model\Icon\Icon as Icon;
use App\Model\Role\Role as Role;
use App\Model\IconType\IconType as IconType;
use App\Model\ListIconType\ListIconType as ListIconType;
use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\Status\Status as Status;
use App\Model\UserLink\UserLink as UserLink;
use App\Model\PostType\PostType as PostType;
use App\Model\Content\Content as Content;
use App\Model\ReatType\ReateType as ReateType;
use App\Model\Reacte\Reacte as Reacte;
use App\Model\Follower\Follower as Follower;
use App\Model\UserActivity\UserActivity as UserActivity;
// -------------------this is for crate tb icon---------------- 
$icon = new Icon();
if(!$checkTable->checkTable($icon->model)) //create 
{

    $createTableSql = "
    CREATE TABLE $icon->model (
        $icon->id INT PRIMARY KEY AUTO_INCREMENT,
        $icon->icon VARCHAR(200) NULL DEFAULT '</i>icon</i>',
        $icon->icon_name VARCHAR(250) NULL,
        $icon->icon_img VARCHAR(255) NULL
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$icon->model.' successful!');
    }
}else{
    ui('We has been created table '.$icon->model.' successful!');
}
if($checkTable->checkTable($icon->model)) //insert
{
    $arrayData = [
        (object)[
            $icon->icon_name => 'Facebook',
            $icon->icon => '<i class="fa-brands fa-facebook"></i>'
        ],
        (object)[
            $icon->icon_name => 'Instagram',
            $icon->icon => '<i class="fa-brands fa-square-instagram"></i>'
        ],
        (object)[
            $icon->icon_name => 'Twitter',
            $icon->icon => '<i class="fa-brands fa-x-twitter"></i>'
        ],
        (object)[
            $icon->icon_name => 'YouTube',
            $icon->icon => '<i class="fa-brands fa-youtube"></i>'
        ],
        (object)[
            $icon->icon_name => 'Tiktok',
            $icon->icon => '<i class="fa-brands fa-tiktok"></i>'
        ],
        (object)[
            $icon->icon_name => 'Telegram',
            $icon->icon => '<i class="fa-brands fa-telegram"></i>'
        ],
        (object)[
            $icon->icon_name => 'linkedin',
            $icon->icon => '<i class="fa-brands fa-linkedin-in"></i>'
        ],
        (object)[
            $icon->icon_name => 'Github',
            $icon->icon => '<i class="fa-brands fa-github-alt"></i>'
        ],
        (object)[
            $icon->icon_name => 'Snapchat',
            $icon->icon => '<i class="fa-brands fa-square-snapchat"></i>'
        ],
        (object)[
            $icon->icon_name => 'Theads',
            $icon->icon => '<i class="fa-brands fa-threads"></i>'
        ],
        (object)[
            $icon->icon_name => 'Website',
            $icon->icon => '<i class="fa-solid fa-globe"></i>'
        ],
        (object)[
            $icon->icon_name => 'Mail',
            $icon->icon => '<i class="fa-regular fa-envelope"></i>'
        ]
    ];
    $checkQuery = "SELECT 1 FROM $icon->model LIMIT 1";
    $checkStmt = mysqli_query($conn, $checkQuery);

    if ($checkStmt === false) {
       ui('Error:'.mysqli_error($conn));
    }

    if (mysqli_num_rows($checkStmt) == 0) {
        $values = [];
        foreach ($arrayData as $item) {
            $values[] = "('".mysqli_real_escape_string($conn, $item->{$icon->icon})."', '".mysqli_real_escape_string($conn, $item->{$icon->icon_name})."')";
        }
        $valuesString = implode(',', $values);

        $insertQuery = "
        INSERT INTO $icon->model ($icon->icon, $icon->icon_name)
        VALUES $valuesString";

        $insertStmt = mysqli_query($conn, $insertQuery);
        if ($insertStmt === false) {
           ui("Insert user failed error: " . mysqli_error($conn));
        } else {
            ui("Insert successful!");
        }
    }else{
        ui('We has been insert data to table '.$icon->model.' successful!');
    }
}
// ------------------this is for create type of icon ---------
$typeIcon = new IconType();
if(!$checkTable->checkTable($typeIcon->model)) //create 
{
    $createTableSql = "
    CREATE TABLE $typeIcon->model (
        $typeIcon->id INT PRIMARY KEY AUTO_INCREMENT,
        $typeIcon->type_name VARCHAR(100) NULL DEFAULT 'typeicon',
        $typeIcon->type_num TINYINT(50) NOT NULL DEFAULT '1'
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$typeIcon->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$typeIcon->model.' successful!');
    }
}else
{
    ui('We has been created table '.$typeIcon->model.' successful!');
}
if($checkTable->checkTable($typeIcon->model)) //insert
{
    $arrayData = ['🔥Recommend','Creator','Realistic','Artistic','Social'];
    $checkQuery = "SELECT 1 FROM $typeIcon->model LIMIT 1";
    $checkStmt = mysqli_query($conn, $checkQuery);

    if ($checkStmt === false) {
       ui('Error insert data to table'.$typeIcon->model.':'.mysqli_error($conn));
    }
    if (mysqli_num_rows($checkStmt) == 0)
    {
        foreach ($arrayData as $item) {

            $insertQuery = "
            INSERT INTO $typeIcon->model ('$typeIcon->type_name')
            VALUES('$item')";
    
            $insertStmt = mysqli_query($conn, $insertQuery);
    
            if ($insertStmt === false) {
               ui("Insert user failed error: " . mysqli_error($conn));
            }
    
        }
    }else{
        ui('We has been insert data to table '.$typeIcon->model.' successful!');
    }
}
// --------------------this Is for create table store list icon type 
$listIconType = new ListIconType();
if(!$checkTable->checkTable($listIconType->model)) //create 
{
    $createTableSql = "
    CREATE TABLE $listIconType->model (
        $listIconType->id INT PRIMARY KEY AUTO_INCREMENT,
        $listIconType->icon_id INT NOT NULL,
        $listIconType->type_id INT NOT NULL,

        FOREIGN KEY ($listIconType->icon_id) REFERENCES $icon->model($icon->id) ON DELETE CASCADE,
        FOREIGN KEY ($listIconType->type_id) REFERENCES $typeIcon->model($typeIcon->id) ON DELETE CASCADE
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$typeIcon->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$typeIcon->model.' successful!');
    }
}else{
    ui('We has been created table '.$listIconType->model.' successful!');
}
// ---------------this Is for create role table-------------
$role = new Role();
if(!$checkTable->checkTable($role->model)) //create
{
    $createTableSql = "
    CREATE TABLE $role->model (
        $role->id INT PRIMARY KEY AUTO_INCREMENT,
        $role->role_name VARCHAR(100) NULL DEFAULT 'undefined'
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$role->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$role->model.' successful!');
    }
}else{
    ui('We has been created table '.$role->model.' successful!');
}
if($checkTable->checkTable($role->model)) //insert
{
    $arrayData = ['owner','admin','user'];
    $checkQuery = "SELECT 1 FROM $role->model LIMIT 1";
    $checkStmt = mysqli_query($conn, $checkQuery);

    if ($checkStmt === false) {
       ui('Error insert data to table'.$role->model.':'.mysqli_error($conn));
    }
    if (mysqli_num_rows($checkStmt) == 0)
    {
        foreach ($arrayData as $item) {

            $insertQuery = "
            INSERT INTO $role->model ($role->role_name)
            VALUES('$item')";
    
            $insertStmt = mysqli_query($conn, $insertQuery);
    
            if ($insertStmt === false) {
               ui("Insert user failed error: " . mysqli_error($conn));
            }
    
        } 
    }else{
        ui('We has been insert data to table '.$role->model.' successful!');
    }
}
// --------------------this is create table user------------------------ 
$user = new User();
if(!$checkTable->checkTable($user->model)) //create
{
    $createTableSql = "
    CREATE TABLE $user->model (
        $user->id INT PRIMARY KEY AUTO_INCREMENT,
        $user->user_role INT NOT NULL DEFAULT '3',
        $user->policy_status TINYINT(4) NOT NULL DEFAULT '1',
        $user->user_status TINYINT(4) NOT NULL DEFAULT '1',
        $user->verify_status TINYINT(4) NOT NULL DEFAULT '0',
        $user->email VARCHAR(250) UNIQUE NOT NULL,
        $user->password VARCHAR(250) NOT NULL,
        $user->user_name VARCHAR(25) UNIQUE NULL,
        $user->created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        $user->updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    
        FOREIGN KEY ($user->user_role) REFERENCES $role->model($role->id) ON DELETE CASCADE
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$user->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$user->model.' successful!');
    }
}else{
    ui('We has been create table '.$user->model.' successful!');
}
// ----------------------this is create user detail tabel ------------- 
$userDetail = new UserDetail();
if(!$checkTable->checkTable($userDetail->model) || $checkTable->checkTable($user->model)){
    $createTableSql = "
    CREATE TABLE $userDetail->model (
        $user->id INT PRIMARY KEY AUTO_INCREMENT,
        $userDetail->user_detail_id INT NOT NULL,
        $userDetail->first_name VARCHAR(50) NOT NULL,
        $userDetail->last_name VARCHAR(50) NOT NULL,
        $userDetail->profile VARCHAR(255) NOT NULL DEFAULT 'profile.jpg',
        $userDetail->gender TINYINT(4) NOT NULL DEFAULT '0',
        $userDetail->bio VARCHAR(100) NULL DEFAULT 'Hi there. I joined Linkme. Happy now?',
        $userDetail->cover VARCHAR(255) NULL DEFAULT 'profile.jpg',
        $userDetail->img_share VARCHAR(255) NULL DEFAULT 'profile.jpg',
        $userDetail->user_birthday DATE NULL,
        $userDetail->user_address TINYINT(4) NULL,

        FOREIGN KEY ($userDetail->user_detail_id) REFERENCES $user->model($user->id) ON DELETE CASCADE
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$userDetail->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$userDetail->model.' successful!');
    }
}else{
    ui('We has been create table '.$userDetail->model.' successful!');
}
// ----------------------this Is create status tabel -------------------
$status = new Status(); 
if(!$checkTable->checkTable($status->model)) //create
{
    $createTableSql = "
    CREATE TABLE $status->model (
        $status->id INT PRIMARY KEY AUTO_INCREMENT,
        $status->status_name VARCHAR(100) NULL DEFAULT 'undefined',
        $status->status_num TINYINT(4) NULL DEFAULT '1'
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$status->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$status->model.' successful!');
    }
}else{
    ui('We has been create table '.$status->model.' successful!');
}
if($checkTable->checkTable($status->model)) //insert
{
    $arrayData = [
        (object)[
            $status->status_name => 'public',
            $status->status_num => '1',
        ],
        (object)[
            $status->status_name => 'private',
            $status->status_num => '0',
        ]
    ];
    $checkQuery = "SELECT 1 FROM $status->model LIMIT 1";
    $checkStmt = mysqli_query($conn, $checkQuery);

    if ($checkStmt === false) {
       ui('Error insert data to table'.$status->model.':'.mysqli_error($conn));
    }
    if (mysqli_num_rows($checkStmt) == 0)
    {
        foreach ($arrayData as $item) {
            $name = $item->{$status->status_name};
            $num = $item->{$status->status_num};
            $insertQuery = "
            INSERT INTO $status->model ($status->status_name,$status->status_num)
            VALUES('$name','$num')";
    
            $insertStmt = mysqli_query($conn, $insertQuery);
    
            if ($insertStmt === false) {
               ui("Insert user failed error: " . mysqli_error($conn));
            }
    
        } 
    }else{
        ui('We has been insert data to table '.$status->model.' successful!');
    }
}
// -------------------this is create user link--------------------------------
$userLink = new UserLink(); 
if(!$checkTable->checkTable($userLink->model)) //create
{
    $createTableSql = "
    CREATE TABLE $userLink->model (
        $userLink->id INT PRIMARY KEY AUTO_INCREMENT,
        $userLink->link_user_id INT NOT NULL,
        $userLink->link_icon_id INT NOT NULL,
        $userLink->link_name VARCHAR(100) NULL,
        $userLink->link_url VARCHAR(255) NULL,
        $userLink->link_img VARCHAR(255) NULL,
        $userLink->link_status TINYINT(4) NOT NULL DEFAULT '1',
        $userLink->created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        $userLink->updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

        FOREIGN KEY ($userLink->link_user_id) REFERENCES $user->model($user->id) ON DELETE CASCADE,
        FOREIGN KEY ($userLink->link_icon_id) REFERENCES $icon->model($icon->id) ON DELETE CASCADE
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$userLink->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$userLink->model.' successful!');
    }
}else
{
    ui('We has been created table '.$userLink->model.' successful!');
}
// -------------------------------this is create post type--------------- 
$postType = new PostType(); 
if(!$checkTable->checkTable($postType->model)) //create
{
    $createTableSql = "
    CREATE TABLE $postType->model (
        $postType->id INT PRIMARY KEY AUTO_INCREMENT,
        $postType->post_type_title VARCHAR(100) NULL DEFAULT '1'
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$postType->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$postType->model.' successful!');
    }
}else
{
    ui('We has been created table '.$postType->model.' successful!');
}
if($checkTable->checkTable($postType->model)) //insert
{
    $arrayData = ['photo','text','share'];
    $checkQuery = "SELECT 1 FROM $postType->model LIMIT 1";
    $checkStmt = mysqli_query($conn, $checkQuery);

    if ($checkStmt === false) {
       ui('Error insert data to table'.$postType->model.':'.mysqli_error($conn));
    }
    if (mysqli_num_rows($checkStmt) == 0)
    {
        foreach ($arrayData as $item) {

            $insertQuery = "
            INSERT INTO $postType->model ($postType->post_type_title)
            VALUES('$item')";
    
            $insertStmt = mysqli_query($conn, $insertQuery);
    
            if ($insertStmt === false) {
               ui("Insert user failed error: " . mysqli_error($conn));
            }
    
        }
    }else{
        ui('We has been insert data to table '.$postType->model.' successful!');
    }
}
// --------------------------this is create content table----------------- 
$content = new Content();
if(!$checkTable->checkTable($content->model)) //create
{
    $createTableSql = "
    CREATE TABLE $content->model (
        $content->id INT PRIMARY KEY AUTO_INCREMENT,
        $content->user_post_id INT NOT NULL,
        $content->post_type INT NOT NULL DEFAULT '1',
        $content->post_status INT NOT NULL DEFAULT '1',
        $content->post_title VARCHAR(250) NULL,
        $content->post_des VARCHAR(500) NULL,
        $content->post_img VARCHAR(250) NULL,
        $content->post_like_count VARCHAR(200) NULL DEFAULT '0',
        $content->post_save_count VARCHAR(200) NULL DEFAULT '0',
        $content->post_comment_count VARCHAR(200) NULL DEFAULT '0',
        $user->created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        $user->updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

        FOREIGN KEY ($content->user_post_id) REFERENCES $user->model($user->id) ON DELETE CASCADE,
        FOREIGN KEY ($content->post_type) REFERENCES $postType->model($postType->id) ON DELETE CASCADE,
        FOREIGN KEY ($content->post_status) REFERENCES $status->model($status->id) ON DELETE CASCADE
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$content->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$content->model.' successful!');
    }
}else{
    ui('We has been create table '.$content->model.' successful!');
}
// -------------------------------this Is for create reate type-------------- 
$reateType = new ReateType(); 
if(!$checkTable->checkTable($reateType->model)) //create
{
    $createTableSql = "
    CREATE TABLE $reateType->model (
        $status->id INT PRIMARY KEY AUTO_INCREMENT,
        $reateType->reacte_type_title VARCHAR(100) NULL DEFAULT 'undefined'
    )";
    $createStmt = mysqli_query($conn, $createTableSql);
    if(!$createStmt)
    {
        ui('Error:'.$reateType->model. mysqli_error($conn)); 
    }else
    {
        ui('We has been created table '.$reateType->model.' successful!');
    }
}else{
    ui('We has been create table '.$reateType->model.' successful!');
}
if($checkTable->checkTable($reateType->model)) //insert
{
    $arrayData = ['like','save','comment','post'];
    $checkQuery = "SELECT 1 FROM $reateType->model LIMIT 1";
    $checkStmt = mysqli_query($conn, $checkQuery);

    if ($checkStmt === false) {
       ui('Error insert data to table'.$reateType->model.':'.mysqli_error($conn));
    }
    if (mysqli_num_rows($checkStmt) == 0)
    {
        foreach ($arrayData as $item) {

            $insertQuery = "
            INSERT INTO $reateType->model ($reateType->reacte_type_title)
            VALUES('$item')";
    
            $insertStmt = mysqli_query($conn, $insertQuery);
    
            if ($insertStmt === false) {
               ui("Insert user failed error: " . mysqli_error($conn));
            }
    
        }
    }else{
        ui('We has been insert data to table '.$reateType->model.' successful!');
    }
}
// ----------------------------this is for create react table---- 
$reacte = new Reacte();
if(!$checkTable->checkTable($reacte->model)) //create
{
    $createTableSql = "
    CREATE TABLE $reacte->model (
        $reacte->id INT PRIMARY KEY AUTO_INCREMENT,
        $reacte->reate_type INT NOT NULL,
        $reacte->post_id INT NOT NULL,
        $reacte->user_reacte_id INT NOT NULL,
        $reacte->user_post_id INT NOT NULL,
        $reacte->reacte_status TINYINT(4) NULL DEFAULT '0',
        $reacte->created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        $reacte->updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

        FOREIGN KEY ($reacte->reate_type) REFERENCES $reateType->model($reateType->id) ON DELETE CASCADE,
        FOREIGN KEY ($reacte->post_id) REFERENCES $content->model($content->id) ON DELETE CASCADE,
        FOREIGN KEY ($reacte->user_reacte_id) REFERENCES $user->model($user->id) ON DELETE CASCADE,
        FOREIGN KEY ($reacte->user_post_id) REFERENCES $user->model($user->id) ON DELETE CASCADE
    )";

    $createStmt = mysqli_query($conn, $createTableSql);

    if(!$createStmt) {
        ui('Error: '.$reacte->model. mysqli_error($conn)); 
    } else {
        ui('We have successfully created the table '.$reacte->model.'!');
    }
} else {
    ui('We has been create table '.$reacte->model.' successful!');
}
// ----------------------this is Create table followe--------------------- 
$follower = new Follower();
if(!$checkTable->checkTable($follower->model)) //create
{
    $createTableSql = "
    CREATE TABLE $follower->model (
        $reacte->id INT PRIMARY KEY AUTO_INCREMENT,
        $follower->user_follower_id INT NOT NULL,
        $follower->user_sand_follower_id INT NOT NULL,
        $follower->follower_status TINYINT(4) NOT NULL DEFAULT '0' CHECK ($follower->follower_status IN (0, 1)),
        $reacte->created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        $reacte->updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

        FOREIGN KEY ($follower->user_follower_id) REFERENCES $user->model($user->id) ON DELETE CASCADE,
        FOREIGN KEY ($follower->user_sand_follower_id) REFERENCES $user->model($user->id) ON DELETE CASCADE
    )";

    $createStmt = mysqli_query($conn, $createTableSql);

    if(!$createStmt) {
        ui('Error: '.$follower->model. mysqli_error($conn)); 
    } else {
        ui('We have successfully created the table '.$follower->model.'!');
    }
} else {
    ui('We has been create table '.$follower->model.' successful!');
}
// -------------------------this is create table user activity table-------------- 
$userActivity = new UserActivity();
if(!$checkTable->checkTable($userActivity->model)) //create
{
    $createTableSql = "
    CREATE TABLE $userActivity->model (
        $userActivity->id INT PRIMARY KEY AUTO_INCREMENT,
        $userActivity->activity_user_id INT NOT NULL,
        $userActivity->activity_content_id INT NOT NULL,
        $userActivity->activity_type_id INT NOT NULL,
        $reacte->created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        $reacte->updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

        FOREIGN KEY ($userActivity->activity_user_id) REFERENCES $user->model($user->id) ON DELETE CASCADE,
        FOREIGN KEY ($userActivity->activity_content_id) REFERENCES $content->model($content->id) ON DELETE CASCADE,
        FOREIGN KEY ($userActivity->activity_type_id) REFERENCES $reateType->model($reateType->id) ON DELETE CASCADE
    )";

    $createStmt = mysqli_query($conn, $createTableSql);

    if(!$createStmt) {
        ui('Error: '.$userActivity->model. mysqli_error($conn)); 
    } else {
        ui('We have successfully created the table '.$userActivity->model.'!');
    }
} else {
    ui('We has been create table '.$userActivity->model.' successful!');
}
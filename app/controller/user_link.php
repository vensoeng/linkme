<?php
session_start();

require 'database/index.php';
require 'app/model/tb_user.php';
require 'database/ui/index.php';
require 'app/config/bio_text.php';
require 'app/model/user_detail.php';
require 'app/model/tb_icon.php';
require 'app/model/tb_icon_type.php';
require 'app/model/tb_store_list_icon_type.php';
require 'app/model/tb_user_link.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\Icon\Icon as Icon;
use App\Model\IconType\IconType as IconType;
use App\Model\ListIconType\ListIconType as ListIconType;
use App\Model\UserLink\UserLink as UserLink;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $userDetail = new UserDetail();
    $icon = new Icon();
    $typeIcon = new IconType();
    $listIconType = new ListIconType();

    if(isset($_POST[$typeIcon->type_name]) && $_POST[$typeIcon->type_name] !== ''){

        $randomKey = array_rand($phrases);
        $randomPhrase = $phrases[$randomKey];
    
        $bio = $_POST['bio'] == '' ? $randomPhrase : $_POST['bio'];
        $escapedBio = $conn->real_escape_string($bio);

        $fileName = '';
        if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $file = $_FILES['img'];
            $fileTmp = $file['tmp_name'];

            $fileName = uniqid().'.png';
            
            if (move_uploaded_file($fileTmp, 'storage/upload/' . $fileName)) {
                ui("Image saved as: " . $fileName);
            } else {
                ui("Failed to save the image.");
            }
        }
        $user = new User();
        $user_id = $_SESSION[$user->id];

        $sql = "UPDATE $userDetail->model 
        SET $userDetail->bio = '$escapedBio', 
            $userDetail->img_share = '$fileName' 
        WHERE $userDetail->user_detail_id = '$user_id'";
        
        $result = $conn->query($sql);
        if($result){

            $_SESSION[$userDetail->bio] = $bio;
            $_SESSION[$userDetail->img_share] = $fileName;

            if(isset($_POST['link_url'])){
                $type_id = $_POST[$typeIcon->type_name];
            
                $sql = "SELECT * FROM $listIconType->model 
                    INNER JOIN $icon->model ON $listIconType->model.$listIconType->icon_id = $icon->model.$icon->id
                    WHERE $listIconType->type_id = '$type_id'";
                
                $result = $conn->query($sql);
                if($result){
                    $userLink = new UserLink();
                    $url = $_POST['link_url'];
                    $created_at = date('Y-m-d H:i:s');

                    if (is_array($url) && mysqli_num_rows($result) > 0){
                        foreach ($result as $index => $item) {
                            $link_icon_id = $item[$listIconType->icon_id];
                            $link_name = $item[$icon->icon_name];

                            if ($index < count($url)) {
                                if(filter_var($url[$index], FILTER_VALIDATE_URL)){
                                    $link_url = $url[$index];
                                }else{
                                    $link_url = "";
                                }
                            }else
                            {
                                $link_url = '';
                            }
                            $sql = "INSERT INTO $userLink->model(
                                $userLink->link_user_id,
                                $userLink->link_icon_id,
                                $userLink->link_name,
                                $userLink->link_url,
                                $userLink->created_at,
                                $userLink->updated_at
                            ) VALUES(
                               '$user_id',
                                '$link_icon_id',
                                '$link_name',
                                '$link_url',
                                '$created_at',
                                '$created_at'
                            )";
                            $result = $conn->query($sql);
                            if(!$result){
                                header('location: /signup/detail/link');
                                return;
                            }
                        }
                        // ================set desable page============== 
                        $_SESSION['user_login'] = 'logined';
                        
                        header('location: /signup/finish');
                    }else{
                        ui('Sorry My serve on error for loop data.<br>Return to :<a href="/signup/detail/link" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Post list</a>again?');
                    } 
                }else{
                    ui('Sorry My serve on error update user link data.<br>Return to :<a href="/signup/detail/link" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Post list</a>again?');
                }
            }else{
                ui('Make sure you provide your correct information?.<br>Return to :<a href="/signup/detail/link" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Post list</a> again?');
            }
        }else{
            ui('Sorry My serve on error update user datail data.<br>Return to :<a href="/signup/detail/link" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Post list</a> again?');
        }
        
    }else{
        ui('We detected that you are modifying our data entry form.<br>Return to : <a href="/signup/detail/link" style="font-family: var(--sg-fontbrand);color:#1876f2c7;">Post list</a> again?',true);
    }
    
}

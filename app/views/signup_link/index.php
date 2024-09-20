<?php
    session_start();
    require 'database/index.php';
    require 'database/ui/index.php';
    require 'app/config/functions.php';
    require 'app/model/user_detail.php';
    require 'app/model/tb_icon.php';
    require 'app/model/tb_icon_type.php';
    require 'app/model/tb_store_list_icon_type.php';
    require 'app/model/tb_user.php';
    require 'app/config/bio_text.php';

    use App\Model\User\User;
    use App\Model\UserDetail\UserDetail as UserDetail;
    use App\Model\Icon\Icon as Icon;
    use App\Model\IconType\IconType as IconType;
    use App\Model\ListIconType\ListIconType as ListIconType;
    use App\Model\ListIconType\RequestionItem as ListIconTypeRequest;

    $user = new User();
    $userDetail = new UserDetail();
    $icon = new Icon();
    $typeIcon = new IconType();
    $listIconType = new ListIconType();

    if (!isset($_SESSION[$user->email]) && !isset($_SESSION[$user->password]) || isset($_SESSION['user_login'])) {
        return header('location:'.getBaseUrl(''));
    }
    include 'app/views/layout/web_icon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>linkme - Customization</title>
    <?=webIcon()?>
    <!-- this is main css  -->
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/main.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/login.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/linkme.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/linkme_form.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=getBaseUrl('')?>public/css/link.css?v=<?=time()?>">
    <!-- this is for icon  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- this is style of swiper  -->
</head>
<body class="scroll-y">
    <!-- this Is content of page  -->
    <main class="web-main over-h">
        <div class="form-head form-head-active">
            <div class="form-body db-c scroll-y">
                <div class="head">
                    <ul class="df-l">
                        <li class="left-05">
                            <h2>Customization  Medialinkyours✨</h2>
                        </li>
                    </ul>
                </div>
                <nav class="head">
                    <ul class="df-l scroll-x data-list-type">
                        <?php
                            //this is show all type of icon 
                            if(!isset($_POST[$typeIcon->type_name]))
                            {
                                $sql = "SELECT * FROM $typeIcon->model";
                                $typeIconResult = $conn->query($sql);
            
                            }else{
                                $sql = "SELECT * FROM $typeIcon->model";
                                $typeIconResult = $conn->query($sql);
                            }

                            if($typeIconResult){
                            foreach ($typeIconResult as $item) {
                        ?>
                            <li class="left-05">
                                <form action="/signup/detail/link" method="POST">
                                    <input type="hidden" name="<?=$typeIcon->type_name?>" value="<?=$item[$typeIcon->id]?>">
                                    <button type="submit" class="bg-n curs-p">
                                        <a class="icon icon-sm iocn-ra <?php if(isset($_POST[$typeIcon->type_name])){if($item[$typeIcon->id] == $_POST[$typeIcon->type_name]){echo "active";}}?>">
                                            <?=htmlspecialchars($item[$typeIcon->type_name], ENT_QUOTES, 'UTF-8')?>
                                        </a>
                                    </button>
                                </form>
                            </li>
                        <?php 
                            } }
                        ?>
                    </ul>
                </nav>
                <form action="/signup/detail/link/store" method="POST" class="form-con" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="file" hidden name="img" id="file-canvas-img">
                    <?php
                    //this is for input for get typelist id of user using link
                        if(!isset($_POST[$typeIcon->type_name])){ ?>
                        <input type="text" hidden name="<?=$typeIcon->type_name?>" value="1">
                    <?php        
                        }else{ ?>
                        <input type="text" hidden name="<?=$typeIcon->type_name?>" value="<?=$_POST[$typeIcon->type_name]?>">
                    <?php
                        }
                    ?>
                    <ul class="linkme_root">
                        <!-- this is user profile details  -->
                        <li class="user-datial linkme-form">
                            <div class="linkme-form-user df-c">
                                <div class="box">
                                    <div class="profile icon icon-ra">
                                    <img class="img-c"
                                        loading="lazy"
                                        srcset="
                                        <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=100? 100w, 
                                        <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=200? 200w, 
                                        <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=400? 400w, 
                                        <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=800? 800w, 
                                        <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=1000? 1000w, 
                                        <?=getBaseUrl('storage/upload/'.$_SESSION[$userDetail->profile])?>?width=1200? 1200w, 
                                        "
                                        sizes="(max-width: 800px) 100vw, 50vw" 
                                        decoding="async"
                                        fetchPriority = "high"
                                        effect="blur"
                                    alt="">
                                    </div>
                                    <div class="text">
                                        <h2><?=$_SESSION[$userDetail->first_name].$_SESSION[$userDetail->last_name]?></h2>
                                        <h3><span><i class="fa-solid fa-link"></i>/</span><?=$_SESSION[$userDetail->first_name].$_SESSION[$userDetail->last_name]?></h3>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li style="--sg-height: 2.8rem;" id="get-height">
                            <label for="#">Your Bio</label>
                            <div class="txt-box df-l">
                                <div class="text-in">
                                    <textarea name="<?=$userDetail->bio?>" id="#" cols="30" maxlength="100" rows="5" oninput="document.querySelector('#caption-count').innerText = (this.value).length"><?php $randomKey = array_rand($phrases);$randomPhrase = $phrases[$randomKey];echo "Hi I'm ".$_SESSION[$userDetail->first_name].$_SESSION[$userDetail->last_name].' '.$randomPhrase;?></textarea>
                                </div>
                            </div>
                            <div class="df-r text-length">
                                <div class="text df-r">
                                    <span id="caption-count">45</span>
                                    <span>/100</span>
                                </div>
                            </div>
                        </li>
                        <!-- This is list icon for user  -->
                        <?php
                            //this is for show all playlist icon of user choose 
                            if(!isset($_POST[$typeIcon->type_name]))
                            {
                                $listIconSql = "SELECT * FROM $listIconType->model 
                                INNER JOIN $icon->model ON $listIconType->model.$listIconType->icon_id = $icon->model.$icon->id
                                WHERE $listIconType->type_id = '1'";
                                
                                $listIconResult = $conn->query($listIconSql); 
                            }else{
                                $type_num = $_POST[$typeIcon->type_name];
                                $listIconSql = "SELECT * FROM $listIconType->model 
                                INNER JOIN $icon->model ON $listIconType->model.$listIconType->icon_id = $icon->model.$icon->id
                                WHERE $listIconType->type_id = '$type_num'";
                                
                                $listIconResult = $conn->query($listIconSql); 
                            }
                            if($listIconResult){
                                foreach ($listIconResult as $item) {
                            ?>
                            <li>
                                <label for="#"><?=$item[$icon->icon_name]?></label>
                                <div class="txt-box df-l">
                                    <div class="icon icon-sm">
                                        <?=$item[$icon->icon]?>
                                    </div>
                                    <div class="text-in">
                                        <input type="text" name="link_url[]" class="db-c" placeholder="Your <?=strtolower($item[$icon->icon_name])?> link">
                                    </div>
                                    <div class="icon-leader i-lead2">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            </li>
                        <?php    
                                }
                            } 
                        ?>
                        <li class="main-btn df-s is-skip">
                            <button type="submit"  class="iocn icon-sm btn next">Next</button>
                            <button type="submit" class="iocn icon-sm btn skip">Skip</button>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="bg"></div>
        </div>
    </main>
    <!-- this is for insert image in js  -->
    <script>
       var listNavs = document.querySelectorAll('.data-list-type .icon');
       <?php
        if(!isset($_POST[$typeIcon->type_name])){ ?>
           listNavs[0].classList.add('active')
       <?php }
       ?>
    </script>
    <!-- this is script for canvas image  -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            html2canvas(document.querySelector('.linkme-form')).then(canvas => {
                canvas.toBlob(function(blob) {
                    const file = new File([blob], "canvas_image.png", {type: "image/png"});
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('file-canvas-img').files = dataTransfer.files;
                    console.log("Image captured and stored in hidden input.");
                });
            });
        })
    </script>
</body>
</html>
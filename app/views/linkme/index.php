<?php
//this is function
require 'database/index.php';
require 'app/config/functions.php';
require 'database/ui/index.php';
// this is model
require 'app/model/tb_user.php';
require 'app/model/user_detail.php';
require 'app/model/tb_user_link.php';
require 'app/model/tb_icon.php';

use App\Model\User\User as User;
use App\Model\UserDetail\UserDetail as UserDetail;
use App\Model\UserLink\UserLink as UserLink;
use App\Model\Icon\Icon as Icon;

if (!isset($item)) {
    ui('
            <h2 class="h2ui">Error: User Not Found!</h2>
            <p>The user you are looking for could not be found in our system. Please check the details and try again.</p>
            <a onclick="history.back()" class="aui">Previous page.</a>
        ');
    return;
}

$user = new User();
$userDetail = new UserDetail();
$userLink = new UserLink();
$icon = new Icon();

$username = $item;

$sql = "SELECT * FROM $userDetail->model
    INNER JOIN $user->model ON $userDetail->model.$userDetail->user_detail_id = $user->model.$user->id
    WHERE $user->model.$user->user_name = '$username'";

$result = $conn->query($sql);
if ($result) {
    if (mysqli_num_rows($result) !== 1) {
        ui('
                <h2 class="h2ui">Error: User Not Found!</h2>
                <p>The user you are looking for could not be found in our system. Please check the details and try again.</p>
                <a onclick="history.back()" class="aui">Previous page.</a>
            ');
        return;
    } else {
        $getUser = $result->fetch_assoc();
    }
} else {
    ui("
            <h2 style='font-size: 1.1rem; font-family: var(--sg-fontbrand);text-align: center;'>Sorry myserver an error</h2>
            " . mysqli_error($conn) . "" . "<br>
            Report about it: <a href='https://t.me/vensoeng' style='font-family: var(--sg-fontbrand);color: #1876f2c7;'>linkme.Support.com</a>
        ");
    return;
}
$userLink = new UserLink();
$icon = new Icon();
$user_id = $getUser[$userDetail->user_detail_id];

$sql = "SELECT * FROM $userLink->model 
    INNER JOIN $icon->model ON $userLink->model.$userLink->link_icon_id = $icon->model.$icon->id
    WHERE $userLink->link_user_id = '$user_id'
    AND $userLink->link_status = 1";
$result = $conn->query($sql);

include 'app/views/layout/web_icon.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>linkme - <?= ucfirst($getUser[$userDetail->first_name] . ' ' . $getUser[$userDetail->last_name]) ?></title>
    <meta property="og:title" content="VenSoeng Story"/>
    <?=webIcon()?>
    <meta property="og:description" content="<?=$getUser[$userDetail->bio]?>" />
    <meta property="og:url" content="<?=getCurrentUrl()?>"/>
    <meta property="og:type" content="website"/>
    <meta property="profile:username" content="vensoeng">
    <meta name="twitter:description" content="Hello! I'm VenSoeng.">
    <link rel="canonical" href="<?=getCurrentUrl()?>">
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="515" />
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:locale" content="km_KH">
    <meta property="og:site_name" content="vensoeng">
    <!-- this is main css  -->
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/linkme.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/linkme_form.css?v=<?= time() ?>">
    <!-- this is for icon  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- this is style of swiper  -->
    <style>
        body::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="scroll-y">
    <!-- this is link me of user  -->
    <div class="linkme df-c linkme_root">
        <div class="linkme-con">
            <div class="link-head df-r">
                <div class="icon icon-ra icon-sm" onclick=" hiddenForm('#main-linkme')">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
            </div>
            <div class="linkme-detail">
                <!-- user-detail  -->
                <div class="likme-user">
                    <div class="profile icon icon-ra">
                        <img class="img-c" loading="lazy" srcset="
                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=100? 100w, 
                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=200? 200w, 
                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=400? 400w, 
                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=800? 800w, 
                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1000? 1000w, 
                            <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1200? 1200w, 
                            " sizes="(max-width: 800px) 100vw, 50vw" decoding="async" fetchPriority="high"
                            effect="blur" alt="">
                    </div>
                    <div class="text">
                        <h2><?= $getUser[$userDetail->first_name] . $getUser[$userDetail->last_name] ?></h2>
                        <blockquote>
                            <p><?= $getUser[$userDetail->bio] ?></p>
                        </blockquote>
                    </div>
                    <ul class="df-c">
                        <?php

                        $randomItems = [];
                        $items = [];
                        if ($result && mysqli_num_rows($result) > 3) {
                            while ($row = $result->fetch_assoc()) {
                                $items[] = $row;
                            }
                            shuffle($items);

                            $randomItems = array_slice($items, 0, 3);
                        } else {
                            $randomItems = $result->fetch_assoc();
                        }
                        if ($randomItems) {
                            foreach ($randomItems as $index => $Item) {
                                ?>
                                <li>
                                    <a href="#" class="icon icon-ra icon-sm">
                                        <?= $Item[$icon->icon] ?>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- this is linkme list  -->
                <div class="linkme-list">
                    <ul>
                        <?php
                        if ($result) {
                            foreach ($result as $index => $item) { ?>
                                <li>
                                    <div class="df-s">
                                        <div class="leading df-l">
                                            <div class="icon icon-sm icon-ra">
                                                <?php
                                                if ($item[$icon->icon_name] == 'Website' && $item[$userLink->link_img] !== '') {
                                                    ?>
                                                    <img class="img-c" loading="lazy" srcset="
                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=100? 100w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=200? 200w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=400? 400w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=800? 800w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=1000? 1000w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=1200? 1200w, 
                                                    " sizes="(max-width: 800px) 100vw, 50vw" decoding="async"
                                                        fetchPriority="high" effect="blur" alt="">
                                                    <?php
                                                } else {
                                                    echo $item[$icon->icon];
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <a href="<?= $item[$userLink->link_url] ?>" class="text df-c">
                                            <h2><?= $item[$userLink->link_name] ?></h2>
                                        </a>
                                        <div class="leading df-l">
                                            <div class="icon icon-sm icon-ra"
                                                onclick="hiddenForm('#form_link_list_<?= $index ?>')">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="linkme-main-contact df-c">
                    <?php
                    if (validateInput($getUser[$user->email]) == "Email") {
                        ?>
                        <a href="mailto:<?= $getUser[$user->email] ?>" class="icon icon-ra">
                            <i class="fa-regular fa-envelope"></i>
                        </a>
                        <?php
                    } else if (validateInput($getUser[$user->email]) == "Phone") {
                        ?>
                            <a href="tel:<?= $getUser[$user->email] ?>" class="icon icon-ra">
                                <i class="fa-solid fa-phone-volume"></i>
                            </a>
                        <?php
                    }
                    ?>
                </div>
                <div class="main-btn">
                    <a href="../signup/" class="icon icon-ra">
                        <i class="fa-solid fa-link"></i>
                        Join <?= ucfirst($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name]) ?> on
                        linkme
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- this is main link list  -->
    <div class="linkme-form linkme_root" id="main-linkme">
        <div class="linkme-form-body scroll-y">
            <!-- this Is head  -->
            <div class="head">
                <ul class="df-s">
                    <li>
                        <a href="#" class="icon icon-ra icon-sm">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </li>
                    <li>
                        <h2>Share linkme</h2>
                    </li>
                    <li>
                        <a class="icon icon-ra icon-sm"
                            onclick="document.querySelector('#main-linkme').classList.remove('linkme-form-active')">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- this is content  -->
            <div class="con scroll-y">
                <!-- this is for user details  -->
                <div class="linkme-form-user df-c">
                    <?php
                    if (file_exists('storage/upload/' . $getUser[$userDetail->img_share])) { ?>
                        <img class="img-c" loading="lazy" srcset="
                                    <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=100? 100w, 
                                    <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=200? 200w, 
                                    <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=400? 400w, 
                                    <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=800? 800w, 
                                    <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=1000? 1000w, 
                                    <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->img_share]) ?>?width=1200? 1200w, 
                                    " sizes="(max-width: 800px) 100vw, 50vw" decoding="async" fetchPriority="high"
                            effect="blur" alt="">
                        <?php
                    } else { ?>
                        <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                            <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                        </h2>
                        <?php
                    }
                    ?>
                </div>
                <!-- this Is for share to ohter media  -->
                <div class="media-list">
                    <ul class="df-l scroll-x">
                        <li class="df-c">
                            <a class="btn-copy">
                                <div class="icon icon-ra icon-sm curs-p">
                                    <i class="fa-solid fa-link"></i>
                                </div>
                                <p>Copylink</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- this is for footer of link me form user -->
            <div class="foot">
                <blockquote>
                    <h2>Join VenSoeng on Linkme</h2>
                    <p>Get your own free Linkme. The only link in bio trusted by 50M+ people.</p>
                </blockquote>
                <div class="main-btn">
                    <a href="/signup" class="btn icon icon-ra icon-sm">
                        Signup for free
                    </a>
                    <a href="/" class="btn icon icon-ra icon-sm">
                        Find out more
                    </a>
                </div>
            </div>
        </div>
        <div class="linkme-bg" onclick="document.querySelector('#main-linkme').classList.remove('linkme-form-active')">
        </div>
    </div>
    <!-- this is for list item  -->
    <?php
    if ($result) //what is result ? result is query from user link 
    {
        foreach ($result as $index => $item) {
            ?>
            <div class="linkme-form linkme_root" id="form_link_list_<?= $index ?>">
                <div class="linkme-form-body scroll-y">
                    <!-- this Is head  -->
                    <div class="head">
                        <ul class="df-s">
                            <li>
                                <a href="#" class="icon icon-ra icon-sm">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </li>
                            <li>
                                <h2>Share linkme</h2>
                            </li>
                            <li>
                                <a class="icon icon-ra icon-sm"
                                    onclick="document.querySelector('#form_link_list_<?= $index ?>').classList.remove('linkme-form-active')">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- this is content  -->
                    <div class="con scroll-y">
                        <!-- this is for user details  -->
                        <div class="linkme-form-user df-c linkme-form-user-list">
                            <div class="box">
                                <div class="profile icon icon-ra <?= strtolower($item[$icon->icon_name]) ?>-i">
                                    <?php
                                    if ($item[$userLink->link_img] !== '' && $item[$userLink->link_img] !== null) {
                                        ?>
                                        <img class="img-c" loading="lazy" srcset="
                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=100? 100w, 
                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=200? 200w, 
                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=400? 400w, 
                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=800? 800w, 
                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=1000? 1000w, 
                                    <?= getBaseUrl('storage/upload/' . $item[$userLink->link_img]) ?>?width=1200? 1200w, 
                                    " sizes="(max-width: 800px) 100vw, 50vw" decoding="async" fetchPriority="high"
                                            effect="blur" alt="">
                                        <?php
                                    } else {
                                        echo $item[$icon->icon];
                                    }
                                    ?>
                                </div>
                                <div class="text">
                                    <h2><?= $item[$userLink->link_name] ?></h2>
                                    <a href="#"><?= $item[$userLink->link_url] ?></a>
                                </div>
                                <blockquote>
                                    <p><?= $getUser[$userDetail->bio] ?></p>
                                </blockquote>
                            </div>
                        </div>
                        <!-- this Is for share to ohter media  -->
                        <div class="media-list">
                            <ul class="df-l scroll-x">
                                <li class="df-c">
                                    <a class="btn-copy curs-p">
                                        <div class="icon icon-ra icon-sm">
                                            <i class="fa-solid fa-link"></i>
                                        </div>
                                        <p>Copylink</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- this is for footer of link me form user -->
                    <div class="foot">
                        <blockquote>
                            <h2>Join VenSoeng on Linkme</h2>
                            <p>Get your own free Linkme. The only link in bio trusted by 50M+ people.</p>
                        </blockquote>
                        <div class="main-btn">
                            <a href="#" class="btn icon icon-ra icon-sm">
                                Signup for free
                            </a>
                            <a href="#" class="btn icon icon-ra icon-sm">
                                Find out more
                            </a>
                        </div>
                    </div>
                </div>
                <div class="linkme-bg"
                    onclick="document.querySelector('#form_link_list_<?= $index ?>').classList.remove('linkme-form-active')">
                </div>
            </div>
            <?php
        }
    }
    ?>
    <script>
        function hiddenForm(activeElement, formElement = '.linkme-form') {
            var form = document.querySelectorAll(formElement);
            var active = document.querySelector(activeElement);
            form.forEach((e, i) => {
                e.classList.remove('linkme-form-active');
                active.classList.add('linkme-form-active');
            })
        }
        var btnCopys = document.querySelectorAll('.btn-copy');
        btnCopys.forEach((element) =>{
            element.addEventListener('click', function() {
                const currentUrl = window.location.href;

                // Check if the clipboard API is available and the context is secure
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(currentUrl).then(function() {
                        alert("Text copied to clipboard: " + currentUrl);
                    }).catch(function(err) {
                        console.error("Could not copy text: ", err);
                    });
                } else {
                    // Fallback for older or unsupported browsers/devices
                    const tempTextArea = document.createElement('textarea');
                    tempTextArea.value = currentUrl;
                    
                    // Ensure the textarea is not visible
                    tempTextArea.style.position = 'absolute';
                    tempTextArea.style.left = '-9999px';

                    document.body.appendChild(tempTextArea);
                    tempTextArea.select();
                    tempTextArea.setSelectionRange(0, 99999); // For mobile compatibility

                    try {
                        document.execCommand('copy');
                        alert("Text copied to clipboard: " + currentUrl);
                    } catch (err) {
                        console.error("Fallback: Could not copy text: ", err);
                    }
                    document.body.removeChild(tempTextArea);
                }
            });

        })
    </script>

</body>

</html>
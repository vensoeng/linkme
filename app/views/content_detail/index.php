<?php
include 'app/config/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>content ditaildd</title>
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?=getBaseUrl('public/css/content_detail.css?v='.time())?>">
    <!-- this is box icon  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- this is font awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
    <header>
        <ul class="df-s">
            <li class="icon icon-ra icon-sm curs-p">
                <i class="bx bx-grid-alt"></i>
            </li>
            <h2>vensoeng</h2>
            <li class="icon icon-ra icon-sm curs-p over-h">
                <img class="img-c" src="storage/upload/66d9c9ce71ff0.jpg" alt="66d9b2ac7a657.png">
            </li>
        </ul>
    </header>
    <main>
        <div class="con">
            <div class="photo">
                <div class="images">
                    <img src="storage/upload/66d9c9ce71ff0.jpg" alt="">
                </div>
            </div>
            <div class="detail">
                <div class="detail-box">
                    <div class="title">
                        <h2>So I have something to tell you how are we do it like this and so how many people.</h2>
                    </div>
                    <div class="date">
                        <p>08 Sep 2024</p>
                    </div>
                    <div class="about">
                        <h2>About</h2>
                        <blockquote>
                            <p>Sorry I'm very excited to do everything like codSorry I'm very excited to do everything like codSorry I'm very excited to do everything like cod</p>
                        </blockquote>
                    </div>
                    <div class="react">
                        <ul class="df-l">
                            <li class="icon icon-ra icon-sm curs-p active">
                                <h2>All</h2>
                            </li>
                            <li class="icon icon-ra icon-sm curs-p">
                                <h2>Like</h2>
                            </li>
                            <li class="icon icon-ra icon-sm curs-p">
                            <h2>Save</h2>
                            </li>
                        </ul>
                    </div>
                    <div class="main-item">
                        <div class="box">
                            <ul>
                                <li class="df-s">
                                    <div class="user-profile df-l">
                                        <a href="#" class="profile icon icon-ra">
                                            <img class="img-c" src="http://localhost/public/images/profile.jpg" alt="">
                                        </a>
                                        <div class="text">
                                            <a href="#">
                                                <h2>VenSoeng</h2>
                                            </a>
                                            <p>@vensoeng001</p>
                                        </div>
                                    </div>
                                    <div class="btn icon icon-ra icon-sm">
                                        <i class="bx bxs-like"></i>
                                    </div>
                                </li>
                                <li class="df-s">
                                    <div class="user-profile df-l">
                                        <a href="#" class="profile icon icon-ra">
                                            <img class="img-c" src="http://localhost/public/images/profile.jpg" alt="">
                                        </a>
                                        <div class="text">
                                            <a href="#">
                                                <h2>VenSoeng</h2>
                                            </a>
                                            <p>@vensoeng001</p>
                                        </div>
                                    </div>
                                    <div class="btn icon icon-ra icon-sm">
                                        <i class="bx bxs-bookmarks"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
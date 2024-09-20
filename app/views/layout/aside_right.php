<aside class="web-asdie">
    <div class="web-asdie-body scroll-y">
        <div class="web-asdie-body-con">
            <!-- this is head  -->
            <div class="head df-s">
                <form action="/search" method="post" class="search df-l">
                    <input type="text" name="action" value="search" hidden>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                    <input type="text" name="search" placeholder="Search linkme">
                    <button class="icon icon-ra icon-sm">
                        <i class="bx bx-search"></i>
                    </button>
                </form>
                <?php
                if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                    ?>
                    <ul class="df-r">
                        <li class="text-be icon icon-ra icon-sm i-user"
                            style="--text-:'you'; --top-: 2.8rem;" onclick="location.href='/you'">
                            <?php
                            if (file_exists('storage/upload/' . $getUser[$userDetail->profile])) { ?>
                                <img class="img-c icon icon-ra over-h" loading="lazy" srcset="
                                        <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=100? 100w, 
                                        <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=200? 200w, 
                                        <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=400? 400w, 
                                        <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=800? 800w, 
                                        <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1000? 1000w, 
                                        <?= getBaseUrl('storage/upload/' . $getUser[$userDetail->profile]) ?>?width=1200? 1200w, 
                                        " sizes="(max-width: 800px) 100vw, 50vw" decoding="async"
                                    fetchPriority="high" effect="blur" alt="">
                                <?php
                            } else { ?>
                                <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                    <?= substr($getUser[$userDetail->first_name] . $getUser[$userDetail->last_name], 0, 1) ?>
                                </h2>
                            <?php }
                            ?>
                            <!-- <i class="bx bx-user"></i> -->
                        </li>
                        <form action="/post/notification" method="POST" hidden class="form-notification">
                            <input type="text" name="action" value="notification">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" hidden>
                            <button type="submit"></button>
                        </form>
                        <li class="icon icon-ra icon-sm i-bell" id="btn-notification"
                        onclick="document.querySelector('.form-notification').querySelector('button').click();"
                        >
                            <i class='bx bx-bell'></i>
                        </li>
                    </ul>
                    <?php
                } else {
                    ?>
                    <ul class="df-r">
                        <li class="icon icon-ra icon-sm i-user" onclick="location.href='/signup'">
                            <i class='bx bx-user-plus'
                                style="margin-left: 0.3rem;font-size: 1.3rem;"></i>
                        </li>
                        <li class="icon icon-ra icon-sm i-bell" onclick="location.href='/signup'">
                            <i class='bx bx-bell'></i>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </div>
            <!-- this is follow to user  -->
            <?php
            if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                $user_id = $getUser[$userDetail->user_detail_id];
                $sql = "
                    SELECT
                        u.{$user->id} AS user_id,
                        u.{$user->user_name},
                        u.{$user->verify_status},
                        d.{$userDetail->profile},
                        d.{$userDetail->first_name},
                        d.{$userDetail->user_detail_id},
                        d.{$userDetail->last_name}
                    FROM {$user->model} u
                    INNER JOIN {$userDetail->model} d
                        ON u.{$user->id} = d.{$userDetail->user_detail_id}
                    LEFT JOIN {$follower->model} f
                        ON (f.{$follower->user_sand_follower_id} = u.{$user->id} AND f.{$follower->user_follower_id} = '$user_id')
                        OR (f.{$follower->user_follower_id} = u.{$user->id} AND f.{$follower->user_sand_follower_id} = '$user_id')
                    WHERE f.{$follower->user_sand_follower_id} IS NULL
                        AND f.{$follower->user_follower_id} IS NULL
                        AND u.{$user->id} != '$user_id'
                    ORDER BY RAND()
                    LIMIT 4
                ";
                $result = $conn->query($sql);

            } else {
                $sql = "SELECT
                        u.{$user->id} AS user_id,
                        u.{$user->verify_status},
                        u.{$user->user_name},
                        d.{$userDetail->profile},
                        d.{$userDetail->first_name},
                        d.{$userDetail->last_name},
                        d.{$userDetail->user_detail_id}
                        FROM {$user->model} u
                        INNER JOIN {$userDetail->model} d
                            ON u.{$user->id} = d.{$userDetail->user_detail_id}
                        ORDER BY RAND()
                        LIMIT 4";
                $result = $conn->query($sql);
            }
                ?>
                <div class="follow">
                    <div class="follow-body">
                        <div class="item-head df-s">
                            <h2>Follow to everyone</h2>
                            <a href="/seemore/user" class="btn icon icon-ra">
                                See all
                            </a>
                        </div>
                        <ul>
                            <?php 
                            if ($result && mysqli_num_rows($result) > 0) {
                                foreach ($result as $index => $item) {
                                    ?>
                                    <li class="df-s">
                                        <div class="user-profile df-l">
                                            <a href="/user/<?= $item[$user->user_name] ?>"
                                                class="profile icon icon-ra">
                                                <?php
                                                if (file_exists('storage/upload/' . $item[$userDetail->profile])) { ?>
                                                    <img class="img-c" loading="lazy" srcset="
                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=100? 100w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=200? 200w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=400? 400w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=800? 800w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                    " sizes="(max-width: 800px) 100vw, 50vw"
                                                        decoding="async" fetchPriority="high" effect="blur" alt="">
                                                    <?php
                                                } else { ?>
                                                    <h2 class="notfound"
                                                        style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                        <?= substr($item[$userDetail->first_name] . $item[$userDetail->last_name], 0, 1) ?>
                                                    </h2>
                                                <?php }
                                                ?>
                                            </a>
                                            <div class="text">
                                                <a href="<?= getBaseUrl('user/' . $item[$user->user_name]) ?>">
                                                    <h2 style="width: max-content; max-width:100%;"
                                                        class="<?= $item[$user->verify_status] == 1 ? 'ui-name text-be' : '' ?>">
                                                        <span><?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?></span>
                                                    </h2>
                                                </a>
                                                <p>@<?= $item[$user->user_name] ?></p>
                                            </div>
                                        </div>
                                        <?php if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) { ?>
                                            <form action="/post/follower" method="POST" data-name="addfollow"
                                                class="form-add-follow">
                                                <input type="hidden" name="csrf_token"
                                                    value="<?= $_SESSION['csrf_token']; ?>" hidden>
                                                <input type="text" class="txt-action" name="action"
                                                    value="addfollow" hidden>
                                                <input type="number" name="<?= $user->id ?>"
                                                    value="<?= $item[$userDetail->user_detail_id] ?>" hidden>
                                                <button class="bg-n" type="submit"
                                                    class="btn icon-ra icon">Follow</button>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <form action="/login" method="post" style="--text--:'Follow';">
                                                <button class="bg-n btn icon-ra icon">Follow</button>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                            }else{
                                ?>
                                    <div class="nores">
                                        <div class="nores-body">
                                            <div class="icon icon-ra">
                                                <i class='bx bxs-hourglass-bottom'></i>
                                            </div>
                                            <blockquote>
                                                <h2>No result</h2>
                                                <p>We couldn't retrieve any followers for this user. Please try again later or check the user's follower list.</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <!-- .this is for user save  -->
            <div class="save">
                <div class="save-body">
                    <div class="item-head df-s">
                        <h2>Foryou</h2>
                        <a href="/seemore/foryou" class="btn icon icon-ra">
                            See all
                        </a>
                    </div>
                    <ul>
                        <?php
                        $foryou = [];
                        if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                            $sql = "
                                    SELECT
                                        c.{$content->id} AS post_id,
                                        c.{$content->post_img},
                                        r.*,
                                        (SELECT COUNT(*) FROM {$reacte->model} r1 WHERE r1.{$reacte->post_id} = c.{$content->id} AND r1.{$reacte->reate_type} = 1) AS reacte_link,
                                        (SELECT COUNT(*) FROM {$reacte->model} r2 WHERE r2.{$reacte->post_id} = c.{$content->id} AND r2.{$reacte->reate_type} = 2) AS reacte_save
                                    FROM {$content->model} c
                                    LEFT JOIN {$reacte->model} r ON r.{$reacte->post_id} = c.{$content->id}
                                    WHERE (c.{$content->post_img} != '' AND c.{$content->post_img} IS NOT NULL)
                                    AND c.{$content->post_status} = 1
                                    ORDER BY GREATEST(
                                        (SELECT COUNT(*) FROM {$reacte->model} r1 WHERE r1.{$reacte->post_id} = c.{$content->id} AND r1.{$reacte->reate_type} = 1),
                                        (SELECT COUNT(*) FROM {$reacte->model} r2 WHERE r2.{$reacte->post_id} = c.{$content->id} AND r2.{$reacte->reate_type} = 2)
                                    ) DESC
                                    LIMIT 4
                                ";
                            $foryou = $conn->query($sql);
                        }
                        if ($foryou && mysqli_num_rows($foryou) > 2) {
                            foreach ($foryou as $index => $item) {
                                ?>
                                <a href="#">
                                    <li>
                                        <img class="img-c"
                                            src="<?= getBaseUrl('storage/upload/' . $item[$content->post_img]) ?>"
                                            alt="">
                                    </li>
                                </a>
                                <?php
                            }
                        } else {
                            ?>
                            <a href="#">
                                <li>
                                    <div class="u df-c">
                                    </div>
                                    <img class="img-c"
                                        src="<?= getBaseUrl('public/images/save_for_user (1).jpg') ?>"
                                        alt="">
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <img class="img-c"
                                        src="<?= getBaseUrl('public/images/save_for_user (3).jpg') ?>"
                                        alt="">
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <img class="img-c"
                                        src="<?= getBaseUrl('public/images/save_for_user (4).jpg') ?>"
                                        alt="">
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <img class="img-c"
                                        src="<?= getBaseUrl('public/images/save_for_user (2).jpg') ?>"
                                        alt="">
                                </li>
                            </a>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- this is user activity  -->
            <?php
            if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                ?>
                <div class="activity">
                    <div class="activity-body">
                        <div class="item-head df-s">
                            <h2>Last Activity</h2>
                            <a href="/seemore/history" class="btn icon icon-ra">
                                See all
                            </a>
                        </div>
                        <ul>
                            <?php
                            $user_id = $getUser[$userDetail->user_detail_id];

                            $sql = "
                                    SELECT
                                        r.{$reacte->id} AS reacte_id,
                                        d.{$userDetail->profile},
                                        d.{$userDetail->first_name},
                                        d.{$userDetail->last_name},
                                        c.{$content->created_at} AS content_created_at,
                                        r.*,
                                        c.*
                                    FROM {$reacte->model} r
                                    INNER JOIN {$content->model} c
                                        ON r.{$reacte->post_id} = c.{$content->id}
                                    INNER JOIN {$userDetail->model} d
                                        ON r.{$reacte->user_reacte_id} = d.{$userDetail->user_detail_id}
                                    WHERE r.{$reacte->reacte_status} = 0
                                    AND r.{$reacte->user_post_id} = '$user_id'
                                ";
                            $getReacte = $conn->query($sql);
                            if ($getReacte && mysqli_num_rows($getReacte) > 0) {
                                ?>
                                <script type="text/javascript">
                                    var notificationElement = document.querySelector('.web-asdie .head ul li:last-child.i-bell');
                                    var notificationEHead = document.querySelector('.web-header ul:last-child li .i-bell');
                                    var title = document.querySelector('title');
                                    var textTitle = title.innerText;
                                    title.innerText = textTitle + " - (<?= mysqli_num_rows($getReacte) ?>)";
                                    notificationElement.setAttribute('style', "--text--:'<?= mysqli_num_rows($getReacte) ?>';");
                                    notificationEHead.setAttribute('style', "--text--:'<?= mysqli_num_rows($getReacte) ?>';");
                                </script>
                                <?php
                            } else {
                                $user_id = $getUser[$userDetail->user_detail_id];

                                $sql = "
                                        SELECT
                                            r.{$reacte->id} AS reacte_id,
                                            d.{$userDetail->profile},
                                            d.{$userDetail->first_name},
                                            d.{$userDetail->last_name},
                                            c.{$content->created_at} AS content_created_at,
                                            r.*,
                                            c.*
                                        FROM {$reacte->model} r
                                        INNER JOIN {$content->model} c
                                            ON r.{$reacte->post_id} = c.{$content->id}
                                        INNER JOIN {$userDetail->model} d
                                            ON r.{$reacte->user_reacte_id} = d.{$userDetail->user_detail_id}
                                        WHERE r.{$reacte->user_post_id} = '$user_id'
                                        ORDER BY r.{$reacte->id} DESC LIMIT 10
                                    ";
                                $getReacte = $conn->query($sql);
                            }
                            if($getReacte && mysqli_num_rows($getReacte) > 0){
                                foreach ($getReacte as $index => $item) {
                                    ?>
                                        <a href="#" class="db-c">
                                            <li class="df-l">
                                            <div class="user-box">
                                                    <div class="profile icon icon-ra icon-sm">
                                                    <?php
                                                        if (file_exists('storage/upload/' . $item[$userDetail->profile])) { ?>
                                                            <img class="img-c over-h icon-ra" loading="lazy" srcset="
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=100? 100w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=200? 200w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=400? 400w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=800? 800w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1000? 1000w, 
                                                                    <?= getBaseUrl('storage/upload/' . $item[$userDetail->profile]) ?>?width=1200? 1200w, 
                                                                    " sizes="(max-width: 800px) 100vw, 50vw" decoding="async"
                                                                fetchPriority="high" effect="blur" alt="">
                                                            <?php
                                                        } else { ?>
                                                            <h2 class="notfound" style="color: var(--sg-main-bg);font-size: 1.3rem">
                                                                <?= substr($item[$userDetail->first_name] . $item[$userDetail->last_name], 0, 1) ?>
                                                            </h2>
                                                        <?php }
                                                    ?>
                                                     <?= $item[$reacte->reate_type] == 1 ? "<i class='bx bxs-like'></i>" : "<i class='bx bxs-bookmark'></i>" ?>
                                                    </div>
                                                </div>
                                                <div class="txt">
                                                    <h2><?= $item[$userDetail->first_name] . $item[$userDetail->last_name] ?> <span><?= $item[$reacte->reate_type] == 1 ? "like your post." : " save your post." ?></span></h2>
                                                    <p class="des"><?= $item[$content->post_des] ?></p>
                                                    <p><?= convertDate($item['content_created_at'], '', true) ?></p>
                                                </div>
                                            </li>
                                        </a>
                                    <?php
                                }
                            }else{
                                ?>
                                    <div class="nores">
                                        <div class="nores-body">
                                            <div class="icon icon-ra">
                                                <i class='bx bxs-hourglass-bottom'></i>
                                            </div>
                                            <blockquote>
                                                <h2>No result</h2>
                                                <p>No results found. Please check your input and try again with different terms.</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>
                            <!-- <li>
                                <a href="#" class="df-l">
                                    <i class='bx bxs-like'></i>
                                    <p><span>kimsan</span> Like your photo.</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="df-l">
                                    <i class='bx bx-bookmark'></i>
                                    <p><span>kimsan</span> Save your photo.</p>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</aside>
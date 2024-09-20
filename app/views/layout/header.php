<header class="web-header">
    <div class="web-head-body df-s">
        <ul class="web-logo df-l">
            <li class="logo df-l">
                <h1>Linkme</h1>
            </li>
        </ul>
        <ul class="list-icon df-r">
            <?php
            if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                ?>
                <li>
                    <div class="i-like icon icon-ra icon-sm curs-p"
                        onclick="location.href='<?= getBaseUrl('me/' . $getUser[$user->user_name]) ?>'">
                        <i class='bx bx-link-alt'></i>
                    </div>
                </li>
                <li>
                    <div class="i-bell i-bell-active icon icon-ra icon-sm curs-p curs-p" onclick="
                    toggleClass('.web-asdie','web-asdie-notification-active','web-asdie-search-active');
                    handleScreenWidth('/feature/notification');
                    ">
                        <i class="bx bx-bell"></i>
                    </div>
                </li>
                <?php
            } else {
                ?>
                <li>
                    <div class="i-like icon icon-ra icon-sm curs-p"
                        onclick="location.href='<?= getBaseUrl('login') ?>'">
                        <i class='bx bx-link-alt'></i>
                    </div>
                </li>
                <li>
                    <div class="i-bell i-bell-active icon icon-ra icon-sm curs-p curs-p"
                        onclick="location.href='<?= getBaseUrl('login') ?>'">
                        <i class="bx bx-bell"></i>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</header>
<!-- this is fix header  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let lastScrollTop = 0;
        const header = document.querySelector('.web-header');
        window.addEventListener('scroll', function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                header.classList.add('web-header-remove');
            } else {
                // User is scrolling up, show the header
                header.classList.remove('web-header-remove');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
        });
    });
</script>
<!-- this is form for alert  -->
<div class="form-alert">
    <div class="form-alert-body">
        <div class="box">
            <div class="head df-s">
                <div class="icon icon-ra icon-sm">
                    <img class="img-c" src="<?= getBaseUrl('') ?>public/images/favicon.png" alt="">
                </div>
                <a class="btn icon icon-ra icon-sm curs-p"
                    onclick="document.querySelector('.form-alert').classList.remove('form-alert-active')">
                    ok
                </a>
            </div>
            <blockquote>
                <p></p>
            </blockquote>
        </div>
    </div>
    <div class="form-alert-bg"></div>
</div>
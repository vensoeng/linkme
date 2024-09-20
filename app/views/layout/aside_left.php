<aside class="web-tablink">
    <div class="web-tablink-body">
        <div class="head df-c">
            <div class="icon icon-ra icon-sm">
                <!-- <i class='bx bx-link'></i> -->
                <h1>Linkme</h1>
            </div>
        </div>
        <div class="con df-c">
            <ul>
                <?php
                if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                    ?>
                    <li class="i-user" onclick="location.href='/you'">
                        <div class="icon icon-ra icon-sm">
                            <i class='bx bx-user'></i>
                        </div>
                        <p>You</p>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="i-logout" onclick="location.href='/signup'">
                        <div class="icon icon-ra icon-sm">
                            <i class="bx bx-user-plus" style="margin-left: 0.3rem;font-size: 1.3rem;"></i>
                        </div>
                        <p>Foryou</p>
                    </li>
                    <?php
                }
                ?>
                <?php
                if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                    ?>
                    <li class="i-bell btn-noti"
                        onclick="toggleClass('.web-asdie','web-asdie-notification-active','web-asdie-search-active');
                        handleScreenWidth('/feature/notification')"
                        >
                        <div class="icon icon-ra icon-sm">
                            <i class="bx bx-bell"></i>
                        </div>
                        <p>Notification</p>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="i-bell" onclick="location.href='/signup'">
                        <div class="icon icon-ra icon-sm">
                            <i class="bx bx-bell"></i>
                        </div>
                        <p>Notification</p>
                    </li>
                    <?php
                }
                ?>
                <li class="i-app <?=urlRequest(getBaseUrl('')) == getBaseUrl('') ? 'i-active' : ''?> btn-home" onclick="
                toggleClass('.web-asdie','k','web-asdie-search-active')
                toggleClass('.web-asdie','k','web-asdie-notification-active');
                handleScreenWidth('/');
                ">
                    <div class="icon icon-ra icon-sm">
                        <i class='bx bx-grid-alt'></i>
                    </div>
                    <p>App</p>
                </li>
                <li class="i-search btn-search <?=urlRequest(getBaseUrl('feature/notification')) == getBaseUrl('feature/notification') ? 'i-active' : '' ?>  <?=urlRequest(getBaseUrl('feature/search')) == getBaseUrl('feature/search') ? 'i-active' : ''?>" 
                onclick="
                toggleClass('.web-asdie','web-asdie-search-active','web-asdie-notification-active');
                handleScreenWidth('/feature/search');
                ">
                    <div class="icon icon-ra icon-sm">
                        <i class='bx bx-search-alt'></i>
                    </div>
                    <p>Search</p>
                </li>
                <?php
                if (isset($_SESSION[$user->email]) && isset($_SESSION[$user->password])) {
                    ?>
                    <li class="i-logout" onclick="location.href='/logout'">
                        <div class="icon icon-ra icon-sm">
                            <i class='bx bx-log-out'></i>
                        </div>
                        <p>Logout</p>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="i-logout" onclick="location.href='/signup'">
                        <div class="icon icon-ra icon-sm">
                            <i class='bx bx-log-out'></i>
                        </div>
                        <p>Logout</p>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</aside>

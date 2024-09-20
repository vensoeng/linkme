<?php

$routes = [
    '/' => 'app/views/welcome.php',
    '/feature/{item}' => 'app/views/feature/index.php',
    '/seemore/{item}' => 'app/views/seemore/index.php',
    '/search' => 'app/views/search/index.php',
    '/detail' => 'app/views/content_detail/index.php',
    '/login' => 'app/views/login/index.php',
    '/login/store' => 'app/controller/login.php',
    '/logout' => 'app/controller/logout.php',
    '/signup' => 'app/views/signup/index.php',
    '/signup/detail' => 'app/views/singup_detail/index.php',
    '/signup/store' => 'app/controller/signup.php',
    '/signup/detail/link' => 'app/views/signup_link/index.php',
    '/signup/detail/link/store' => 'app/controller/user_link.php',
    '/signup/finish' => 'app/views/signup_finish/index.php',
    '/edit/profile' => 'app/controller/edit_profile.php',
    '/edit/link' => 'app/controller/edit_link.php',
    '/post/content' => 'app/controller/content.php',
    '/post/follower' => 'app/controller/follow.php',
    '/post/reacte' => 'app/controller/reacte.php',
    '/post/notification' => 'app/controller/notification.php',
    '/you' => 'app/views/you/index.php',
    '/user/{item}' => 'app/views/user/index.php',
    '/me/{item}' => 'app/views/linkme/index.php',
    '/db' => 'database/migration/index.php',//this Is access to database
];


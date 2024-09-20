<?php 

function webIcon($patch = 'public/images/',$image_name = 'public/images/og.jpg',$name = 'Linkme platform'){
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= getBaseUrl('public/images/favicon.png') ?>" type="image/png" sizes="307x307">
    <link rel="icon" href="<?= getBaseUrl('public/images/favicon.png') ?>" type="image/png" sizes="307x307">
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Linkme"/>
    <meta property="og:description" content="Welcome to LinkMe, your go-to platform for web development and mobile app projects. Hello! I'm VenSoeng, a passionate and dedicated developer. Explore my work at http://linkme.free.nf/"/>
    <meta property="og:url" content="http://linkme.free.nf/"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="km_KH"/>
    <meta property="og:site_name" content="<?=$name?>"/>
    <!-- Image Tags -->
    <meta property="og:image" content="<?= getBaseUrl($patch.$image_name) ?>"/>
    <meta property="og:image:secure_url" content="<?= getBaseUrl($patch.$image_name) ?>"/>
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="515"/>
    <meta property="og:image:type" content="image/jpg"/>
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="<?=$name?>"/>
    <meta name="twitter:description" content="Welcome to LinkMe, your go-to platform for web development and mobile app projects. Hello! I'm VenSoeng, a passionate and dedicated developer. Explore my work at http://linkme.free.nf/"/>
    <meta name="twitter:image" content="<?= getBaseUrl($patch.$image_name) ?>"/>
    <!-- Canonical Link -->
    <link rel="canonical" href="http://linkme.free.nf/"/>
    <!-- Other Meta Tags -->
    <meta property="profile:username" content="<?=$name?>"/>
    <meta name="msapplication-TileImage" content="<?= getBaseUrl($patch.$image_name) ?>"/>
    <!-- Conditional Image Handling for Blogger -->
    <meta property="og:image" content="<?= getBaseUrl($patch.$image_name) ?>"/>
    <?php
}

?>
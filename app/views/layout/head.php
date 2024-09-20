<?php
include 'app/views/layout/web_icon.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkme</title>
    <?=webIcon()?>
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/post.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/home.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getBaseUrl('') ?>public/css/form.css?v=<?= time() ?>">
    <!-- this is box icon  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- this is font awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
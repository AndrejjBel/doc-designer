<?php
$home_url = home_url();
?>
<!DOCTYPE html>
<html lang="ru-RU" data-menu-color="dark">

<head>
    <meta charset="utf-8" />
    <title><?php echo $data['title'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $data['description'];?>">
    <meta name="csrf_tocken" content="<?= csrf_token() ?>">

    <link rel="icon" href="<?php echo $home_url;?>/public/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $home_url;?>/public/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $home_url;?>/public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $home_url;?>/public/images/favicon/favicon-16x16.png">

    <script src="<?php echo $home_url;?>/public/js/admin/config.min.js"></script>
    <script src="<?php echo $home_url;?>/public/js/admin/vendor.min.js"></script>

    <?php if (in_array($data['temp'], ['glamping-add', 'glamping-edit', 'post-add', 'post-edit', 'review-add', 'review-edit'])) { ?>
        <link href="<?php echo $home_url;?>/public/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $home_url;?>/public/vendor/select2/js/select2.min.js" defer></script>

        <link href="<?php echo $home_url;?>/public/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $home_url;?>/public/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js" defer></script>

        <link href="<?php echo $home_url;?>/public/vendor/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $home_url;?>/public/vendor/flatpickr/flatpickr.min.js" defer></script>

        <link href="<?php echo $home_url;?>/public/css/admin/quill.snow.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $home_url;?>/public/js/admin/quill-new.min.js" defer></script>
    <?php } ?>

    <link href="<?php echo $home_url;?>/public/css/admin/app.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="<?php echo $home_url;?>/public/css/admin/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $home_url;?>/public/css/admin/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/admin/main.css' );?>" rel="stylesheet" type="text/css" />

    <script src="<?php echo $home_url;?>/public/js/admin/app.min.js" defer></script>

    <script src="<?php echo $home_url;?>/public/js/sortable/sortable.js" defer></script>
    <script src="<?php echo $home_url;?>/public/js/admin/admin.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/admin/admin.js' );?>" defer></script>
</head>

<body>

    <div id="preloader" style="opacity: -0.1; display: none;">
        <div id="status" style="opacity: -0.1; display: none;">
            <div class="bouncing-loader"><div></div><div></div><div></div></div>
        </div>
    </div>

    <div class="wrapper">

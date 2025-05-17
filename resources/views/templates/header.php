<?php
$home_url = home_url();
?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="shortcut icon" href="https://traveling-best.ru/wp-content/themes/traveling-best/src/img/favicon.ico" type="image/x-icon">
	<link rel="icon" sizes="16x16" href="https://traveling-best.ru/wp-content/themes/traveling-best/src/img/logo16.png" type="image/png">
    <link rel="icon" sizes="32x32" href="https://traveling-best.ru/wp-content/themes/traveling-best/src/img/logo32.png" type="image/png">

    <meta name='robots' content='noindex, nofollow' />
    <!-- <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' /> -->

    <!-- SEO -->
    <?php echo seo_pages_render($data['mod'], $data['cur_page'], $data['pagesCount']);?>
    <!-- SEO end-->

    <!-- Css -->
    <link href="<?php echo $home_url;?>/public/assets/libs/tiny-slider/tiny-slider.css" rel="stylesheet">
    <link href="<?php echo $home_url;?>/public/assets/libs/js-datepicker/datepicker.min.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="<?php echo $home_url;?>/public/assets/css/bootstrap-green.min.css" id="bootstrap-style" class="theme-opt" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="<?php echo $home_url;?>/public/assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $home_url;?>/public/assets/libs/@iconscout/unicons/css/line.css" type="text/css" rel="stylesheet">
    <!-- Style Css-->
    <link href="<?php echo $home_url;?>/public/assets/css/style-green.min.css" id="color-opt" class="theme-opt" rel="stylesheet" type="text/css">

    <link href="<?php echo $home_url;?>/public/dist/main.min.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/dist/main.min.css' );?>" rel="stylesheet" type="text/css">

    <link href="<?php echo $home_url;?>/public/css/front/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/front/main.css' );?>" rel="stylesheet" type="text/css">

    <!-- JAVASCRIPT -->
    <script src="<?php echo $home_url;?>/public/assets/libs/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <!-- Lightbox -->
    <!-- <script src="../public/assets/libs/shufflejs/shuffle.min.js" defer></script> -->
    <!-- <script src="../public/assets/libs/tobii/js/tobii.min.js" defer></script> -->
    <script src="<?php echo $home_url;?>/public/assets/libs/tiny-slider/min/tiny-slider.js"></script>
    <script src="<?php echo $home_url;?>/public/assets/libs/js-datepicker/datepicker.min.js"></script>
    <!-- Main Js -->
    <script src="<?php echo $home_url;?>/public/assets/libs/feather-icons/feather.min.js" defer></script>
    <script src="<?php echo $home_url;?>/public/assets/js/plugins.init.js" defer></script>
    <script src="<?php echo $home_url;?>/public/assets/js/app.js" defer></script>

    <!-- <script src="../public/js/cookie/cookie.min.js" defer></script> -->
    <script src="<?php echo $home_url;?>/public/js/front/main.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/front/main.js' );?>" defer></script>

    <script id="js-before">const scriptJson = <?php echo (array_key_exists('scriptJson', $data))? $data['scriptJson'] : '[{}]';?></script>

</head>
<body class="<?php echo (array_key_exists('body_classes', $data))? $data['body_classes'] : '';?>" data-theme="light">
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Loader -->

    <?php if (array_key_exists('temp_header', $data)) {
        insertTemplate('/templates/' . $data['temp_header'], ['data' => $data]);
    } ?>

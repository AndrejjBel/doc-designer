<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo seo_meta($data, 'title');?></title>
    <meta name="description" content="<?php echo seo_meta($data, 'description');?>" />

    <!-- favicon -->
    <link rel="icon" href="../public/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/images/favicon/favicon-16x16.png">
    <?php echo scripts_styles_render($data['script_rend']);?>

    <!-- Css -->
    <link href="../public/assets/css/bootstrap.min.css" id="bootstrap-style" class="theme-opt" rel="stylesheet" type="text/css">
    <link href="../public/assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
    <link href="../public/assets/libs/@iconscout/unicons/css/line.css" type="text/css" rel="stylesheet">
    <link href="../public/assets/css/style.min.css" id="color-opt" class="theme-opt" rel="stylesheet" type="text/css">

    <link href="../public/css/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/main.css' );?>" rel="stylesheet" type="text/css">
    <link href="../public/css/front/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/front/main.css' );?>" rel="stylesheet" type="text/css">

    <!-- Javascript -->
    <script src="../public/assets/libs/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script src="../public/assets/libs/feather-icons/feather.min.js" defer></script>
    <script src="../public/assets/js/plugins.init.js" defer></script>
    <script src="../public/assets/js/app.js" defer></script>
    <script src="../public/js/main.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/main.js' );?>" defer></script>
    <?php echo custom_styles();?>

</head>
<body class="<?php echo (array_key_exists('body_classes', $data))? $data['body_classes'] : '';?>">

    <?php if (array_key_exists('temp_header', $data)) {
        insertTemplate('/templates/' . $data['temp_header'], ['data' => $data]);
    } ?>

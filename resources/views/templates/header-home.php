<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo seo_meta($data, 'title');?></title>
    <meta name="description" content="<?php echo seo_meta($data, 'description');?>" />

    <!-- favicon -->
    <link rel="icon" href="../public/images/favicon/favicon.ico?v=2" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/images/favicon/apple-touch-icon.png?v=2" type="image/png">
    <link rel="icon" sizes="32x32" href="../public/images/favicon/favicon-32x32.png?v=2" type="image/png">
    <link rel="icon" sizes="16x16" href="../public/images/favicon/favicon-16x16.png?v=2" type="image/png">
    <link rel="shortcut icon" sizes="16x16" href="../public/images/favicon/favicon-16x16.png?v=2" type="image/png">
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
    <?php if (request_host() == 'yurist-dok.online') { ?>
    <meta name="yandex-verification" content="7b6f7d1a5a989856" />
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=104843804', 'ym');

        ym(104843804, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
    </script>
    <!-- /Yandex.Metrika counter -->
    <?php } ?>

</head>
<body class="<?php echo (array_key_exists('body_classes', $data))? $data['body_classes'] : '';?>">

    <?php if (array_key_exists('temp_header', $data)) {
        insertTemplate('/templates/' . $data['temp_header'], ['data' => $data]);
    } ?>

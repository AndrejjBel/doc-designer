<?php
$home_url = config('main', 'home_url');
$meta_robots = '';
// $site_settings = json_decode(site_settings('site_settings'));
// if ($site_settings) {
//     if (isset($site_settings->maintenance)) {
//         $meta_robots = "<meta name='robots' content='noindex, nofollow' />" . PHP_EOL;
//     } else {
//         $meta_robots = "<meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />" . PHP_EOL;
//     }
// }
?>
<!DOCTYPE html>
<html lang="ru-RU">

<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <?php //echo $meta_robots;?>

    <title><?php echo $data['title'];?></title>
    <meta name="description" content="<?php echo $data['description'];?>">
    <meta name="csrf_tocken" content="<?= csrf_token() ?>">

    <link rel="icon" href="<?php echo $home_url;?>/public/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $home_url;?>/public/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $home_url;?>/public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $home_url;?>/public/images/favicon/favicon-16x16.png">

    <script type="text/javascript">
        var varsAll = '';
        var varsYes = '';
    </script>

    <script src="<?php echo $home_url;?>/public/js/admin/config.min.js"></script>

    <?php if (in_array($data['temp'], ['product-add', 'product-edit'])) { ?>
        <link href="<?php echo $home_url;?>/public/css/admin/quill.snow.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $home_url;?>/public/js/admin/quill-new.min.js"></script>
    <?php } ?>

    <link href="<?php echo $home_url;?>/public/css/admin/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="<?php echo $home_url;?>/public/css/admin/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $home_url;?>/public/css/admin/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/admin/main.css' );?>" rel="stylesheet" type="text/css" />

    <script src="<?php echo $home_url;?>/public/js/admin/vendor.min.js"></script>
    <script src="<?php echo $home_url;?>/public/js/admin/app.min.js" defer></script>

    <script src="<?php echo $home_url;?>/public/js/clipboard/clipboard.js" defer></script>
    <script src="<?php echo $home_url;?>/public/js/sortable/sortable.js" defer></script>
    <script src="<?php echo $home_url;?>/public/js/cookie/cookie.min.js" defer></script>
    <script src="<?php echo $home_url;?>/public/js/admin/admin.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/admin/admin.js' );?>" defer></script>
    <script src="<?php echo $home_url;?>/public/js/admin/admin-page.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/admin/admin-page.js' );?>" defer></script>
</head>

<body>
    <div class="wrapper">

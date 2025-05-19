<?php
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

    <link rel="icon" href="../public/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/images/favicon/favicon-16x16.png">

    <script src="../public/js/admin/config.min.js"></script>

    <?php if (in_array($data['temp'], ['product-add', 'product-edit'])) { ?>
        <link href="../public/css/admin/quill.snow.css" rel="stylesheet" type="text/css" />
        <script src="../public/js/admin/quill-new.min.js"></script>
    <?php } ?>

    <link href="../public/css/admin/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="../public/css/admin/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../public/css/admin/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/admin/main.css' );?>" rel="stylesheet" type="text/css" />

    <script src="../public/js/admin/vendor.min.js"></script>
    <script src="../public/js/admin/app.min.js" defer></script>

    <script src="../public/js/sortable/sortable.js" defer></script>
    <script src="../public/js/admin/admin.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/admin/admin.js' );?>" defer></script>
</head>

<body>
    <div class="wrapper">

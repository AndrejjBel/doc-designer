<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta content="<?php echo $data['description'];?>" name="description" />
    <title><?php echo $data['title'];?></title>

    <link rel="shortcut icon" href="../public/images/favicon.ico">

    <script src="../public/js/admin/config.js"></script>

    <link href="../public/css/admin/app.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="../public/css/admin/icons.min.css" rel="stylesheet" type="text/css" />

    <link href="../public/css/admin/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/admin/main.css' );?>" rel="stylesheet">
    <script type="text/javascript">var tlgApiObj</script>

</head>
<body class="<?php echo (array_key_exists('body_classes', $data))? $data['body_classes'] : '';?>">
    <?php if (array_key_exists('temp_header', $data)) {
        insertTemplate('/templates/' . $data['temp_header'], ['data' => $data]);
    } ?>

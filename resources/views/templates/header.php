<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta content="<?php echo $data['description'];?>" name="description" />
    <title><?php echo $data['title'];?></title>

    <!-- favicon -->
    <link rel="icon" href="../public/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="../public/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/images/favicon/favicon-16x16.png">
    <?php echo scripts_styles_render($data['script_rend']);?>

    <!-- Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="../public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/admin/quill.snow.css" rel="stylesheet" type="text/css" />

    <link href="../public/css/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/main.css' );?>" rel="stylesheet" type="text/css">
    <link href="../public/css/front/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/front/main.css' );?>" rel="stylesheet" type="text/css">

    <!-- JAVASCRIPT -->
    <script src="../public/assets/js/color-modes.js" defer></script>
    <script src="../public/assets/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="../public/js/main.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/main.js' );?>" defer></script>

</head>
<body class="<?php echo (array_key_exists('body_classes', $data))? $data['body_classes'] : '';?>">

    <div class="dropdown position-fixed end-0 mt-3 me-3 bd-mode-toggle my-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
        id="bd-theme"
        type="button"
        aria-expanded="false"
        data-bs-toggle="dropdown"
        aria-label="Toggle theme (auto)">
        <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
        </ul>
    </div>

    <?php if (array_key_exists('temp_header', $data)) {
        insertTemplate('/templates/' . $data['temp_header'], ['data' => $data]);
    } ?>

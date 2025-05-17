<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta content="<?php echo $data['description'];?>" name="description" />
    <title><?php echo $title;?></title>

    <link rel="shortcut icon" href="../public/assets-adm/images/favicon.ico">

    <script src="../public/assets-adm/js/config.js"></script>

    <link href="../public/assets-adm/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="../public/css/main.css?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/css/main.css' );?>" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script> -->
    <script type="text/javascript">var tlgApiObj</script>
    <!-- <script src="../public/js/main.js?ver=<?php echo filemtime( HLEB_GLOBAL_DIR . '/public/js/main.js' );?>" defer></script> -->
    <?php //if ($title == 'Admin') { ?>
        <!-- <script src="../public/js/update-meta.js?ver=<?php //echo filemtime( MY_DIR . '/assets/update-meta.js' );?>" defer></script> -->
    <?php //} ?>

</head>
<body>
    <?php if ($mod !== 'auth') { ?>
        <header>
            <nav class="navbar bg-body-tertiary">
                <div class="container">
                    <div class="navbar-brand">
                        Logo
                        <!-- <img src="../public/imgages/logo.jpg" alt="Logo" width="auto" height="30" class="d-inline-block align-text-top"> -->
                    </div>

                    <?php if (is_login()) { ?>
                        <div class="navbar-logout-btn d-flex align-items-center justify-content-center">
                            <div class="navbar-logout-btn__navbar-username me-2">
                                <h6 class="mb-0"><?php echo userData('name');?></h6>
                            </div>
                            <form action="/logout" method="post" accept-charset="utf-8">
                                <input type="hidden" name="actions" value="logOut">
                                <button type="submit" class="btn btn-outline-primary">Выйти</button>
                            </form>
                        </div>
                    <?php } else { ?>
                        <a href="/login" class="btn btn-outline-primary">Войти</a>
                    <?php } ?>
                </div>
            </nav>
        </header>
    <?php } ?>

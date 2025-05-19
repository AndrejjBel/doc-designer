<?php
insertTemplate('/templates/header-auth', ['data' => $data]);
$form_warning = '';
$form_warning_disp = ' d-none';
$form_warning_type = ' alert-success';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'error') {
        $form_warning = 'Пароли не совпадают';
        $form_warning_disp = '';
    }
}
if (isset($data['success'])) {
    if ($data['success'] == 'new_password') {
        $form_warning = 'Новый пароль';
        $form_warning_disp = '';
        $form_warning_type = ' alert-success';
    } elseif ($data['success'] == 'password_changed') {
        $form_warning = 'Пароль успешно изменен';
        $form_warning_disp = '';
        $form_warning_type = ' alert-success';
    } else {
        $form_warning = $data['success'];
        $form_warning_disp = '';
        $form_warning_type = ' alert-success';
    }
}
$selector_v = '';
$token_v = '';
if (isset($_GET['selector'])) {
    $selector_v = $_GET['selector'];
}
if (isset($_GET['token'])) {
    $token_v = $_GET['token'];
}
if (isset($data['selector'])) {
    $selector_v = $data['selector'];
}
if (isset($data['token'])) {
    $token_v = $data['token'];
}
if (isset($data['warning'])) {
    $form_warning = $data['warning'];
    $form_warning_disp = '';
    $form_warning_type = ' alert-danger';
}

if (isset($data['success'])) {
    if ($data['success'] == 'new_password') {
        ?>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-lg-5">
                        <div class="reg">
                            <div class="card bg-transparent mb-0">
                                <!-- Logo-->
                                <div class="auth-brand">
                                    <a href="/" class="logo-light d-flex gap-2 align-items-center">
                                        <img src="../public/images/logo-txtgen1.png" alt="logo" height="22">
                                        <span class="fs-4">TxtGen</span>
                                    </a>
                                </div>

                                <div class="card-body p-4">

                                    <div class="w-75">
                                        <h4 class="text-dark-50 mt-0 fw-bold">Новый пароль</h4>
                                        <!-- <p class="text-muted mb-4">Нет аккаунта? Создайте аккаунт, это займет меньше минуты</p> -->
                                    </div>

                                    <!-- <div id="waybill-update-message" class="alert<?php //echo $form_warning_type;?> alert-dismissible waybill-container<?php //echo $form_warning_disp;?>" role="alert">
                                        <div><?php //echo $form_warning;?></div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div> -->


                                    <form action="/forgot-password" method="post">
                                        <input type="hidden" name="actions" value="reset_password">
                                        <input type="hidden" name="selector" value="<?php echo $selector_v; ?>">
                                        <input type="hidden" name="token" value="<?php echo $token_v; ?>">

                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Новый пароль</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Введите пароль">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_password_again" class="form-label">Пароль еще раз</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" name="new_password_again" id="new_password_again" class="form-control" placeholder="Введите пароль">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 text-center">
                                            <button class="btn btn-primary w-100" type="submit">Изменить пароль</button>
                                        </div>

                                    </form>
                                </div> <!-- end card-body -->
                            </div>
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

    <?php } elseif ($data['success'] == 'password_changed') { ?>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-lg-5">
                        <div class="position-relative rounded-3 overflow-hidden">
                            <div class="card bg-transparent mb-0">
                                <div class="d-grid gap-2">
                                    <a href="/login">Вход</a>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
    <?php } else { ?>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-lg-5">
                        <div id="waybill-update-message" class="alert<?php echo $form_warning_type;?> alert-dismissible waybill-container<?php echo $form_warning_disp;?>" role="alert">
                            <div><?php echo $form_warning;?></div>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
    <?php }
} else { ?>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-lg-5">
                    <div class="position-relative rounded-3 overflow-hidden">
                        <div class="card bg-transparent mb-0">
                            <!-- Logo-->
                            <div class="auth-brand">
                                <a href="/" class="logo-light d-flex gap-2 align-items-center">
                                    <img src="../public/images/logo-txtgen1.png" alt="logo" height="22">
                                    <span class="fs-4">TxtGen</span>
                                </a>
                            </div>

                            <div class="card-body p-4">

                                <div class="w-100">
                                    <h4 class="text-dark-50 mt-0 fw-bold">Сбросить пароль</h4>
                                    <p class="text-muted mb-4">Введите свой адрес электронной почты, и мы отправим вам письмо с инструкциями по сбросу пароля.</p>
                                </div>

                                <form action="/forgot-password" method="post">
                                    <input type="hidden" name="actions" value="forgot_password">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="email" name="email" id="email" required="" placeholder="Введите E-mail">
                                    </div>

                                    <div class="mb-0 text-center">
                                        <button class="btn btn-primary w-100" type="submit">Сбросить пароль</button>
                                    </div>
                                </form>
                            </div> <!-- end card-body-->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted bg-body">Вернуться к <a href="/login" class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Вход</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
<?php } ?>

<?php
insertTemplate('/templates/footer-auth', ['data' => $data]);

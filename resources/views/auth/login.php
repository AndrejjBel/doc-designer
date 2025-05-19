<?php
insertTemplate('/templates/header-auth', ['data' => $data]);
$form_warning = '';
$form_warning_disp = ' d-none';
$form_warning_type = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'error') {
        $form_warning = 'Неверный логин или пароль';
        $form_warning_disp = '';
        $form_warning_type = ' alert-danger';
    } elseif ($_GET['error'] == 'email_noverifi') {
        $form_warning = 'Необходимо подтвердить E-mail';
        $form_warning_disp = '';
        $form_warning_type = ' alert-danger';
    }
}

if (isset($_GET['pass'])) {
    if ($_GET['pass'] == 'yes') {
        $form_warning = 'Пароль успешно изменен';
        $form_warning_disp = '';
        $form_warning_type = ' alert-success';
    }
}

// if (isset($success)) {
//     $form_warning = $success;
//     $form_warning_disp = '';
//     $form_warning_type = ' alert-success';
// }
?>

<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-lg-5">
                <div class="position-relative rounded-3 overflow-hidden">
                    <div class="card bg-transparent mb-0">
                        <div class="auth-brand">
                            <a href="/" class="logo-light d-flex gap-2 align-items-center">
                                <img src="../public/images/logo-txtgen1.png" alt="logo" height="22">
                                <span class="fs-4">TxtGen</span>
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <div class="w-100">
                                <h4 class="pb-0 fw-bold">Вход</h4>
                                <p class="fw-semibold mb-4">Введите свой адрес электронной почты и пароль.</p>
                            </div>

                            <div class="alert<?php echo $form_warning_type;?> alert-dismissible<?php echo $form_warning_disp;?>" role="alert">
                                <div><?php echo $form_warning;?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <form  action="/login" method="post">
                                <input type="hidden" name="actions" value="login">

                                <div class="mb-3">
                                    <label for="login" class="form-label">Логин или Email</label>
                                    <input class="form-control" type="text" name="login" id="login" required="" placeholder="Введите свой логин или E-mail">
                                </div>

                                <div class="mb-3">
                                    <!-- <a href="/forgot-password" class="float-end fs-12">Забыли пароль?</a> -->
                                    <label for="password" class="form-label">Пароль</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Введите пароль">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1">
                                        <label class="form-check-label" for="remember">Запомнить меня</label>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary w-100" type="submit">Вход</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted bg-body">Нет учетной записи? <a href="/signin" class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Регистрация</b></a></p>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</div>

<?php
insertTemplate('/templates/footer-auth', ['data' => $data]);

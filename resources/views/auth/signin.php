<?php
insertTemplate('/templates/header-auth', ['data' => $data]);
$site_settings = json_decode(site_settings('site_settings'));
$site_title = '';
if ($site_settings) {
    if (isset($site_settings->site_title)) {
        $site_title = $site_settings->site_title;
    }
}
$form_warning = '';
$form_warning_disp = ' d-none';
if (isset($_GET['error'])) {
    $form_warning = warning_value($_GET['error']);
    $form_warning_disp = '';
}
?>

<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-lg-5">
                <div class="reg">
                    <div class="card bg-transparent mb-0">
                        <div class="auth-brand border-bottom">
                            <span class="logo-lg d-flex gap-2 align-items-center">
                                <img src="../public/images/logo-n.png" alt="logo">
                                <span class="text-logo"><?php echo $site_title;?></span>
                            </span>
                        </div>

                        <div class="card-body p-4">

                            <div class="w-100">
                                <h4 class="text-dark-50 mt-0 fw-bold">Регистрация</h4>
                                <p class="text-muted mb-4">Нет аккаунта? Создайте аккаунт, это займет меньше минуты</p>
                            </div>

                            <div class="alert alert-danger alert-dismissible<?php echo $form_warning_disp;?>" role="alert">
                                <div><?php echo $form_warning;?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <form  action="/signin" method="post">
                                <input type="hidden" name="actions" value="signin">

                                <div class="mb-3">
                                    <label for="username" class="form-label">Логин</label>
                                    <input class="form-control" type="text" name="username" id="username" placeholder="Введите Логин" required>
                                    <span class="help-block"><small>Логин может состоять из латинских букв и цифр, символов "_" и "-", начало и окончание буква</small></span>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="email" name="email" id="email" required placeholder="Введите E-mail">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Пароль</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Введите пароль">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="pryvasi" id="checkbox-signup" value="1">
                                        <label class="form-check-label" for="checkbox-signup">Я принимаю <a href="#" class="text-muted">Условия и положения</a></label>
                                    </div>
                                </div>

                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary w-100" type="submit">Регистрация</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted bg-body">У вас уже есть аккаунт? <a href="/login" class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Войти</b></a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
insertTemplate('/templates/footer-auth', ['data' => $data]);

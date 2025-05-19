<?php
insertTemplate('/templates/header-auth', ['data' => $data]);
$form_warning = '';
$form_warning_text = '';
$form_warning_disp = ' d-none';
$form_warning_type = '';
$form_img_class = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'error') {
        $form_warning = 'Неверный логин или пароль';
        $form_warning_text = '';
        $form_warning_disp = '';
    }
}
elseif (isset($_GET['email'])) {
    $form_warning = 'Пожалуйста, проверьте свою электронную почту.';
    $form_warning_text = 'Письмо было отправлено на адрес <b>' . $_GET['email'] . '</b>.
    Проверьте наличие письма от компании и нажмите на ссылку, чтобы
    сбросить пароль.';
}
elseif (isset($data['error']) && isset($data['error_type'])) {
    $form_warning = $data['error'] . '. ' . $data['error_type'];
    $form_warning_text = '';
    $form_warning_disp = '';
    $form_warning_type = ' alert-danger';
    $form_img_class = ' d-none';
}
elseif (isset($data['success'])) {
    $form_warning = $data['success'];
    $form_warning_text = '';
    $form_warning_disp = '';
    $form_warning_type = ' alert-success';
    $form_img_class = ' d-none';
}
else {
    hl_redirect('/');
}
?>

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

                        <div class="m-auto">
                            <img src="../public/assets-adm/images/svg/mail_sent.svg" alt="mail sent image" height="64" class="<?php echo $form_img_class;?>" />
                            <h4 class="text-dark-50 mt-4 fw-bold"><?php echo $form_warning;?></h4>
                            <p class="text-muted mb-4">
                                <?php echo $form_warning_text;?>
                            </p>
                        </div>

                        <form action="index.html">
                            <div class="mb-0 text-center">
                                <a href="/" class="btn btn-primary w-100" type="submit"><i class="ri-home-4-line me-1"></i>Назад на главную</a>
                            </div>
                        </form>

                    </div> <!-- end card-body-->
                </div>
                <!-- end card-->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<?php
insertTemplate('/templates/footer-auth', ['data' => $data]);

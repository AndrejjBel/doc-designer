<?php
$site_settings = json_decode(site_settings('site_settings_pay'));
$pay_pass = '';
if ($site_settings->pay_pass) {
    $pay_pass = hex2bin($site_settings->pay_pass);
}
?>
<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/dashboard/generale">Консоль</a></li>
                                <li class="breadcrumb-item active">Платежи</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Платежи</h4>
                    </div>
                </div>
            </div>

            <form id="site_settings_pay" class="mb-4">
                <h4 class="fs-16">Настройки обработки платежей</h4>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pay_user" class="form-label">Сервер PayKeeper</label>
                        <input type="text" id="server_paykeeper" name="server_paykeeper" class="form-control" autocomplete="new-password" value="<?php echo ($site_settings)? $site_settings->server_paykeeper : '';?>">
                        <span class="help-block"><small>Сервер Api PayKeeper</small></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pay_user" class="form-label">Пользователь</label>
                        <input type="text" id="pay_user" name="pay_user" class="form-control" autocomplete="new-password" value="<?php echo ($site_settings)? $site_settings->pay_user : '';?>">
                        <span class="help-block"><small>Пользователь Api</small></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pay_pass" class="form-label">Пароль авторизации</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="pay_pass" name="pay_pass" class="form-control" autocomplete="new-password" value="<?php echo $pay_pass;?>">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        <span class="help-block"><small>Пароль авторизации Api</small></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pay_pass" class="form-label">Секретное слово</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="secret_seed" name="secret_seed" class="form-control" autocomplete="new-password" value="<?php echo ($site_settings)? $site_settings->secret_seed : '';?>">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        <span class="help-block"><small>Секретное слово Api</small></span>
                    </div>
                </div>



                <?php echo csrf_field();?>

                <div class="mb-0">
                    <button type="button" name="submit" class="btn btn-primary" onclick="formSiteSettingsPay(this)">Сохранить</button>
                </div>

            </form>

        </div>
    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<?php
// var_dump(json_decode(site_settings('site_settings')));

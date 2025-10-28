<?php
$site_settings = json_decode(site_settings('site_settings'));
$copyright = '';
if ($site_settings) {
    if (isset($site_settings->copyright)) {
        $copyright = $site_settings->copyright;
    }
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
                                <li class="breadcrumb-item active">Настройки</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Настройки</h4>
                    </div>
                </div>
            </div>

            <form id="site_settings" class="mb-4">
                <div class="mb-3">
                    <label for="site_title" class="form-label">Название сайта</label>
                    <input type="text" id="site_title" name="site_title" class="form-control" value="<?php echo ($site_settings)? $site_settings->site_title : '';?>">
                    <span class="help-block"><small>Название сайта</small></span>
                </div>

                <div class="mb-3">
                    <label for="site_description" class="form-label">Описание сайта</label>
                    <textarea class="form-control" id="site_description"  name="site_description" rows="5"><?php echo ($site_settings)? $site_settings->site_description : '';?></textarea>
                    <span class="help-block"><small>Описание сайта</small></span>
                </div>

                <div class="mb-3">
                    <label for="copyright" class="form-label">Copyright</label>
                    <input type="text" id="copyright" name="copyright" class="form-control" value="<?php echo $copyright;?>">
                    <span class="help-block"><small>Copyright</small></span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="post_limit_admin" class="form-label">Количество записей в админке</label>
                            <input type="number"
                                id="post_limit_admin"
                                name="post_limit_admin"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->post_limit_admin : '';?>">
                            <span class="help-block"><small>Количество записей на страницах в админке</small></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="post_limit_site" class="form-label">Количество записей на сайте</label>
                            <input type="number"
                                id="post_limit_site"
                                name="post_limit_site"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->post_limit_site : '';?>">
                            <span class="help-block"><small>Количество записей на страницах на сайте</small></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="keyRate" class="form-label">Ключевая ставка ЦБ РФ</label>
                            <input type="number"
                                id="keyRate"
                                name="keyRate"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->keyRate : '';?>">
                            <!-- <span class="help-block"><small>Количество записей на страницах на сайте</small></span> -->
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Регистрация</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="signin_vision" name="signin_vision" <?php echo (isset($site_settings->signin_vision))? checked($site_settings->signin_vision) : '';?>>
                        <label class="form-check-label" for="signin_vision">Разрешить регистрацию на сайте</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="site_styles" class="form-label">Стили</label>
                    <textarea class="form-control" id="site_styles"  name="site_styles" rows="5"><?php echo ($site_settings)? $site_settings->site_styles : '';?></textarea>
                    <span class="help-block"><small>Стили для сайта</small></span>
                </div>

                <div class="mb-3">
                    <label for="contact_email" class="form-label">Email для сообщений контактной формы</label>
                    <input type="text" id="contact_email" name="contact_email" class="form-control" value="<?php echo ($site_settings)? $site_settings->contact_email : '';?>">
                    <span class="help-block"><small>Email для сообщений контактной формы</small></span>
                </div>

                <div class="row">
                    <label class="form-label">Настройки SMTP</label>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="smtp_host" class="form-label">Host</label>
                            <input type="text"
                                id="smtp_host"
                                name="smtp_host"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->smtp_host : '';?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="smtp_port" class="form-label">Port</label>
                            <input type="text"
                                id="smtp_port"
                                name="smtp_port"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->smtp_port : '';?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="smtp_username" class="form-label">Username</label>
                            <input type="text"
                                id="smtp_username"
                                name="smtp_username"
                                class="form-control"
                                value="<?php echo ($site_settings)? $site_settings->smtp_username : '';?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="smtp_password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                    id="smtp_password"
                                    name="smtp_password"
                                    class="form-control"
                                    autocomplete="new-password"
                                    value="<?php echo ($site_settings)? $site_settings->smtp_password : '';?>">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Сайт на обслуживании</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="maintenance" name="maintenance" <?php //echo (isset($site_settings->maintenance))? checked($site_settings->maintenance) : '';?>>
                                <label class="form-check-label" for="maintenance">Закрыть сайт на обслуживание</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="maintenance-date" class="form-label">Дата обслуживания "до"</label>
                            <input class="form-control" id="maintenance-date" type="date" name="maintenance_date" value="<?php //echo (isset($site_settings->maintenance_date))? $site_settings->maintenance_date : '';?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="maintenance-time" class="form-label">Время обслуживания "до"</label>
                            <input class="form-control" id="maintenance-time" type="time" name="maintenance_time" value="<?php //echo (isset($site_settings->maintenance_time))? $site_settings->maintenance_time : '08:00';?>">
                        </div>
                    </div>
                </div> -->


                <?php echo csrf_field();?>

                <div class="mb-0">
                    <button type="button" name="submit" class="btn btn-primary" onclick="formSiteSettings(this)">Сохранить</button>
                </div>

            </form>

        </div>
    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<?php
// var_dump(json_decode(site_settings('site_settings')));

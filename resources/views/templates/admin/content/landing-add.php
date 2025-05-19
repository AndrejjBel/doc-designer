<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/admin">Консоль</a></li>
                                <li class="breadcrumb-item active">Лендинг</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Лендинг</h4>
                    </div>
                </div>
            </div>

            <form id="user_landing" class="mb-4">
                <div class="mb-3">
                    <label for="landing_title" class="form-label">Название Лендинга</label>
                    <input type="text" id="landing_title" name="landing_title" class="form-control" value="<?php //echo ($site_settings)? $site_settings->site_title : '';?>">
                    <span class="help-block"><small>Название Лендинга</small></span>
                </div>

                <div class="mb-3">
                    <label for="landing_description" class="form-label">Описание Лендинга</label>
                    <textarea class="form-control" id="landing_description"  name="landing_description" rows="5"><?php //echo ($site_settings)? $site_settings->site_description : '';?></textarea>
                    <span class="help-block"><small>Описание Лендинга</small></span>
                </div>

                <?php echo csrf_field();?>

                <div class="mb-0">
                    <button type="button" name="submit" class="btn btn-info" onclick="formUserLanding(this)">Сохранить</button>
                </div>

            </form>

        </div>
    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<?php
// var_dump(json_decode(site_settings('site_settings')));

<?php
$user = $data['user'];
$br_gen = 'Консоль';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
}
?>
<div class="content-page user-settings">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $br_gen;?></a></li>
                                <li class="breadcrumb-item active">Профиль <?php echo ($user['first_name'])? $user['first_name'] : $user['username'];?></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Профиль <?php echo ($user['first_name'])? $user['first_name'] : $user['username'];?></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card overflow-hidden">
                        <div class="card-body">

                            <div id="basicwizard">
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-4 border-top-0" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#basictab1" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1 active" aria-selected="true" role="tab">
                                            <i class="ri-account-circle-line fw-normal fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Профиль</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#basictab2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1" aria-selected="false" role="tab" tabindex="-1">
                                            <i class="ri-lock-2-line fw-normal fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Пароль</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0">
                                    <form class="tab-pane user-settings active show" id="basictab1" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="first_name">Имя</label>
                                                    <div class="col-md-9">
                                                        <input type="text"
                                                            id="first_name"
                                                            name="first_name"
                                                            class="form-control"
                                                            placeholder="Имя"
                                                            value="<?php echo ($user['first_name'])? $user['first_name'] : '';?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="last_name"> Фамилия</label>
                                                    <div class="col-md-9">
                                                        <input type="text"
                                                            id="last_name"
                                                            name="last_name"
                                                            class="form-control"
                                                            placeholder="Фамилия"
                                                            value="<?php echo ($user['last_name'])? $user['last_name'] : '';?>">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="email">Email</label>
                                                    <div class="col-md-9">
                                                        <input type="email"
                                                            id="email"
                                                            name="email"
                                                            class="form-control"
                                                            placeholder="Email"
                                                            value="<?php echo $user['email'];?>"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="phone">Телефон</label>
                                                    <div class="col-md-9">
                                                        <input type="text"
                                                            id="phone"
                                                            name="phone"
                                                            class="form-control phone_mask"
                                                            placeholder="Телефон"
                                                            value="<?php echo get_user_meta($user, 'phone');?>">
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="description">О себе</label>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control"
                                                            id="description"
                                                            name="description"
                                                            rows="5"><?php echo get_user_meta($user, 'description');?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo csrf_field();?>
                                        <ul class="pager wizard mb-0 list-inline">
                                            <li class="next list-inline-item float-end">
                                                <button type="button" name="submit" class="btn btn-info">Сохранить</button>
                                            </li>
                                        </ul>
                                    </form>

                                    <form class="tab-pane user-password" id="basictab2" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="password_old">Старый пароль <span class="text-danger">*<span></label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" id="password_old" name="password_old" class="form-control" placeholder="Старый пароль" required>
                                                            <div class="input-group-text" data-password="false">
                                                                <span class="password-eye"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="password_new">Новый пароль <span class="text-danger">*<span></label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" id="password_new" name="password_new" class="form-control" placeholder="Новый пароль" required>
                                                            <div class="input-group-text" data-password="false">
                                                                <span class="password-eye"></span>
                                                            </div>
                                                            <div class="invalid-feedback">Пароли не совпадают</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="password_re">Новый пароль <span class="text-danger">*<span></label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" id="password_re" name="password_re" class="form-control" placeholder="Новый пароль еще раз" required>
                                                            <div class="input-group-text" data-password="false">
                                                                <span class="password-eye"></span>
                                                            </div>
                                                            <div class="invalid-feedback">Пароли не совпадают</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo csrf_field();?>
                                        <ul class="list-inline wizard mb-0">
                                            <li class="next list-inline-item float-end">
                                                <button type="button" name="submit" class="btn btn-info">Сохранить</button>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/admin">Консоль</a></li>
                                <li class="breadcrumb-item active"><?php echo $data['title']?></li>
                            </ol>
                        </div>
                        <h4 class="page-title"><?php echo $data['title']?></h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row g-4">
                <div class="col-12">
                    <div class="mb-4">

                        <div class="table-responsive-sm">
                            <table class="table table-sm table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th></th>
                                        <th>Имя</th>
                                        <th>Логин</th>
                                        <th>E-mail</th>
                                        <th>Роль</th>
                                        <th>Баланс</th>
                                        <th>Verified</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['user_all'] as $key => $user) {
                                        $user_role = '-';
                                        if ((int)$user['roles_mask'] != 0) {
                                            $user_role = rolesOptions()[(int)$user['roles_mask']];
                                        }
                                        // $user_balance = $user['balance'] - $currUser['expenses']; //($user['c_tokens']/1000*0.144 + $user['p_tokens']/1000*0.432);
                                    ?>
                                        <tr id="user<?php echo $user['id'];?>">
                                            <td><?php echo $user['id'];?></td>
                                            <td class="table-user"><img src="../public/images/no-avatar.png" alt="table-user" class="me-1 rounded-circle" /></td>
                                            <td>
                                                <input class="form-control d-inline-flex border-0 bg-transparent ps-1 pe-1 w-auto"
                                                    type="text"
                                                    name="first_name"
                                                    value="<?php echo ($user['first_name'])? $user['first_name'] : $user['username'];?>"
                                                    readonly>
                                            </td>
                                            <td>
                                                <?php echo $user['username'];?>
                                            </td>
                                            <td>
                                                <input class="form-control d-inline-flex border-0 bg-transparent ps-1 pe-1 w-auto"
                                                type="text"
                                                name="email"
                                                value="<?php echo $user['email'];?>"
                                                readonly>
                                            </td>
                                            <td>
                                                <select name="roles_mask" class="form-control select2 select2-hidden-accessible border-0 bg-transparent w-auto cursor-pointer" disabled>
                                                    <?php echo createRolesOptions('Нет роли', $user['roles_mask']);?>
                                                </select>
                                            </td>
                                            <td><?php //echo round($user_balance, 2);?>0 ₽</td>
                                            <td><?php echo ($user['verified'])? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-reset fs-16 px-1 js-user-edit"
                                                    data-state="def"
                                                    data-id="user<?php echo $user['id'];?>"
                                                    title="Редактировать">
                                                    <i class="ri-edit-2-line"></i>
                                                </a>

                                                <div class="dropdown d-inline-block">
                                                    <button type="button"
                                                        class="btn btn-light btn-sm dropdown-toggle arrow-none"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                        title="Изменить пароль">
                                                        <i class="ri-settings-3-line"></i>
                                                    </button>
                                                    <div class="dropdown-menu adm-user-settings">
                                                        <div class="px-2 py-2">
                                                            <div class="mb-3">
                                                                <label for="user-pass-edit" class="form-label">Новый пароль</label>
                                                                <input type="text" class="form-control" id="user-pass-edit" placeholder="Новый пароль">
                                                            </div>
                                                            <button class="btn btn-primary btn-sm js-adm-user-pass-edit"
                                                                data-id="<?php echo $user['id'];?>"
                                                                onclick="admEditUserPass(this)">Изменить пароль</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="dropdown d-inline-block">
                                                    <button type="button"
                                                        class="btn btn-light btn-sm dropdown-toggle arrow-none"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                        title="Удалить пользователя">
                                                        <i class="ri-delete-bin-line text-danger"></i>
                                                    </button>
                                                    <div class="dropdown-menu adm-user-settings">
                                                        <div class="px-2 py-2">
                                                            <div class="mb-3">
                                                                <div class="form-label">Вы действительно хотите удалить пользователя: <span class="fw-bolder"><?php echo $user['username'];?></span>?</div>
                                                            </div>
                                                            <button class="btn btn-danger btn-sm"
                                                                data-id="user<?php echo $user['id'];?>"
                                                                onclick="userDelete(this)">Удалить пользователя</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <?php echo csrf_field();

    // $tokens = get_utoai();
    // $tokens = get_utoai_fid(19);

    // $m = 'gpt-4o-mini-2024-07-18';
    // $type = 'completion';
    //
    // $cost = cost_of_request($m, $type);

    // echo __DIR__;

    // $rolesNames = [];
    // foreach (\Delight\Auth\Role::getMap() as $roleValue => $roleName) {
    //     $rolesNames[] = $roleName;
    // }

    // echo '<pre>';
    // var_dump(implode(',', $rolesNames));
    // echo '</pre>';
    ?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

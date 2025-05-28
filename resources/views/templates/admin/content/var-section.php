<?php
$br_gen = 'Консоль';
$pagin_link = '/admin/glampings';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
    $pagin_link = '/dashboard/glampings';
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
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $br_gen;?></a></li>
                                <li class="breadcrumb-item active">Переменные</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Переменные</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 order-1 order-xl-0">
                    <div class="mb-4">
                        <h4 class="fs-16">Разделы</h4>
                        <?php if (count($data['vars_parent'])) { ?>

                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVar" aria-expanded="false" aria-controls="collapseVar">
                                            Разделы
                                            <span class="badge bg-primary rounded-pill ms-1">
                                                <?php echo count($data['vars_parent']);?>
                                            </span>
                                        </button>
                                    </h2>
                                    <div id="collapseVar" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body p-0">
                                            <div class="list-group p-1 list-vars">
                                                <?php echo sections_vars($data['vars_parent']);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <h4 class="fs-16">Разделы еще не созданы</h4>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-xl-6 d-flex justify-content-end align-items-start">
                    <button class="btn btn-sm btn-primary"
                        type="button"
                        name="button"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-vargr-add">Добавить раздел</button>
                </div>
            </div>

            <?php if (count($data['vars_parent'])) { ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="title-group d-flex gap-2 flex-xl-row flex-column align-items-xl-end justify-content-xl-between mb-3">
                            <h4 class="vars-title fs-16 mb-0 fl-upp"><?php echo $data['vars_parent'][0]['title'];?></h4>
                            <button class="btn btn-sm btn-primary ms-auto"
                                type="button"
                                name="button"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-var-add"
                                style="width: fit-content;">Создать переменную</button>
                        </div>
                        <div class="table-responsive-sm">
                            <table class="table table-sm table-centered table-hover mb-0 vars-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Наименование переменной</th>
                                        <th>Описание</th>
                                        <th>Группа</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (table_vars($data['vars'], $data['vars_parent'][0]['id'])) { ?>
                                        <?php echo table_vars($data['vars'], $data['vars_parent'][0]['id']);?>
                                    <?php } else { ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><h4 class="fs-16 mt-3 fl-upp">Переменные еще не созданы</h4></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

    </div>

    <div class="modal fade" id="modal-vargr-add" tabindex="-1" aria-labelledby="varGrAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="varGrAddLabel">Создать группу/раздел</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="group_section">
                        <div class="row">
                            <div class="col-12 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Группа</label>
                                    <select class="form-select" id="parentid" name="parentid" onchange="selectChange(this)">
                                        <?php echo options_vars_group($data['vars'], $data['var_id']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Имя раздела <span class="text-danger">*</span></label>
                                    <input id="title" type="text" class="form-control" value="" name="title" oninput="inputChange(this)" placeholder="Введите имя раздела">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button id="grAddBtn" type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-var-add" tabindex="-1" aria-labelledby="varAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="varAddLabel">Создать переменную</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_var_add">
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Имя переменной <span class="text-danger">*</span></label>
                                    <input id="title" type="text" class="form-control" value="" name="title" oninput="inputChange(this)" placeholder="Введите имя переменной">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Группа</label>
                                    <select class="form-select" id="parentid" name="parentid">
                                        <?php echo options_vars($data['vars_parent']);?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Тип</label>
                                    <select id="type" class="form-select" name="type">
                                        <option value="1">Вводится клиентом</option>
                                        <option value="2">API Запрос в ФССП</option>
                                        <option value="3">Заголовок</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Тип данных</label>
                                    <select id="typedata" class="form-select" name="typedata">
                                        <option value="1">Текстовое поле</option>
                                        <option value="2">Цифровое поле</option>
                                        <option value="3">Выбор даты</option>
                                        <option value="4">Ввод телефона</option>
                                        <option value="5">Поле с выбором</option>
                                        <option value="8">Поле с мультивыбором</option>
                                        <option value="6">Описание</option>
                                        <option value="7">Ссылки на документы</option>
                                        <option value="9">Текстовая надпись</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Описание</label>
                                    <input id="descr" type="text" class="form-control" value="" name="descr" placeholder="Введите описание переменной">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Подсказка</label>
                                    <input id="captholder" type="text" class="form-control" value="" name="captholder" placeholder="Введите подсказку для ввода">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1 mb-lg-4" id="row_sprav_frm_extdata">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-1">Список для выбора: введите опции через точку с запятой ; </label>
                                    <input id="extdata" type="text" class="form-control" value="" name="extdata" placeholder="">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button id="varAddBtn" type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-var-modal" class="modal fade" tabindex="-1" aria-labelledby="delete-var-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <h4 class="modal-title" id="delete-var-modalLabel">Удаление переменной <span class="delete-var-title"></span></h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mt-0">Вы действительно хотите удалить переменную - <span class="delete-var-title"></span>?</h5>
                    <p>Переменная будет удалена без возможности восстановления.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button id="delete-var" type="button" class="btn btn-danger" data-bs-dismiss="modal" data-id="0" onclick="varsDelete(this)">Да, удалить</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    echo csrf_field();

    // locationsCount();

    // rest_api_glemp();

    // $glampings = locationsCount();
    // $post_term = 'moskovskaya-oblast';
    // $result = array_filter($glampings, function($k) use ($post_term) {
    //     return $k['post_term'] === $post_term;
    // });

    // $array = $data['vars'];
    // $array_pi = $data['vars_parent'];
    //
    // $search = [$array_pi[0]['id']];
    // $newArray = array_filter($array, function($_array) use ($search){
    //     return in_array($_array['parentid'], $search);
    // });
    //
    // $array_new = array_multisort_value($newArray, 'title', SORT_ASC);

    // $randomCode = random_int(1000, 9999);

    // $id = 35;

    // $home_url = config('main', 'home_url');
    //
    // echo '<pre>';
    // var_dump($home_url);
    // echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    ?>

</div>

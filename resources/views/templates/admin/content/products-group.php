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
                                <li class="breadcrumb-item active">Группы шаблонов</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Группы шаблонов</h4>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-end align-items-start">
                    <button class="btn btn-sm btn-soft-success"
                        type="button"
                        name="button"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-productsgr-add">Добавить раздел</button>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="table-responsive-sm">
                        <table class="table table-sm table-centered table-hover mb-0 vars-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование переменной</th>
                                    <th>Кол-во #</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (table_vars_group($data['products'])) { ?>
                                    <?php echo table_vars_group($data['products'], $data['userRoles'], 'products');?>
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

        </div>

        <?php //echo table_vars_group($data['vars']);?>

    </div>

    <div class="modal fade" id="modal-productsgr-add" tabindex="-1" aria-labelledby="varPrAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="varPrAddLabel">Создать группу/раздел</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="group_prod_section">
                        <div class="row">
                            <div class="col-12 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Группа</label>
                                    <select class="form-select" id="parentid" name="parentid" onchange="selectChange(this)">
                                        <?php echo products_group_options_add($data['products_gr']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label class="mb-1">Имя раздела <span class="text-danger">*</span></label>
                                    <input id="title" type="text" class="form-control" value="" name="title" oninput="inputChange(this)" placeholder="Введите имя раздела">
                                </div>
                            </div>

                            <div class="col-12 mb-1 mb-lg-4">
                                <div class="form-group">
                                    <label for="description" class="form-label">Описание раздела</label>
                                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                                </div>
                            </div>
                            <input class="d-none" type="text" name="prod_gr_id" value="">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button id="grPrAddBtn" type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-var-modal" class="modal fade" tabindex="-1" aria-labelledby="delete-var-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <h4 class="modal-title" id="delete-var-modalLabel">Удаление группы шаблонов <span class="delete-var-title"></span></h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mt-0">Вы действительно хотите удалить группу <span class="delete-var-title"></span>?</h5>
                    <p>Группа будет удалена со всеми разделами и шаблонами без возможности восстановления.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button id="delete-var" type="button" class="btn btn-danger" data-bs-dismiss="modal" data-id="0" onclick="productGroupDelete(this)">Да, удалить</button>
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

    // echo '<pre>';
    // var_dump($data['products_gr']);
    // echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    ?>

    <script type="text/javascript">
        prodGroups = '<?php echo htmlspecialchars_decode(json_encode($data['products_gr'], JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));?>';
    </script>

</div>

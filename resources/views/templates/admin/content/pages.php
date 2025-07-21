<?php
$gr_val = 0;
if (isset($_COOKIE['docDesProd'])) {
    $ddp = json_decode($_COOKIE['docDesProd']);
    $gr_val = $ddp->group;
}
$br_gen = 'Консоль';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
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
                                <li class="breadcrumb-item active">Страницы</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Страницы</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- <div class="row mb-4 filter-products">
                <div class="col-md-4 mb-2 mb-md-0 filter-item">
                    <label for="example-select" class="form-label">Группа</label>
                    <select class="form-select form-select-sm" id="productGroup" onchange="filterGroupChange(this)">
                        <?php //productGroup($data['products_gr'], $gr_val);?>
                    </select>
                </div>

                <div class="col-md-4 mb-2 mb-md-0 filter-item">
                    <label for="example-select" class="form-label">Раздел</label>
                    <select class="form-select form-select-sm" id="productСhapter">
                        <option value="0">Все разделы</option>
                    </select>
                </div>

                <div class="col-6 col-md-2 d-flex align-items-end justify-content-start filter-item">
                    <div class="filter-btns d-flex gap-2 align-items-center">
                        <button class="btn btn-sm btn-soft-danger btn-filter-close"
                            type="button"
                            name="button"
                            onclick="btnFilterClose()"
                            title="Сбросить фильтр">
                            <i class="ri-filter-off-line"></i>
                        </button>
                        <button id="filter-products-btn"
                            class="btn btn-sm btn-soft-success"
                            type="button"
                            name="button"
                            onclick="filtrPagesBtn()">Фильтр</button>
                    </div>
                </div>

                <div class="col-6 col-md-2 d-flex align-items-end justify-content-end filter-item">
                    <div class="filter-btns d-flex gap-2 align-items-center">
                        <button class="btn btn-sm btn-soft-danger btn-filter-close"
                            type="button"
                            name="button"
                            onclick="btnFilterClose()"
                            title="Сбросить фильтр">
                            <i class="ri-filter-off-line"></i>
                        </button>
                        <a href="/admin/page-add" class="btn btn-sm btn-soft-success">Создать страницу</a>
                    </div>
                </div>
            </div> -->

            <?php if (count($data['pages_list']) ) { ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="count-items d-flex flex-column flex-md-row justify-content-md-between">
                        <h5 class="page-title">Всего <?php echo $data['postCount'];?> страниц.</h5>
                        <h5 class="page-title">Страница <?php echo $data['cur_page'];?> из <?php echo $data['pagesCount'];?></h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="col-6">Заголовок</th>
                                    <th class="col-3">Группа/раздел</th>
                                    <th>Статус</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['pages_list'] as $key => $product) {
                                    $text_status = '';
                                    $class_btn = '';
                                    $status = 1;
                                    if ($product['status']) {
                                        $text_status = 'Активен';
                                        $class_btn = ' btn-soft-success';
                                        $status = 1;
                                    } else {
                                        $text_status = 'Выкл';
                                        $class_btn = ' btn-soft-danger';
                                        $status = 0;
                                    }
                                    ?>
                                    <tr id="prod<?php echo $product['id'];?>">
                                        <td><?php echo $product['id'];?></td>
                                        <td id="title<?php echo $product['id'];?>"><?php echo $product['title'];?></td>
                                        <td class="groups-product"><?php echo getGroupsProd($data['products_gr'], $product['terms']);?></td>
                                        <td class="actions-products">
                                            <button class="btn btn-sm  w-100<?php echo $class_btn;?>"
                                                data-id="<?php echo $product['id'];?>"
                                                data-status="<?php echo $status;?>"
                                                type="button"
                                                onclick="pageStatusChange(this)"
                                                name="button"
                                                title="Изменить статус"><?php echo $text_status;?></button>
                                        </td>
                                        <td class="actions-product">
                                            <a href="/<?php echo $product['slug'];?>" target="_blank" class="text-reset fs-16 mx-1" data-state="def" title="Смотреть">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="/admin/page-edit?id=<?php echo $product['id'];?>" class="text-reset fs-16 mx-1 js-user-settings" data-id="product<?php echo $product['id']?>" title="Редактировать">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <a href="/admin/page-add?duplicate=<?php echo $product['id'];?>" target="_blank" class="text-reset fs-16 mx-1 js-duplicate-btn" data-state="def" title="Дублировать">
                                                <i class="bi bi-files"></i>
                                            </a>
                                            <?php if ($data['userRoles'] == 'SUPER_ADMIN') { ?>
                                            <button
                                                class="btn btn-link mx-1 p-0 js-product-delete"
                                                type="button"
                                                name="button"
                                                onclick="pageTableDelete(this)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-page-modal"
                                                data-id="<?php echo $product['id'];?>" title="Удалить">
                                                <i class="ri-delete-bin-line text-danger"></i>
                                            </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php } else { ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="page-title">Страниц еще нет</h5>
                    </div>
                </div>
            <?php } ?>

            <div class="paginate mb-4">
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], '/admin/products', '/admin/products');?>
            </div>

        </div>

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
                                        <?php //echo products_group_options_add($data['products_gr']);?>
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

    <div id="delete-page-modal" class="modal fade" tabindex="-1" aria-labelledby="delete-page-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <h4 class="modal-title" id="delete-page-modalLabel">Удаление страницы <span class="delete-page-title"></span></h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mt-0">Вы действительно хотите удалить страницу <span class="delete-page-title"></span>?</h5>
                    <p>Страница будет удален без возможности восстановления.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button id="delete-page" type="button" class="btn btn-danger" data-bs-dismiss="modal" data-id="0" onclick="pageDelete(this)">Да, удалить</button>
                </div>
            </div>
        </div>
    </div>

    <?php echo csrf_field();?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    // prodVarsAdd();

    // $search = [14491];
    // $newArray = array_filter($data['products_gr'], function($_array) use ($search){
    //     return in_array($_array['id'], $search);
    // });

    // $new = array_values($newArray);
    // $new = array_combine(range(1, count($newArray)), $newArray);

    // reset($newArray);
    // $new = current($newArray);

    // $out = [];
    // array_walk_recursive($newArray, function($newArray) use (&$out) { $out[] = $newArray; });

    // $cooc = json_decode($_COOKIE['docDesProd']);

    // echo '<pre>';
    // var_dump($data['parentids']);
    // echo '</pre>';
    ?>

</div>

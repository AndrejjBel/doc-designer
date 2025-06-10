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
                                <li class="breadcrumb-item active">Шаблоны</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Шаблоны</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-4 filter-products">
                <div class="col-md-4 mb-2 mb-md-0 filter-item">
                    <label for="example-select" class="form-label">Группа</label>
                    <select class="form-select form-select-sm" id="productGroup" onchange="filterGroupChange(this)">
                        <?php productGroup($data['products_gr'], $gr_val);?>
                    </select>
                </div>

                <div class="col-md-4 mb-2 mb-md-0 filter-item">
                    <label for="example-select" class="form-label">Раздел</label>
                    <select class="form-select form-select-sm" id="productСhapter">
                        <option value="0">Все разделы</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end justify-content-end justify-content-md-start filter-item">
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
                            onclick="filtrProdBtn()">Фильтр</button>
                    </div>
                </div>
            </div>

            <?php if (count($data['products_list']) ) { ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="count-items d-flex flex-column flex-md-row justify-content-md-between">
                        <h5 class="page-title">Всего <?php echo $data['postCount'];?> шаблонов.</h5>
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
                                <?php foreach ($data['products_list'] as $key => $product) {
                                    $text_status = '';
                                    $class_btn = '';
                                    $status = 1;
                                    if ($product['active']) {
                                        $text_status = 'Активен';
                                        $class_btn = ' btn-soft-success';
                                        $status = 1;
                                    } else {
                                        $text_status = 'Выкл';
                                        $class_btn = ' btn-soft-danger w-100';
                                        $status = 0;
                                    }
                                    ?>
                                    <tr id="prod<?php echo $product['id'];?>">
                                        <td><?php echo $product['id'];?></td>
                                        <td id="title<?php echo $product['id'];?>"><?php echo $product['title'];?></td>
                                        <td class="groups-product"><?php echo getGroupsProd($data['products_gr'], $product['parentid']);?></td>
                                        <td class="actions-products">
                                            <button class="btn btn-sm<?php echo $class_btn;?>"
                                                data-id="<?php echo $product['id'];?>"
                                                data-status="<?php echo $status;?>"
                                                type="button"
                                                onclick="productStatusChange(this)"
                                                name="button"
                                                title="Изменить статус"><?php echo $text_status;?></button>
                                        </td>
                                        <td class="actions-product">
                                            <a href="/products/<?php echo $product['id'];?>" target="_blank" class="text-reset fs-16 mx-1" data-state="def" title="Смотреть">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="/admin/product-edit?id=<?php echo $product['id'];?>" class="text-reset fs-16 mx-1 js-user-settings" data-id="product<?php echo $product['id']?>" title="Редактировать">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <a href="/admin/product-add?duplicate=<?php echo $product['id'];?>" target="_blank" class="text-reset fs-16 mx-1 js-duplicate-btn" data-state="def" title="Дублировать">
                                                <i class="bi bi-files"></i>
                                            </a>
                                            <button
                                                class="btn btn-link mx-1 p-0 js-product-delete"
                                                type="button"
                                                name="button"
                                                onclick="productTableDelete(this)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-product-modal"
                                                data-id="<?php echo $product['id'];?>" title="Удалить">
                                                <i class="ri-delete-bin-line text-danger"></i>
                                            </button>
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
                        <h5 class="page-title">Шаблонов еще нет</h5>
                    </div>
                </div>
            <?php } ?>

            <div class="paginate mb-4">
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], '/admin/products', '/admin/products');?>
            </div>

        </div>

    </div>

    <div id="delete-product-modal" class="modal fade" tabindex="-1" aria-labelledby="delete-product-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <h4 class="modal-title" id="delete-product-modalLabel">Удаление шаблона <span class="delete-product-title"></span></h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="mt-0">Вы действительно хотите удалить шаблон <span class="delete-product-title"></span>?</h5>
                    <p>Шаблон будет удален без возможности восстановления.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button id="delete-product" type="button" class="btn btn-danger" data-bs-dismiss="modal" data-id="0" onclick="productDelete(this)">Да, удалить</button>
                </div>
            </div>
        </div>
    </div>

    <?php echo csrf_field();?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);

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

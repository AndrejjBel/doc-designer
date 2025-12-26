<?php
$br_gen = 'Консоль';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
}
$document_drafting = config('main', 'document_drafting');
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
                                <li class="breadcrumb-item active"><?php echo $data['title']?></li>
                            </ol>
                        </div>
                        <h4 class="page-title"><?php echo $data['title']?></h4>
                    </div>
                </div>
            </div>

            <?php if (count($data['orders']) ) { ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="col-1">Дата</th>
                                    <th class="col-2">Клиент</th>
                                    <th class="col-3">Документ</th>
                                    <th class="col-2">Статус</th>
                                    <th>Файлы</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['orders'] as $key => $order) {
                                    $mess = docOrderComments($order['id']);
                                    $noVisionMess = noVisionMess($mess, $data['user']['id']);
                                    $user = json_decode($order['clientmeta'], true);
                                    $lawyer = json_decode($order['lawyer'], true);
                                    $strjson = json_decode($order['strjson'], true);
                                    $btn_appoint = '';
                                    $lawyer_info = '';
                                    $into_work = '';
                                    if (is_admin_allowed()) {
                                        $into_work = '<button class="btn btn-sm btn-outline-warning btn-adm ms-1"
                                        type="button"
                                        data-order="' . $order['id'] . '"
                                        title="Взять в работу"
                                        onclick="doc_order_staus_change(this)">
                                        <i class="bi bi-check-circle"></i>
                                        <span class="ms-1">В работу</span>
                                        </button>';
                                    }
                                    if (is_admin()) {
                                        $btn_appoint = '<div class="dropdown">
                                        <button class="btn btn-outline-success btn-adm dropdown-toggle arrow-none ms-1"
                                            type="button"
                                            name="button"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="true"
                                            data-bs-auto-close="outside"
                                            data-order="' . $order['id'] . '"
                                            title="Назначить юриста">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <div class="dropdown-menu adm-user-settings">
                                            <form class="px-2 py-2">
                                                <div class="mb-3">
                                                    <label for="lawyer" class="form-label">Назначить юристу</label>
                                                    <select id="lawyer" name="lawyer" class="form-select">
                                                        <option value="0">Выберите юриста</option>
                                                        ' . lawyers_select() . '
                                                    </select>
                                                </div>
                                                <button class="btn btn-primary btn-sm js-adm-user-pass-edit"
                                                    data-orderid="' . $order['id'] . '"
                                                    onclick="appointLawyer(this)">Назначить</button>
                                            </form>
                                        </div>
                                        </div>';
                                    }
                                    if ($order['status'] == 1) {
                                        $order_url = '<button class="btn btn-outline-info btn-adm"
                                            type="button"
                                            name="button"
                                            data-order="' . $order['id'] . '"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalOrderDocInfo"
                                            title="Информация о заказе">
                                            <i class="bi bi-info-circle"></i>
                                        </button>';
                                        $order_url .= $into_work;
                                        $order_url .= $btn_appoint;
                                    } else {
                                        $lawyer_fio = ($lawyer['fio'])? $lawyer['fio'] : $lawyer['username'];
                                        $order_url = '<button class="btn btn-outline-info btn-adm"
                                            type="button"
                                            name="button"
                                            data-order="' . $order['id'] . '"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalOrderDocInfo"
                                            title="Информация о заказе">
                                            <i class="bi bi-info-circle"></i>
                                        </button>';
                                        $order_url .= $btn_appoint;
                                        $lawyer_info = '<span id="lawyer-info-' . $order['id'] . '" class="d-flex badge badge-outline-success mt-1 w-fit-cont">
                                            ' . $lawyer_fio . '
                                        </span>';
                                    }
                                    ?>
                                    <tr id="order<?php echo $order['id'];?>">
                                        <td><?php echo $order['id'];?></td>
                                        <td id="title<?php echo $order['id'];?>">
                                            <?php echo date('d.m.Y', strtotime($order['dateopen']));?><br>
                                            <?php echo date('H:m', strtotime($order['dateopen']));?>
                                        </td>
                                        <td>
                                            <p class="mb-0"><?php echo $user['name'];?></p>
                                            <p class="fs-12 mb-0"><?php echo $user['phone'];?></p>
                                            <p class="fs-12 mb-0"><?php echo $user['email'];?></p>
                                        </td>
                                        <td><?php echo $strjson['sos_trebovanie']; //order_prod_title($data['products'], $order['productid']);?></td>
                                        <td>
                                            <div id="doc-order-status-wrap-<?php echo $order['id'];?>" class="doc-order-status d-flex flex-column">
                                                <span id="doc-order-status-<?php echo $order['id'];?>" class="d-flex badge badge-outline-<?php echo doc_orders_status($order['status'])[2]?> w-fit-cont">
                                                    <?php echo mb_ucfirst(doc_orders_status($order['status'])[1]);?>
                                                </span>
                                                <?php echo $lawyer_info;?>
                                            </div>
                                        </td>
                                        <td class="text-center cursor-point dropdown-toggle arrow-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <?php echo order_upload($order, $data['products']);?>
                                                <?php if (count($mess)) { ?>
                                                    <div class="btn btn-primary rounded-pill position-relative px-2 count-mess">
                                                        <?php echo count($mess);?>
                                                        <?php if ($noVisionMess) { ?>
                                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                <?php echo $noVisionMess;?>
                                                            </span>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td id="order_url" class="actions-product">
                                            <div class="doc-order-buttons d-flex">
                                                <?php echo $order_url;?>
                                                <a href="/<?php echo $data['mod'];?>/doc-order/?id=<?php echo $order['id'];?>" class="btn btn-outline-secondary btn-adm ms-1"
                                                    title="Перейти к заказу">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </div>
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
                        <h5 class="page-title">Покупок еще нет</h5>
                    </div>
                </div>
            <?php } ?>

            <div class="paginate mb-4">
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], '/admin/orders', '/admin/orders');?>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalOrderDocInfo" tabindex="-1" aria-labelledby="modalOrderInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalOrderInfoLabel">Информация о заказе</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const ordersArr = '<?php echo addslashes(json_encode($data['orders'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));?>';
        varsAll = '<?php echo addslashes(json_encode($data['vars'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));?>';
    </script>

    <?php
    echo csrf_field();

    // echo '<pre>';
    // echo var_dump($data);
    // echo '</pre>';

    // echo number_format($data['orders'][0]['summ'], 2, ".", "");

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    ?>

</div>

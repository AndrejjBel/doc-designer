<?php
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
                                <li class="breadcrumb-item active">Продажи</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Продажи</h4>
                    </div>
                </div>
            </div>

            <?php if (count($data['orders']) ) { ?>

            <div class="row mb-4">
                <div class="col-12">
                    <!-- <div class="count-items d-flex flex-column flex-md-row justify-content-md-between">
                        <h5 class="page-title">Всего <?php //echo $data['postCount'];?> шаблонов.</h5>
                        <h5 class="page-title">Страница <?php //echo $data['cur_page'];?> из <?php //echo $data['pagesCount'];?></h5>
                    </div> -->
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="col-1">Дата</th>
                                    <th class="col-3">Клиент</th>
                                    <th class="col-5">Шаблон</th>
                                    <th>Сумма</th>
                                    <th>Оплачено</th>
                                    <th>Тип оплаты</th>
                                    <th>Скачать</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['orders'] as $key => $order) {
                                    $user = json_decode($order['clientmeta'], true);
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
                                        <td><?php echo order_prod_title($data['products'], $order['productid']);?></td>
                                        <td class="text-center"><?php echo $order['summ'];?>р.</td>
                                        <td class="text-center"><?php echo $order['sumpay'];?>р.</td>
                                        <td class="text-center cursor-point dropdown-toggle arrow-none"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            title="Редактировать">
                                            <?php echo order_vars_html('type', $order['typepay']);?><br>
                                            <?php echo order_vars_html('status', $order['status']);?>

                                            <div class="dropdown-menu">
                                                <button
                                                    class="dropdown-item<?php echo optionActive(1, $order['status']);?>"
                                                    data-id="<?php echo $order['id'];?>"
                                                    data-value="1"
                                                    onclick="orderStatusEdit(this)">Ожидание оплаты</button>
                                                <button
                                                    class="dropdown-item<?php echo optionActive(2, $order['status']);?>"
                                                    data-id="<?php echo $order['id'];?>"
                                                    data-value="2"
                                                    onclick="orderStatusEdit(this)">Оплачено</button>
                                                <button
                                                    class="dropdown-item<?php echo optionActive(3, $order['status']);?>"
                                                    data-id="<?php echo $order['id'];?>"
                                                    data-value="3"
                                                    onclick="orderStatusEdit(this)">Отменен</button>
                                            </div>
                                        </td>
                                        <td id="order_url" class="text-center actions-product">
                                            <a href="<?php echo $order['doc_url'];?>" class="text-reset fs-16 mx-1" title="Скачать" download>
                                                <i class="bi bi-download text-success"></i>
                                            </a>
                                            <?php //echo order_upload($order['status'], $order['doc_url']);?>
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

    <?php
    echo csrf_field();

    // echo '<pre>';
    // echo var_dump($data['loginsEmails']['logins']);
    // echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    ?>

</div>

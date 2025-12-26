<?php
$user = $data['user'];
$document_drafting = config('main', 'document_drafting');
$br_gen = 'Консоль';
$pag_url = '/admin/user-orders';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
    $pag_url = '/dashboard/user-orders';
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
                                <li class="breadcrumb-item active">Покупки <?php echo ($user['first_name'])? $user['first_name'] : $user['username'];?></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Покупки <?php echo ($user['first_name'])? $user['first_name'] : $user['username'];?></h4>
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
                                    <th class="col-5">Шаблон</th>
                                    <th>Сумма</th>
                                    <th>Оплачено</th>
                                    <th>Тип оплаты</th>
                                    <th>Скачать</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['orders'] as $key => $order) {
                                    // $text_status = '';
                                    // $class_btn = '';
                                    // $status = 1;
                                    // if ($product['active']) {
                                    //     $text_status = 'Активен';
                                    //     $class_btn = ' btn-soft-success';
                                    //     $status = 1;
                                    // } else {
                                    //     $text_status = 'Выкл';
                                    //     $class_btn = ' btn-soft-danger';
                                    //     $status = 0;
                                    // }
                                    ?>
                                    <tr id="order<?php echo $order['id'];?>">
                                        <td><?php echo $order['id'];?></td>
                                        <td id="title<?php echo $order['id'];?>">
                                            <?php echo date('d.m.Y', strtotime($order['dateopen']));?><br>
                                            <?php echo date('H:m', strtotime($order['dateopen']));?>
                                        </td>
                                        <td><?php echo order_prod_title($data['products'], $order['productid']);?></td>
                                        <td class="text-center"><?php echo $order['summ'];?>р.</td>
                                        <td class="text-center"><?php echo $order['sumpay'];?>р.</td>
                                        <td class="text-center">
                                            <?php echo order_vars_html('type', $order['typepay']);?><br>
                                            <?php echo order_vars_html('status', $order['status']);?>
                                        </td>
                                        <td class="text-center actions-product">
                                            <?php echo order_upload($order, $data['products']);?>
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
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], $pag_url, $pag_url);?>
            </div>

        </div>
    </div>

    <?php

    // $search = [14465];
    // $product = array_shift(array_filter($data['products'], function($_array) use ($search){
    //     return in_array($_array['id'], $search);
    // }));

    // $search = 14465;
    //
    // $pr = prod_meta_fid($data['products'], $search, 'parentid');
    //
    // $parentid = order_prod_meta($data['products'], 14557, 'parentid');

    // echo '<pre>';
    // var_dump($data['pagesCount']);
    // echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<?php
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
                                <li class="breadcrumb-item active">Заказы</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Заказы</h4>
                    </div>
                </div>
            </div>

            <?php if (count($data['orders'])) { ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="table-responsive-sm">
                        <table class="table table-sm table-centered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="width:30%;">Заказы</th>
                                    <th>Покупатель</th>
                                    <th>Статус</th>
                                    <th>Дата</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['orders'] as $key => $order) {
                                    $user = usernameId($order['user_id']);
                                    $user_name = 'No';
                                    if ($user) {
                                        if (usernameId($order['user_id'])['first_name']) {
                                            $user_name = usernameId($order['user_id'])['first_name'];
                                        } else {
                                            $user_name = usernameId($order['user_id'])['username'];
                                        }
                                    } else {
                                        $user_info = explode(';', $order['user_info']);
                                        $user_name = $user_info[0] . '<br>' . $user_info[1];
                                    }
                                    ?>
                                    <tr id="order<?php echo $order['id'];?>">
                                        <td><?php echo $order['id'];?></td>
                                        <td><?php orderProducts($order['order_products']);?></td>
                                        <td><?php echo $user_name;?></td>
                                        <td>
                                            <select name="order_status"
                                                data-id="<?php echo $order['id'];?>"
                                                class="form-control form-select-sm border-0 bg-transparent w-auto cursor-pointer fw-semibold<?php selected_order_status($order['status']);?>"
                                                title="Статус/Изменить статус"
                                                onchange="changeStatusOrder(this)">
                                                <option class="text-warning" value="created" <?php echo selected($order['status'], 'created');?>>Новый</option>
                                                <option class="text-success" value="processed" <?php echo selected($order['status'], 'processed');?>>В обработке</option>
                                                <option class="text-dark" value="completed" <?php echo selected($order['status'], 'completed');?>>Обработан</option>
                                            </select>
                                            <?php //echo $order['status'];?>
                                        </td>
                                        <td><?php echo date('d.m.Y', strtotime($order['order_date']));?></td>
                                        <td>
                                            <!-- <a href="#<?php //echo $order['id'];?>" target="_blank" class="text-reset fs-16 px-1" data-state="def" title="Смотреть">
                                                <i class="ri-eye-line"></i>
                                            </a> -->
                                            <a href="/dashboard/order-edit?id=<?php echo $order['id'];?>" class="text-reset fs-16 px-1 js-user-settings" title="Редактировать">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
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
                    <h5 class="page-title">Заказов еще нет</h5>
                </div>
            </div>
        <?php } ?>

            <div class="paginate mb-4">
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], '/dashboard/orders', '/dashboard/orders');?>
            </div>

        </div>

    </div>

    <?php echo csrf_field();?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<?php
// var_dump($data['paginate']);

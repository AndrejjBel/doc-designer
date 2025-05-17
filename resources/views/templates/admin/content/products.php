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
                                <li class="breadcrumb-item active">Товары</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Товары</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <?php if (count($data['products'])) { ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="table-responsive-sm">
                        <table class="table table-sm table-centered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Заголовок</th>
                                    <th>Автор</th>
                                    <th>Категория</th>
                                    <th>Статус</th>
                                    <th>Дата</th>
                                    <th>Изменен</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['products'] as $key => $product) {
                                    if (usernameId($product['post_author_id'])['first_name']) {
                                        $user_name = usernameId($product['post_author_id'])['first_name'];
                                    } else {
                                        $user_name = usernameId($product['post_author_id'])['username'];
                                    }
                                    $thumb = $product['post_thumb_img'];
                                    if ($thumb) {
                                        $thumb_img = json_decode($thumb, true)[0]['link'];
                                    } else {
                                        $thumb_img = '../public/images/no-images.png';
                                    }
                                    ?>
                                    <tr id="user<?php echo $product['post_id'];?>">
                                        <td><?php echo $product['post_id'];?></td>
                                        <td>
                                            <div class="table-img border rounded-1 overflow-hidden">
                                                <img src="<?php echo $thumb_img;?>" alt="table-user" />
                                            </div>
                                        </td>
                                        <td><?php echo $product['post_title'];?></td>
                                        <td><?php echo $user_name;?></td>
                                        <td><?php echo productCategory(0, $product['post_term']);?></td>
                                        <td><?php echo $product['post_status'];?></td>
                                        <td><?php echo date('d.m.Y', strtotime($product['post_date']));?></td>
                                        <td><?php echo date('d.m.Y', strtotime($product['post_modified']));?></td>
                                        <td>
                                            <a href="<?php echo $product['post_url'];?>" target="_blank" class="text-reset fs-16 px-1" data-state="def" data-id="user<?php echo $user['id']?>" title="Смотреть">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="/dashboard/product-edit?id=<?php echo $product['post_id'];?>" class="text-reset fs-16 px-1 js-user-settings" data-id="user<?php echo $user['id']?>" title="Редактировать">
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
                        <h5 class="page-title">Товаров еще нет</h5>
                    </div>
                </div>
            <?php } ?>

            <div class="paginate mb-4">
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], '/dashboard/products', '/dashboard/products');?>
            </div>

        </div>

    </div>

    <?php echo csrf_field();?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

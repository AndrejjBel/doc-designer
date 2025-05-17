<?php insertTemplate('/templates/header', ['data' => $data]); ?>

<!-- Hero Start -->
<section class="bg-half-100 bg-light d-table w-100">
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title mb-0">Корзина</h4>
                </div>
            </div><!--end col-->
        </div><!--end row-->

        <div class="position-breadcrumb">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="/products">Изделия</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Корзина</li>
                </ul>
            </nav>
        </div>
    </div> <!--end container-->
</section><!--end section-->
<div class="position-relative">
    <div class="shape overflow-hidden text-color-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
<!-- Hero End -->

<!-- Start -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive bg-white shadow rounded products-list">
                    <?php if ($data['posts']) { ?>
                    <table class="table mb-0 table-center">
                        <thead>
                            <tr>
                                <th class="border-bottom py-3" style="min-width:20px "></th>
                                <th class="border-bottom text-start py-3" style="min-width: 300px;">Изделие</th>
                                <th class="border-bottom text-center py-3" style="min-width: 160px;">Цена</th>
                                <th class="border-bottom text-center py-3" style="min-width: 170px;">Количество</th>
                                <th class="border-bottom text-end py-3 pe-4" style="min-width: 160px;">Сумма</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data['posts'] as $post) {
                                $thumb = $post['post_thumb_img'];
                                if ($thumb) {
                                    $thumb_img = json_decode($thumb, true)[0]['link'];
                                } else {
                                    $thumb_img = '../public/images/no-images.png';
                                }
                            ?>
                            <tr class="shop-list" data-id="<?php echo $post['post_id'];?>">
                                <td class="h6 text-center">
                                    <a href="javascript:void(0)" onclick="deleteProductCart(this)" class="text-danger" data-id="<?php echo $post['post_id'];?>">
                                        <i class="uil uil-times"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $thumb_img;?>" class="img-fluid avatar avatar-small rounded shadow" style="height:auto;" alt="">
                                        <a href="<?php echo $post['post_url'];?>">
                                            <h6 class="mb-0 ms-3"><?php echo $post['post_title'];?></h6>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo number_format($post['post_price'], 0, ',', ' ');?> ₽</td>
                                <td class="text-center qty-icons">
                                    <button onclick="productCountCart(this, 'minus')" class="btn btn-icon btn-soft-primary minus">-</button>
                                    <input min="0" name="quantity" value="<?php echo $post['order_count'];?>" type="number" class="btn btn-icon btn-soft-primary qty-btn quantity">
                                    <button onclick="productCountCart(this, 'plus')" class="btn btn-icon btn-soft-primary plus">+</button>
                                </td>
                                <td class="text-end fw-bold pe-4 js-total-price" data-price="<?php echo number_format($post['post_price'], 0, ',', '');?>" data-total="<?php echo $post['post_price']*$post['order_count'];?>">
                                    <span class="total-price"><?php echo number_format($post['post_price']*$post['order_count'], 0, ',', ' ');?></span>
                                    <span>₽</span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                    <table class="table mb-0 table-center">
                        <thead>
                            <tr>
                                <th class="h6 text-center">Корзина пуста</th>
                            </tr>
                        </thead>
                    </table>
                    <?php } ?>
                </div>
            </div><!--end col-->
        </div><!--end row-->
        <div class="row mt-4">
            <div class="col-lg-8 col-md-6">
                <a href="/products" class="btn btn-primary">В каталог изделий</a>
                <!-- <a href="javascript:void(0)" class="btn btn-soft-primary ms-2">Update Cart</a> -->
            </div>
        </div>

        <div class="row mt-4">
            <?php if (!userId()) { ?>
                <form id="user_order" class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Ваше имя <span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="user" class="fea icon-sm icons"></i>
                            <input name="name" id="name" type="text" class="form-control ps-5" placeholder="Имя :">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ваш телефон <span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="phone" class="fea icon-sm icons"></i>
                            <input name="phone" id="phone" class="form-control ps-5 phone_mask" type="text" placeholder="Телефон :" autocomplete="TPWS4H">
                        </div>
                    </div>
                    <?php echo csrf_field();?>
                </form>
            <?php } ?>

            <div class="col-lg-4 col-md-6 ms-auto mt-4 pt-2">
                <div class="table-responsive bg-white rounded shadow">
                    <table class="table table-center table-padding mb-0">
                        <tbody>
                            <!-- <tr>
                                <td class="h6 ps-4 py-3">Subtotal</td>
                                <td class="text-end fw-bold pe-4">$ 2190</td>
                            </tr>
                            <tr>
                                <td class="h6 ps-4 py-3">Taxes</td>
                                <td class="text-end fw-bold pe-4">$ 219</td>
                            </tr> -->
                            <tr class="bg-light">
                                <td class="h6 ps-4 py-3">Итого</td>
                                <td class="text-end fw-bold pe-4"><span class="itog-total"><?php echo number_format(itog_summ($data['posts']), 0, ',', ' ');?></span> ₽</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 pt-2 text-end">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="placeOrder(this)">Заказать</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="toast-container position-fixed top-80 end-0 p-3">
    <div id="placeOrder" class="toast text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="d-flex">
            <div class="toast-body"><strong class="me-auto">Заказ создан</strong>. В ближайшее время с Вами свяжется менеджер.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть" onClick="lrAction();"></button>
        </div>
    </div>

    <div id="noCard" class="toast text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><strong class="me-auto">Ваша корзина пуста</strong></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>
        </div>
    </div>
</div>

<?php
echo csrf_field();
insertTemplate('/templates/footer-pages', ['data' => $data]);

// $po = '[{"id":"16","count":"1"},{"id":"23","count":"6"},{"id":"26","count":"2"},{"id":"27","count":"2"}]';
// $orderList = json_decode($po, true);
// $ids = [];
// foreach ($orderList as $key => $value) {
//     $ids[$value['id']] = $value['count'];
// }

// echo '<pre>';
// var_dump(orderProducts($po));
// echo '</pre>';

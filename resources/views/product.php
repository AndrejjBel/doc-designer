<?php
insertTemplate('/templates/header', ['data' => $data]);
$post = $data['post_data'][0];
$thumb = $post['post_thumb_img'];
if ($thumb) {
    $thumb_img = json_decode($thumb, true)[0]['link'];
} else {
    $thumb_img = '../public/images/no-images.png';
}
$gallery = $post['post_gallery_img'];
if ($gallery) {
    $gallery_img = json_decode($gallery);
} else {
    $gallery_img = false;
}
$add_cart = 0;
if (isset($_COOKIE['ordersProduct'])) {
    $orders = explode(';', $_COOKIE['ordersProduct']);
    foreach ($orders as $value) {
        if ((int)explode('-', $value)[0] == (int)$post['post_id']) {
            $add_cart++;
        }
    }
}
?>

<section class="bg-half-100 bg-light d-table w-100">
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title"><?php echo $post['post_title'];?></h4>
                </div>
            </div>
        </div>

        <div class="position-breadcrumb">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="/products">Изделия</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $post['post_title'];?></li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<div class="position-relative">
    <div class="shape overflow-hidden text-color-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0 order-2 order-md-1">
                <div class="col-12 text-center mb-4">
                    <img src="<?php echo $thumb_img;?>" class="img-fluid rounded" alt="">
                </div>

                <div class="work-detail">
                    <?php echo str_replace('<p>', '<p class="text-muted">', $post['post_content']);?>
                </div>

                <?php if ($gallery_img) { ?>
                <div class="col-md-12 mt-4 pt-2">
                    <div class="tiny-two-item">
                        <?php foreach ($gallery_img as $key => $img) { ?>
                            <div class="tiny-slide">
                                <div class="card border-0 work-container work-primary work-modern position-relative d-block overflow-hidden rounded">
                                    <div class="portfolio-box-img position-relative overflow-hidden">
                                        <img class="item-container img-fluid mx-auto" src="<?php echo $img->link; ?>" alt="1" />
                                        <div class="overlay-work"></div>
                                        <div class="content">
                                            <h5 class="text-white mb-0"><?php echo $post['post_title'];?></h5>
                                            <h6 class="text-white-50 tag mt-1 mb-0"><?php echo productCategory($post['post_term'], 1);?></h6>
                                        </div>
                                        <div class="icons text-center">
                                            <a href="<?php echo $img->link; ?>" class="work-icon bg-white d-inline-flex rounded-pill lightbox"><i data-feather="camera" class="fea icon-sm image-icon"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <div class="card shadow rounded border-0 mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Leave A Comment :</h5>

                        <form class="mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Your Comment</label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="message-circle" class="fea icon-sm icons"></i>
                                            <textarea id="message" placeholder="Your Comment" rows="5" name="message" class="form-control ps-5" required=""></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input id="name" name="name" type="text" placeholder="Name" class="form-control ps-5" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input id="email" type="email" placeholder="Email" name="email" class="form-control ps-5" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="send d-grid">
                                        <button type="submit" class="btn btn-primary">Send Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 order-1 order-md-2 pb-sm-4">
                <div class="sticky-bar work-detail p-4 rounded shadow">
                    <h4 class="title pb-3 border-bottom">Информация :</h4>

                    <ul class="list-unstyled mb-4">
                        <li class="mt-3">
                            <b>Цена :</b>
                            <span id="total" data-price="<?php echo $post['post_price'];?>"><?php echo number_format($post['post_price'], 0, ',', ' ');?></span>₽
                        </li>
                        <li class="mt-3">
                            <b>Категория :</b>
                            <span><?php echo productCategory($post['post_term'], 1);?></span>
                        </li>
                    </ul>

                    <div class="shop-list d-flex flex-wrap flex-row gap-2 justify-content-between mb-4">
                        <?php if ($add_cart) { ?>
                            <button class="btn btn-primary btn-sm fs-14">В корзине</button>
                        <?php } else { ?>
                            <div class="qty-icons">
                                <button onclick="productCount(this, 'minus')" class="btn btn-icon btn-soft-primary minus">-</button>
                                <input min="1" name="quantity" value="1" type="number" class="btn btn-icon btn-soft-primary qty-btn quantity">
                                <button onclick="productCount(this, 'plus')" class="btn btn-icon btn-soft-primary plus">+</button>
                            </div>
                            <button id="add_cart" class="btn btn-primary btn-sm fs-14" data-id="<?php echo $post['post_id'];?>" data-count="1" onclick="addCart(this)">В корзину</button>
                        <?php } ?>
                    </div>

                    <?php if (!$add_cart) { ?>
                        <div class="mt-3">
                            <b>Общая стоимость :</b>
                            <span id="total_price"><?php echo number_format($post['post_price'], 0, ',', ' ');?></span>₽
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="toast-container position-fixed top-80 end-0 p-3">
    <div id="addCartToast" class="toast text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><strong class="me-auto"><?php echo $data['post_data'][0]['post_title'];?></strong> в корзине</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>
        </div>
    </div>
</div>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

// if (is_login()) {
//     echo 'Login';
// } else {
//     echo 'No Login';
// }
// $user = userAllDataMeta();
// echo '<pre>';
// var_dump($user);
// var_dump(get_user_meta($user, 'phone'));
// echo '</pre>';

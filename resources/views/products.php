<?php insertTemplate('/templates/header', ['data' => $data]); ?>

<!-- Hero Start -->
<section class="bg-half-100 bg-light d-table w-100">
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title mb-0"> Изделия </h4>
                </div>
            </div>  <!--end col-->
        </div><!--end row-->

        <div class="position-breadcrumb">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Изделия</li>
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

<!-- News Start -->
<section class="section">
    <div class="container">
        <!-- <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Latest News</h4>
                    <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                </div>
            </div>
        </div> -->

        <div class="row">
            <?php
            foreach ($data['posts_data'] as $key => $post) {
                $thumb = $post['post_thumb_img'];
                if ($thumb) {
                    $thumb_img = json_decode($thumb, true)[0]['link'];
                } else {
                    $thumb_img = '../public/images/no-images.png';
                }
            ?>
                <div class="col-lg-4 col-md-6 mt-4 pt-2">
                    <div class="card blog blog-primary rounded border-0 shadow">
                        <div class="card-img position-relative">
                            <img src="<?php echo $thumb_img;?>" class="card-img-top rounded-top img-fluid" alt="...">
                            <div class="overlay rounded-top"></div>
                        </div>
                        <div class="card-body content">
                            <h5><a href="<?php echo $post['post_url'];?>" class="card-title title text-dark"><?php echo $post['post_title'];?></a></h5>
                            <div class="post-meta d-flex justify-content-between mt-3">
                                <small class="text-muted"><?php echo productCategory('', $post['post_term']);?></small>
                                <a href="<?php echo $post['post_url'];?>" class="text-muted readmore">Подробнее <i class="uil uil-angle-right-b align-middle"></i></a>
                            </div>
                        </div>
                        <div class="author">
                            <!-- <small class="user d-block"><i class="uil uil-user"></i> Calvin Carlo</small> -->
                            <small class="date"><i class="uil uil-calendar-alt"></i><?php echo post_date($post['post_date']);?></small>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div><!--end row-->

        <div class="row">
            <!-- PAGINATION START -->
            <div class="col-12 mt-4 pt-2">
                <?php echo paginat_front($data['cur_page'], $data['pagesCount'], '/products', '/products');?>
            </div>
            <!-- PAGINATION END -->
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
<!-- News End -->
<!-- End Works -->

</div>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

// echo '<pre>';
// var_dump(json_decode($data['posts_data'][10]["post_thumb_img"])[0]->link);
// echo '</pre>';

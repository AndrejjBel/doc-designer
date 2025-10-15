<?php
$reviews = reviews_arr();
if (count($reviews)) {
?>

<div class="container mb-6">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <div class="section-title mb-4 pb-2">
                <h4 class="title mb-4">Отзывы пользователей</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12 pt-2">
            <div class="tiny-three-item">
                <?php foreach ($reviews as $key => $review) { ?>
                    <div class="tiny-slide">
                        <div class="card border-0 text-center bg-transparent">
                            <div class="card-body py-0">
                                <!-- <img src="assets/images/client/01.jpg" class="img-fluid avatar avatar-small rounded-circle mx-auto shadow" alt=""> -->
                                <p class="text-muted mt-4">"<?php echo $review['text']; ?>"</p>
                                <h6 class="text-primary"><?php echo $review['name']; ?></h6>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php }

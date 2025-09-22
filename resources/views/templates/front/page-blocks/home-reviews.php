<?php
$reviews = reviews_arr();
?>
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

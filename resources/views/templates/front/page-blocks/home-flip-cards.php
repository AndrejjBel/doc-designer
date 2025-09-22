<?php
$situations = situations_arr();
?>

<div class="row home-flip-cards">
    <?php foreach ($situations as $key => $situation) { ?>
        <div class="col-md-6 col-lg-4 col-xl-3 mb-4 home-flip-card">
            <div class="flip-card mx-auto">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="../public/images/products-group/<?php echo $situation['img']?>" alt="">
                        <h3 class="flip-card-front-title"><?php echo $situation['title']?></h3>
                        <ul>
                            <?php foreach ($situation['front_items'] as $key => $front_item) { ?>
                                <li data-list="bullet"><?php echo $front_item?></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="flip-card-back bg-secondary bg-gradient">
                        <h3><?php echo $situation['back_items']['title']?></h3>
                        <?php foreach ($situation['back_items']['items'] as $key => $back_items) { ?>
                            <a href="<?php echo $back_items['link']?>"><?php echo $back_items['text']?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

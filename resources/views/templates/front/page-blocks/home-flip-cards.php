<?php
$situations = situations_arr();
$cols = 'col-md-6 col-lg-4 col-xl-3 ';
$flip_card = '';
if ($location == 'calculators') {
    $situations = situations_calc_arr();
    $cols = 'col-md-6 col-lg-4 ';
    $flip_card = ' high';
}
?>

<div class="row home-flip-cards">
    <?php foreach ($situations as $key => $situation) { ?>
        <div class="<?php echo $cols;?>mb-4 home-flip-card">
            <div class="flip-card<?php echo $flip_card;?> mx-auto">
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
                        <?php if ($situation['back_items']['text']) { ?>
                            <p><?php echo $situation['back_items']['text'];?></p>
                        <?php } ?>
                        <?php foreach ($situation['back_items']['items'] as $key => $back_items) { ?>
                            <a href="<?php echo $back_items['link']?>"><?php echo $back_items['text']?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

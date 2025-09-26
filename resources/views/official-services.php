<?php
insertTemplate('/templates/header-home', ['data' => $data]);
$services = services_arr();
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="page-title text-center mb-4 pb-2">
                <h1 class="mb-4">Официальный перечень служб для мониторинга ситуации</h1>
            </div>
        </div>

        <div class="page-content service-items">
            <?php foreach ($services as $key => $service) { ?>
                <div class="d-flex features feature-primary key-feature mb-4 p-3 rounded shadow service-item">
                    <a href="<?php echo $service['link'];?>" class="service-item-link" title="Перейти на сайт"></a>
                    <div class="icon text-center rounded-circle me-3">
                        <img src="/public/images/services/<?php echo $service['img'];?>" alt="">
                    </div>
                    <div class="flex-1">
                        <h3 class="service-item-title mb-0"><?php echo $service['title'];?></h3>
                        <p class="service-item-description"><?php echo $service['text'];?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
insertTemplate('/templates/footer-new', ['data' => $data]);

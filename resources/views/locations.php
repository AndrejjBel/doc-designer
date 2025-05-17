<?php insertTemplate('/templates/header', ['data' => $data]); ?>

<main id="primary" class="site-main mb-5">
    <article class="site-main-article container">
        <div class="site-main-article__top mb-3">
            <div class="site-main-article__top__item title-order d-flex justify-content-between align-items-center">
                <div class="site-main-article__top__item__count">
                    <span>Регионы</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 accordion mb-5" id="buyingquestion">
            <div class="accordion-item rounded">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Выбор региона
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse border-0 collapse" aria-labelledby="headingOne" data-bs-parent="#buyingquestion">
                <div class="accordion-body text-muted">
                    <input id="locSearchPage" class="form-control form-control-sm mb-3" type="text" name="" value="">
                    <ul class="loc-page"></ul>
                </div>
            </div>
        </div>
    </div>

    <div class="locations-items mb-3">
        <?php foreach ($data['locations'] as $key => $item) { ?>
            <div class="card-items loc-item">
                <a href="/location/<?php echo $item['slug']?>" class="loc-item__link"></a>
                <img src="<?php echo json_decode($item['img'], true)[0]['link']?>" class="loc-item__img" alt="">
                <div class="loc-item__text">
                    <div class="loc-item__text__title">
                        <?php echo $item['title']?>
                    </div>
                    <div class="loc-item__text__count">
                        <?php echo tb_num_word($item['count'], array(' глэмпинг', ' глэмпинга', ' глэмпингов'))?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="paginate mb-4">
        <?php echo $data['paginator'];?>
    </div>
</article>
</main>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

// echo '<pre>';
// var_dump($data['locations']);
// echo '</pre>';

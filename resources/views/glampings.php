<?php insertTemplate('/templates/header', ['data' => $data]); ?>

<main id="primary" class="site-main mb-5">
    <article class="site-main-article container">
        <div class="site-main-article__top mb-3">
            <div class="site-main-article__top__item title-order d-flex justify-content-between align-items-center">
                <div class="site-main-article__top__item__count">
                    <span>Найдено глэмпингов: <span class="count-number"><?php echo $data['postsCount']; ?></span></span>
                </div>

                <select class="form-select form-control site-main-article__top__item__order" title="Сортировка" aria-label="Сортировка">
                    <option value="new" selected>По новинкам</option>
                    <option value="popular">По популярности</option>
                    <option value="rating">По рейтингу</option>
                    <option value="price-up">По цене &#8593;</option>
                    <option value="price-down">По цене &#8595;</option>
                </select>
        </div>
    </div>

    <div class="glampings-items mb-3">
        <?php popular_glampings_home($data['glampings']);?>
    </div>

    <div class="paginate mb-4">
        <?php echo $data['paginator'];?>
    </div>
</article>
</main>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

// echo '<pre>';
// var_dump($data['cur_page']);
// echo '</pre>';

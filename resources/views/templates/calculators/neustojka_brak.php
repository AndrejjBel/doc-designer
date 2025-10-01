<?php
insertTemplate('/templates/header-home', ['data' => $data]);
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="page-title text-center mb-4 pb-2">
                <h1 class="mb-4">Калькулятор расчета неустойки <br>за недостаток товара, брак</h1>
            </div>
        </div>
    </div>

        <div class="page-content calculators">
            <h2 class="text-center mb-4">Введите необходимые для расчета данные</h2>

            <form id="calculator-nb" class="mb-5">
                <div class="row flex-column align-items-center justify-content-center">
                    <div class="col-md-6 mb-3">
                        <label for="cena" class="form-label">Цена товара</label>
                        <input id="cena" name="cena" type="number" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="payment_date" class="form-label">Укажите дату оплаты</label>
                        <input id="payment_date" name="payment_date" type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
                    </div>

                    <div class="col-md-6">
                        <label for="current_date" class="form-label">Укажите сегодняшнее число</label>
                        <input id="current_date" name="current_date" type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
                    </div>
                </div>
            </form>

            <div id="calc-btn" class="button d-flex flex-column align-items-center mb-5">
                <button class="btn btn-warning" type="button" name="button" onclick="calculatorNb(this)">Расчитать сейчас</button>
            </div>

            <div class="result d-flex flex-column align-items-center">
                <div class="result-text mb-4">
                    <h3>Расчет неустойки:</h3>
                    <p>Период просрочки: <span class="days-neust fw-bolder"></span> дн.</p>
                    <p>Неустойка по ст. 23, 23.1, 28 ЗоЗПП: 1%</p>

                    <h4>Размер неустойки за каждый день просрочки:</h4>
                    <p><span class="cena-neust"></span> руб. × 1% = <span class="rnd-neust fw-bolder"></span> руб.</p>

                    <h4>Неустойка за все время составляет:</h4>
                    <p><span class="rnd-neust"></span> руб. × <span class="days-neust"></span> дн. = <span class="rnAll-neust fw-bolder"></span> руб.</p>
                </div>

                <a href="#preloaddocBtn" id="preloaddocBtn" class="btn btn-success">Составить претензию</a>
            </div>

            <div id="preload-doc" class="preload-doc mb-5">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column flex-lg-row align-items-center justify-content-center">
                        <div class="pleload-imgs-wrap d-flex flex-column bg-light border border-2 rounded p-3 ms-auto">
                            <div class="pleload-imgs d-flex flex-column">
                                <a href="../public/images/preload/1.png" class="pleload-img rounded lightbox d-inline-block" title="">
                                    <img src="../public/images/preload/1.png" class="img-fluid" alt="">
                                </a>
                                <a href="../public/images/preload/2.png" class="pleload-img rounded lightbox d-inline-block" title="">
                                    <img src="../public/images/preload/2.png" class="img-fluid" alt="">
                                </a>
                                <a href="../public/images/preload/3.png" class="pleload-img rounded lightbox d-inline-block" title="">
                                    <img src="../public/images/preload/3.png" class="img-fluid" alt="">
                                </a>
                                <a href="../public/images/preload/4.png" class="pleload-img rounded lightbox d-inline-block" title="">
                                    <img src="../public/images/preload/4.png" class="img-fluid" alt="">
                                </a>
                                <a href="../public/images/preload/5.png" class="pleload-img rounded lightbox d-inline-block" title="">
                                    <img src="../public/images/preload/5.png" class="img-fluid" alt="">
                                </a>
                                <div class="page-count border">Страница <span>1</span></div>
                            </div>
                        </div>

                        <div class="pleload-imgs-nav d-flex flex-lg-column me-lg-auto">
                            <div class="pleload-imgs-nav-item">
                                <button class="btn btn-primary" type="button" data-page="1" onclick="pleloadImgsNav(this)" disabled>1</button>
                            </div>
                            <div class="pleload-imgs-nav-item">
                                <button class="btn btn-primary" type="button" data-page="2" onclick="pleloadImgsNav(this)">2</button>
                            </div>
                            <div class="pleload-imgs-nav-item">
                                <button class="btn btn-primary" type="button" data-page="3" onclick="pleloadImgsNav(this)">3</button>
                            </div>
                            <div class="pleload-imgs-nav-item">
                                <button class="btn btn-primary" type="button" data-page="4" onclick="pleloadImgsNav(this)">4</button>
                            </div>
                            <div class="pleload-imgs-nav-item">
                                <button class="btn btn-primary" type="button" data-page="5" onclick="pleloadImgsNav(this)">5</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 order-first order-lg-last mb-4 mb-lg-0">
                        <p class="fw-bolder">Если вы обнаружили недостатки в качестве купленного товара, вы имеете право потребовать от продавца вернуть бракованную вещь или обменять её на аналогичную.</p>
                        <p class="fw-bolder">В таком случае ваша претензия должна включать в себя:</p>
                        <ul class="fw-semibold">
                            <li>изложения обстоятельств, при которых была совершена покупка, с указанием ее даты, времени и места;</li>
                            <li>реквизиты товарного или кассового чека (отсутствие платежного документа не является причиной отказа в принятии претензии);</li>
                            <li>описание товара и его основные эксплуатационные характеристики, в том числе серийный номер, артикул и другие данные; описание выявленных недостатков и их влияние на потребительские свойства продукта;</li>
                            <li>предложение к продавцу организовать экспертизу вещи за его счет, в случае сомнений в справедливости ваших утверждений;</li>
                            <li>способ доставки в торговую точку товара большого размера и весом свыше 5 килограмм (согласно законодательству эта обязанность ложится на продавца).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-situation">
                <?php insertTemplate('/templates/front/page-blocks/home-flip-cards', ['location' => 'calculators']); ?>
            </div>
        </div>
    </div>
</div>

<?php

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);

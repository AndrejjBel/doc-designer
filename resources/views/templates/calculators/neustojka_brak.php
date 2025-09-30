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

                <button class="btn btn-success" type="button" name="button">Составить претензию</button>
            </div>
        </div>
    </div>
</div>

<?php

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);

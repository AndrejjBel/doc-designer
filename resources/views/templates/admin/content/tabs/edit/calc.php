<?php
if ($product['calc']) {
    $calc = json_decode($product['calc'], true);
} else {
    $calc = 0;
}
?>
<div class="col-12 mb-3 calc">
    <div class="col-12 col-md-5 col-lg-4">
        <label class="form-label">Калькулятор</label>
        <select class="form-select" name="calc" onchange="calcFieldsActions(this)">
            <option value="0"<?php echo selected(0, ($calc)? $calc['calc'] : 0);?>>Нет калькулятора</option>
            <option value="1"<?php echo selected(1, ($calc)? $calc['calc'] : 0);?>>Неустойка по строительству ДДУ</option>
            <option value="2"<?php echo selected(2, ($calc)? $calc['calc'] : 0);?>>Неустойка за любые услуги (3%)</option>
            <option value="3"<?php echo selected(3, ($calc)? $calc['calc'] : 0);?>>Неустойка за бракованный товар (1%)</option>
            <option value="4"<?php echo selected(4, ($calc)? $calc['calc'] : 0);?>>Неустойка за не поставленный товар (0,5%)</option>
            <option value="5"<?php echo selected(5, ($calc)? $calc['calc'] : 0);?>>Процент за пользование чужими деньгами</option>
        </select>
    </div>
</div>

<div class="row mb-3 calc-fields">
    <h5>Данные для расчета</h5>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Дата начала периода</label>
        <select class="form-select" name="date-start">
            <?php varsForProductOptions($product['vars'], $vars, ($calc)? $calc['dateStart'] : 0);?>
        </select>
    </div>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Дата окончания периода</label>
        <select class="form-select" name="date-end">
            <?php varsForProductOptions($product['vars'], $vars, ($calc)? $calc['dateEnd'] : 0);?>
        </select>
    </div>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Стоимость</label>
        <select class="form-select" name="cost">
            <?php varsForProductOptions($product['vars'], $vars, ($calc)? $calc['cost'] : 0);?>
        </select>
    </div>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Расчет</label>
        <select class="form-select" name="calculation">
            <?php varsForProductOptions($product['vars'], $vars, ($calc)? $calc['calculation'] : 0);?>
        </select>
    </div>
</div>

<?php

// echo '<pre>';
// var_dump($product['calc']);
// echo '</pre>';

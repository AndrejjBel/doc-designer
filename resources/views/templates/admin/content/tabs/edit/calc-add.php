<div class="col-12 mb-3 calc">
    <div class="col-12 col-md-5 col-lg-4">
        <label for="allsit" class="form-label">Калькулятор</label>
        <select class="form-select" name="calc" value="0" onchange="calcFieldsActions(this)">
            <option value="0">Нет калькулятора</option>
            <option value="1">Неустойка по строительству ДДУ</option>
            <option value="2">Неустойка за любые услуги (3%)</option>
            <option value="3">Неустойка за бракованный товар (1%)</option>
            <option value="4">Неустойка за не поставленный товар (0,5%)</option>
            <option value="5">Процент за пользование чужими деньгами</option>
        </select>
    </div>
</div>

<div class="row mb-3 calc-fields">
    <h5>Данные для расчета</h5>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Дата начала периода</label>
        <select class="form-select" name="date-start">
            <option value="0">Выберите переменную</option>
        </select>
    </div>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Дата окончания периода</label>
        <select class="form-select" name="date-end">
            <option value="0">Выберите переменную</option>
        </select>
    </div>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Стоимость</label>
        <select class="form-select" name="cost">
            <option value="0">Выберите переменную</option>
        </select>
    </div>

    <div class="col-12 col-md-6 mb-2">
        <label class="form-label">Расчет</label>
        <select class="form-select" name="calculation">
            <option value="0">Выберите переменную</option>
        </select>
    </div>
</div>

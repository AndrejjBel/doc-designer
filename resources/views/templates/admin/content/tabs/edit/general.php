<?php ?>

<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="title" class="form-label">Наименование <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control" value="<?php echo $product['title'];?>" placeholder="Наименование" required>
        <div id="title" class="invalid-feedback">Заполните Наименование</div>
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label for="group" class="form-label">Родительская группа <span class="text-danger">*</span></label>
        <select class="form-select" name="parentid">
            <?php echo products_group_options($products_gr, $product['parentid']);?>
        </select>
    </div>

    <div class="col-12 mb-3">
        <label for="description" class="form-label">Описание шаблона</label>
        <textarea class="form-control" id="description" name="description" rows="2"><?php echo $product['description'];?></textarea>
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label for="price" class="form-label">Цена</label>
        <input type="number" id="price" name="price" class="form-control" value="<?php echo $product['price'];?>">
    </div>

    <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="active" name="active"<?php echo checked(1, $product['active'])?>>
            <label class="form-check-label" for="active">Показывать на сайте</label>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="favor" name="favor"<?php echo checked(1, $product['favor'])?>>
            <label class="form-check-label" for="favor">Популярный</label>
        </div>
    </div>

    <div class="col-12 calc">
        <div class="col-12 col-md-5 col-lg-4 mb-3">
            <label for="allsit" class="form-label">Калькулятор</label>
            <select class="form-select" name="calc">
                <option value="0"<?php echo selected(0, $product['calc']);?>>Нет калькулятора</option>
                <option value="1"<?php echo selected(1, $product['calc']);?>>Неустойка по строительству ДДУ</option>
                <option value="2"<?php echo selected(2, $product['calc']);?>>Неустойка за любые услуги</option>
                <option value="3"<?php echo selected(3, $product['calc']);?>>Неустойка за бракованный товар</option>
                <option value="4"<?php echo selected(4, $product['calc']);?>>Неустойка за не поставленный товар</option>
                <option value="5"<?php echo selected(5, $product['calc']);?>>Процент за пользование чужими деньгами</option>
            </select>
        </div>
    </div>

    <div class="col-12 col-md-8 mb-3">
        <label for="allsit" class="form-label">Ссылка</label>
        <input type="text" id="allsit" name="allsit" class="form-control" value="<?php echo $product['allsit'];?>">
    </div>

    <div class="col-12 col-md-4 mb-3 d-flex gap-1 align-items-end">
        <a href="<?php echo $product['allsit'];?>" class="btn btn-success" title="Открыть на сайте">
            <i class="bi bi-box-arrow-up-right"></i>
        </a>
    </div>
</div>

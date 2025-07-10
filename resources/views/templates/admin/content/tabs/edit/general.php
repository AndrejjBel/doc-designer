<?php
$seo = json_decode($product['ceo']);
?>

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

    <div class="col-12 col-md-8 mb-3">
        <label for="link" class="form-label">Постоянная ссылка <span class="text-danger">*</span></label>
        <div class="input-group">
            <input
                type="text"
                id="allsit"
                name="allsit"
                class="form-control"
                value="<?php echo $product['allsit'];?>"
                data-post-type="products" 
                data-type="edit"
                onblur="slugUnicActions(this)">
            <a href="/products/<?php echo $product['allsit'];?>" class="btn btn-success" title="Открыть на сайте">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            <div id="title" class="warning-feedback">Ссылка уникализирована</div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label for="seo_title" class="form-label">Seo title</label>
        <textarea class="form-control" id="seo_title" name="seo_title" rows="1" oninput="numberCharacters(this)"><?php echo ($seo)? $seo->title : '';?></textarea>
        <span>Рекомендуемое количество символов <span class="number-characters-rec"><?php echo SITE_NCRST;?></span> / <span class="number-characters-curr text-success">0</span></span>
    </div>

    <div class="col-12 mb-3">
        <label for="seo_description" class="form-label">Seo description</label>
        <textarea class="form-control" id="seo_description" name="seo_description" rows="1" oninput="numberCharacters(this)"><?php echo ($seo)? $seo->description : '';?></textarea>
        <span>Рекомендуемое количество символов <span class="number-characters-rec"><?php echo SITE_NCRSD;?></span> / <span class="number-characters-curr text-success">0</span></span>
    </div>
</div>

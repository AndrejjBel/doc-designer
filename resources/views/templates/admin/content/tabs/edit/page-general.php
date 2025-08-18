<?php
$seo = json_decode($page['seo']);
?>

<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="page_gr" class="form-label">Родительская группа <span class="text-danger">*</span></label>
        <select id="page_gr" class="form-select" name="page_gr" data-pr="<?php echo $page['product_id'];?>" onchange="pageTermChenge(this)">
            <option value="cont_page">Контентная страница</option>
            <?php echo products_group_options($products_gr, $page['terms'], $page['product_id']);?>
        </select>
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label for="product" class="form-label">Шаблон <span class="text-danger">*</span></label>
        <select id="product" class="form-select" name="product_id" onchange="pageProductChenge(this)">
            <option value="0">Выберите шаблон</option>
        </select>
    </div>

    <div class="col-12 mb-3">
        <label for="title" class="form-label">Заголовок <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control" value="<?php echo $page['title'];?>" placeholder="Заголовок" oninput="inputChange(this)">
        <div id="title" class="invalid-feedback">Заполните Заголовок</div>
    </div>

    <!-- <div class="col-12 mb-3">
        <label for="description" class="form-label">Описание страницы</label>
        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
    </div> -->

    <div class="col-12 col-md-8 mb-3">
        <label for="link" class="form-label">Постоянная ссылка <span class="text-danger">*</span></label>
        <div class="input-group">
            <input
                type="text"
                id="link"
                name="link"
                class="form-control"
                value="<?php echo $page['slug'];?>"
                data-post-type="pages"
                data-type="<?php echo ($duplicate)? 'add' : 'edit';?>"
                onblur="slugUnicActions(this)">
            <a href="/<?php echo $page['slug'];?>" class="btn btn-success" title="Открыть на сайте">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            <div id="title" class="warning-feedback">Ссылка уникализирована</div>
        </div>
        <span class="help-block">
            <small>Если оставить пустым, ссылка будет сформирована автоматически</small>
        </span>
    </div>

    <div class="col-12 mb-3">
        <label for="seo_title" class="form-label">Seo title</label>
        <textarea class="form-control" id="seo_title" name="seo_title" rows="1" oninput="numberCharacters(this)"><?php echo $seo->title;?></textarea>
        <span>Рекомендуемое количество символов <span class="number-characters-rec"><?php echo SITE_NCRST;?></span> / <span class="number-characters-curr text-success">0</span></span>
    </div>

    <div class="col-12 mb-3">
        <label for="seo_description" class="form-label">Seo description</label>
        <textarea class="form-control" id="seo_description" name="seo_description" rows="1" oninput="numberCharacters(this)"><?php echo $seo->description;?></textarea>
        <span>Рекомендуемое количество символов <span class="number-characters-rec"><?php echo SITE_NCRSD;?></span> / <span class="number-characters-curr text-success">0</span></span>
    </div>

    <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="active" name="active"<?php echo checked(1, $page['status'])?>>
            <label class="form-check-label" for="active">Показывать на сайте</label>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="favor" name="favor"<?php echo checked(1, $page['favor'])?>>
            <label class="form-check-label" for="favor">Популярная</label>
        </div>
    </div>
</div>

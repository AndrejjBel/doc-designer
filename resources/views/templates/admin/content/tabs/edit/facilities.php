<?php
$post_meta = json_decode($glamping['post_meta'], true);
?>
<div class="row border-bottom border-light-subtle">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">В доме:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="working-hours" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="working-hours d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('facilities_options_home', 'options_home', (array_key_exists('options_home', $post_meta))? $post_meta['options_home'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Ванная комната:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="options_bathroom" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="options_bathroom d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('facilities_options_bathroom', 'options_bathroom', (array_key_exists('options_bathroom', $post_meta))? $post_meta['options_bathroom'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Дети:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="options_children" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="options_children d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('facilities_options_children', 'options_children', (array_key_exists('inoptions_childrenternet', $post_meta))? $post_meta['options_children'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Домашние животные:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="pets" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="pets d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('pets', 'pets', (array_key_exists('pets', $post_meta))? $post_meta['pets'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Интернет:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="internet" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="internet d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('internet', 'internet', (array_key_exists('internet', $post_meta))? $post_meta['internet'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Парковка:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="parking" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="parking d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('parking', 'parking', (array_key_exists('parking', $post_meta))? $post_meta['parking'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Питание:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="nutrition" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="nutrition d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('nutrition', 'nutrition', (array_key_exists('nutrition', $post_meta))? $post_meta['nutrition'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Спальня:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="bedroom" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="bedroom d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('bedroom', 'bedroom', (array_key_exists('bedroom', $post_meta))? $post_meta['bedroom'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Территория:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="glamping_territory" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="glamping_territory d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('glamping_territory', 'territory', (array_key_exists('territory', $post_meta))? $post_meta['territory'] : ''); ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">SPA:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="spa" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="spa d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('spa', 'spa', (array_key_exists('spa', $post_meta))? $post_meta['spa'] : '') ?>
        </div>
    </div>
</div>

<div class="row border-bottom border-light-subtle mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Развлечения:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="entertainment" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="entertainment d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('glamping_entertainment', 'entertainment', (array_key_exists('entertainment', $post_meta))? $post_meta['entertainment'] : '') ?>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Дополнительные услуги:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="additional_features" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="additional_features d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('additional_features', 'additional_features', (array_key_exists('additional_features', $post_meta))? $post_meta['additional_features'] : '') ?>
        </div>
    </div>
</div>

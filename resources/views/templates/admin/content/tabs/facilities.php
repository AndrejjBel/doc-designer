<div class="row border-bottom border-light-subtle">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">В доме:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="working-hours" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="working-hours d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('facilities_options_home', 'options_home') ?>
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
            <?php options_get_checkbox('facilities_options_bathroom', 'options_bathroom') ?>
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
            <?php options_get_checkbox('facilities_options_children', 'options_children') ?>
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
            <?php options_get_checkbox('pets', 'pets') ?>
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
            <?php options_get_checkbox('internet', 'internet') ?>
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
            <?php options_get_checkbox('parking', 'parking') ?>
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
            <?php options_get_checkbox('nutrition', 'nutrition') ?>
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
            <?php options_get_checkbox('bedroom', 'bedroom') ?>
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
            <?php options_get_checkbox('glamping_territory', 'territory') ?>
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
            <?php options_get_checkbox('spa', 'spa') ?>
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
            <?php options_get_checkbox('glamping_entertainment', 'entertainment') ?>
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
            <?php options_get_checkbox('additional_features', 'additional_features') ?>
        </div>
    </div>
</div>

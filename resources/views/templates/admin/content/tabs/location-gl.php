<div class="row border-bottom border-light-subtle">
    <div class="col-12 mb-3">
        <label for="address" class="form-label">Адрес</label>
        <input type="text" name="address" id="address" class="form-control" placeholder="Адрес">
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label for="coordinates" class="form-label">Координаты</label>
        <input type="text" name="coordinates" id="coordinates" class="form-control" placeholder="Координаты">
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label class="form-label">Природа вокруг:</label>
            <a href="javascript: void(0);" class="fs-12" data-check="glamping_nature_around" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="glamping_nature_around d-flex gap-2 flex-wrap">
            <?php options_get_checkbox('glamping_nature_around', 'glamping_nature_around') ?>
        </div>
    </div>
</div>

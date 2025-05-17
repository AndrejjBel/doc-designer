<div class="acc-options accordion" id="accordionExample">
    <div class="accordion-item" data-order="0">
        <h2 class="accordion-header position-relative">
            <button class="accordion-button fw-medium collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#acc-option0"
                aria-expanded="false"
                aria-controls="collapseOne">Вариант размещения</button>
            <button class="btn position-absolute btn-del-acc-option"
                type="button"
                name="button"
                title="Удалить вариант"
                onclick="accDelete(this)">
                <i class="ri-close-circle-line text-danger me-1"></i>
            </button>
        </h2>
        <div id="acc-option0" class="accordion-collapse collapse" data-item="0" data-bs-parent="#accordionExample" style="">
            <div class="accordion-body">
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="acc_type_vision" name="acc_type_vision[]">
                    <label class="form-check-label" for="acc_type_vision">Не показывать этот вариант размещения</label>
                </div>

                <div class="mb-3">
                    <label for="acc_type_title" class="form-label">Название варианта размещения <span class="text-danger">*</span></label>
                    <input type="text"
                        name="acc_type_title[]"
                        id="acc_type_title"
                        class="form-control acc_type_title"
                        placeholder="Добавить заголовок"
                        oninput="accTitle(this)"
                        required>
                    <div id="type_title" class="invalid-feedback">Заполните Название</div>
                </div>

                <div class="mb-3">
                    <label for="acc_type_text" class="form-label">Описание варианта размещения</label>
                    <textarea class="form-control" id="acc_type_text"  name="acc_type_text[]" rows="6"></textarea>
                </div>

                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="acc_type_area" class="form-label">Площадь (кв.м)</label>
                        <input type="text" class="form-control" id="acc_type_area" name="acc_type_area[]">
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="acc_type_places" class="form-label">Мест</label>
                        <input type="text" class="form-control" id="acc_type_places" name="acc_type_places[]">
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="acc_type_price" class="form-label">Цена (минимальная)</label>
                        <div class="input-group">
                            <input type="number" name="acc_type_price[]" id="acc_type_price" class="form-control" placeholder="Цена">
                            <span class="input-group-text">₽</span>
                        </div>
                    </div>
                </div>

                <div class="mb-3 post-gallery">
                    <label class="form-label">Галерея изображений</label>
                    <div class="acc-post-gallery-img d-flex flex-row gap-2 flex-wrap mb-3"></div>
                    <label for="acc_post_gallery-0" class="btn btn-outline-secondary">
                        <span class="spinner-border spinner-border-sm me-1 js-spinner-gallery" role="status" aria-hidden="true"></span>Выбрать изображения</label>
                    <input class="input-upload" type="file" id="acc_post_gallery-0" name="acc_post_gallery-0[]" data-name="acc_post_gallery" onChange="uploadImages(this, form)" value="0" multiple />
                </div>

                <div class="facilities mt-2">
                    <h5 class="facilities mb-3">Удобства</h5>
                    <div class="row border-bottom border-light-subtle">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">В доме:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_options_home" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_options_home d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('facilities_options_home', 'acc_options_home') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Ванная комната:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_options_bathroom" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_options_bathroom d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('facilities_options_bathroom', 'acc_options_bathroom') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Дети:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_options_children" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_options_children d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('facilities_options_children', 'acc_options_children') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Домашние животные:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_pets" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_pets d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('pets', 'acc_pets') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Интернет:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_internet" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_internet d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('internet', 'acc_internet') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Питание:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_nutrition" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_nutrition d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('nutrition', 'acc_nutrition') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Спальня:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_bedroom" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_bedroom d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('bedroom', 'acc_bedroom') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">SPA:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_spa" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_spa d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('spa', 'acc_spa') ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-btn mt-3 text-end">
    <button id="add-acc-option" type="button" class="btn btn-sm btn-outline-success" onclick="accAdd(this)">
        <i class="ri-add-circle-line me-1"></i>
        <span> Добавить вариант</span>
    </button>
    <!-- <button id="add-acc-option" type="button" class="btn btn-primary">Добавить вариант</button> -->
</div>

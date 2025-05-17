<form id="add_location" class="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="location_title" class="form-label">Название региона <span class="text-danger">*</span></label>
        <input type="text" name="location_title" id="location_title" class="form-control" placeholder="Добавить азвание региона" required>
        <div id="title" class="invalid-feedback">Заполните название региона</div>
    </div>

    <div class="mb-3 row">
        <label for="location_link" class="col-sm-2 col-form-label col-form-label-sm">Постоянная ссылка: <span class="text-danger">*</span></label>
        <div class="col-sm-10">
            <input id="location_link" name="location_link" type="text" class="form-control form-control-sm" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="location_description" class="form-label">Описание региона</label>
        <textarea class="form-control" id="location_description"  name="location_description" rows="6"></textarea>
    </div>

    <div class="col-12 col-md-3 mb-3 post-thumbnail">
        <label class="form-label">Картинка региона</label>
        <div class="post-thumbnail-wrap mb-2"></div>
        <!-- <label for="location_thumbnail" class="btn btn-outline-secondary label-upload activate">Выбрать изображение</label> -->
        <label for="location_thumbnail" class="btn btn-outline-secondary label-upload activate">
            <span class="spinner-border spinner-border-sm me-1 js-spinner-thumb" role="status" aria-hidden="true"></span>Выбрать изображение</label>
        <input class="input-upload" type="file" id="location_thumbnail" name="location_thumbnail" onChange="uploadImages(this, form)" value="0" />
    </div>

    <div class="mb-4">
        <label for="post_gallery" class="form-label">SEO Meta тексты</label>
        <div class="accordion" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Изменить Meta тексты
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse p-2" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                    <div class="mb-3">
                        <label for="location_meta_title" class="form-label">Meta Title</label>
                        <input type="text" name="location_meta_title" id="location_meta_title" class="form-control" placeholder="Добавить Title">
                    </div>

                    <div class="mb-3">
                        <label for="location_meta_description" class="form-label">Meta Description</label>
                        <input type="text" name="location_meta_description" id="location_meta_description" class="form-control" placeholder="Добавить Description">
                    </div>

                    <div class="mb-3">
                        <label for="location_meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" name="location_meta_keywords" id="location_meta_keywords" class="form-control" placeholder="Добавить Keywords">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php echo csrf_field();?>
    <button type="submit" name="submit" data-id="0" data-type="add" class="btn btn-primary">Добавить</button>
</form>

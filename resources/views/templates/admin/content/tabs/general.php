<div class="mb-3">
    <label for="post_title" class="form-label">Заголовок <span class="text-danger">*</span></label>
    <input type="text" name="post_title" id="post_title" class="form-control" placeholder="Добавить заголовок" required>
    <div id="title" class="invalid-feedback">Заполните Заголовок</div>
</div>

<div class="mb-3 d-flex gap-3">
    <div class="col-form-label col-form-label-sm"><strong>Постоянная ссылка:</strong></div>
    <div id="post-link" class="col-form-label col-form-label-sm post-link">
        <a href="#"></a>
    </div>
</div>

<div class="row">

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label for="post_term" class="form-label">Регион</label>
        <select class="form-control select2" name="post_term" data-toggle="select2">
            <?php locations();?>
        </select>
    </div>

    <!-- <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label for="post_price" class="form-label">Цена</label>
        <div class="input-group">
            <input type="number" name="post_price" id="post_price" class="form-control" placeholder="Добавить цену">
            <span class="input-group-text">₽</span>
        </div>
    </div> -->

</div>

<!-- <div class="span3">
    <label for="tags" class="form-label">Теги</label>
    <input name="tags" id="tags" class="tagsinput" value="">
    <div id="tagitems" class="card tagitems d-flex gap-1 flex-row flex-wrap flex-grow-1 flex-shrink-1 p-2">
        <div class="tagitems__wrap d-flex gap-1 flex-wrap"></div>
        <div class="tagitems__input d-flex gap-1 flex-row flex-fill">
            <input class="form-control p-1 lh-1 border-0" type="text" id="tag_add" name="tag_add" value="">
        </div>
    </div>
</div> -->

<div class="mb-3">
    <h4 class="fs-16 mt-2">Описание</h4>
    <div id="snow-editor" style="height: 300px; position: relative;" class="ql-container ql-snow"></div>
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
                    <label for="post_meta_title" class="form-label">Meta Title</label>
                    <textarea class="form-control" name="post_meta_title" id="post_meta_title" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label for="post_meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" name="post_meta_description" id="post_meta_description" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label for="post_meta_keywords" class="form-label">Meta Keywords</label>
                    <textarea class="form-control" name="post_meta_keywords" id="post_meta_keywords" rows="2"></textarea>
                </div>
            </div>
        </div>

    </div>
</div>

<?php if ($data['mod'] == 'admin') { ?>
    <div class="col-12 col-md-3 col-lg-3 mb-3">
        <label for="post_status" class="form-label">Статус</label>
        <select class="form-select form-select-sm" id="post_status" name="post_status">
            <option value="publish">Опубликован</option>
            <option value="pending">На утверждении</option>
            <option value="draft">Черновик</option>
            <option value="private">Private</option>
        </select>
    </div>
<?php } ?>

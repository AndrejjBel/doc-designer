<?php
$seo_meta = json_decode($glamping['post_seo'], true);
$post_term_obj = explode(';', $glamping['post_term']);
if (count($post_term_obj) == 2) {
    $post_term = $post_term_obj[1];
} else {
    $post_term = $post_term_obj[0];
}
?>
<div class="mb-3">
    <label for="post_title" class="form-label">Заголовок <span class="text-danger">*</span></label>
    <input type="text" name="post_title" id="post_title" class="form-control" value="<?php echo $glamping['post_title'];?>" placeholder="Добавить заголовок" required>
    <div id="title" class="invalid-feedback">Заполните Заголовок</div>
</div>

<div class="mb-3 d-flex gap-3">
    <div class="col-form-label col-form-label-sm"><strong>Постоянная ссылка:</strong></div>
    <div id="post-link" class="col-form-label col-form-label-sm post-link">
        <a href="<?php echo $glamping['post_url'];?>"><?php echo home_url() . $glamping['post_url'];?></a>
    </div>
</div>

<div class="row">

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label for="post_term" class="form-label">Регион</label>
        <select class="form-control select2" name="post_term" data-toggle="select2">
            <?php locations($post_term); ?>
        </select>
    </div>

</div>

<div class="mb-3">
    <h4 class="fs-16 mt-2">Описание</h4>
    <div id="snow-editor" style="height: 300px; position: relative;" class="ql-container ql-snow"><?php echo $glamping['post_content'];?></div>
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
                    <textarea class="form-control" name="post_meta_title" id="post_meta_title" rows="2"><?php echo $seo_meta['title'];?></textarea>
                </div>

                <div class="mb-3">
                    <label for="post_meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" name="post_meta_description" id="post_meta_description" rows="2"><?php echo $seo_meta['description'];?></textarea>
                </div>

                <div class="mb-3">
                    <label for="post_meta_keywords" class="form-label">Meta Keywords</label>
                    <textarea class="form-control" name="post_meta_keywords" id="post_meta_keywords" rows="2"><?php echo $seo_meta['keywords'];?></textarea>
                </div>
            </div>
        </div>

    </div>
</div>

<?php if ($mod == 'admin') { ?>
    <div class="col-12 col-md-3 col-lg-3 mb-3">
        <label for="post_status" class="form-label">Статус</label>
        <select class="form-select form-select-sm" id="post_status" name="post_status">
            <option value="publish"<?php echo selected('publish', $glamping['post_status']);?>>Опубликован</option>
            <option value="pending"<?php echo selected('pending', $glamping['post_status']);?>>На утверждении</option>
            <option value="draft"<?php echo selected('draft', $glamping['post_status']);?>>Черновик</option>
            <option value="private"<?php echo selected('private', $glamping['post_status']);?>>Private</option>
        </select>
    </div>
<?php } ?>

<?php
$thumb = '';
if (isset($glamping['post_thumb_img'])) {
    $thumb = (count(json_decode($glamping['post_thumb_img'], true)))? json_decode($glamping['post_thumb_img'], true) : '';
}
$gallery = json_decode($glamping['post_gallery_img'], true);
?>
<div class="col-12 col-md-3 mb-3 post-thumbnail">
    <label class="form-label">Основное изображение</label>
    <div class="post-thumbnail-wrap mb-2">
        <?php post_thumbnail_edit_new($thumb);?>
    </div>
    <label for="post_thumbnail" class="btn btn-outline-secondary label-upload">
        <span class="spinner-border spinner-border-sm me-1 js-spinner-thumb" role="status" aria-hidden="true"></span>Выбрать изображение</label>
    <input class="input-upload" type="file" id="post_thumbnail" name="post_thumbnail" onChange="uploadImages(this, form)" value="0" />
</div>

<div class="mb-3 post-gallery">
    <label class="form-label">Галерея изображений</label>
    <div class="post-gallery-img d-flex flex-row gap-2 flex-wrap mb-3">
        <?php post_gallery_edit_new($gallery);?>
    </div>
    <label for="post_gallery" class="btn btn-outline-secondary">
        <span class="spinner-border spinner-border-sm me-1 js-spinner-gallery" role="status" aria-hidden="true"></span>Выбрать изображения</label>
    <input class="input-upload" type="file" id="post_gallery" name="post_gallery[]" onChange="uploadImages(this, form)" value="0" multiple />
</div>

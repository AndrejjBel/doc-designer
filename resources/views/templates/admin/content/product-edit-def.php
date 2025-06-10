<?php
$post = $data['post_data'];
$thumb = $post['post_thumb_img'];
if ($thumb) {
    $thumb_img = json_decode($thumb, true)[0];
} else {
    $thumb_img = '';
}
$gallery = $post['post_gallery_img'];
if ($gallery) {
    $gallery_img = json_decode($gallery, true);
} else {
    $gallery_img = false;
}
?>

<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/dashboard/generale">Консоль</a></li>
                                <li class="breadcrumb-item"><a href="/dashboard/products">Товары</a></li>
                                <li class="breadcrumb-item active">Редактировать товар</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Редактировать товар</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form id="add-edit-product" class="mb-5" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="post_title" class="form-label">Заголовок <span class="text-danger">*</span></label>
                            <input type="text"
                                name="post_title"
                                id="post_title"
                                class="form-control"
                                placeholder="Добавить заголовок"
                                value="<?php echo $post['post_title'];?>"
                                required>
                            <div id="title" class="invalid-feedback">Заполните Заголовок</div>
                        </div>

                        <div class="mb-3 d-flex gap-3">
                            <div class="col-form-label col-form-label-sm"><strong>Постоянная ссылка:</strong></div>
                            <div id="post-link" class="col-form-label col-form-label-sm post-link">
                                <a href="<?php echo $post['post_url'];?>" title="Перейти"><?php echo home_url() . $post['post_url'];?></a>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <label for="post_term" class="form-label">Категория</label>
                                <select class="form-select" id="post_term" name="post_term">
                                    <?php productCategory($post['post_term']);?>
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <label for="post_price" class="form-label">Цена</label>
                                <div class="input-group">
                                    <input type="number" name="post_price" id="post_price" class="form-control" value="<?php echo $post['post_price'];?>" placeholder="Добавить цену">
                                    <span class="input-group-text">₽</span>
                                </div>
                            </div>

                        </div>

                        <div class="span3">
                            <label for="tags" class="form-label">Теги</label>
                            <input name="tags" id="tags" class="tagsinput" value="<?php echo $post['post_tags'];?>">
                            <div id="tagitems" class="card tagitems d-flex gap-1 flex-row flex-wrap flex-grow-1 flex-shrink-1 p-2">
                                <div class="tagitems__wrap d-flex gap-1 flex-wrap"></div>
                                <div class="tagitems__input d-flex gap-1 flex-row flex-fill">
                                    <!-- <div class="btn btn-sm btn-outline-primary p-1 lh-1"><i class="ri-add-fill"></i></div> -->
                                    <input class="form-control p-1 lh-1 border-0" type="text" id="tag_add" name="tag_add" value="">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h4 class="fs-16 mt-2">Описание</h4>
                            <div id="snow-editor" style="height: 300px; position: relative;" class="ql-container ql-snow">
                                <?php echo $post['post_content'];?>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 mb-3 post-thumbnail">
                            <label for="post_thumbnail" class="form-label">Основное изображение</label>
                            <div class="post-thumbnail-wrap mb-2">
                                <?php echo post_thumbnail_edit($thumb_img);?>
                            </div>
                            <label for="post_thumbnail" class="btn btn-outline-secondary label-upload">Выбрать изображение</label>
                            <input class="input-upload" type="file" id="post_thumbnail" name="post_thumbnail" onChange="uploadImages(this, form)" value="0" />
                        </div>

                        <div class="mb-3 post-gallery">
                            <label for="post_gallery" class="form-label">Галерея изображений</label>
                            <div id="images" class="post-gallery-img d-flex flex-row gap-2 flex-wrap mb-3">
                                <?php echo post_gallery_edit($gallery_img);?>
                            </div>
                            <label for="post_gallery" class="btn btn-outline-secondary">Выбрать изображения</label>
                            <input class="input-upload" type="file" id="post_gallery" name="post_gallery[]" onChange="uploadImages(this, form)" value="0" multiple />
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
                                            <input type="text" name="post_meta_title" id="post_meta_title" class="form-control" value="<?php echo $post['post_meta_title'];?>" placeholder="Добавить Title">
                                        </div>

                                        <div class="mb-3">
                                            <label for="post_meta_description" class="form-label">Meta Description</label>
                                            <input type="text" name="post_meta_description" id="post_meta_description" class="form-control" value="<?php echo $post['post_meta_description'];?>" placeholder="Добавить Description">
                                        </div>

                                        <div class="mb-3">
                                            <label for="post_meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" name="post_meta_keywords" id="post_meta_keywords" class="form-control" value="<?php echo $post['post_meta_keywords'];?>" placeholder="Добавить Keywords">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3 mb-3">
                            <label for="post_status" class="form-label">Статус</label>
                            <select class="form-select form-select-sm" id="post_status" name="post_status">
                                <option value="published"<?php echo selected($post['post_status'], 'published');?>>Опубликовано</option>
                                <option value="pending"<?php echo selected($post['post_status'], 'pending');?>>На утверждении</option>
                                <option value="draft"<?php echo selected($post['post_status'], 'draft');?>>Черновик</option>
                                <option value="private"<?php echo selected($post['post_status'], 'private');?>>Private</option>
                            </select>
                        </div>

                        <input type="hidden" name="post_type" value="products">
                        <input type="hidden" name="post_slug" id="post_slug" value="">
                        <?php echo csrf_field();?>
                        <button type="submit" name="submit" data-type="edit"  data-id="<?php echo $post['post_id'];?>" class="btn btn-primary">Обновить</button>
                    </form>

                </div>
            </div>

        </div>

    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $data['br'];?></a></li>
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>/posts">Записи</a></li>
                                <li class="breadcrumb-item active">Добавить запись</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Добавить запись</h4>
                    </div>
                </div>
            </div>

            <form id="add-edit-post" class="mb-5" enctype="multipart/form-data">
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
                        <label for="post_term" class="form-label">Категория</label>
                        <select class="form-control select2" name="post_term" data-toggle="select2">
                            <?php categoryes();?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <h4 class="fs-16 mt-2">Содержание</h4>
                    <div id="snow-editor" style="height: 300px; position: relative;" class="ql-container ql-snow"></div>
                </div>

                <div class="col-12 col-md-3 mb-3 post-thumbnail">
                    <label class="form-label">Основное изображение</label>
                    <div class="post-thumbnail-wrap mb-2"></div>
                    <label for="post_thumbnail" class="btn btn-outline-secondary label-upload">
                        <span class="spinner-border spinner-border-sm me-1 js-spinner-thumb" role="status" aria-hidden="true"></span>Выбрать изображение</label>
                    <input class="input-upload" type="file" id="post_thumbnail" name="post_thumbnail" onChange="uploadImages(this, form)" value="0" />
                </div>

                <div class="mb-3 post-gallery">
                    <label class="form-label">Галерея изображений</label>
                    <div class="post-gallery-img d-flex flex-row gap-2 flex-wrap mb-3"></div>
                    <label for="post_gallery" class="btn btn-outline-secondary">
                        <span class="spinner-border spinner-border-sm me-1 js-spinner-gallery" role="status" aria-hidden="true"></span>Выбрать изображения</label>
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
                            <option value="published">Опубликован</option>
                            <option value="pending">На утверждении</option>
                            <option value="draft">Черновик</option>
                            <option value="private">Private</option>
                        </select>
                    </div>
                <?php } ?>

                <input type="hidden" name="post_type" value="posts">
                <input type="hidden" name="post_slug" id="post_slug" value="">
                <?php echo csrf_field();?>
                <button type="submit" name="submit" data-type="add" data-mod="<?php echo $data['mod'];?>" class="btn btn-primary">Опубликовать</button>
            </form>

        </div>

    </div>

    <?php echo csrf_field();?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<div class="modal fade" id="addPostInfo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Добавление записи</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Советы по добавлению записи</h5>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
            </div>
        </div>
    </div>
</div>

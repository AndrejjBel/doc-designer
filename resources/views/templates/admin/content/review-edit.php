<?php
$post = $data['post'];
$glamping = $data['glamping'];
$gallery = json_decode($post['post_gallery_img'], true);
?>
<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $data['br'];?></a></li>
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>/reviews">Отзывы</a></li>
                                <li class="breadcrumb-item active">Редактировать отзыв</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Редактировать отзыв</h4>
                    </div>
                </div>
            </div>

            <div class="status text-end">
                <h5 class="d-inline-block">Статус:</h5>
                <?php echo post_status($post['post_status']);?>
            </div>

            <form id="add-edit-review" class="mb-5" enctype="multipart/form-data">
                <div class="mb-3">
                    <h4 class="fs-16 mt-2">Отзыв для глэмпинга - <?php echo $glamping['post_title'];?></h4>
                </div>

                <div class="mb-3">
                    <h4 class="fs-16 mt-2">Содержание отзыва</h4>
                    <div id="snow-editor" style="height: 300px; position: relative;" class="ql-container ql-snow"><?php echo $post['post_content'];?></div>
                </div>

                <div class="mb-3 post-gallery">
                    <label class="form-label">Галерея изображений</label>
                    <div class="post-gallery-img d-flex flex-row gap-2 flex-wrap mb-3">
                        <?php post_gallery_edit($gallery);?>
                    </div>
                    <label for="post_gallery" class="btn btn-outline-secondary">
                        <span class="spinner-border spinner-border-sm me-1 js-spinner-gallery" role="status" aria-hidden="true"></span>Выбрать изображения</label>
                    <input class="input-upload" type="file" id="post_gallery" name="post_gallery[]" onChange="uploadImages(this, form)" value="0" multiple />
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-xl-3 mb-3">
                        <label for="post_rating" class="form-label">Рейтинг</label>
                        <input type="number"
                            name="post_rating"
                            id="post_rating"
                            class="form-control"
                            min="0"
                            max="5"
                            value="<?php echo $post['post_rating'];?>"
                            oninput="postRatingChange(this)">
                        <div id="title" class="invalid-feedback">Заполните рейтинг</div>
                    </div>

                    <?php if ($data['mod'] == 'admin') { ?>
                        <div class="col-12 col-md-6 col-xl-3 mb-3">
                            <label for="post_parent" class="form-label">Глэмпинг</label>
                            <select class="form-select select2 select2-sm" id="post_parent" name="post_parent" data-toggle="select2">
                                <?php glampings_select($post['post_parent']);?>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-xl-3 mb-3">
                            <label for="post_author" class="form-label">Автор</label>
                            <select class="form-select select2" id="post_author" name="post_author" data-toggle="select2">
                                <?php users_select($post['post_author']);?>
                            </select>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3 mb-3">
                            <label for="post_status" class="form-label">Статус</label>
                            <select class="form-select select2" id="post_status" name="post_status" data-toggle="select2-hide-search">
                                <option value="published"<?php echo selected('published', $post['post_status']);?>>Опубликован</option>
                                <option value="pending"<?php echo selected('pending', $post['post_status']);?>>На утверждении</option>
                                <option value="draft"<?php echo selected('draft', $post['post_status']);?>>Черновик</option>
                                <option value="private"<?php echo selected('private', $post['post_status']);?>>Private</option>
                            </select>
                        </div>
                    <?php } ?>
                </div>

                <input type="hidden" name="post_type" value="reviews">
                <input type="hidden" name="post_slug" id="post_slug" value="">
                <?php echo csrf_field();?>
                <button type="submit" name="submit"  data-id="<?php echo $post['id'];?>" data-type="edit" data-mod="<?php echo $data['mod'];?>" class="btn btn-primary">Изменить</button>
            </form>

        </div>

    </div>

    <?php //echo csrf_field();?>

    <?php
    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';
    ?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $data['br'];?></a></li>
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>/glampings">Глэмпинги</a></li>
                                <li class="breadcrumb-item active">Добавить глэмпинг</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Добавить глэмпинг</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form id="add-edit-glamping" class="mb-5" enctype="multipart/form-data">
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#general"
                                data-bs-toggle="tab"
                                aria-expanded="false"
                                class="nav-link active">Основное</a>
                            </li>
                            <li class="nav-item">
                                <a href="#characteristics"
                                data-bs-toggle="tab"
                                aria-expanded="true"
                                class="nav-link">Характеристики</a>
                            </li>
                            <li class="nav-item">
                                <a href="#facilities"
                                data-bs-toggle="tab"
                                aria-expanded="true"
                                class="nav-link">Удобства</a>
                            </li>
                            <li class="nav-item">
                                <a href="#location"
                                data-bs-toggle="tab"
                                aria-expanded="false"
                                class="nav-link">Местоположение</a>
                            </li>
                            <li class="nav-item">
                                <a href="#acc-options"
                                data-bs-toggle="tab"
                                aria-expanded="false"
                                class="nav-link">Варианты размещения</a>
                            </li>
                            <li class="nav-item">
                                <a href="#photo"
                                data-bs-toggle="tab"
                                aria-expanded="false"
                                class="nav-link">Фото</a>
                            </li>
                        </ul>

                        <div class="tab-content mb-5">
                            <div class="tab-pane show active" id="general">
                                <?php insertTemplate('/templates/admin/content/tabs/general', ['data' => $data]);?>
                            </div>
                            <div class="tab-pane" id="characteristics">
                                <?php insertTemplate('/templates/admin/content/tabs/characteristics', ['data' => $data]);?>
                            </div>
                            <div class="tab-pane" id="facilities">
                                <?php insertTemplate('/templates/admin/content/tabs/facilities', ['data' => $data]);?>
                            </div>
                            <div class="tab-pane" id="location">
                                <?php insertTemplate('/templates/admin/content/tabs/location-gl', ['data' => $data]);?>
                            </div>
                            <div class="tab-pane" id="acc-options">
                                <?php insertTemplate('/templates/admin/content/tabs/acc-options', ['data' => $data]);?>
                            </div>
                            <div class="tab-pane" id="photo">
                                <?php insertTemplate('/templates/admin/content/tabs/photo', ['data' => $data]);?>
                            </div>
                        </div>

                        <input type="hidden" name="post_type" value="glampings">
                        <input type="hidden" name="post_slug" id="post_slug" value="">
                        <?php echo csrf_field();?>
                        <button type="submit" name="submit" data-type="add" data-mod="<?php echo $data['mod'];?>" class="btn btn-primary">Опубликовать</button>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <?php echo csrf_field();?>
    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

<div class="modal fade" id="addPostInfo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Добавление глэмпинга</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Советы по добавлению глэмпинга</h5>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
            </div>
        </div>
    </div>
</div>

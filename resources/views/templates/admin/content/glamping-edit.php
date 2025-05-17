<?php
$glamping = $data['glamping'];
$mod = $data['mod'];
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
                                <li class="breadcrumb-item active">Добавить глэмпинг</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Редактирование - <?php echo $glamping['post_title']?></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="status text-end">
                        <h5 class="d-inline-block">Статус:</h5>
                        <?php echo post_status($glamping['post_status']);?>
                    </div>
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
                                <?php insertTemplate('/templates/admin/content/tabs/edit/general', ['mod' => $data['mod'], 'glamping' => $data['glamping']]);?>
                            </div>
                            <div class="tab-pane" id="characteristics">
                                <?php insertTemplate('/templates/admin/content/tabs/edit/characteristics', ['glamping' => $data['glamping']]);?>
                            </div>
                            <div class="tab-pane" id="facilities">
                                <?php insertTemplate('/templates/admin/content/tabs/edit/facilities', ['glamping' => $data['glamping']]);?>
                            </div>
                            <div class="tab-pane" id="location">
                                <?php insertTemplate('/templates/admin/content/tabs/edit/location-gl', ['glamping' => $data['glamping']]);?>
                            </div>
                            <div class="tab-pane" id="acc-options">
                                <?php insertTemplate('/templates/admin/content/tabs/edit/acc-options', ['glamping' => $data['glamping']]);?>
                            </div>
                            <div class="tab-pane" id="photo">
                                <?php insertTemplate('/templates/admin/content/tabs/edit/photo', ['glamping' => $data['glamping']]);?>
                            </div>
                        </div>

                        <input type="hidden" name="post_type" value="glampings">
                        <input type="hidden" name="post_id" value="<?php echo $glamping['id'];?>">
                        <input type="hidden" name="post_slug" id="post_slug" value="">
                        <?php echo csrf_field();?>
                        <button type="submit" name="submit" data-id="<?php echo $glamping['id'];?>" data-type="edit" class="btn btn-primary">Обновить</button>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <?php echo csrf_field();?>
    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

    <?php
    // $meta_acc = json_decode($glamping['post_meta_acc'], true);
    // echo '<pre>';
    // var_dump($mod);
    // echo '</pre>';
    ?>

</div>

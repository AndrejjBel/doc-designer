<?php
$post_meta = json_decode($glamping['post_meta'], true);
?>
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="post_term" class="form-label">Тип глэмпинга</label>

        <select class="form-control select2" name="glamping_allocation[]" data-toggle="select2" multiple>
            <?php options_get_new('glamping_allocation', $post_meta['glamping_allocation']);?>
        </select>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label for="post_price" class="form-label">Цена (минимальная)</label>
        <div class="input-group">
            <input type="number" name="post_price" id="post_price" class="form-control" placeholder="Цена" value="<?php echo $glamping['post_price'];?>">
            <span class="input-group-text">₽</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label for="number_nights" class="form-label">Проживание от (количество ночей)</label>
        <input type="number" name="number_nights" id="number_nights" class="form-control" placeholder="Количество ночей" value="<?php echo $post_meta['number_nights'];?>">
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label for="capacity" class="form-label">Вместимость</label>
        <input type="number" name="capacity" id="capacity" class="form-control" placeholder="Вместимость" value="<?php echo $post_meta['capacity'];?>">
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="labels d-flex gap-4">
            <label for="working_hours" class="form-label">Режим работы - сезоны</label>
            <a href="javascript: void(0);" class="fs-12" data-check="working-hours" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
        </div>
        <div class="working-hours d-flex gap-2">
            <?php options_get_checkbox('working_hours', 'working_hours', json_decode($glamping['post_working'], true)) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label class="form-label">Заезд (ч)</label>
        <input type="text" class="form-control" name="checkin_glamping" value="<?php echo $post_meta['checkin_glamping'];?>">
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label class="form-label">Выезд (ч)</label>
        <input type="text" class="form-control" name="checkout_glamping" value="<?php echo $post_meta['checkout_glamping'];?>">
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" class="form-control" name="email_glamping" value="<?php echo $post_meta['email_glamping'];?>">
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label class="form-label">Телефон</label>
        <input type="text" class="form-control phone_mask" name="phone_glamping" value="<?php echo $post_meta['phone_glamping'];?>" placeholder="+7(999) 999-99-99">
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label class="form-label">Сайт</label>
        <input type="email" class="form-control" name="site_glamping" value="<?php echo $post_meta['capacity'];?>">
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <label class="form-label">Партнерская ссылка</label>
        <input type="text" class="form-control" name="affiliate_link" value="<?php echo $post_meta['affiliate_link'];?>">
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-8 mb-3">
        <label class="form-label">Правила бронирования/отмены бронирования</label>
        <textarea class="form-control" id="glc_notes"  name="glc_notes" rows="6"><?php echo $post_meta['glc_notes'];?></textarea>
    </div>
</div>

<div id="product" class="block-content block-product shadow-md rounded-2 py-3 px-4">
    <h4 class="text-center mb-5"><?php echo $data['product']['title'];?></h4>

    <div class="d-flex gap-2 justify-content-between product-btn mb-3">
        <button class="btn btn-sm btn-primary mt-2 mt-md-0"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasFields"
        aria-controls="offcanvasVars">Поля</button>

        <button
            class="btn btn-sm btn-primary mt-2 mt-md-0"
            type="button"
            name="button"
            onclick="payAction(this)">Купить за <?php echo $data['product']['price'];?>руб.</button>
    </div>

    <div class="product-block ql-editor pe-2">
        <?php echo replace_vars_content($data['vars'], $data['product']['descr']);?>
    </div>
</div>

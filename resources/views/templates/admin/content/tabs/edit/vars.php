<div class="d-flex flex-wrap vars-wrap">
    <div class="hc-500 p-2 overflow-hidden  border border-1 rounded-1 vars-wrap-item">
        <div class="vp-title d-flex gap-2 flex-wrap flex-md-nowrap align-items-center justify-content-between border-bottom border-1 pb-2">
            <h5 class="flex-grow-0 flex-shrink-0 mb-0">Выбранные переменные</h5>
        </div>
        <div class="vpw">
            <div class="overflow-auto p-2 vars-product">
                <?php echo vars_for_product_create($varsProduct, $vars, $product_id, $product['vars']);?>
            </div>
        </div>
    </div>
    <div class="hc-500 p-2 overflow-hidden  border border-1 rounded-1 vars-wrap-item">
        <div class="vp-title d-flex gap-2 flex-wrap flex-md-nowrap align-items-center justify-content-between border-bottom border-1 pb-2">
            <h5 class="flex-grow-0 flex-shrink-0 mb-0">Все переменные</h5>
            <div class="input-group">
                <input id="search-vars" type="search" class="form-control form-control-sm" placeholder="Введите текст для поиска">
            </div>
        </div>
        <div class="vpw">
            <div class="overflow-auto p-2 vars-all">
                <?php echo vars_products_create($vars, $varsProduct, $product['vars'], $product_id);?>
            </div>
        </div>
    </div>
</div>

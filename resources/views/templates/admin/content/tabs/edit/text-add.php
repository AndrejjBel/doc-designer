
<div class="d-flex justify-content-between mb-3">
    <h4 class="fs-16 mt-2">Текст шаблона</h4>

    <button class="btn btn-sm btn-primary mt-2 mt-md-0"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasVars"
    aria-controls="offcanvasVars">Переменные</button>
</div>

<div class="d-flex gap-2 mb-3 align-items-center justify-content-end ql-container-height">
    <h5 class="m-0">Высота:</h5>
    <div class="d-flex gap-2">
        <div class="form-check">
            <input type="radio" id="h400" name="ql-container-height" class="form-check-input" value="h400" onclick="radioActions(this)" checked>
            <label class="form-check-label" for="h400">400px</label>
        </div>
        <div class="form-check">
            <input type="radio" id="h600" name="ql-container-height" class="form-check-input" value="h600" onclick="radioActions(this)">
            <label class="form-check-label" for="h600">600px</label>
        </div>
        <div class="form-check">
            <input type="radio" id="h-full" name="ql-container-height" class="form-check-input" value="h-full" onclick="radioActions(this)">
            <label class="form-check-label" for="h-full">Full</label>
        </div>
    </div>
</div>

<div class="mb-3">
    <div id="snow-editor" class="ql-container ql-snow product-descr-form"></div>
</div>

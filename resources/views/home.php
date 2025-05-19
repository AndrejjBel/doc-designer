<?php
insertTemplate('/templates/header', ['data' => $data]);
$userId = userId();

$maintenance = 0;
$site_settings = json_decode(site_settings('site_settings'));
if ($site_settings) {
    if (isset($site_settings->maintenance)) {
        $maintenance = 1;
    }
}
?>

<main>
    <?php if ($maintenance) { ?>
        <h1 class="text-body-emphasis">Сайт на обслуживании</h1>
    <?php } else { ?>
    <h1 class="text-body-emphasis">Генератор текстов</h1>
    <!-- <p class="fs-5 col-md-8">Генератор текстов.</p> -->

    <?php if (is_login()) { ?>

        <form id="genTxt">
            <div class="col-sm-4 mt-2 mb-3">
                <label for="promt" class="form-label">Модель</label>
                <select name="model" class="form-select" aria-label="Модель">
                    <option value="gpt-4o-mini" selected>gpt-4o-mini</option>
                    <option value="gpt-4.1-mini">gpt-4.1-mini</option>
                    <option value="gpt-4.1-nano">gpt-4.1-nano</option>
                    <option value="gpt-3.5-turbo">gpt-3.5-turbo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="promt" class="form-label">Промт</label>
                <textarea id="promt" name="promt" class="form-control" rows="4" cols="80"></textarea>
                <!-- <div id="emailHelp" class="form-text">Мы никогда никому не передадим вашу электронную почту.</div> -->
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Текст</label>
                <textarea id="text" name="text" class="form-control" rows="8" cols="80"></textarea>
            </div>
            <?php echo csrf_field();?>
            <button type="button" class="btn btn-primary">Генерировать</button>
        </form>

        <div class="return-text mt-4"></div>

        <div class="return-cost mt-4"></div>

    <?php } else { ?>

        <div class="mb-5">
            <a href="/login/" class="btn btn-primary btn-lg px-4">Вход</a>
        </div>

    <?php } ?>

    <?php } ?>
</main>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

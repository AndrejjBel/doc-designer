<?php
function replace_vars_content($vars, $content) {
    $vars_title = [];
    $vars_captholder = [];
    $vars_title[] = '#starthide#';
    $vars_title[] = '#endhide#';
    $vars_captholder[] = '<div class="text-blure">';
    $vars_captholder[] = '</div>';
    foreach ($vars as $var) {
        if (!$var['isgr']) {
            $vars_title[] = '#' . $var['title'] . '#';
            $vars_captholder[] = '<span class="fielddok"
            data-id="' . $var['id'] . '"
            data-key="' . $var['title'] . '"
            data-descr="' . $var['descr'] . '"
            data-bs-toggle="modal"
            data-bs-target="#edit-var-text-modal">' . $var['captholder'] . '</span>';
        }
    }
    return str_replace($vars_title, $vars_captholder, $content);
}

function fields_list_content($descr, $prod_vars, $vars) {
    $vars_pr = explode(',', $prod_vars);
    $content = '';
    foreach ($vars_pr as $prod_var) {
        $search = [(int)$prod_var];
        $var = array_shift(array_filter($vars, function($_array) use ($search){
            return in_array($_array['id'], $search);
        }));
        $content .= fields_html($var, $var['title']);
    }
    return $content;
}

function fields_html($var, $name) {
    $options_data = vars_options('typedata_field');
    $label = ($var['descr'])? $var['descr'] : $var['captholder'];
    $phone = '';
    if ($options_data[$var['typedata']][2] == 'phone') {
        $phone = ' phone_mask';
    }
    $content = '';
    if ($options_data[$var['typedata']][0] == 'input') {
        $content .= '<div class="col-12 mb-2">';
        $content .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';
        $content .= '<input type="' . $options_data[$var['typedata']][1] . '"
            id="' . $name . '"
            name="' . $name . '"
            value=""
            class="form-control field-item' . $phone . '"
            placeholder="' . $var['captholder'] . '"
            onblur="fieldFillingForm(this)">';
        $content .= '</div>';
    }
    if ($options_data[$var['typedata']][0] == 'textarea') {
        $content .= '<div class="col-12 mb-2">';
        $content .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';
        $content .= '<textarea class="form-control field-item" id="' . $name . '" name="' . $name . '" value="" rows="2" onblur="fieldFillingForm(this)"></textarea>';
        $content .= '</div>';
    }
    if ($options_data[$var['typedata']][0] == 'label') {
        $content .= '<div class="col-12 var-label">';
        $content .= '<h6 class="product-title">' . $label . '</h6>';
        $content .= '</div>';
    }
    // $content .= '</div>';
    return $content;
}

function fields_list($descr, $vars) {
    preg_match_all("/#(.+?)#/", $descr, $matches);
    $searchArr = [];
    foreach ($matches[0] as $value) {
        $searchArr[] = var_ft($vars, $value);
    }
    return $searchArr;
}

function var_ft($vars, $field_name) {
    $search = [str_replace('#', '', $field_name)];
    $newVars = array_filter($vars, function($_array) use ($search){
        return in_array($_array['title'], $search);
    });
    return $newVars;
}

function order_prod_title($products, $product_id) {
    $search = [$product_id];
    $product = array_shift(array_filter($products, function($_array) use ($search){
        return in_array($_array['id'], $search);
    }));
    return $product['title'];
}

function vars_options($name='') {
    $type = [
        1 => 'Вводится клиентом',
        2 => 'API Запрос в ФССП',
        3 =>'Заголовок'
    ];
    $typedata = [
        1 => 'Текстовое поле',
        2 => 'Цифровое поле',
        3 => 'Выбор даты',
        4 => 'Ввод телефона',
        5 => 'Поле с выбором',
        6 => 'Описание',
        7 => 'Ссылки на документы',
        8 => 'Поле с мультивыбором',
        9 => 'Текстовая надпись'
    ];

    $typedata_field = [
        1 => ['input', 'text', ''],
        2 => ['input', 'number', ''],
        3 => ['input', 'date', ''],
        4 => ['input', 'text', 'phone'],
        5 => ['select', '', ''],
        6 => ['textarea', '', ''],
        7 => ['input', 'text', 'url'],
        8 => ['select', 'multiple', ''],
        9 => ['label', '', '']
    ];
    $result = [];
    if ($name == 'type') {
        $result = $type;
    }
    if ($name == 'typedata') {
        $result = $typedata;
    }
    if ($name == 'typedata_field') {
        $result = $typedata_field;
    }
    return $result;
}

function replace_vars_order_content($vars, $content) {
    $vars_title = [];
    $vars_captholder = [];
    $vars_title[] = '#starthide#';
    $vars_title[] = '#endhide#';
    $vars_captholder[] = '<div class="text-blure">';
    $vars_captholder[] = '</div>';
    foreach ($vars as $key => $val) {
        $vars_title[] = '#' . $key . '#';
        $vars_captholder[] = $val;
    }
    return str_replace($vars_title, $vars_captholder, $content);
}

function blocks_modal_render($arr) {
    $content = '<div class="accordion type-dispute mb-2" id="typeDispute">';
    foreach ($arr as $key => $item) {
        $btn_text = ($item->btn_text)? $item->btn_text : 'Таб ' . $key+1;
        $stages_html = blocks_modal_stages_render($item->stages, $key+1);
        $content .= '<div class="accordion-item acc-item">';
        $content .= '<h2 class="accordion-header position-relative" id="headingOne">
            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tdi' . $key+1 . '" aria-expanded="false" aria-controls="collapseOne">
                <span class="acc-item-title">' . $btn_text . '</span>
                <button class="btn btn-link mx-1 p-0 js-acc-item-delete" type="button" name="button" onclick="accItemDelete(this)" title="Удалить">
                    <i class="ri-delete-bin-line text-danger"></i>
                </button>
            </button>
        </h2>';
        $content .= '<div id="tdi' . $key+1 . '" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#typeDispute" style="">';
        $content .= '<div class="accordion-body">
            <div class="btn_text mb-2">
                <label for="btn_text' . $key+1 . '" class="form-label">Текст кнопки</label>
                <input type="text" id="btn_text' . $key+1 . '" name="btn_text" class="form-control btn_text" value="' . $item->btn_text . '" oninput="accItemTitleAction(this)">
            </div>
            <div class="tab_title mb-2">
                <label for="tab_title' . $key+1 . '" class="form-label">Заголовок таба</label>
                <input type="text" id="tab_title' . $key+1 . '" name="tab_title" class="form-control tab_title" value="' . $item->tab_title . '">
            </div>
            <div class="tab_text mb-2">
                <label for="tab_text" class="form-label">Текст таба</label>
                <textarea class="form-control tab_text" id="tab_text" name="tab_text" rows="4">' . $item->tab_text . '</textarea>
                <span class="help-block">
                <small>Допускается любой HTML</small>
                </span>
            </div>';
        $content .= '<div class="mb-2">
                <label class="form-label">Этапы</label>
                <div class="accordion stages mb-2" id="stages' . $key+1 . '">';
        $content .= $stages_html;
        $content .= '</div>';
        $content .= '<div class="mb-2 text-end">
                    <button type="button" class="btn btn-primary" onclick="addStagesItem(this)">Добавить этап</button>
                </div>
            </div>
        </div>';
        $content .= '</div>';

        $content .= '</div>';
    }
    $content .= '</div>';
    $content .= '<div class="mb-2 text-end">
        <button type="button" class="btn btn-primary" onclick="addAccItem(this)">Добавить таб</button>
    </div>';
    return $content;
}

function blocks_modal_stages_render($stages, $ti) {
    $content = '';
    foreach ($stages as $key => $stage) {
        $btns_html = blocks_modal_stages_btns_render($stage->btnsStages, $ti, $key+1);
        $content .= '<div class="accordion-item stages-item">
                        <h2 class="accordion-header position-relative" id="headingOne">
                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stage' . $ti . $key+1 . '" aria-expanded="false" aria-controls="collapseOne">
                                <span class="stages-item-title">Этап ' . $key+1 . '</span>
                                <button class="btn btn-link mx-1 p-0 js-stages-item-delete" type="button" name="button" onclick="stagesItemDelete(this)" title="Удалить">
                                    <i class="ri-delete-bin-line text-danger"></i>
                                </button>
                            </button>
                        </h2>
                        <div id="stage' . $ti . $key+1 . '" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#stages' . $ti . '" style="">
                            <div class="accordion-body">
                                <div class="stage_text mb-2">
                                    <label for="stage_text1" class="form-label">Текст этапа</label>
                                    <textarea class="form-control stage_text" id="stage_text1" name="stage_text" rows="4">' . $stage->stage_text . '</textarea>
                                    <span class="help-block">
                                    <small>Допускается любой HTML</small>
                                    </span>
                                </div>
                                <div class="stage-buttons mb-2">
                                    <label class="form-label">Кнопки</label>
                                    <div class="accordion mb-2 stage-btns" id="stage-btns' . $ti . $key+1 . '">';
        $content .= $btns_html;
        $content .= '</div>
                        <div class="mb-2 text-end">
                            <button type="button" class="btn btn-primary" onclick="addBtnTab(this)">Добавить кнопку</button>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>';
    }
    return $content;
}

function blocks_modal_stages_btns_render($btns, $ti, $si) {
    $content = '';
    foreach ($btns as $key => $btn) {
        $content .= '<div class="accordion-item stage-btns-item stage-btns-' . $ti . $si . '">
            <h2 class="accordion-header position-relative" id="headingOne">
                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stage-btns' . $ti . $si . $key+1 . '" aria-expanded="false" aria-controls="collapseOne">
                    <span class="stages-item-title">Кнопка ' . $key+1 . '</span>
                    <button class="btn btn-link mx-1 p-0 js-stage-item-delete" type="button" name="button" onclick="stageBtnDelete(this)" title="Удалить">
                        <i class="ri-delete-bin-line text-danger"></i>
                    </button>
                </button>
            </h2>
            <div id="stage-btns' . $ti . $si . $key+1 . '" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#stage-btns' . $ti . $si . '" style="">
                <div class="accordion-body">
                    <div class="stage-buttons-item">
                        <div class="stage_btn_text mb-2">
                            <label for="stage_btn_text' . $si . $key+1 . '" class="form-label">Текст кнопки</label>
                            <input type="text" id="stage_btn_text' . $si . $key+1 . '" name="stage_btn_text" class="form-control stage_btn_text" value="' . $btn->stage_btn_text . '">
                        </div>
                        <div class="stage_btn_link mb-2">
                            <label for="stage_btn_link' . $si . $key+1 . '" class="form-label">Ссылка кнопки</label>
                            <input type="text" id="stage_btn_link' . $si . $key+1 . '" name="stage_btn_link" class="form-control stage_btn_link" value="' . $btn->stage_btn_link . '">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
    return $content;
}

function btnBlokStatus($bloks, $blok_name) {
    $res = '';
    if ($bloks) {
        $bloks_names = array_keys(json_decode($bloks, true));
        if (in_array($blok_name, $bloks_names)) {
            $res = ' disabled';
        }
    }
    echo $res;
}

function btnBloksPageAdmin($bloks) {
    $content = '';
    if ($bloks) {
        $bloks_names = array_keys(json_decode($bloks, true));
        foreach ($bloks_names as $key => $blok) {
            $modalData = 'data-block="' . $blok . '"';
            if ($blok == 'ssi') {
                $modalData = 'data-bs-toggle="modal"
                data-bs-target="#blockContEdit"
                data-block="' . $blok . '"
                onclick="btnContRender(this)"';
            }
            $content .= '<div class="button-block" data-block="' . $blok . '">
                <button type="button" class="btn btn-outline-secondary w-100 text-start btn-blok"
                ' . $modalData . '>
                <strong>' . bloks_names($blok) . '</strong>
                </button>
                <span class="btn-blok-del" data-block="' . $blok . '" title="Удалить блок" onclick="btnBlocksContsDel(this)">
                <i class="ri-delete-bin-line text-danger"></i>
                </span>
                </div>';
        }
    }
    return $content;
}

function bloksPageFront($bloks, $product='', $vars='') {
    $content = '';
    if ($bloks) {
        $blocks = json_decode($bloks, true);
        $bloks_names = array_keys($blocks);
        $fb_name = '';
        foreach ($bloks_names as $key => $blok) {
            if ($blok == 'product') {
                if ($product) {
                    $arg = ['product' => $product, 'vars' => $vars];
                    $content .= template('/templates/front/page-blocks/' . $blok, ['data' => $arg]);
                } else {
                    $content .= '';
                }
            } else {
                $arg = $blocks[$blok];
                $content .= template('/templates/front/page-blocks/' . $blok, ['data' => json_decode($arg)]);
            }
        }
    }
    return $content;
}

function bloks_names($name) {
    $bn = [
        'ssi' => 'Этапы решения вопроса',
        'faq' => 'Faq',
        'product' => 'Шаблон',
        'situations' => 'Ситуации'
    ];
    return $bn[$name];
}

function html_to_pdf($html, $fname) {
    require_once HLEB_GLOBAL_DIR . '/app/Content/dompdf/autoload.inc.php';
    $dompdf = new Dompdf\Dompdf();
    $dompdf->set_option('isRemoteEnabled', true);
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('defaultFont', 'garamond');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->render();

    // Вывод файла в браузер:
    // $dompdf->stream('schet');

    // Или сохранение на сервере:
    $pdf = $dompdf->output();
    // $upload_path = HLEB_GLOBAL_DIR . '/upload/';
    // $file_name = $fname . '.pdf';
    // file_put_contents($upload_path . $file_name, $pdf);

    $uploadsubddir = date('m-Y');
	$uploaddir = HLEB_PUBLIC_DIR . '/uploads/' . $uploadsubddir;
    $file_url = '/public/uploads/' . $uploadsubddir . '/' . $fname . '.pdf';
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777, true );
    $path = $uploaddir . '/' . $fname . '.pdf';
	file_put_contents($path, $pdf);

    return $file_url;
}

function rolesTranslate($name) {
    $roles = [
        'ADMIN' => 'АДМИН',
        'AUTHOR' => 'АВТОР',
        'COLLABORATOR' => 'СОТРУДНИК',
        'CONSULTANT' => 'КОНСУЛЬТАНТ',
        'CONSUMER' => 'ПОТРЕБИТЕЛЬ',
        'CONTRIBUTOR' => 'УЧАСТНИК',
        'COORDINATOR' => 'КООРДИНАТОР',
        'CREATOR' => 'СОЗДАТЕЛЬ',
        'DEVELOPER' => 'РАЗРАБОТЧИК',
        'DIRECTOR' => 'ДИРЕКТОР',
        'EDITOR' => 'РЕДАКТОР',
        'EMPLOYEE' => 'СОТРУДНИК',
        'MAINTAINER' => 'ОБСЛУЖИВАЮЩИЙ',
        'MANAGER' => 'МЕНЕДЖЕР',
        'MODERATOR' => 'МОДЕРАТОР',
        'PUBLISHER' => 'ИЗДАТЕЛЬ',
        'REVIEWER' => 'РЕЦЕНЗЕНТ',
        'SUBSCRIBER' => 'ПОДПИСЧИК',
        'SUPER_ADMIN' => 'СУПЕРАДМИН',
        'SUPER_EDITOR' => 'СУПЕРРЕДАКТОР',
        'SUPER_MODERATOR' => 'СУПЕРМОДЕРАТОР',
        'TRANSLATOR' => 'ПЕРЕВОДЧИК'
    ];
    return $roles[$name];
}

function rolesMaskTranslate($mask) {
    $roles = [
        1 => 'Админ',
        2 => 'Автор',
        4 => 'Сотрудник',
        8 => 'Консультант',
        16 => 'Потребитель',
        32 => 'Участник',
        64 => 'Координатор',
        128 => 'Создатель',
        256 => 'Разработчик',
        512 => 'Директор',
        1024 => 'Редактор',
        2048 => 'Сотрудник',
        4096 => 'Обслуживающий',
        8192 => 'Менеджер',
        16384 => 'Модератор',
        32768 => 'Издатель',
        65536 => 'Рецензент',
        131072 => 'Подписчик',
        262144 => 'Суперадмин',
        524288 => 'Суперредактор',
        1048576 => 'Супермодератор',
        2097152 => 'Переводчик'
    ];

    return $roles[$mask];
}

function scripts_styles_render($script_rend) {
    $script_data = [
        'product' => '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@22.6.0/dist/css/suggestions.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@22.6.0/dist/js/jquery.suggestions.min.js"></script>'
    ];

    if ($script_rend) {
        return $script_data[$script_rend];
    } else {
        return;
    }
}

function custom_styles() {
    $site_settings = json_decode(site_settings('site_settings'));
    $site_styles = '';
    if ($site_settings) {
        if (isset($site_settings->site_styles)) {
            if ($site_settings->site_styles) {
                $site_styles = '<style id="custom-styles">' . compress_css($site_settings->site_styles) . '</style>';
            }
        }
    }
    return $site_styles;
}

function seo_meta($data, $name) {
    $seo_title = $data['title'];
    $seo_description = $data['description'];
    if (array_key_exists('seo', $data['page_data'])) {
        $seo = json_decode($data['page_data']['seo'], true);
        if ($seo['title']) {
            $seo_title = $seo['title'];
        }
        if ($seo['description']) {
            $seo_description = $seo['description'];
        }
    }
    if ($name == 'title') {
        return $seo_title;
    }
    if ($name == 'description') {
        return $seo_description;
    }
}

function compress_css($buffer) {
    $buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer);
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", "  ", "    ", "    "), "", $buffer);
    return $buffer;
}

function compress_js($buffer) {
    $buffer = preg_replace("/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/", "", $buffer);
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", "  ", "    ", "    "), "", $buffer);
    return $buffer;
}

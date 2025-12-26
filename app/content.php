<?php
function replace_vars_content($vars, $content) {
    $vars_title = [];
    $vars_captholder = [];
    $vars_title[] = '#starthide#';
    $vars_title[] = '#endhide#';
    $vars_captholder[] = '<div class="text-blure">';
    $vars_captholder[] = '</div>';
    foreach ($vars as $var) {
        $var_key = $var['title'];
        if ($var['typedata'] == 8) {
            $var_key = $var['title'].'[]';
        }
        if (!$var['isgr']) {
            $vars_title[] = '#' . $var['title'] . '#';
            $vars_captholder[] = '<span class="fielddok"
            data-id="' . $var['id'] . '"
            data-key="' . $var_key . '"
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
        $arf = array_filter($vars, function($_array) use ($search){
            return in_array($_array['id'], $search);
        });
        $var = array_shift($arf);
        // $var = array_shift(array_filter($vars, function($_array) use ($search){
        //     return in_array($_array['id'], $search);
        // }));
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
    if ($options_data[$var['typedata']][0] == 'select') {
        $multiple = '';
        if ($options_data[$var['typedata']][1] == 'multiple') {
            $multiple = ' multiple';
            $name = $name.'[]';
        }
        $options = '';
        foreach (explode(';', $var['extdata']) as $key => $option) {
            $options .= '<option value="' . $option . '">' . $option . '</option>';
        }
        $content .= '<div class="col-12 mb-2">';
        $content .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';
        $content .= '<select class="form-select form-control field-item" name="' . $name . '"' . $multiple . ' onblur="fieldFillingForm(this)">';
        $content .= $options;
        $content .= '</select>';
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
    $arf = array_filter($products, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });
    $product = array_shift($arf);
    return $product['title'];
}

function order_prod_meta($products, $product_id, $meta) {
    $search = [$product_id];
    $arf = array_filter($products, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });
    $product = array_shift($arf);
    return $product[$meta];
}

function prod_meta_fid($products, $product_id, $meta) {
    $search = [$product_id];
    $arf = array_filter($products, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });
    $product = array_shift($arf);
    return $product[$meta];
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
        if (validateDate($val, 'Y-m-d')) {
            $vars_captholder[] = date('d-m-Y', strtotime($val));
        } else {
            $vars_captholder[] = $val;
        }
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

function documents_list($docs, $groups) {
    $groups_parent = [];
    $content = '';
    if (count($docs)) {
        foreach ($groups as $key => $group) {
            $groups_parent[$group['id']] = $group['parentid'];
        }

        foreach ($docs as $key => $doc) {
            $content .= '<div class="documents-list-item col-md-6 col-lg-4 mb-4 pb-2" data-parentid="' . $groups_parent[$doc['parentid']] . '">';
            $content .= '<div class="card blog blog-primary document-card rounded border-0 shadow overflow-hidden p-3">';
            $content .= '<a href="/documents/' . $doc['allsit'] . '" title="Купить за ' . $doc['price'] . 'руб." target="_blanc"></a>';
            $content .= '<h3 class="">' . trim(mb_eregi_replace('[0-9./]', '', $doc['title'])) . '</h1>';
            $content .= '<div class="doc-price text-end fw-bolder text-primary">' . $doc['price'] . 'руб.</div>';
            $content .= '</div>';
            $content .= '</div>';
        }
    }
    return ['content' => $content, 'count' => count($docs)];
}

function documents_list_filtr($docs, $groups) {
    $groups_parent = [];
    $groups_names = [];
    $groups_cur_prod = [];
    $groups_filtr = [];
    $content = '';
    if (count($docs)) {
        foreach ($groups as $key => $group) {
            $groups_parent[$group['id']] = $group['parentid'];
        }

        foreach ($groups as $key => $group) {
            $groups_names[$group['id']] = $group['title'];
        }

        foreach ($docs as $key => $doc) {
            $groups_cur_prod[] = $doc['parentid'];
        }

        foreach (array_unique($groups_cur_prod) as $key => $group) {
            $groups_filtr[$group] = $groups_parent[$group];
        }

        $content .= '<div class="col-12 col-sm-auto mb-3 documents-filtr-item">
        <button class="btn btn-soft-success" type="button" data-groupid="all" onclick="documentsFiltr(this)" disabled>Все документы</button>
        </div>';

        foreach (array_unique($groups_filtr) as $key => $group) {
            $content .= '<div class="col-12 col-sm-auto mb-3 documents-filtr-item">';
            $content .= '<button class="btn btn-soft-secondary" type="button" data-groupid="' . $group . '" onclick="documentsFiltr(this)">';
            $content .= $groups_names[$group];
            $content .= '</button>';
            $content .= '</div>';
        }
    }
    return $content;
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

function all_roles_select() {
    $select_roles = '<select class="form-select" name="role" id="role">
        <option value="0">Выберите роль</option>
        <option value="1">АДМИН</option>
        <option value="2">АВТОР</option>
        <option value="4">СОТРУДНИК</option>
        <option value="8">КОНСУЛЬТАНТ</option>
        <option value="16">ПОТРЕБИТЕЛЬ</option>
        <option value="32">УЧАСТНИК</option>
        <option value="64">КООРДИНАТОР</option>
        <option value="128">СОЗДАТЕЛЬ</option>
        <option value="256">РАЗРАБОТЧИК</option>
        <option value="512">ДИРЕКТОР</option>
        <option value="1024">РЕДАКТОР</option>
        <option value="2048">СОТРУДНИК</option>
        <option value="4096">ОБСЛУЖИВАЮЩИЙ</option>
        <option value="8192">МЕНЕДЖЕР</option>
        <option value="16384">МОДЕРАТОР</option>
        <option value="32768">ИЗДАТЕЛЬ</option>
        <option value="65536">РЕЦЕНЗЕНТ</option>
        <option value="131072" selected>ПОДПИСЧИК</option>
        <option value="262144">СУПЕРАДМИН</option>
        <option value="524288">СУПЕРРЕДАКТОР</option>
        <option value="1048576">СУПЕРМОДЕРАТОР</option>
        <option value="2097152">ПЕРЕВОДЧИК</option>
        <option value="4194304">ЮРИСТ</option>
    </select>';
    return $select_roles;
}

function scripts_styles_render($script_rend) {
    $script_data = [
    'product' => '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@22.6.0/dist/css/suggestions.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@22.6.0/dist/js/jquery.suggestions.min.js"></script>',

    'home' => '
    <link href="/public/assets/libs/tiny-slider/tiny-slider.css" rel="stylesheet">
    <script src="/public/assets/libs/tiny-slider/min/tiny-slider.js"></script>',

    'calculators' => '
    <link href="../public/assets/libs/tobii/css/tobii.min.css" rel="stylesheet">
    <script src="../public/assets/libs/tobii/js/tobii.min.js"></script>',

    'documents' => '
    <script src="../public/js/front/documents.js?ver=' . filemtime( HLEB_GLOBAL_DIR . '/public/js/front/documents.js' ) . '" defer></script>',
    ];

    if ($script_rend) {
        return $script_data[$script_rend];
    } else {
        return;
    }
}

function lawyers_select() {
    $lawyers = get_lawyers();
    $content = '';
    foreach ($lawyers as $key => $lawyer) {
        $name = ($lawyer['fio'])? $lawyer['fio'] : $lawyer['username'];
        $content .= '<option value="' . $lawyer['id'] . '">' . $name . '</option>';
    }
    return $content;
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
    if (array_key_exists('page_data', $data)) {
        if (array_key_exists('seo', $data['page_data'])) {
            $seo = json_decode($data['page_data']['seo'], true);
            if ($seo['title']) {
                $seo_title = $seo['title'];
            }
            if ($seo['description']) {
                $seo_description = $seo['description'];
            }
        }
    }
    if (array_key_exists('product', $data)) {
        if ($data['product']) {
            $seo = json_decode($data['product']['ceo'], true);
            if ($seo['title']) {
                $seo_title = $seo['title'];
            }
            if ($seo['description']) {
                $seo_description = $seo['description'];
            }
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

function num_word($value, $words, $show = true) {
	$num = $value % 100;
	if ($num > 19) {
		$num = $num % 10;
	}
	$out = ($show) ?  $value . ' ' : '';
	switch ($num) {
		case 1:  $out .= $words[0]; break;
		case 2:
		case 3:
		case 4:  $out .= $words[1]; break;
		default: $out .= $words[2]; break;
	}
	return $out;
}

function commentsDocUp($comments, $type) {
    $search = [$type];
    $arf = array_filter($comments, function($_array) use ($search){
        return in_array($_array['type'], $search);
    });
    $comment = $arf;
    return $comment;
}

function lawyersForId($lawyers, $id) {
    $search = [$id];
    $arf = array_filter($lawyers, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });
    $lawyer = array_shift($arf);
    return $lawyer;
}

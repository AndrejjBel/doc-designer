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
            data-bs-target="#edit-var-text-modal">
            <strong>' . $var['captholder'] . '</strong>
            </span>';
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
    $content = '';
    if ($options_data[$var['typedata']][0] == 'input') {
        $content .= '<div class="col-12 mb-2">';
        $content .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';
        $content .= '<input type="' . $options_data[$var['typedata']][1] . '"
            id="' . $name . '"
            name="' . $name . '"
            class="form-control field-item"
            placeholder="' . $var['captholder'] . '"
            oninput="fieldFillingForm(this)">';
        $content .= '</div>';
    }
    if ($options_data[$var['typedata']][0] == 'textarea') {
        $content .= '<div class="col-12 mb-2">';
        $content .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';
        $content .= '<textarea class="form-control field-item" id="' . $name . '" name="' . $name . '" rows="2" oninput="fieldFillingForm(this)"></textarea>';
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

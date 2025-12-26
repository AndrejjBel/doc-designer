<?php
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
        'TRANSLATOR' => 'ПЕРЕВОДЧИК',
        'LAWYER' => 'ЮРИСТ'
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
        2097152 => 'Переводчик',
        4194304 => 'Юрист'
    ];

    return $roles[$mask];
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

function orders_vars($name) {
    $arr = [
        'status' => [
            1 => ['Ожидание оплаты', 'warning'],
            2 => ['Оплачено', 'success'],
            3 => ['Отменен', 'danger']
        ],
        'type' => [
            1 => ['Наличные', 'success'],
            2 => ['Безнал', 'info'],
            3 => ['На карту', 'info'],
            4 => ['Онлайн оплата', 'warning'],
            5 => ['Без оплаты', 'secondary']
        ],
    ];
    return $arr[$name];
}

function doc_orders_status($key) {
    $statuses = [
        1 => ['pending', 'в обработке', 'secondary'],
        2 => ['in_progress', 'в работе', 'info'],
        3 => ['completed', 'готов', 'succes'],
        4 => ['cancelled', 'отменён', 'danger']
    ];
    return $statuses[$key];
}

function doc_orders_status_obj($name, $type='key') {
    $statuses_key = [
        1 => 'pending',
        2 => 'in_progress',
        3 => 'completed',
        4 => 'cancelled'
    ];

    $statuses_name = [
        'pending' => 'ожидает обработки',
        'in_progress' => 'юрист взял в работу',
        'completed' => 'документ отправлен',
        'cancelled' => 'отменён'
    ];

    if ($type == 'key') {
        return $statuses_key[$name];
    } elseif ($type == 'name') {
        return $statuses_name[$name];
    }
}

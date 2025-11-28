<?php

function sections_vars($items) {
    $content = '';
    $active = '';
    $i = 0;
    foreach ($items as $item) {
        if ($i == 0) {
            $content .= '<a href="javascript: void(0);"
                class="list-group-item list-group-item-action border-0 rounded-0 sections-vars-link active"
                data-id="' . $item["id"] . '"
                onclick="sectionsVarsLink(this)">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">' . $item["title"] . '</h5>
                </div>
            </a>';
        } else {
            $content .= '<a href="javascript: void(0);"
                class="list-group-item list-group-item-action border-0 rounded-0 sections-vars-link"
                data-id="' . $item["id"] . '"
                onclick="sectionsVarsLink(this)">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">' . $item["title"] . '</h5>
                </div>
            </a>';
        }
        $i++;
    }
    return $content;
}

function table_vars_group($items, $userRoles=0, $type='') {
    $items_new = array_multisort_value($items, 'title', SORT_ASC);
    $delBtn = '';
    $delBtnPar = '';
    $dataBsTarget = '#modal-vargr-add';
    if ($type == 'products') {
        $dataBsTarget = '#modal-productsgr-add';
    }
    $content = '';
    foreach ($items_new as $item) {
        if ($item['parentid'] == 0) {
            if ($userRoles) {
                if ($userRoles == 'SUPER_ADMIN') {
                    $delBtn = '<a href="javascript: void(0);"
                        class="text-reset fs-16 px-1 ms-1 js-var-delete"
                        data-id="' . $item["id"] . '"
                        data-par="yes"
                        onclick="varsTableDelete(this)"
                        data-bs-toggle="modal"
                        data-bs-target="#delete-var-modal"
                        title="Удалить">
                        <i class="ri-delete-bin-line text-danger"></i>
                    </a>';
                }
            }
            $content .= '<tr id="var' . $item['id'] . '">';
            $content .= '<td>' . $item['id'] . '</td>';
            $content .= '<td id="title' . $item['id'] . '"><a href="/admin/vars/' . $item['id'] . '" class="parent-var-table" title="Перейти">' . $item['title'] . ' (корневая)</a></td>';
            $content .= '<td>' . count_var_root($items_new, $item['id']) . '</td>';
            $content .= '<td>';
            $content .= '<a href="javascript: void(0);"
                class="text-reset fs-16 px-1 js-var-edit"
                data-id="' . $item["id"] . '"
                data-type="' . $type . '"
                onclick="varsTableEdit(this)"
                data-bs-toggle="modal"
                data-bs-target="' . $dataBsTarget . '"
                title="Редактировать">
                <i class="ri-edit-2-line"></i>
            </a>';
            $content .= $delBtn;
            $content .= '</td>';
            $content .= '</tr>';

            foreach ($items_new as $item_par) {
                if ($item_par['parentid'] == $item["id"] && $item_par['isgr'] == 1) {
                    if ($userRoles) {
                        if ($userRoles == 'SUPER_ADMIN') {
                            $delBtnPar = '<a href="javascript: void(0);"
                                class="text-reset fs-16 px-1 ms-1 js-var-delete"
                                data-id="' . $item_par["id"] . '"
                                data-par="no"
                                onclick="varsTableDelete(this)"
                                data-bs-toggle="modal"
                                data-bs-target="#delete-var-modal"
                                title="Удалить">
                                <i class="ri-delete-bin-line text-danger"></i>
                            </a>';
                        }
                    }
                    $content .= '<tr id="var' . $item_par['id'] . '">';
                    $content .= '<td>' . $item_par['id'] . '</td>';
                    $content .= '<td id="title' . $item_par['id'] . '" class="parent-var-title">– ' . $item_par['title'] . '</td>';
                    $content .= '<td>' . count_var($items_new, $item_par['id']) . '</td>';
                    $content .= '<td>';
                    $content .= '<a href="javascript: void(0);"
                        class="text-reset fs-16 px-1 js-var-edit"
                        data-id="' . $item_par["id"] . '"
                        data-type="' . $type . '"
                        onclick="varsTableEdit(this)"
                        data-bs-toggle="modal"
                        data-bs-target="' . $dataBsTarget . '"
                        title="Редактировать">
                        <i class="ri-edit-2-line"></i>
                    </a>';
                    $content .= $delBtnPar;
                    $content .= '</td>';
                    $content .= '</tr>';
                }
            }
        }
    }
    return $content;
}

function table_vars($array, $var_id, $userRoles=0) {
    $delBtn = '';
    $search = [$var_id];
    $items = array_filter($array, function($_array) use ($search){
        return in_array($_array['parentid'], $search);
    });

    $content = '';
    foreach ($items as $key => $item) {
        if ($userRoles) {
            if ($userRoles == 'SUPER_ADMIN') {
                $delBtn = '<a href="javascript: void(0);"
                    class="text-reset fs-16 px-1 ms-1 js-var-delete"
                    data-id="' . $item["id"] . '"
                    onclick="varsTableDelete(this)"
                    data-bs-toggle="modal"
                    data-bs-target="#delete-var-modal"
                    title="Удалить">
                    <i class="ri-delete-bin-line text-danger"></i>
                </a>';
            }
        }
        $content .= '<tr id="var' . $item['id'] . '">';
        $content .= '<td>' . $item['id'] . '</td>';
        $content .= '<td id="title' . $item['id'] . '">' . $item['title'] . '</td>';
        $content .= '<td style="width: 40%;">' . $item['descr'] . '</td>';
        $content .= '<td>' . vars_options('typedata')[$item['typedata']] . '</td>';
        $content .= '<td>';
        $content .= '<a href="javascript: void(0);"
            class="text-reset fs-16 px-1 js-var-edit"
            data-id="' . $item["id"] . '"
            data-bs-toggle="modal"
            data-bs-target="#modal-var-add"
            onclick="varsTableEdit(this)"
            title="Редактировать">
            <i class="ri-edit-2-line"></i>
        </a>';
        $content .= $delBtn;
        $content .= '</td>';
        $content .= '</tr>';
    }
    return $content;
}

function options_vars($items) {
    $content = '';
    foreach ($items as $item) {
        $content .= '<option value="' . $item["id"] . '">' . mb_ucfirst($item['title']) . '</option>';
    }
    return $content;
}

function options_vars_group($items, $gr_id) {
    $items_new = array_multisort_value($items, 'title', SORT_ASC);
    $content = '<option value="no">Выберите группу</option>';
    $content .= '<option value="0">Корневая группа</option>';
    foreach ($items_new as $item) {
        if ($item['parentid'] == 0) {
            if ($gr_id == $item["id"]) {
                $content .= '<option value="' . $item["id"] . '" selected>' . mb_ucfirst($item['title']) . '</option>';
            } else {
                $content .= '<option value="' . $item["id"] . '">' . mb_ucfirst($item['title']) . '</option>';
            }
        }
    }
    return $content;
}

function count_var($vars, $var_id) {
    $count = 0;
    foreach ($vars as $var) {
        if ($var['parentid'] == $var_id) {
            $count++;
        }
    }
    return $count;
}

function count_var_root($vars, $root_id) {
    $parents = [];
    $count = 0;
    foreach ($vars as $var) {
        if ($var['parentid'] == $root_id) {
            $parents[] = $var['id'];
        }
    }
    foreach ($vars as $var_par) {
        if (in_array($var_par['parentid'], $parents)) {
            $count++;
        }
    }
    return $count;
}

function products_group_options($items, $prod_gr=0) {
    $items_new = array_multisort_value($items, 'title', SORT_ASC);
    $content = '';
    foreach ($items_new as $item) {
        if ($item['parentid'] == 0) {
            $content .= '<optgroup label="' . $item['title'] . '">';

            foreach ($items_new as $item_par) {
                if ($item_par['parentid'] == $item["id"] && $item_par['isgr'] == 1) {
                    if ($prod_gr == $item_par['id']) {
                        $content .= '<option value="' . $item_par['id'] . '" selected>' . $item_par['title'] . '</option>';
                    } else {
                        $content .= '<option value="' . $item_par['id'] . '">' . $item_par['title'] . '</option>';
                    }
                }
            }
        }
    }
    $content .= '</optgroup>';
    return $content;
}

function products_group_options_add($items) {
    $items_new = array_multisort_value($items, 'title', SORT_ASC);
    $content = '';
    $content .= '<option value="no">Выберите группу</option>';
    $content .= '<option value="0">Корневая группа</option>';
    foreach ($items_new as $item) {
        if ($item['parentid'] == 0) {
            $content .= '<option value="' . $item['id'] . '">' . $item['title'] . '</option>';
        }
    }
    return $content;
}

function vars_products_create($items, $varsProduct, $vars_prod, $product_id=0) {
    $vars = explode(',', $vars_prod);
    // foreach ($varsProduct as $var) {
    //     $vars[] = $var['varid'];
    // }
    $items_new = array_multisort_value($items, 'title', SORT_ASC);
    $content = '';
    foreach ($items_new as $item) {
        if ($item['parentid'] != 0 && $item['isgr'] == 1) {
            if (count_var($items_new, $item['id'])) {
                $content .= '<div id="cr' . $item['id'] . '" class="gr-vars" data-grid-cr="' . $item['parentid'] . '">';
                $content .= '<div class="h4 mt-2">' . $item['title'] . '</div>';

                foreach ($items_new as $item_par) {
                    if ($item_par['parentid'] == $item["id"] && $item_par['isgr'] == 0) {
                        if (in_array($item_par["id"], $vars)) {
                            $content .= '<button type="button"
                                class="btn btn-outline-secondary w-100 text-start btn-var-prod"
                                data-varid-cr="' . $item_par["id"] . '"
                                data-parid-cr="' . $item_par["parentid"] . '"
                                data-prodid-cr="' . $product_id . '"
                                onclick="btnVarAddProd(this)"
                                disabled>';
                            $content .= '<strong>' . $item_par['title'] . '</strong> - ';
                            $content .= $item_par['descr'];
                            $content .= '</button>';
                        } else {
                            $content .= '<button type="button"
                                class="btn btn-outline-secondary w-100 text-start btn-var-prod"
                                data-varid-cr="' . $item_par["id"] . '"
                                data-parid-cr="' . $item_par["parentid"] . '"
                                data-prodid-cr="' . $product_id . '"
                                onclick="btnVarAddProd(this)">';
                            $content .= '<strong>' . $item_par['title'] . '</strong> - ';
                            $content .= $item_par['descr'];
                            $content .= '</button>';
                        }
                    }
                }
                $content .= '</div>';
            }
        }
    }
    return $content;
}

function vars_for_product_create($varsProduct, $varsArr, $product_id, $vars_prod) {
    // $vars = [];
    // foreach ($varsProduct as $var) {
    //     $vars[] = $var['varid'];
    // }
    $search = explode(',', $vars_prod);
    $newVars = array_filter($varsArr, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });

    $varsArrNew = array_multisort_value($varsArr, 'title', SORT_ASC);
    $items_new = array_multisort_value($newVars, 'title', SORT_ASC);
    $content = '';
    foreach ($varsArrNew as $item) {
        if ($item['parentid'] != 0 && $item['isgr'] == 1) {
            if (count_var($items_new, $item['id'])) {
                $content .= '<div id="pr' . $item['id'] . '" class="gr-vars" data-grid-pr="' . $item['parentid'] . '">';
                $content .= '<div class="h4 mt-2">' . $item['title'] . '</div>';

                foreach ($items_new as $item_par) {
                    if ($item_par['parentid'] == $item["id"]) {
                        $content .= '<button type="button" class="btn btn-outline-secondary w-100 text-start btn-var-prod" data-varid-pr="' . $item_par["id"] . '" data-parid-pr="' . $item_par["parentid"] . '">';
                        $content .= '<strong>' . $item_par['title'] . '</strong> - ';
                        $content .= $item_par['descr'];
                        $content .= '<span class="btn-var-del-prod float-end"
                            data-varid-pr="' . $item_par["id"] . '"
                            data-parid-pr="' . $item['id'] . '"
                            data-prodid-pr="' . $product_id . '"
                            title="Удалить переменную"
                            onclick="btnVarDelProd(this)">
                        <i class="ri-delete-bin-line text-danger"></i>
                        </span>';
                        $content .= '</button>';
                    }
                }
                $content .= '</div>';
            }
        }
    }
    return $content;
}

// Orders
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

function order_vars_html($name, $value) {
    $res = orders_vars($name)[$value];
    return '<span class="badge bg-' . $res[1] . '" data-name="' . $name . '">' . $res[0] . '</span>';
}

function order_upload($order, $products) {
    $document_drafting = config('main', 'document_drafting');
    $parentid = order_prod_meta($products, $order['productid'], 'parentid');
    $res = '<i class="bi bi-envelope"></i>';
    if (in_array($parentid, $document_drafting)) {
        $res = '<i class="bi bi-envelope" title="Документ будет отправлен на почту"></i>';
    } else {
        $res = '<i class="bi bi-download text-danger mx-1"></i>';
        if ($order['status'] == 2) { //  && $order['summ'] == $order['sumpay']
            $res = '<a href="' . $order['doc_url'] . '" class="text-reset fs-16 mx-1" title="Скачать" download>
                <i class="bi bi-download text-success"></i>
            </a>';
        }
    }

    return $res;
}

function ext_user_meta($user, $meta) {
    if ($user) {
        if (in_array($meta, ['phone', 'description'])) {
            $user_meta = json_decode($user['meta'], true);
            return $user_meta[$meta];
        } else {
            return $user[$meta];
        }
    } else {
        return '';
    }
}

function GetPaykLink($payment_data) {
    $site_settings_pay = json_decode(site_settings('site_settings_pay'));

	$user = $site_settings_pay->pay_user;
	$password = $site_settings_pay->pay_pass;

	# Basic-авторизация передаётся как base64
	$base64=base64_encode("$user:$password");
	$headers=Array();
	array_push($headers,'Content-Type: application/x-www-form-urlencoded');

	# Подготавливаем заголовок для авторизации
	array_push($headers,'Authorization: Basic '.$base64);

	# Укажите адрес ВАШЕГО сервера PayKeeper, адрес demo.paykeeper.ru - пример!
	// $server_paykeeper="https://demo.paykeeper.ru";
	$server_paykeeper="https://urist-master.server.paykeeper.ru";

	# Параметры платежа, сумма - обязательный параметр
	# Остальные параметры можно не задавать


	# Готовим первый запрос на получение токена безопасности
	$uri="/info/settings/token/";

	# Для сетевых запросов в этом примере используется cURL
	$curl=curl_init();

	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_URL,$server_paykeeper.$uri);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
	curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($curl,CURLOPT_HEADER,false);

	# Инициируем запрос к API
	$response=curl_exec($curl);
	$php_array=json_decode($response,true);

	# В ответе должно быть заполнено поле token, иначе - ошибка
	if (isset($php_array['token'])) $token=$php_array['token']; else die();


	# Готовим запрос 3.4 JSON API на получение счёта
	$uri="/change/invoice/preview/";

	# Формируем список POST параметров
	$request = http_build_query(array_merge($payment_data, array ('token'=>$token)));

	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_URL,$server_paykeeper.$uri);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($curl,CURLOPT_HEADER,false);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$request);


	$response=json_decode(curl_exec($curl),true);
	# В ответе должно быть поле invoice_id, иначе - ошибка
	if (isset($response['invoice_id'])) $invoice_id = $response['invoice_id']; else die();

	# В этой переменной прямая ссылка на оплату с заданными параметрами
	$link = "$server_paykeeper/bill/$invoice_id/";

	# Теперь её можно использовать как угодно, например, выводим ссылку на оплату
	return $link;

    // Пример
    // $bankrequest['pay_amount'] =  $check['summ'];
    // $bankrequest['clientid'] =  $check['clientname'];
    // $bankrequest['orderid'] =  $check['id'];
    // $bankrequest['client_email'] =  $check['clientemail'];
    // $bankrequest['service_name'] =  $prod['title'];
    // $bankrequest['client_phone'] =  $inp_data['clientphone'];
    // $bankschlink = GetPaykLink($bankrequest);

}

function cmp($a, $b) {
    return strcasecmp($a["title"], $b["title"]);
}

function array_multisort_value() {
	$args = func_get_args();
	$data = array_shift($args);
	foreach ($args as $n => $field) {
		if (is_string($field)) {
			$tmp = array();
			foreach ($data as $key => $row) {
				$tmp[$key] = $row[$field];
			}
			$args[$n] = $tmp;
		}
	}
	$args[] = &$data;
	call_user_func_array('array_multisort', $args);
	return array_pop($args);
}

if(!function_exists('mb_ucfirst')) {
	function mb_ucfirst($str) {
		$fc = mb_strtoupper(mb_substr($str, 0, 1));
		return $fc . mb_substr($str, 1);
	}
}

// encrypt - $code = encryptIt($str, 'your key');
// decrypt - $str = decryptIt($code, 'your key');
function encryptIt($str, $encryption_key=SITE_KEYCODE) {
    $ciphering = "AES-256-CTR";
    $options = 0;
    $encryption_iv = '0123456789abcdef';
    $encryption = openssl_encrypt($str, $ciphering, $encryption_key, $options, $encryption_iv);
    return $encryption;
}

function decryptIt($encryption, $encryption_key=SITE_KEYCODE) {
    $ciphering = "AES-256-CTR";
    $options = 0;
    $encryption_iv = '0123456789abcdef';
    $encryption = openssl_decrypt($encryption, $ciphering, $encryption_key, $options, $encryption_iv);
    return $encryption;
}

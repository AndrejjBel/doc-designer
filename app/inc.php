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

function table_vars_group($items) {
    $items_new = array_multisort_value($items, 'title', SORT_ASC);
    $content = '';
    foreach ($items_new as $item) {
        if ($item['parentid'] == 0) {
            $content .= '<tr id="var' . $item['id'] . '">';
            $content .= '<td>' . $item['id'] . '</td>';
            $content .= '<td id="title' . $item['id'] . '"><a href="/admin/vars/' . $item['id'] . '" class="parent-var-table" title="Перейти">' . $item['title'] . ' (корневая)</a></td>';
            $content .= '<td>' . count_var_root($items_new, $item['id']) . '</td>';
            $content .= '<td>';
            $content .= '<a href="javascript: void(0);"
                class="text-reset fs-16 px-1 js-var-edit"
                data-id="' . $item["id"] . '"
                onclick="varsTableEdit(this)"
                title="Редактировать">
                <i class="ri-edit-2-line"></i>
            </a>';
            $content .= '<a href="javascript: void(0);"
                class="text-reset fs-16 px-1 ms-1 js-var-delete"
                data-id="' . $item["id"] . '"
                data-par="yes"
                onclick="varsTableDelete(this)"
                data-bs-toggle="modal"
                data-bs-target="#delete-var-modal"
                title="Удалить">
                <i class="ri-delete-bin-line text-danger"></i>
            </a>';
            $content .= '</td>';
            $content .= '</tr>';

            foreach ($items_new as $item_par) {
                if ($item_par['parentid'] == $item["id"] && $item_par['isgr'] == 1) {
                    $content .= '<tr id="var' . $item_par['id'] . '">';
                    $content .= '<td>' . $item_par['id'] . '</td>';
                    $content .= '<td id="title' . $item_par['id'] . '" class="parent-var-title">– ' . $item_par['title'] . '</td>';
                    $content .= '<td>' . count_var($items_new, $item_par['id']) . '</td>';
                    $content .= '<td>';
                    $content .= '<a href="javascript: void(0);"
                        class="text-reset fs-16 px-1 js-var-edit"
                        data-id="' . $item_par["id"] . '"
                        onclick="varsTableEdit(this)"
                        title="Редактировать">
                        <i class="ri-edit-2-line"></i>
                    </a>';
                    $content .= '<a href="javascript: void(0);"
                        class="text-reset fs-16 px-1 ms-1 js-var-delete"
                        data-id="' . $item_par["id"] . '"
                        data-par="no"
                        onclick="varsTableDelete(this)"
                        data-bs-toggle="modal"
                        data-bs-target="#delete-var-modal"
                        title="Удалить">
                        <i class="ri-delete-bin-line text-danger"></i>
                    </a>';
                    $content .= '</td>';
                    $content .= '</tr>';
                }
            }
        }
    }
    return $content;
}

function table_vars($array, $var_id) {
    $search = [$var_id];
    $items = array_filter($array, function($_array) use ($search){
        return in_array($_array['parentid'], $search);
    });

    $content = '';
    foreach ($items as $key => $item) {
        $content .= '<tr id="var' . $item['id'] . '">';
        $content .= '<td>' . $item['id'] . '</td>';
        $content .= '<td id="title' . $item['id'] . '">' . $item['title'] . '</td>';
        $content .= '<td style="width: 40%;">' . $item['descr'] . '</td>';
        $content .= '<td>...</td>';
        $content .= '<td>';
        $content .= '<a href="javascript: void(0);"
            class="text-reset fs-16 px-1 js-var-edit"
            data-id="' . $item["id"] . '"
            onclick="varsTableEdit(this)"
            title="Редактировать">
            <i class="ri-edit-2-line"></i>
        </a>';
        $content .= '<a href="javascript: void(0);"
            class="text-reset fs-16 px-1 ms-1 js-var-delete"
            data-id="' . $item["id"] . '"
            onclick="varsTableDelete(this)"
            data-bs-toggle="modal"
            data-bs-target="#delete-var-modal"
            title="Удалить">
            <i class="ri-delete-bin-line text-danger"></i>
        </a>';
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
    // usort($items, "cmp");
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

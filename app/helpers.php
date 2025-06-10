<?php
use Hleb\Static\Request;
use App\Models\{
    ProductsModel,
    VarsModel,
    Admin\AdminModel,
    Myorm\MyormModel,
    User\UsersModel
};

$site_settings = json_decode(site_settings('site_settings'));
define('LIMIT_POSTS_ADMIN', ($site_settings->post_limit_admin)? (int)$site_settings->post_limit_admin : 12);
define('LIMIT_POSTS_FRONT', ($site_settings->post_limit_site)? (int)$site_settings->post_limit_site : 12);
define('SITE_SETTINGS', $site_settings);

/**
 * Gets the URL of the site's main page
 *
 * @param string    $slash_end    Add a slash at the end.
 *
 * home_url() - http(s)://example.com
 * home_url('/') - http(s)://example.com/
*/
function home_url($slash_end='') {
    return request_uri()->getScheme() . '://' . request_uri()->getHost() . $slash_end;
}

function site_settings($option_name) {
    $site_settings = AdminModel::get_site_settings($option_name);
    if ($site_settings) {
        return $site_settings['option_value'];
    } else {
        return $site_settings;
    }
}

function userId() {
    $db = MyormModel::dbc();
    $auth = new \Delight\Auth\Auth($db);
    $user_id = ($auth->getUserId())? $auth->getUserId() : 0;
    return $user_id;
}

function is_login() {
    $db = MyormModel::dbc();
    $auth = new \Delight\Auth\Auth($db);
    $is_login = 0;
    if ($auth->check()) {
    	$is_login = 1;
    }
    $db = null;
	return $is_login;
}

function is_superadmin() {
    $db = MyormModel::dbc();
    $auth = new \Delight\Auth\Auth($db);
    return $auth->hasRole(\Delight\Auth\Role::SUPER_ADMIN);
}

function is_admin_allowed() {
    $db = MyormModel::dbc();
    $auth = new \Delight\Auth\Auth($db);
    return $auth->hasAnyRole(
        \Delight\Auth\Role::ADMIN,
        \Delight\Auth\Role::SUPER_ADMIN
    );
}

function userData($meta) {
    $db = MyormModel::dbc();
    $auth = new \Delight\Auth\Auth($db);
    $user_meta = '';
    if ($meta == 'name') {
        $user_meta = $auth->getUsername();
    }
    return $user_meta;
}

function userAllData() {
    $db = MyormModel::dbc();
    $auth = new \Delight\Auth\Auth($db);
    $id = $auth->getUserId();
    $sth = $db->prepare("SELECT * FROM `users` WHERE `id` = ?");
    $sth->execute(array($id));
    $array = $sth->fetch(PDO::FETCH_ASSOC);
    return $array;
}

function userAllDataMeta() {
    $db = MyormModel::dbc();
    $auth = new \Delight\Auth\Auth($db);
    $id = $auth->getUserId();
    $sth = $db->prepare("SELECT * FROM `users` WHERE `id` = ?");
    $sth->execute([$id]);
    $arr_gen = $sth->fetch(PDO::FETCH_ASSOC);
    $sth = $db->prepare("SELECT `meta` FROM `usermeta` WHERE `user_id` = ?");
    $sth->execute([$id]);
    $arr_meta = $sth->fetch(PDO::FETCH_ASSOC);
    if ($arr_meta) {
        $result = array_merge($arr_gen, $arr_meta);
    } else {
        $result = $arr_gen;
    }
    return $result;
}

function update_user_first_name($user_id, $first_name) {
    $db = MyormModel::dbc();
    $sql = "UPDATE users SET first_name = :first_name WHERE id = :user_id";
    $sth = $db->prepare($sql);
    $sth->bindValue(":user_id", $user_id);
    $sth->bindValue(":first_name", $first_name);
    $sth->execute();
    $ret = (int)$sth->errorInfo()[0];
    return json_encode($ret, JSON_UNESCAPED_UNICODE);
}

function update_user_role_reg($user_id) {
    $db = MyormModel::dbc();
    $sql = "UPDATE users SET roles_mask = :role WHERE id = :user_id";
    $sth = $db->prepare($sql);
    $sth->bindValue(":user_id", $user_id);
    $sth->bindValue(":role", 131072);
    $sth->execute();
    $ret = (int)$sth->errorInfo()[0];
    return json_encode($ret, JSON_UNESCAPED_UNICODE);
}

function update_user_reg_admin($user_id, $first_name, $role) {
    $db = MyormModel::dbc();
    $sql = "UPDATE users SET first_name = :first_name, roles_mask = :role WHERE id = :user_id";
    $sth = $db->prepare($sql);
    $sth->bindValue(":user_id", $user_id);
    $sth->bindValue(":first_name", $first_name);
    $sth->bindValue(":role", $role);
    $sth->execute();
    $ret = (int)$sth->errorInfo()[0];
    // echo json_encode($ret, JSON_UNESCAPED_UNICODE);
}

function update_user($user_id, $email, $first_name, $role) {
    $db = MyormModel::dbc();
    $sql = "UPDATE users SET email = :email, first_name = :first_name, roles_mask = :roles_mask WHERE id = :user_id";
    $sth = $db->prepare($sql);
    $sth->bindValue(":user_id", $user_id);
    $sth->bindValue(":email", $email);
    $sth->bindValue(":first_name", $first_name);
    $sth->bindValue(":roles_mask", $role);
    $sth->execute();
    // $ret = (int)$sth->errorInfo()[0];
    // echo json_encode($ret, JSON_UNESCAPED_UNICODE);
}

function unicUsername($username) {
    $db = MyormModel::dbc();
    $sql = "SELECT * FROM users WHERE username=:username";
    $sth = $db->prepare($sql);
    $sth->bindValue(":username", $username);
    $sth->execute();
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function unicUserEmail($email) {
    $db = MyormModel::dbc();
    $sql = "SELECT * FROM users WHERE email=:email";
    $sth = $db->prepare($sql);
    $sth->bindValue(":email", $email);
    $sth->execute();
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function unicValue($table, $key, $link) {
    $db = MyormModel::dbc();
    $sql = "SELECT $key FROM $table WHERE $key LIKE :value";
    $sth = $db->prepare($sql);
    $sth->bindValue(":value", $link.'%');
    $sth->execute();
    $user = $sth->fetchAll(PDO::FETCH_COLUMN);
    return $user;
}

function usernameId($user_id) {
    $db = MyormModel::dbc();
    $sql = "SELECT username, first_name FROM users WHERE id=:user_id";
    $sth = $db->prepare($sql);
    $sth->bindValue(":user_id", $user_id);
    $sth->execute();
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function get_user_meta($user, $user_meta) {
    $meta = '';
    if (array_key_exists('meta', $user)) {
        $meta = json_decode($user['meta'], true);
    }
    if ($meta) {
        if (array_key_exists($user_meta, $meta)) {
            return $meta[$user_meta];
        }
    } else {
        return $meta;
    }
}

function user_meta($role_value) {
    return \Delight\Auth\Role::getMap()[$role_value];
}

function rolesOptions() {
	$out = [];
	foreach (\Delight\Auth\Role::getMap() as $roleValue => $roleName) {
		$out[$roleValue] = $roleName;
	}
	return $out;
}

function createRolesOptions($defolt='Нет роли', $value=0) {
	$out = '';
    $out .= '<option value="0">' . $defolt . '</option>';
	foreach (\Delight\Auth\Role::getMap() as $roleValue => $roleName) {
        if ($roleValue == $value) {
            $out .= '<option value="' . $roleValue . '" selected>' . $roleName . '</option>';
        } else {
            $out .= '<option value="' . $roleValue . '">' . $roleName . '</option>';
        }
	}
	return $out;
}

function orderProducts($productsArr, $ret=1){
    $productsList = json_decode($productsArr, true);
    $prod_id = [];
    foreach ($productsList as $key => $value) {
        $prod_id[] = $value['id'];
    }

    $prod_id_count = [];
    foreach ($productsList as $key => $value) {
        $prod_id_count[$value['id']] = $value['count'];
    }
    $products = PostModel::getPostsForId(implode(',', $prod_id));
    $products_data_cart = [];
    foreach ($products as $key => $product) {
        if (in_array($product['post_id'], $prod_id)) {
            $product['count'] = (int)$prod_id_count[(int)$product['post_id']];
        }
        $products_data_cart[] = $product;
    }
    if ($ret) {
        foreach ($products_data_cart as $key => $product) {
            echo $key+1 . '. ' . $product['post_title'] . ' - ' . $product['count'] . 'шт.<br>';
        }
    } else {
        return $products_data_cart;
    }
}

function warning_value($value) {
    $warn = [
        'email' => 'Неверный адрес электронной почты', // 'Invalid email address',
        'password' => 'Неверный пароль', // 'Invalid password',
        'email_exists' => 'Пользователь с таким E-mail уже существует', // 'User already exists',
        'username_exists' => 'Пользователь с таким Логином уже существует',
        'username_novalid' => 'Логин может состоять из латинских букв и цифр, символов "_" и "-", начало и окончание буква',
        'pryvasi' => 'Необходимо принять условия и положения',
        'many_requests' => 'Слишком много запросов', // 'Too many requests'
    ];
    return $warn[$value];
}

function productCategory($value=0, $return=0) {
    $category = [
        'uncategorized' => 'Без категории',
        '1' => 'Первая категория',
        '2' => 'Вторая категория',
        '3' => 'Третья категория',
    ];
    if ($return) {
        return $category[$return];
    } else {
        foreach ($category as $key => $cat) {
            echo '<option value="' . $key . '"' . selected($value, $key) . '>' . $cat . '</option>';
        }
    }
}

function pagination($pNum, $pagesCount, $sheet, $other, $sign = '?', $sort = null) {
    if ($pNum > $pagesCount) {
        return null;
    }

    $other = empty($other) ? '' : $other;
    $first = empty($other) ? '/' : $other;

    $page = $other . '';
    if (in_array($sheet, ['all', 'questions', 'posts', 'products'])) {
        $page  = $other . '/' . $sheet;
    }

    $html = '<div class="flex gap">';

    if ($pNum != 1) {
        if (($pNum - 1) == 1) {
            $html .= '<a class="p5" href="' . $first . $sort . '"><< Страница ' . ($pNum - 1) . '</a>';
        } else {
            $html .= '<a class="p5" href="' . $page . $sign . 'page=' . ($pNum - 1) . $sort . '"><< Страница ' . ($pNum - 1) . '</a>';
        }
    }

    if ($pagesCount > $pNum) {
        $html .= '<div class="bg-blue p5-10 white">' . ($pNum) . '</div>';
    }

    if ($pagesCount > $pNum) {
        if ($pagesCount > $pNum + 1) {
            $html .= '<a class="p5" href="' . $page . $sign . 'page=' . ($pNum + 1) . $sort . '"> ' . ($pNum + 1) . ' </a>';
        }

        if ($pagesCount > $pNum + 2) {
            $html .= '<a class="p5" href="' . $page . $sign . 'page=' . ($pNum + 2) . $sort . '"> ' . ($pNum + 2) . '</a>';
        }

        if ($pagesCount > $pNum + 2) {
            $html .= '...';
        }

        $html .= '<a class="p5 lowercase gray-600" href="' . $page . $sign . 'page=' . ($pNum + 1) . $sort . '">Страница ' . ($pNum + 1) . ' >></a>';
    }

    $html .= '</div>';

    return $html;
}

function paginat_admin($pNum, $pagesCount, $sheet, $other, $sign='?page=') {
    if ($pagesCount <= 1 ) {
        return null;
    }
    $html = '<ul class="pagination mb-0">';
    if ($pNum > 1) {
        if ($pNum == 2) {
            $html .= '<li class="page-item">
                <a class="page-link" href="' . $other . '" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>';
        } else {
            $html .= '<li class="page-item">
                <a class="page-link" href="' . $sheet . $sign . $pNum-1 . '" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>';
        }
    }
    for ($i=1; $i <= $pagesCount; $i++) {
        if ($pNum == $i) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            if ($i == 1) {
                $html .= '<li class="page-item"><a class="page-link" href="' . $other . '">1</a></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . $sheet . $sign . $i . '">' . $i . '</a></li>';
            }
        }
    }
    if ($pNum < $pagesCount) {
        $html .= '<li class="page-item">
            <a class="page-link" href="' . $sheet . $sign . $pNum+1 . '" aria-label="Next">
                <span aria-hidden="true">»</span>
            </a>
        </li>';
    }
    $html .= '</ul>';
    return $html;
}

function paginat_front($pNum, $pagesCount, $sheet, $other, $sign='?page=') {
    if ($pagesCount <= 1 ) {
        return null;
    }
    $html = '<ul class="pagination justify-content-center mb-0">';
    if ($pNum > 1) {
        if ($pNum == 2) {
            $html .= '<li class="page-item">
                <a class="page-link" href="' . $other . '" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>';
        } else {
            $html .= '<li class="page-item">
                <a class="page-link" href="' . $sheet . $sign . $pNum-1 . '" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                </a>
            </li>';
        }
    }
    for ($i=1; $i <= $pagesCount; $i++) {
        if ($pNum == $i) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            if ($i == 1) {
                $html .= '<li class="page-item"><a class="page-link" href="' . $other . '">1</a></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . $sheet . $sign . $i . '">' . $i . '</a></li>';
            }
        }
    }
    if ($pNum < $pagesCount) {
        $html .= '<li class="page-item">
            <a class="page-link" href="' . $sheet . $sign . $pNum+1 . '" aria-label="Next">
                <span aria-hidden="true">»</span>
            </a>
        </li>';
    }
    $html .= '</ul>';
    return $html;
}

function pageNumber() {
    $page = Request::get('page')->value();
    $pageNumber = (int)$page ?? null;
    return $pageNumber <= 1 ? 1 : $pageNumber;
}

function translit_sef($value) {
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

		'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
		'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
		'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
		'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
		'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
		'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
		'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
	);
	$value = strtr($value, $converter);
    $value = str_replace(' ', '_', $value);
	return $value;
}

function translit_friendly_url($value) {
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
	);
	$value = mb_strtolower($value);
	$value = strtr($value, $converter);
	$value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
	$value = mb_ereg_replace('[-]+', '-', $value);
	$value = trim($value, '-');
	return $value;
}

function translit_file($filename) {
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

		'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
		'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
		'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
		'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
		'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
		'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
		'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
	);
	$new = '';
	$file = pathinfo(trim($filename));
	if (!empty($file['dirname']) && @$file['dirname'] != '.') {
		$new .= rtrim($file['dirname'], '/') . '/';
	}
	if (!empty($file['filename'])) {
		$file['filename'] = str_replace(array(' ', ','), '-', $file['filename']);
		$file['filename'] = strtr($file['filename'], $converter);
		$file['filename'] = mb_ereg_replace('[-]+', '-', $file['filename']);
		$file['filename'] = trim($file['filename'], '-');
		$new .= $file['filename'];
	}
	if (!empty($file['extension'])) {
		$new .= '.' . $file['extension'];
	}
	return $new;
}

function gen_password($length = 6) {
	$chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP#&$';
	$size = strlen($chars) - 1;
	$password = '';
	while($length--) {
		$password .= $chars[random_int(0, $size)];
	}
	return $password;
}

function check($s) {
    $len = strlen($s);
    if ($len < 3 || $len > 15)
        return false;
    if (!preg_match("/^[a-z0-9][a-z0-9-_]+[a-z0-9]$/is", $s))
        return false;
    foreach (["--", "__", "-_", "_-"] as $v)
        if (strpos($s, $v))
            return false;
    return true;
}

function post_date($post_date) {
    $d = date('d', strtotime($post_date));
    $m = date_month_locale(date('n', strtotime($post_date)));
    $y = date('Y', strtotime($post_date));
    $date = $d . ' ' . $m . ' ' . $y;
    return $date;
}

function date_month_locale($mn) {
    $month_list = [
        1  => 'января',
        2  => 'февраля',
        3  => 'марта',
        4  => 'апреля',
        5  => 'мая',
        6  => 'июня',
        7  => 'июля',
        8  => 'августа',
        9  => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря'
    ];
    return $month_list[$mn];
}

/**
 * Выделение select option.
 *
 * @param mixed $var
 * @param string $value
 * @return string
 */
function selected($var, $value)  {
	if (!is_array($var)) {
		$var = explode(',', $var);
	}
	return (in_array($value, $var)) ? ' selected' : '';
}

function selected_order_status($value, $ret=1)  {
	if ($value == 'created') {
		$class = ' text-warning';
	} elseif ($value == 'processed') {
        $class = ' text-success';
    } elseif ($value == 'completed') {
        $class = ' text-dark';
    }
    if ($ret) {
        echo $class;
    } else {
        return $class;
    }
}

/**
 * Отмечает CheckBox и radiobutton.
 *
 * @param mixed $var
 * @param string $value
 * @return string
 */
function checked($var, $value = null) {
	if (is_null($value)) {
		return ($var) ? ' checked' : '';
	} else {
		if (!is_array($var)) {
			$var = explode(',', $var);
		}
		return (in_array($value, $var)) ? ' checked' : '';
	}
}

function post_thumbnail_edit($thumb_img) {
    if ($thumb_img) {
        echo '<div class="post-thumbnail-img mb-2">
        <img src="' . $thumb_img['link'] . '" alt="">
        <button type="button" class="btn btn-danger js-thumbnail-remove" data-id="' . $thumb_img['id'] . '" data-path="' . $thumb_img['link'] . '" onclick="removeGallery(this,form)">
            <i class="ri-close-line"></i>
        </button>
        </div>';
    }
}

function post_gallery_edit($gallery_img) {
    if ($gallery_img) {
        uasort($gallery_img, 'sortOrder');
        $img_path = [];
        $content = '';
        foreach ($gallery_img as $key => $img) {
            $content .= '<div class="post-gallery-edit-item border" data-fname="' . basename($img['link']) . '">
            <img src="' . $img['link'] . '" alt="">
            <button type="button" class="btn btn-danger thumbnail-remove js-gallery-remove" data-id="' . $img['id'] . '" data-path="' . $img['link'] . '" onclick="removeGallery(this,form)">
                <i class="ri-close-line"></i>
            </button>
            </div>';
        }

        echo $content;
    }
}

function sortOrder($a, $b){
    if (array_key_exists('order', $a) && array_key_exists('order', $b)) {
        // return ($a['order'] > $b['order']);
        return strcmp($a['order'], $b['order']);
    } else {
        return;
    }
}

function str_int($n) {
    return (int)$n;
}

function itog_summ($data) {
    $summ = 0;
    if ($data) {
        foreach ($data as $key => $post) {
            $summ = $summ + (int)number_format($post['post_price'], 0, ',', '')*(int)$post['order_count'];
        }
    }
    return $summ;
}

function mini_cart_products($data) {
    if ($data) {
        echo '<div class="cart-products pb-4">';
        foreach ($data as $post) {
            $thumb = $post['post_thumb_img'];
            if ($thumb) {
                $thumb_img = json_decode($thumb, true)[0]['link'];
            } else {
                $thumb_img = '../public/images/no-images.png';
            }
            ?>
            <a href="<?php echo $post['post_url'];?>" class="d-flex align-items-center mb-1">
                <div class="cart-mini-img">
                    <img src="<?php echo $thumb_img;?>" class="shadow rounded" alt="">
                </div>
                <div class="flex-1 text-start ms-3">
                    <h6 class="text-dark mb-0"><?php echo $post['post_title'];?></h6>
                    <p class="text-muted mb-0">
                        <?php echo number_format($post['post_price'], 0, ',', ' ');?>₽ X <?php echo $post['order_count'];?>
                    </p>
                </div>
                <h6 class="text-dark mb-0"><?php echo number_format($post['post_price']*$post['order_count'], 0, ',', ' ');?>₽</h6>
            </a>
            <?php
        } ?>
        </div>
        <div class="d-flex align-items-center justify-content-between pt-4 border-top">
            <h6 class="text-dark mb-0">Итого(₽):</h6>
            <h6 class="text-dark mb-0">
                <?php echo number_format(itog_summ($data), 0, ',', ' ');?>₽
            </h6>
        </div>

        <div class="mt-3 text-center">
            <a href="/cart" class="btn btn-primary me-2">В корзину</a>
        </div>
    <?php
    }
}

function navigation_admin_left_html($nav, $vars) {
    // $nav = config('navigation', $nav.'_nav');
    $nav = nav_obj($vars);
    $id = ($nav['container_id'])? ' id="' . $nav['container_id'] . '"' : '';
    $class = ($nav['container_class'])? ' class="' . $nav['container_class'] . '"' : '';
    $content = '<' . $nav['container'] . $id . $class . '>';
    foreach ($nav['structure'] as $key => $item) {
        if (count($item['children'])) {
            $content .= '<li class="side-nav-item">';
            $content .= '<a data-bs-toggle="collapse" href="#' . $item['link'] . '" aria-expanded="false" aria-controls="' . $item['link'] . '" class="side-nav-link">';
            $content .= '<i class="' . $item['icon'] . '"></i>';
            $content .= '<span>' . $item['name'] . '</span>';
            $content .= '<span class="menu-arrow"></span>';
            $content .= '</a>';
            $content .= '<div class="collapse" id="' . $item['link'] . '">';
            $content .= '<ul class="side-nav-second-level">';
            foreach ($item['children'] as $key => $children) {
                if ($children['class_li']) {
                    $content .= '<li class="' . $children['class_li'] . '">';
                } else {
                    $content .= '<li>';
                }
                $content .= '<a href="' . $children['link'] . '" title="' . $children['name'] . '">' . $children['name'] . '</a>';
                $content .= '</li>';
            }
            $content .= '</ul>';
            $content .= '</div>';
            $content .= '</li>';
        } else {
            $content .= '<li class="side-nav-item">';
            $content .= '<a href="' . $item['link'] . '" class="side-nav-link">';
            $content .= '<i class="' . $item['icon'] . '"></i>';
            $content .= '<span>' . $item['name'] . '</span>';
            $content .= '</a>';
            $content .= '</li>';
        }
    }
    $content .= '</' . $nav['container'] . '">';
    return $content;
}

function navigation_primary_html() {
    $nav = config('navigation', 'site_primary_nav');
    $id = ($nav['container_id'])? ' id="' . $nav['container_id'] . '"' : '';
    $class = ($nav['container_class'])? ' class="' . $nav['container_class'] . '"' : '';
    $content = '<' . $nav['container'] . $id . $class . '>';
    foreach ($nav['structure'] as $key => $item) {
        $content .= '<li>';
        $content .= '<a href="' . $item['link'] . '" class="sub-menu-item">' . $item['name'] . '</a>';
        $content .= '</li>';
    }
    $content .= '</' . $nav['container'] . '">';
    return $content;
}

function curl_api_img($prompt) {
	$openai = New Openai();
	$model = 'dall-e-3'; // dall-e-2 dall-e-3
	$size = '1024x1024'; // dall-e-3 - 1024x1024, 1792x1024, or 1024x1792; dall-e-2 - 256x256, 512x512, or 1024x1024
	$response_format = 'url'; // url or b64_json
	$result = $openai->image($model, $prompt, $size, $response_format);
	$obj = json_decode($result, true);
    $result = $obj['data'][0][$response_format];
    return $result;
}

function get_utoai() {
    return UsersModel::getUserTokensOai();
}

function get_utoai_fid($user_id) {
    return UsersModel::getUserTokensOaiForId($user_id);
}

function cost_of_request($model, $type) {
    $separator = '-';
    $m_arr = explode($separator, $model);
    $m_str = $m_arr[0].$separator.$m_arr[1].$separator.$m_arr[2];

    return cost_type_arr($m_str, $type);
}

function cost_type_arr($model, $type) {
    if ($type == 'completion') {
        $cost = [
            'gpt-4o-mini' => 0.0432,
            'gpt-4.1-mini' => 0.1152,
            'gpt-4.1-nano' => 0.0288,
            'gpt-3.5-turbo' => 0.144
        ];
    } elseif ($type == 'prompt') {
        $cost = [
            'gpt-4o-mini' => 0.1728,
            'gpt-4.1-mini' => 0.4608,
            'gpt-4.1-nano' => 0.1152,
            'gpt-3.5-turbo' => 0.432
        ];
    }
    return $cost[$model];
}

function paVars($id) {
    $vars_parent = VarsModel::getVarsParentIdGr($id);
    return $vars_parent;
}

function getGroupsProd($prod_arr, $id) {
    $title = '';
    $title_par = '';
    $search = [$id];
    $newArray = array_filter($prod_arr, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });
    reset($newArray);
    $new = current($newArray);
    if ($new) {
        $title = $new['title'];

        if ($new['parentid']) {
            $search_par = [$new['parentid']];
            $newArray_par = array_filter($prod_arr, function($_array) use ($search_par){
                return in_array($_array['id'], $search_par);
            });
            reset($newArray_par);
            $new_par = current($newArray_par);
            $title_par = $new_par['title'];
        }
    }

    if ($title_par || $title) {
        $res = implode("<br>", [$title_par, $title]);
    } else {
        $res = '<span class="text-danger">Нет группы</span>';
    }

    return $res;
}

function productGroup($arr, $value=0) {
    echo '<option value="0">Все группы</option>';
    foreach ($arr as $cat) {
        if ($cat['parentid'] == 0) {
            echo '<option value="' . $cat['id'] . '"' . selected($value, $cat['id']) . '>' . $cat['title'] . '</option>';
        }
    }
}

function varPageGroupTitile($vars, $var_id) {
    $search = [$var_id];
    $newArray = array_filter($vars, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });
    reset($newArray);
    $new = current($newArray);
    return $new['title'];
}

function varsForProduct($varsProduct, $varsArr) {
    $vars = explode(',', $varsProduct);
    // foreach ($varsProduct as $var) {
    //     $vars[] = $var['varid'];
    // }
    $search = $vars;
    $newVars = array_filter($varsArr, function($_array) use ($search){
        return in_array($_array['id'], $search);
    });

    $content = '';
    foreach ($newVars as $var) {
        $content .= '<div class="vars-item d-flex gap-2 align-items-start mb-1" data-vit="' . $var['id'] . '">';
        $content .= '<button type="button"
            class="btn btn-sm btn-outline-secondary flex-grow-0 flex-shrink-0 text-truncate"
            data-clipboard-text="#' . $var['title'] . '#">
            #' . $var['title'] . '#
            </button>';
        $content .= '<span>' . $var['descr'] . '</span>';
        $content .= '</div>';
    }
    echo $content;
}

//Отправка в Телеграм
function message_to_telegram($text, $chatid) {
    $tg_token = '5820237672:AAFAuLq18Zqy0kPW77E5Dk37_UH7xWpfgYM';
    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . $tg_token . '/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $chatid, // TELEGRAM_CHATID
                'parse_mode' => 'HTML',
                'text' => $text,
            ),
        )
    );
    curl_exec($ch);
}

function prodVarsAdd() {
    $products = ProductsModel::getProductsNogr();
    $products_ids = [];
    foreach ($products as $product) {
        $products_ids[] = $product['id'];
    }

    foreach ($products_ids as $product) {
        $vars_prod = ProductsModel::getVarsForProduct($product);
        $vars = [];
        foreach ($vars_prod as $var) {
            $vars[] = $var['varid'];
        }

        ProductsModel::editVars([
            'id' => $product,
            'vars' => implode(',', $vars)
        ]);
    }

    return $products_ids;
}

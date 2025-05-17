<?php
use Hleb\Static\Request;
use App\Models\{
    PostModel,
    OrdersModel,
    LocationModel,
    GlampingModel,
    ReviewsModel,
    Admin\AdminModel,
    Admin\AdminUsersModel,
    Myorm\MyormModel
};
use App\Content\Paginator;

$site_settings = json_decode(site_settings('site_settings'));
define('LIMIT_POSTS_ADMIN', ($site_settings->post_limit_admin)? (int)$site_settings->post_limit_admin : 12);
define('LIMIT_POSTS_FRONT', ($site_settings->post_limit_site)? (int)$site_settings->post_limit_site : 12);
define('LIMIT_LOC_SLIDER', 20);

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
    $value = $sth->fetchAll(PDO::FETCH_COLUMN);
    return $value;
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
        'uncategorized' => 'Выберите регион',
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

function locations($value=0, $return=0) {
    $locations = LocationModel::getLocations();
    if ($return) {
        return $locations;
    } else {
        foreach ($locations as $location) {
            echo '<option value="' . $location['slug'] . '"' . selected($value, $location['slug']) . '>' . $location['title'] . '</option>';
        }
    }
}

function locations_home() {
    $locations = LocationModel::getLocations();
    $options = '<option value="0">Выберите регион</option>';
    foreach ($locations as $location) {
        $options .= '<option value="' . $location['slug'] . '">' . $location['title'] . ' <sup>' . $location['count'] . '</sup></option>';
    }

    $slider_loc = '';
    $locations_sl = $locations;
    uasort($locations_sl, 'sortLoc');
    $il = 0;
    foreach ($locations_sl as $key => $location) {
        if ((int)$location['count']) {
            if ($il < LIMIT_LOC_SLIDER ) {
                $img_arr = json_decode($location['img'], true)[0];
                $slider_loc .= '<div class="tiny-slide">
                    <div class="popular-tour rounded-md position-relative overflow-hidden mx-2">
                        <img class="img-fluid tns-lazy-img" data-src="' . $img_arr['link'] . '" alt="">
                        <div class="content">
                            <span class="title text-white h6 title-dark">' . $location['title'] . '&nbsp;<sup>' . $location['count'] . '</sup></span>
                        </div>
                        <a href="/location/' . $location['slug'] . '/" class="link-location text-white h6 title-dark"></a>
                    </div>
                </div>';
            }
        }
        $il++;
    }

    return ['options' => $options, 'slider_loc' => $slider_loc];
}

function locations_home_t() {
    $locations = LocationModel::getLocations();
    return $locations;
}

function locations_post($slug) {
    return LocationModel::getLocationForSlug($slug);
}

function locations_post_id($locations, $id) {
    $result = array_filter($locations, function($k) use ($id) {
        return $k['id'] === $id;
    });
    return array_shift($result);
}

function locations_post_slug($locations, $slug) {
    $result = array_filter($locations, function($k) use ($slug) {
        return $k['slug'] === $slug;
    });
    return array_shift($result);
}

function users_select($value=0, $return=0) {
    $users = AdminUsersModel::getUsers();
    if ($return) {
        return $users;
    } else {
        echo '<option value="0">Выберите автора</option>';
        foreach ($users as $user) {
            $name = '#' . $user['id'] . ' ' . $user['username'];
            if ($user['id'] == 1) {
                $name = $name . ' (admin)';
            }
            echo '<option value="' . $user['id'] . '"' . selected($value, $user['id']) . '>' . $name . '</option>';
        }
    }
}

function glampings_select($value=0, $return=0) {
    $glampings = GlampingModel::getPostsAll();
    if ($return) {
        return $glampings;
    } else {
        foreach ($glampings as $glamping) {
            echo '<option value="' . $glamping['id'] . '"' . selected($value, $glamping['id']) . '>' . $glamping['post_title'] . '</option>';
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

function paginat_front($pNum, $pagesCount, $sheet, $other, $sign='page/') {
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
                <a class="page-link" href="' . $sheet . $sign . $pNum-1 . '/" aria-label="Previous">
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
                $html .= '<li class="page-item"><a class="page-link" href="' . $sheet . $sign . $i . '/">' . $i . '</a></li>';
            }
        }
    }
    if ($pNum < $pagesCount) {
        $html .= '<li class="page-item">
            <a class="page-link" href="' . $sheet . $sign . $pNum+1 . '/" aria-label="Next">
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
	return (in_array($value, $var)) ? ' selected="selected"' : '';
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
            if ($var) {
                $var = explode(',', $var);
                return (in_array($value, $var)) ? ' checked' : '';
            } else {
                return '';
            }
		} else {
            return (in_array($value, $var)) ? ' checked' : '';
        }
	}
}

function post_thumbnail_edit($thumb_img) {
    if ($thumb_img) {
        echo '<div class="post-thumbnail-img mb-2">
        <img src="' . $thumb_img['link'] . '" alt="">
        <button type="button" class="btn btn-danger js-thumbnail-remove" data-position="thumbnail" data-id="' . $thumb_img['id'] . '" data-path="' . $thumb_img['link'] . '" onclick="removeGallery(this,form)">
            <i class="ri-close-line"></i>
        </button>
        </div>';
    }
}

function post_thumbnail_edit_new($thumb_img) {
    if ($thumb_img) {
        $link = $thumb_img['link'];
        if (isset($link['w'])) {
            $srset = ' srcset="/' . $link['w'] . '" src="/' . $link['g'] . '"' ;
        } else {
            $srset = ' src="' . $link['g'] . '"';
        }
        echo '<div class="post-thumbnail-img mb-2">
        <img' . $srset . ' alt="">
        <button type="button" class="btn btn-danger js-thumbnail-remove" data-position="thumbnail" data-id="' . $thumb_img['id'] . '" data-path="' . $link['g'] . '" onclick="removeGallery(this,form)">
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
            <img src="/' . $img['link'] . '" alt="">
            <button type="button" class="btn btn-danger thumbnail-remove js-gallery-remove" data-position="gallery" data-id="' . $img['id'] . '" data-path="' . $img['link'] . '" onclick="removeGallery(this,form)">
                <i class="ri-close-line"></i>
            </button>
            </div>';
        }

        echo $content;
    }
}

function post_gallery_edit_new($gallery_img) {
    if ($gallery_img) {
        // uasort($gallery_img, 'sortOrder');
        $img_path = [];
        $content = '';
        foreach ($gallery_img as $key => $img) {
            if (isset($img['link']['w'])) {
                $srset = ' srcset="/' . $img['link']['w'] . '" src="/' . $img['link']['g'] . '"' ;
            } else {
                $srset = ' src="' . $img['link']['g'] . '"';
            }
            $content .= '<div class="post-gallery-edit-item border" data-fname="' . basename($img['link']['g']) . '">
            <img' . $srset . ' alt="">
            <button type="button" class="btn btn-danger thumbnail-remove js-gallery-remove" data-position="gallery" data-id="' . $img['id'] . '" data-path="' . $img['link']['g'] . '" onclick="removeGallery(this,form)">
                <i class="ri-close-line"></i>
            </button>
            </div>';
        }

        echo $content;
    }
}

function post_gallery_edit_acc($gallery_img) {
    if ($gallery_img) {
        // uasort($gallery_img, 'sortOrder');
        $img_path = [];
        $content = '';
        if (is_array($gallery_img)) {
            $gallery_img_arr = $gallery_img;
        } else {
            $gallery_img_arr = json_decode($gallery_img, true);
        }
        foreach ($gallery_img_arr as $key => $img) {
            if (isset($img['link']['w'])) {
                $srset = ' srcset="/' . $img['link']['w'] . '" src="/' . $img['link']['g'] . '"' ;
            } else {
                $srset = ' src="' . $img['link']['g'] . '"';
            }
            $content .= '<div class="post-thumbnail-img border" data-fname="' . basename($img['link']['g']) . '">
            <img' . $srset . ' alt="">
            <button type="button" class="btn btn-danger thumbnail-remove js-gallery-remove" data-id="' . $img['id'] . '" data-path="' . $img['link']['g'] . '" data-position="acc-gallery" onclick="removeGallery(this,form)">
                <i class="ri-close-line"></i>
            </button>
            </div>';
        }

        echo $content;
    }
}

function sortLoc($a, $b){
    if (array_key_exists('count', $a) && array_key_exists('count', $b)) {
        return ($b['count'] > $a['count']);
    } else {
        return;
    }
}

function sortOrder($a, $b){
    if (array_key_exists('order', $a) && array_key_exists('order', $b)) {
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

function navigation_admin_left_html($nav) {
    $nav = config('navigation', $nav.'_nav');
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
                $content .= '<a href="' . $children['link'] . '">' . $children['name'] . '</a>';
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

function options_get($key) {
    $options = options_set()[$key];
    foreach ($options as $option) {
        echo '<option value="' . $option . '">' . $option . '</option>';
    }
}

function options_get_new($key, $value = null) {
    $options = options_set()[$key];
    foreach ($options as $option) {
        echo '<option value="' . $option . '"' . selected($value, $option) . '">' . $option . '</option>';
    }
}

function options_get_checkbox($key, $name, $value = null) {
    $options = options_set()[$key];
    foreach ($options as $option) {
        echo '<div class="form-check form-checkbox-success mb-2">
        <input type="checkbox" class="form-check-input" id="' . $option . '" name="' . $name . '[]" value="' . $option . '"' . checked($value, $option) . '>
        <label class="form-check-label" for="' . $option . '">' . $option . '</label>
        </div>';
    }
}

function acc_render_edit($meta_acc) {

    for ($i=0; $i < count($meta_acc['acc_type_title']); $i++) {
        $acc_options_home_check = '';
        $acc_options_bathroom_check = '';
        $acc_options_children_check = '';
        $acc_pets_check = '';
        $acc_internet_check = '';
        $acc_bedroom_check = '';
        $acc_spa_check = '';
        $acc_nutrition_check = '';
        $acc_type_vision_check = '';
        if (array_key_exists('acc_options_home', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_options_home'])) {
                $acc_options_home_check = $meta_acc['acc_options_home'][$i];
            }
        }
        if (array_key_exists('acc_options_bathroom', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_options_bathroom'])) {
                $acc_options_bathroom_check = $meta_acc['acc_options_bathroom'][$i];
            }
        }
        if (array_key_exists('acc_options_children', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_options_children'])) {
                $acc_options_children_check = $meta_acc['acc_options_children'][$i];
            }
        }
        if (array_key_exists('acc_pets', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_pets'])) {
                $acc_pets_check = $meta_acc['acc_pets'][$i];
            }
        }
        if (array_key_exists('acc_internet', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_internet'])) {
                $acc_internet_check = $meta_acc['acc_internet'][$i];
            }
        }
        if (array_key_exists('acc_bedroom', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_bedroom'])) {
                $acc_bedroom_check = $meta_acc['acc_bedroom'][$i];
            }
        }
        if (array_key_exists('acc_spa', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_spa'])) {
                $acc_spa_check = $meta_acc['acc_spa'][$i];
            }
        }
        if (array_key_exists('acc_nutrition', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_nutrition'])) {
                $acc_nutrition_check = $meta_acc['acc_nutrition'][$i];
            }
        }

        if (array_key_exists('acc_type_vision', $meta_acc)) {
            if (array_key_exists($i, $meta_acc['acc_type_vision'])) {
                $acc_type_vision_check = $meta_acc['acc_type_vision'][$i];
            }
        }
    ?>
    <div class="accordion-item" data-order="<?php echo $i;?>">
        <h2 class="accordion-header position-relative">
            <button class="accordion-button fw-medium collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#acc-option<?php echo $i;?>"
                aria-expanded="false"
                aria-controls="collapseOne"><?php echo ($meta_acc['acc_type_title'][$i])? $meta_acc['acc_type_title'][$i] : 'Вариант размещения';?></button>
            <button class="btn position-absolute btn-del-acc-option"
                type="button"
                name="button"
                title="Удалить вариант"
                onclick="accDelete(this)">
                <i class="ri-close-circle-line text-danger me-1"></i>
            </button>
        </h2>
        <div id="acc-option<?php echo $i;?>" class="accordion-collapse collapse" data-item="<?php echo $i;?>" data-bs-parent="#accordionExample" style="">
            <div class="accordion-body">
                <div class="form-check mb-3">
                    <input type="checkbox"
                        class="form-check-input"
                        id="acc_type_vision"
                        name="acc_type_vision"
                        <?php echo checked($acc_type_vision_check, 'on');?>>
                    <label class="form-check-label" for="acc_type_vision">Не показывать этот вариант размещения</label>
                </div>

                <div class="mb-3">
                    <label for="acc_type_title" class="form-label">Название варианта размещения <span class="text-danger">*</span></label>
                    <input type="text"
                        name="acc_type_title[]"
                        id="acc_type_title"
                        class="form-control acc_type_title"
                        placeholder="Добавить заголовок"
                        oninput="accTitle(this)"
                        value="<?php echo $meta_acc['acc_type_title'][$i];?>"
                        required>
                    <div id="type_title" class="invalid-feedback">Заполните Название</div>
                </div>

                <div class="mb-3">
                    <label for="acc_type_text" class="form-label">Описание варианта размещения</label>
                    <textarea class="form-control" id="acc_type_text"  name="acc_type_text[]" rows="6"><?php echo $meta_acc['acc_type_text'][$i];?></textarea>
                </div>

                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="acc_type_area" class="form-label">Площадь (кв.м)</label>
                        <input type="text" class="form-control" id="acc_type_area" name="acc_type_area[]" value="<?php echo $meta_acc['acc_type_area'][$i];?>">
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="acc_type_places" class="form-label">Мест</label>
                        <input type="text" class="form-control" id="acc_type_places" name="acc_type_places[]" value="<?php echo $meta_acc['acc_type_places'][$i];?>">
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="acc_type_price" class="form-label">Цена (минимальная)</label>
                        <div class="input-group">
                            <input type="number" name="acc_type_price[]" id="acc_type_price" class="form-control" placeholder="Цена" value="<?php echo $meta_acc['acc_type_price'][$i];?>">
                            <span class="input-group-text">₽</span>
                        </div>
                    </div>
                </div>

                <div class="mb-3 post-gallery">
                    <label class="form-label">Галерея изображений</label>
                    <div class="acc-post-gallery-img d-flex flex-row gap-2 flex-wrap mb-3">
                        <?php
                        if (is_array($meta_acc['acc_imagesItems'])) {
                            ($meta_acc['acc_imagesItems'])? post_gallery_edit_acc($meta_acc['acc_imagesItems'][$i], true) : '';
                        } else {
                            (json_decode($meta_acc['acc_imagesItems']))? post_gallery_edit_acc(json_decode($meta_acc['acc_imagesItems'], true)[$i]) : '';
                        }
                        ?>
                    </div>
                    <label for="acc_post_gallery-<?php echo $i;?>" class="btn btn-outline-secondary">
                        <span class="spinner-border spinner-border-sm me-1 js-spinner-gallery" role="status" aria-hidden="true"></span>Выбрать изображения</label>
                    <input class="input-upload" type="file" id="acc_post_gallery-<?php echo $i;?>" name="acc_post_gallery-<?php echo $i;?>[]" data-name="acc_post_gallery" onChange="uploadImages(this, form)" value="0" multiple />
                </div>

                <div class="facilities mt-2">
                    <h5 class="facilities mb-3">Удобства</h5>
                    <div class="row border-bottom border-light-subtle">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">В доме:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_options_home" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_options_home d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('facilities_options_home', 'acc_options_home', $acc_options_home_check); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Ванная комната:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_options_bathroom" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_options_bathroom d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('facilities_options_bathroom', 'acc_options_bathroom', $acc_options_bathroom_check); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Дети:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_options_children" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_options_children d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('facilities_options_children', 'acc_options_children', $acc_options_children_check); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Домашние животные:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_pets" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_pets d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('pets', 'acc_pets', $acc_pets_check); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Интернет:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_internet" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_internet d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('internet', 'acc_internet', $acc_internet_check); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Питание:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_nutrition" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_nutrition d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('nutrition', 'acc_nutrition', $acc_nutrition_check); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row border-bottom border-light-subtle mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">Спальня:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_bedroom" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_bedroom d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('bedroom', 'acc_bedroom', $acc_bedroom_check) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 mb-3">
                            <div class="labels d-flex gap-4">
                                <label class="form-label">SPA:</label>
                                <a href="javascript: void(0);" class="fs-12" data-check="acc_spa" data-checked="0" onclick="checkAll(this)">Выделить/снять все</a>
                            </div>
                            <div class="acc_spa d-flex gap-2 flex-wrap">
                                <?php options_get_checkbox('spa', 'acc_spa', $acc_spa_check) ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
    }

}

function post_status($status) {
    $status_options = [
        'publish' => 'Опубликован',
        'published' => 'Опубликован',
        'pending' => 'На утверждении',
        'draft' => 'Черновик',
        'private' => 'Private'
    ];
    return '<span class="status-value ' . $status . '">' . $status_options[$status] . '</span>';
}

function options_set() {
    $site_options = [];
    $site_options['glamping_type'] = [
        'Глэмпинг',
        'Эко-отель',
        'Турбаза',
        'Частный сектор'
    ];

    $site_options['glamping_allocation'] = [
        'А-фрейм',
        'Барнхаус',
        'Белл-тент',
        'Вагончик',
        'Дом в лесу',
        'Дом на воде',
        'Дом на дереве',
        'Дом на колесах',
        'Дубльдом',
        'Зеркальный дом',
        'Купол',
        'Лотус-тент',
        'Модульный дом',
        'Сафари-тент',
        'Типи',
        'Эко-дом',
        'Юрта'
    ];

    $site_options['glamping_facilities_general'] = [
        'Wi-Fi',
        'Кондиционер',
        'Парковка',
        'Можно с животными',
    ];

    $site_options['facilities_options_home'] = [
        'Гардероб',
        'Диван',
        'Камин',
        'Кондиционер',
        'Мини-кухня',
        'Обогреватель',
        'Проектор',
        'Санузел',
        'Сейф',
        'Стиральная машина',
        'Стол',
        'Стулья',
        'Телевизор',
        'Теплый пол',
        'Утюг',
        'Шкаф',
        'Кухня (общая)',
        'Музыкальная колонка',
        'Санузел (общий)',
        'Яндекс.Станция Алиса',
    ];

    $site_options['facilities_options_bathroom'] = [
        'Гель для душа',
        'Душ',
        'Душ (общий)',
        'Мыло',
        'Набор полотенец',
        'Умывальник',
        'Тапочки',
        'Халат',
        'Фен',
        'Шампунь',
    ];

    $site_options['facilities_options_kitchen'] = [
        'Кофеварка',
        'Кофемашина',
        'Микроволновая печь',
        'Мини-бар',
        'Плита',
        'Посуда',
        'Посудомоечная машина',
        'Тостер',
        'Чайник',
        'Холодильник',
    ];

    $site_options['glamping_nutrition'] = [
        'Доставка еды',
        'Завтрак',
        'Питьевая вода',
        'Ресторан',
        'Трехразовое питание',
    ];

    $site_options['facilities_options_children'] = [
        'Детский уголок',
        'Детская площадка',
        'Детская кроватка по запросу',
    ];

    $site_options['glamping_territory'] = [
        'Бассейн',
        'Беседка',
        'Гамак',
        'Джакузи',
        'Игровая зона',
        'Качеля',
        'Мангал',
        'Терраса',
        'Ферма',
        'Шезлонг',
        'Костровая зона',
    ];

    $site_options['facilities_options_safety'] = [
        'Видеонаблюдение по территории',
        'Датчик дыма',
        'Охраняемая территория',
        'Охраняемая парковка',
    ];

    $site_options['glamping_entertainment'] = [
        'Аквапарк',
        'Аэрохоккей',
        'Бадминтон',
        'Багги',
        'Баскетбол',
        'Батут',
        'Беговые лыжи',
        'Библиотека',
        'Вейкборд',
        'Велосипед',
        'Виндсерфинг',
        'Волейбольная площадка',
        'Гидроциклы',
        'Горнолыжный курорт',
        'Дартс',
        'Йога',
        'Караоке',
        'Кайтсерфинг',
        'Кинотеатр',
        'Лазертаг',
        'Лодка',
        'Массаж',
        'Мотосноуборды',
        'Настольный теннис',
        'Прогулки на лошадях',
        'Рыбалка',
        'САП-борд',
        'Серфинг',
        'Скалодром',
        'Снегоход',
        'Эко-тропа',
        'Байдарки',
        'Квадроциклы',
        'Катамараны',
        'Настольные игры',
        'Веревочный парк',
        'Каяки',
        'Каток',
        'Пляж',
        'Приставка Dendi',
        'Рафтинг',
        'Теннисный корт',
        'Тир',
        'Тюбинги',
        'Фотосессия',
        'Фрисби',
        'Футбольная площадка',
        'Экскурсии',
        'Эндуро',
        'Яхтинг',
        'PlayStation'
    ];

    $site_options['glamping_nature_around'] = [
        'Лес',
        'Горы',
        'Река',
        'Озеро',
        'Море',
        'Поле',
    ];

    $site_options['working_hours'] = [
        'январь',
        'февраль',
        'март',
        'апрель',
        'май',
        'июнь',
        'июль',
        'август',
        'сентябрь',
        'октябрь',
        'ноябрь',
        'декабрь',
    ];

    $site_options['pets'] = [
        'Возможно размещение с животными при предварительном согласовании',
        'Размещение с животными не допускается'
    ];

    $site_options['internet'] = [
        'Wi-Fi'
    ];

    $site_options['parking'] = [
        'Парковка'
    ];

    $site_options['nutrition'] = [
        'Доставка еды',
        'Завтрак',
        'Питьевая вода',
        'Ресторан',
        'Трехразовое питание'
    ];

    $site_options['bedroom'] = [
        'Комод',
        'Кровать King Size',
        'Ортопедический матрас',
        'Тумба',
        'Электропростынь'
    ];

    $site_options['spa'] = [
        'Баня (сауна)',
        'Фурако (купель)',
        'Банный чан'
    ];

    $site_options['additional_features'] = [
        'Трансфер'
    ];

    // $site_options['additional_features'] = [
    //     'Завтрак',
    //     'Трансфер',
    //     'Трехразовое питание'
    // ];

    return $site_options;
}

function locationsCount() {
    $glampings = GlampingModel::getPostsCountLocations();
    $locations = LocationModel::getLocationsIs();
    foreach ($locations as $location) {
        $post_term = $location['slug'];
        $result = array_filter($glampings, function($k) use ($post_term) {
            return $k['post_term'] === $post_term;
        });
        LocationModel::updateCount([
            'id'    => $location['id'],
            'count' => count($result)
        ]);
    }
}

function popular_glampings_home($glampings) {
    $separator = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M8.99854 11.8577C8.99854 11.0248 9.26181 10.3403 9.78835 9.80418C10.3245 9.26806 11.0329 9 11.9137 9C12.7849 9 13.4933 9.26327 14.039 9.78982C14.5847 10.3068 14.8575 11.0104 14.8575 11.9008V12.4321C14.8575 13.265 14.5943 13.9447 14.0677 14.4713C13.5412 14.9978 12.8279 15.2611 11.928 15.2611C11.0377 15.2611 10.3245 14.9978 9.78835 14.4713C9.26181 13.9352 8.99854 13.2459 8.99854 12.4034V11.8577Z" fill="var(--bs-gray)"/>
    </svg>';
    $content = '';
    foreach ($glampings as $key => $glamping) {
        $post_thumb = json_decode($glamping['post_thumb_img'], true);
        if (isset($post_thumb['link'])) {
            if (isset($post_thumb['link']['w'])) {
                $srset = ' srcset="/' . $post_thumb['link']['w'] . '" src="/' . $post_thumb['link']['g'] . '"' ;
            } else {
                $srset = ' src="' . $post_thumb['link']['g'] . '"';
            }
        }
        $post_meta = json_decode($glamping['post_meta'], true);
        $rating = (int)$glamping['rating'];
        $rating_count = (int)explode('/', $glamping['rating_data'])[1];
    ?>
    <div class="card-items" itemscope itemtype="https://schema.org/Campground">
        <a href="<?php echo $glamping['post_url']; ?>" class="card-items__link"></a>
        <div class="card-items__img">
            <span><img <?php echo $srset;?> alt=""></span>
            <div class="card-items__img__info">
                <?php if ( $glamping['temp_out'] == 1 ) { ?>
                    <div class="card-items__img__info__item" style="background: #FF9800;">
                        <span>Временно не работает</span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card-items__content">
            <a href="<?php echo $glamping['post_url']; ?>" itemprop="url">
                <span itemprop="name"><?php echo $glamping['post_title']; ?></span>
            </a>
            <div class="card-items__content__adress">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C9.87827 2 7.84344 2.84285 6.34315 4.34315C4.84285 5.84344 4 7.87827 4 10C4 13.0981 6.01574 16.1042 8.22595 18.4373C9.31061 19.5822 10.3987 20.5195 11.2167 21.1708C11.5211 21.4133 11.787 21.6152 12 21.7726C12.213 21.6152 12.4789 21.4133 12.7833 21.1708C13.6013 20.5195 14.6894 19.5822 15.774 18.4373C17.9843 16.1042 20 13.0981 20 10C20 7.87827 19.1571 5.84344 17.6569 4.34315C16.1566 2.84285 14.1217 2 12 2ZM12 23C11.4453 23.8321 11.445 23.8319 11.4448 23.8317L11.4419 23.8298L11.4352 23.8253L11.4123 23.8098C11.3928 23.7966 11.3651 23.7776 11.3296 23.753C11.2585 23.7038 11.1565 23.6321 11.0278 23.5392C10.7705 23.3534 10.4064 23.0822 9.97082 22.7354C9.10133 22.043 7.93939 21.0428 6.77405 19.8127C4.48426 17.3958 2 13.9019 2 10C2 7.34784 3.05357 4.8043 4.92893 2.92893C6.8043 1.05357 9.34784 0 12 0C14.6522 0 17.1957 1.05357 19.0711 2.92893C20.9464 4.8043 22 7.34784 22 10C22 13.9019 19.5157 17.3958 17.226 19.8127C16.0606 21.0428 14.8987 22.043 14.0292 22.7354C13.5936 23.0822 13.2295 23.3534 12.9722 23.5392C12.8435 23.6321 12.7415 23.7038 12.6704 23.753C12.6349 23.7776 12.6072 23.7966 12.5877 23.8098L12.5648 23.8253L12.5581 23.8298L12.556 23.8312C12.5557 23.8314 12.5547 23.8321 12 23ZM12 23L12.5547 23.8321C12.2188 24.056 11.7807 24.0556 11.4448 23.8317L12 23Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8ZM8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10C16 12.2091 14.2091 14 12 14C9.79086 14 8 12.2091 8 10Z" fill="black"/>
                </svg>
                <span itemprop="address"><?php echo $post_meta['address']; ?></span>
            </div>
            <div class="card-items__content__reviews">
                <?php if ( $rating_count == 0 ) { ?>
                    <span class="card-items__content__reviews-count" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
                        <meta itemprop="ratingValue" content="0">Нет отзывов</span>
                <?php } else { ?>
                <span class="card-items__content__reviews-stars" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
                    <meta itemprop="ratingValue" content="<?php echo $rating; ?>">
                    <?php echo $rating; ?>
                </span>
                <span><?php echo $separator; ?></span>
                <span class="card-items__content__reviews-count">
                    <?php echo tb_num_word($rating_count, array(' отзыв', ' отзыва', ' отзывов')); ?>
                </span>
                <?php } ?>
            </div>
            <div class="card-items__content__bottom">
                <div class="card-items__content__bottom-price" itemprop="priceRange">
                    <span>от <span class="price-color"><?php echo ($glamping['post_price'])? number_format($glamping['post_price'], 0, ',', ' ') . ' ₽' : 'не указано'; ?></span> за 1 ночь</span>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    echo $content;
}

function reviews_home($reviews) {
    foreach ($reviews as $key => $review) {
        $review_meta = json_decode($review['post_meta'], true);
        $rs = '';
        for ($i=0; $i < (int)$review['post_rating']; $i++) {
            $rs .= '<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>';
        }
        ?>
        <div class="tiny-slide">
            <div class="d-flex client-testi m-2">
                <div class="card flex-1 content p-3 shadow rounded position-relative">
                    <div class="review-info">
                        <span><?php echo $review_meta['name'];?></span>
                        <span><?php echo date("d.m.Y", strtotime($review['post_date'])); ?>г.</span>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <?php echo $rs;?>
                    </ul>
                    <p class="review-content text-muted mt-2">"<?php echo $review['post_content'];?>"</p>
                    <a href="/glampings/<?php echo $review_meta['glamping_slug'];?>" class="review-content-link">
                        <h6 class="text-primary">
                            <?php echo $review_meta['glamping_title'];?>
                        </h6>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}

function location_list_footer_auto() {
    $locations = LocationModel::getLocationsTsc();
    foreach ($locations as $key => $location) {
        if ($key <= 7) {
            echo '<li>
            <a href="/location/' . $location['slug']. '/" class="text-foot">
            <i class="uil uil-angle-right-b me-1"></i>' . $location['title'] . '<sup>' . $location['count'] . '</sup>
            </a>
            </li>';
        }
    }
}

function tb_num_word($value, $words, $show = true) {
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

function rest_api_glemp($page=0) {
    $url = 'https://test.traveling-best.ru/wp-json/myplugin/v1/glamp-pars/' . $page;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response= curl_exec($ch);
    curl_close($ch);

    $glemps = json_decode($response, true);

    foreach ($glemps as $glemp) {
        $post_seo = [
            'title' => $glemp['title'],
            'description' => $glemp['description'],
            'keywords' => ''
        ];
        GlampingModel::restapi_create(
            [
                'post_title'            => $glemp['post_title'],
                'post_content'          => $glemp['post_content'],
                'post_slug'             => $glemp['post_slug'],
                'post_url'              => $glemp['post_url'],
                'post_status'           => $glemp['post_status'],
                'post_author'           => 1,
                'post_term'             => $glemp['post_term'],
                'post_tags'             => '',
                'post_thumb_img'        => json_encode($glemp['post_thumb_img'], JSON_UNESCAPED_UNICODE),
                'post_gallery_img'      => json_encode($glemp['post_gallery_img'], JSON_UNESCAPED_UNICODE),
                'post_price'            => $glemp['post_price'] ?? NULL,
                'post_working'          => json_encode($glemp['post_working'], JSON_UNESCAPED_UNICODE),
                'post_seo'              => json_encode($post_seo, JSON_UNESCAPED_UNICODE),
                'post_meta'             => json_encode($glemp['post_meta'], JSON_UNESCAPED_UNICODE),
                'post_meta_acc'         => json_encode($glemp['post_meta_acc'], JSON_UNESCAPED_UNICODE),
                'views'                 => $glemp['views'],
                'temp_data'             => $glemp['temp_data'],
                'post_date'             => $glemp['post_date']
            ]
        );
    }
}

function rest_api_reviews($page=0) {
    $url = 'https://test.traveling-best.ru/wp-json/myplugin/v1/reviews_rest/' . $page;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response= curl_exec($ch);
    curl_close($ch);

    $reviews = json_decode($response, true);

    foreach ($reviews as $key => $review) {
        $post_meta = [
            'email' => $review['rating_email'],
            'name' => $review['rating_name'],
            'glamping_title' => $review['glamping_title'],
            'glamping_slug' => $review['glamping_slug']
        ];
        ReviewsModel::create_rest(
            [
                'post_parent'           => (int)$review['parent_post'],
                'post_title'            => $review['post_title'],
                'post_content'          => $review['post_content'],
                'post_slug'             => NULL,
                'post_url'              => $review['post_slug'],
                'post_status'           => 'publish',
                'post_author'           => 1,
                'post_gallery_img'      => NULL,
                'post_meta'             => json_encode($post_meta, JSON_UNESCAPED_UNICODE),
                'post_rating'           => (int)$review['rating_post'],
                'post_date'             => $review['post_date'],
                'post_modified'         => $review['post_date']
            ]
        );
    }
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

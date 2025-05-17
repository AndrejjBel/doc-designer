<?php
$locations = $data['locations'];
$br_gen = 'Консоль';
$pagin_link = '/admin/glampings';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
    $pagin_link = '/dashboard/glampings';
}
?>
<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $br_gen;?></a></li>
                                <li class="breadcrumb-item active">Глэмпинги</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Глэмпинги</h4>
                    </div>
                </div>
            </div>

            <?php if (count($data['glampings'])) { ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="table-responsive-sm">
                        <table class="table table-sm table-centered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Заголовок</th>
                                    <th>Автор</th>
                                    <th>Регион</th>
                                    <th>Статус</th>
                                    <th>Дата</th>
                                    <th>Изменен</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['glampings'] as $key => $glamping) {
                                    if (usernameId($glamping['post_author'])['first_name']) {
                                        $user_name = usernameId($glamping['post_author'])['first_name'];
                                    } else {
                                        $user_name = usernameId($glamping['post_author'])['username'];
                                    }
                                    $thumb = $glamping['post_thumb_img'];
                                    $thumb_img = '../public/images/no-images.png';
                                    if ($thumb) {
                                        if (is_null($thumb)) {
                                            $thumb_img = '../public/images/no-images.png';
                                        } else {
                                            $thumb_img = json_decode($thumb, true);
                                            if (count($thumb_img)) {
                                                if ((int)$thumb_img['id']) {
                                                    $thumb_img = '/' . $thumb_img['link']['g'];
                                                } else {
                                                    $thumb_img = $thumb_img['link']['g'];
                                                }
                                            } else {
                                                $thumb_img = '../public/images/no-images.png';
                                            }
                                        }
                                    } else {
                                        $thumb_img = '../public/images/no-images.png';
                                    }
                                    ?>
                                    <tr id="user<?php echo $glamping['id'];?>">
                                        <td><?php echo $glamping['id'];?></td>
                                        <td class="table-img">
                                            <div class="tab-img border border-1 rounded-1">
                                                <img src="<?php echo $thumb_img;?>" alt="table-user" class="" />
                                            </div>
                                        </td>
                                        <td class="table-post-title"><?php echo $glamping['post_title'];?></td>
                                        <td><?php echo $user_name;?></td>
                                        <td><?php echo locations_post_slug($locations, $glamping['post_term'])['title'];?></td>
                                        <td>
                                            <?php if ($data['mod'] == 'admin') { ?>
                                            <div class="dropdown d-inline-block">
                                                <button type="button"
                                                    class="btn btn-sm dropdown-toggle arrow-none"
                                                    data-bs-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    title="Изменить пароль">
                                                    <?php echo post_status($glamping['post_status']);?>
                                                </button>
                                                <div class="dropdown-menu adm-user-settings">
                                                    <div class="px-2 py-2">
                                                        <div class="mb-3">
                                                            <label for="post_status" class="form-label">Статус</label>
                                                            <select class="form-select form-select-sm" id="post_status" name="post_status">
                                                                <option value="publish">Опубликован</option>
                                                                <option value="pending">На утверждении</option>
                                                                <option value="draft">Черновик</option>
                                                                <option value="private">Private</option>
                                                            </select>
                                                        </div>
                                                        <button class="btn btn-primary btn-sm js-adm-user-pass-edit"
                                                            data-id="<?php echo $glamping['id']?>"
                                                            data-type="glampings"
                                                            onclick="editStatus(this)">Изменить cтатус</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            } else {
                                                echo post_status($glamping['post_status']);
                                            }
                                            ?>
                                        </td>
                                        <td title="<?php echo date('d.m.Y H:i', strtotime($glamping['post_date']));?>">
                                            <?php echo date('d.m.Y', strtotime($glamping['post_date']));?>
                                        </td>
                                        <td title="<?php echo date('d.m.Y H:i', strtotime($glamping['post_modified']));?>">
                                            <?php echo date('d.m.Y', strtotime($glamping['post_modified']));?>
                                        </td>
                                        <td>
                                            <a href="<?php echo $glamping['post_url'];?>" target="_blank" class="text-reset fs-16 px-1" data-state="def" data-id="user<?php echo $user['id']?>" title="Смотреть">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="/<?php echo $data['mod'];?>/glamping-edit?id=<?php echo $glamping['id'];?>" class="text-reset fs-16 px-1 js-user-settings" data-id="user<?php echo $user['id']?>" title="Редактировать">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php } else { ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="page-title">Глэмпингов еще нет</h5>
                    </div>
                </div>
            <?php } ?>

            <div class="paginate mb-4">
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], $pagin_link, $pagin_link);?>
            </div>

        </div>

    </div>

    <?php
    echo csrf_field();

    // locationsCount();

    // rest_api_glemp();

    // $glampings = locationsCount();
    // $post_term = 'moskovskaya-oblast';
    // $result = array_filter($glampings, function($k) use ($post_term) {
    //     return $k['post_term'] === $post_term;
    // });

    // echo '<pre>';
    // var_dump($locations);
    // echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    ?>

</div>

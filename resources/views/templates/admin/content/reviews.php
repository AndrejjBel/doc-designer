<?php
$br_gen = 'Консоль';
$pagin_link = '/admin/posts';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
    $pagin_link = '/dashboard/posts';
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
                                <li class="breadcrumb-item active">Отзывы</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Отзывы</h4>
                    </div>
                </div>
            </div>

            <?php if (count($data['posts'])) { ?>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="table-responsive-sm">
                            <table class="table table-sm table-centered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Заголовок</th>
                                        <th>Автор</th>
                                        <th>Статус</th>
                                        <th>Дата</th>
                                        <th>Изменен</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['posts'] as $key => $post) {
                                        if (usernameId($post['post_author'])['first_name']) {
                                            $user_name = usernameId($post['post_author'])['first_name'];
                                        } else {
                                            $user_name = usernameId($post['post_author'])['username'];
                                        }
                                        ?>
                                        <tr id="user<?php echo $post['id'];?>">
                                            <td><?php echo $post['id'];?></td>
                                            <td class="table-post-title" title="<?php echo $post['post_title'];?>">
                                                <?php echo $post['post_title'];?>
                                            </td>
                                            <td><?php echo $user_name;?></td>
                                            <td>
                                                <?php if ($data['mod'] == 'admin') { ?>
                                                <div class="dropdown d-inline-block">
                                                    <button type="button"
                                                        class="btn btn-sm dropdown-toggle arrow-none"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                        title="Изменить пароль">
                                                        <?php echo post_status($post['post_status']);?>
                                                    </button>
                                                    <div class="dropdown-menu adm-user-settings">
                                                        <div class="px-2 py-2">
                                                            <div class="mb-3">
                                                                <label for="post_status" class="form-label">Статус</label>
                                                                <select class="form-select form-select-sm" id="post_status" name="post_status">
                                                                    <option value="published">Опубликован</option>
                                                                    <option value="pending">На утверждении</option>
                                                                    <option value="draft">Черновик</option>
                                                                    <option value="private">Private</option>
                                                                </select>
                                                            </div>
                                                            <button class="btn btn-primary btn-sm js-adm-user-pass-edit"
                                                                data-id="<?php echo $post['id']?>"
                                                                data-type="reviews"
                                                                onclick="editStatus(this)">Изменить cтатус</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                } else {
                                                    echo post_status($post['post_status']);
                                                }
                                                ?>
                                            </td>
                                            <td title="<?php echo date('d.m.Y H:i', strtotime($post['post_date']));?>">
                                                <?php echo date('d.m.Y', strtotime($post['post_date']));?>
                                            </td>
                                            <td title="<?php echo date('d.m.Y H:i', strtotime($post['post_modified']));?>">
                                                <?php echo date('d.m.Y', strtotime($post['post_modified']));?>
                                            </td>
                                            <td>
                                                <a href="/<?php echo $data['mod'];?>/review-edit?id=<?php echo $post['id'];?>" class="text-reset fs-16 px-1 js-user-settings" data-id="user<?php echo $user['id']?>" title="Редактировать">
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
                    <h5 class="page-title">Отзывов еще нет</h5>
                </div>
            </div>
        <?php } ?>

            <div class="paginate mb-4">
                <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], $pagin_link, $pagin_link);?>
            </div>

        </div>

    </div>

    <?php echo csrf_field();?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

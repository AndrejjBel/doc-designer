<?php
$pagin_link = '/admin/location';
if ($data['mod'] == 'dashboard') {
    $pagin_link = '/dashboard/location';
}
if (count($data['locations'])) {
?>
<div class="row g-4">
    <div class="col-12">
        <div class="mb-4">

            <div class="table-responsive-sm">
                <table class="table table-sm table-centered mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Название</th>
                            <th>Ссылка</th>
                            <th>Глэмпингов</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['locations'] as $key => $location) {
                            $thumb = $location['img'];
                            if ($thumb) {
                                $thumb_arr = json_decode($thumb, true)[0];
                                if ((int)$thumb_arr['id']) {
                                    $thumb_img = '/' . $thumb_arr['link'];
                                } else {
                                    $thumb_img = $thumb_arr['link'];
                                }
                            } else {
                                $thumb_img = '../public/images/noimg.png';
                            }
                        ?>
                            <tr id="location<?php echo $location['id']?>">
                                <td><?php echo $location['id']?></td>
                                <td class="table-img">
                                    <div class="tab-img border border-1 rounded-1">
                                        <img src="<?php echo $thumb_img;?>" alt="table-user" class="" />
                                    </div>
                                </td>
                                <td>
                                    <input class="form-control d-inline-flex border-0 bg-transparent ps-1 pe-1"
                                        type="text"
                                        name="first_name"
                                        value="<?php echo $location['title'];?>"
                                        readonly>
                                </td>
                                <td>
                                    <input class="form-control d-inline-flex border-0 bg-transparent ps-1 pe-1 w-auto"
                                    type="text"
                                    name="email"
                                    value="<?php echo $location['slug']?>"
                                    readonly>
                                </td>
                                <td><?php echo $location['count'] ;?></td>
                                <td>
                                    <!-- <a href="javascript: void(0);" class="text-reset fs-16 px-1 js-location-settings" data-bs-toggle="dropdown" data-id="user<?php echo $location['id']?>">
                                        <i class="ri-settings-3-line"></i>
                                    </a> -->
                                    <a href="#location-add"
                                        class="text-reset fs-16 px-1 js-location-edit nav-link active"
                                        data-state="def"
                                        data-id="location<?php echo $location['id']?>"
                                        data-bs-toggle="tab"
                                        role="tab"
                                        aria-selected="true"
                                        onclick="locEdit(this)"
                                        title="Редактировать">
                                        <i class="ri-edit-2-line"></i>
                                    </a>

                                    <!-- <a href="#location" data-bs-toggle="tab" aria-expanded="false" class="nav-link active" aria-selected="true" role="tab">Регионы</a> -->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php } else { ?>
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="page-title">Регионов еще нет</h5>
        </div>
    </div>
<?php } ?>

<div class="paginate mb-4">
    <?php echo paginat_admin($data['cur_page'], $data['pagesCount'], $pagin_link, $pagin_link);?>
</div>

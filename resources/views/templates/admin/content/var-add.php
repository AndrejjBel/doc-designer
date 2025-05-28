<?php
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
                                <li class="breadcrumb-item active">Добавить раздел переменных</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Добавить раздел переменных</h4>
                    </div>
                </div>
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

    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    ?>

</div>

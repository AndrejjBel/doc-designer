<?php
insertTemplate('/templates/header-new', ['data' => $data]);
?>

<div class="page-content">
    <div class="container">
        <h4 class="page-title text-center mb-5"><?php echo $data['page_data']['title'];?></h4>

        <div class="content-blocks">
            <?php echo bloksPageFront($data['page_data']['blocks']);?>
        </div>

    </div>
</div>



<?php
// $blocks = json_decode($data['page_data']['blocks'], true);
// $bloks_names = array_keys($blocks);
// foreach ($bloks_names as $key => $blok) {
//     $arg = json_decode($blocks[$blok], true);
//     // $fb_name = 'blok_' . $blok;
//     // $content .= $fb_name($blok);
// }

// echo $bloks_html = bloksPageFront($data['page_data']['blocks']);

// echo '<pre>';
// var_dump(json_decode($blocks['ssi']));
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);

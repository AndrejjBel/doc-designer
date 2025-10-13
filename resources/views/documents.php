<?php
insertTemplate('/templates/header-home', ['data' => $data]);
?>

<div class="container mb-5">
    <div class="page-title text-center mb-4 pb-2">
        <h1 class="mb-4">Документы</h1>
    </div>

    <div class="page-content documents">
        <div class="documents-filtr mb-4">
            <div class="row">
                <?php echo documents_list_filtr($data['products'], $data['prodGroups']);?>
            </div>
        </div>
        <!-- <a href="javascript:void(0)" class="d-block mb-4 documents-filtr-vision" onclick="documentsFiltrVision(this)">Показать все</a> -->

        <div class="documents-list">
            <h6 class="documents-count">Найдено
                <span class="doc-count"><?php echo documents_list($data['products'], $data['prodGroups'])['count'];?></span>
                <span class="doc-text"><?php echo num_word(documents_list($data['products'], $data['prodGroups'])['count'], ['документ', 'документа', 'документов'], false);?></span>
            </h6>
            <div class="row">
                <?php echo documents_list($data['products'], $data['prodGroups'])['content'];?>
            </div>
        </div>
    </div>
</div>

<?php

// echo documents_list_filtr($data['products'], $data['prodGroups']);

// $result = array_unique($docs);

// echo '<pre>';
// var_dump($docs);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);

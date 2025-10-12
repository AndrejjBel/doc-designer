<?php
insertTemplate('/templates/header-home', ['data' => $data]);
?>

<div class="container mb-5">
    <div class="page-title text-center mb-4 pb-2">
        <h1 class="mb-4">Документы</h1>
    </div>

    <div class="page-content documents">
        <div class="documents-list">
            <div class="row">
                <?php echo documents_list($data['products']);?>
            </div>
        </div>
    </div>
</div>

<?php

// echo '<pre>';
// var_dump($data['products']);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);

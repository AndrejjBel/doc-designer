<?php
insertTemplate('/templates/header-home', ['data' => $data]);
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="page-title text-center mb-4 pb-2">
                <h1 class="mb-4">Документы</h1>
            </div>
        </div>

        <div class="page-content documents"></div>
    </div>
</div>

<?php
insertTemplate('/templates/footer-new', ['data' => $data]);

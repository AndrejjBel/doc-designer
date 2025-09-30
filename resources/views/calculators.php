<?php
insertTemplate('/templates/header-home', ['data' => $data]);
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="page-title text-center mb-4 pb-2">
                <h1 class="mb-4">Калькуляторы</h1>
            </div>
        </div>

        <div class="page-content calculators">
            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2 calculators-item">
                <a href="/calculators/neustojka-brak/" class="calculators-item-link"></a>
                <div class="card blog border-0 work-container work-primary work-classic shadow rounded-md overflow-hidden">
                    <div class="card-body">
                        <div class="content">
                            <h5 class="mt-3">Калькулятор - неустойка, брак</h5>
                            <p class="text-muted">Описание Калькулятор - неустойка, брак</p>
                            <a href="javascript:void(0)" class="link h6">Сделать расчет <i class="uil uil-angle-right-b align-middle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
insertTemplate('/templates/footer-new', ['data' => $data]);

<?php
insertTemplate('/templates/header-new', ['data' => $data]);
?>

<div class="page-content">
    <div class="container">
        <h4 class="page-title text-center mb-5"><?php echo $data['page_data']['title'];?></h4>

        <div class="block-content block-tabs border rounded-2 p-3">
            <div class="row tabs-nav">
                <div class="col-lg-12">
                    <ul class="nav nav-pills flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link rounded active" id="pills-cloud-tab" data-bs-toggle="pill" href="#pills-cloud" role="tab" aria-controls="pills-cloud" aria-selected="false">
                                <div class="text-center">
                                    <h6 class="mb-0">Алименты с родителя-Судебный приказ</h6>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link rounded" id="pills-smart-tab" data-bs-toggle="pill" href="#pills-smart" role="tab" aria-controls="pills-smart" aria-selected="false">
                                <div class="text-center">
                                    <h6 class="mb-0">About</h6>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link rounded" id="pills-apps-tab" data-bs-toggle="pill" href="#pills-apps" role="tab" aria-controls="pills-apps" aria-selected="false">
                                <div class="text-center">
                                    <h6 class="mb-0">Service</h6>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row pt-3 tabs-content">
                <div class="col-12">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-cloud" role="tabpanel" aria-labelledby="pills-cloud-tab">
                            <p class="text-muted mb-0">You can combine all the Landrick templates into a single one, you can take a component from the Application theme and use it in the Website.</p>
                        </div>

                        <div class="tab-pane fade" id="pills-smart" role="tabpanel" aria-labelledby="pills-smart-tab">
                            <p class="text-muted mb-0">You can combine all the Landrick templates into a single one, you can take a component from the Application theme and use it in the Website.</p>
                        </div>

                        <div class="tab-pane fade" id="pills-apps" role="tabpanel" aria-labelledby="pills-apps-tab">
                            <p class="text-muted mb-0">You can combine all the Landrick templates into a single one, you can take a component from the Application theme and use it in the Website.</p>

                            <div class="row block-tabs-child mt-4">
                                <div class="col-lg-12">
                                    <ul class="nav nav-pills flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link rounded active" id="pills-cloud-tab" data-bs-toggle="pill" href="#pills-cloud1" role="tab" aria-controls="pills-cloud" aria-selected="false">
                                                <div class="text-center">
                                                    <h6 class="mb-0">Этап 1</h6>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link rounded" id="pills-smart-tab" data-bs-toggle="pill" href="#pills-smart1" role="tab" aria-controls="pills-smart" aria-selected="false">
                                                <div class="text-center">
                                                    <h6 class="mb-0">Этап 2</h6>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link rounded" id="pills-apps-tab" data-bs-toggle="pill" href="#pills-apps1" role="tab" aria-controls="pills-apps" aria-selected="false">
                                                <div class="text-center">
                                                    <h6 class="mb-0">Этап 3</h6>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="col-12">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-cloud1" role="tabpanel" aria-labelledby="pills-cloud-tab">
                                            <p class="text-muted mb-0">You can combine all the Landrick templates into a single one, you can take a component from the Application theme and use it in the Website.</p>
                                            <div class="d-grid gap-2 d-md-block mt-2">
                                                <button class="btn btn-primary text-uppercase" type="button">Создать исковое заявление</button>
                                                <button class="btn btn-primary text-uppercase" type="button">Создать ходатайство</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="pills-smart1" role="tabpanel" aria-labelledby="pills-smart-tab">
                                            <p class="text-muted mb-0">You can combine all the Landrick templates into a single one, you can take a component from the Application theme and use it in the Website.</p>
                                        </div>

                                        <div class="tab-pane fade" id="pills-apps1" role="tabpanel" aria-labelledby="pills-apps-tab">
                                            <p class="text-muted mb-0">You can combine all the Landrick templates into a single one, you can take a component from the Application theme and use it in the Website.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php

// $roles = rolesOptions();

// echo '<pre>';
// var_dump($roles);
// echo '</pre>';

insertTemplate('/templates/footer-new', ['data' => $data]);

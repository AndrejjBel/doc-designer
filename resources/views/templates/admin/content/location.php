<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/admin">Консоль</a></li>
                                <li class="breadcrumb-item active">Регионы</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Регионы</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="mb-5">
                        <ul id="loc" class="nav nav-tabs nav-bordered justify-content-between mb-3">
                            <li class="nav-item">
                                <a href="#location"
                                data-bs-toggle="tab"
                                aria-expanded="false"
                                class="nav-link active" onclick="locFormReset()">Регионы</a>
                            </li>
                            <li class="nav-item">
                                <a href="#location-add"
                                data-bs-toggle="tab"
                                aria-expanded="true"
                                class="nav-link">Добавить регион</a>
                            </li>
                        </ul>

                        <div class="tab-content mb-5">
                            <div class="tab-pane show active" id="location">
                                <?php insertTemplate('/templates/admin/content/tabs/location', ['data' => $data]);?>
                            </div>
                            <div class="tab-pane" id="location-add">
                                <?php insertTemplate('/templates/admin/content/tabs/location-add', ['data' => $data]);?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]); ?>

</div>

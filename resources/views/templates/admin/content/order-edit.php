<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/dashboard/generale">Консоль</a></li>
                                <li class="breadcrumb-item"><a href="/dashboard/orders">Заказы</a></li>
                                <li class="breadcrumb-item active">Редактирование заказа #<?php echo $data['order']?></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Заказ #<?php echo $data['order']?></h4>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <?php echo csrf_field();?>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

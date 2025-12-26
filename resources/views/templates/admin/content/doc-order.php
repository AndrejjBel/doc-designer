<?php
$br_gen = 'Консоль';
if ($data['mod'] == 'dashboard') {
    $br_gen = 'Личный кабинет';
}
$order = $data['order'];
$lawyer = '';
$lawyer_fio = '';
if ($order['lawyer']) {
    $lawyer = json_decode($order['lawyer'], true);
    $lawyer_fio = ($lawyer['fio'])? $lawyer['fio'] : $lawyer['username'];
}
$strjson = json_decode($order['strjson'], true);
$vars = $data['vars'];
$strjson_un = $strjson;
unset($strjson_un['summ']);
$nsrtl = '';
foreach ($strjson_un as $key => $value) {
    if (is_array($value)) {
        $nsrtl .= '<div class="doc-order-info-item d-flex mb-2">
            <div class="doc-order-info-item-title fw-bolder">' . varDescr($vars, $key) . ':</div>
            <div class="doc-order-info-item-text ms-2">
                ' . implode(', ', $value) . '
            </div>
        </div>';
    } else {
        $nsrtl .= '<div class="doc-order-info-item d-flex mb-2">
            <div class="doc-order-info-item-title fw-bolder">' . varDescr($vars, $key) . ':</div>
            <div class="doc-order-info-item-text ms-2">
                ' . $value . '
            </div>
        </div>';
    }
}
$user = $data['user'];
$message_title = 'Отправить сообщение юристу';
if ($user['roles_mask'] != 131072) {
    $message_title = 'Отправить сообщение заказчику';
}
$doc_upload = (count(commentsDocUp($data['comments'], 'doc_upload')))? array_shift(commentsDocUp($data['comments'], 'doc_upload')) : '';
$comments = commentsDocUp($data['comments'], 'comments');
$lawyers = get_lawyers();
?>
<div class="content-page user-settings">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod']?>"><?php echo $br_gen;?></a></li>
                                <li class="breadcrumb-item"><a href="/<?php echo $data['mod'];?>/orders-documents">Заказы документов</a></li>
                                <li class="breadcrumb-item active">Заказ №<?php echo $order['id']?></li>
                            </ol>
                        </div>
                        <!-- <h4 class="page-title">Заказ №<?php //echo $order['id'] . ': ' . mb_ucfirst($strjson['sos_trebovanie']);?></h4> -->
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="doc-order-info-wrap mb-3">
                        <div class="doc-order-title d-flex justify-content-between border-bottom pb-2">
                            <h4 class="page-title">Заказ №<?php echo $order['id'] . ': ' . mb_ucfirst($strjson['sos_trebovanie']);?></h4>
                            <?php if (is_lawyer_allowed()) { ?>
                                <button type="button"
                                    class="btn btn-sm btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalUploadDocument">Загрузить документ</button>
                            <?php } ?>
                        </div>
                        <div class="doc-order-info border-bottom mt-3 pb-3">
                            <div class="doc-order-info-item d-flex mb-2">
                                <div class="doc-order-info-item-title fw-bolder">Дата:</div>
                                <div class="doc-order-info-item-text ms-2">
                                    <?php echo date('d.m.Y', strtotime($order['dateopen']));?>
                                </div>
                            </div>
                            <div class="doc-order-info-item d-flex mb-2">
                                <div class="doc-order-info-item-title fw-bolder">Статус:</div>
                                <div class="doc-order-info-item-text d-flex ms-2">
                                    <span class="d-flex badge badge-outline-<?php echo doc_orders_status($order['status'])[2]?> w-fit-cont">
                                        <?php echo mb_ucfirst(doc_orders_status($order['status'])[1]);?>
                                    </span>
                                    <?php if ($order['status'] >= 2) { ?>
                                        <span class="d-flex badge badge-outline-success ms-1 w-fit-cont">
                                            Юрист: <?php echo $lawyer_fio;?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="doc-order-info-item d-flex mb-2">
                                <div class="doc-order-info-item-title fw-bolder">Стоимость:</div>
                                <div class="doc-order-info-item-text ms-2">
                                    <?php echo number_format($order['summ'], 0, '', ' ');;?> ₽
                                </div>
                            </div>

                            <div class="accordion accordion-flush" id="CardaccordionExample">
                                <div class="card mb-0 border-0">
                                    <div id="CardcollapseOne" class="collapse" aria-labelledby="CardheadingOne" data-bs-parent="#CardaccordionExample" style="">
                                        <div class="card-body p-0">
                                            <?php echo $nsrtl;?>
                                        </div>
                                    </div>
                                    <div class="card-header p-0 border-0" id="CardheadingOne">
                                        <h5 class="m-0">
                                            <a class="d-block info-doc-order" data-bs-toggle="collapse" href="#CardcollapseOne" aria-expanded="true" aria-controls="CardcollapseOne">
                                                Подробнее...
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($doc_upload) { ?>
                        <div class="result-doc border-bottom pb-4 mb-4">
                            <div class="message-item">
                                <div class="message-item-header rounded-top-2 py-2 px-3 text-bg-primary">
                                    <i class="bi bi-file-earmark-check me-1"></i>
                                    <span>Документ от юриста</span>
                                </div>
                                <div class="message-item-body border rounded-bottom-2 p-3">
                                    <div class="message-item-body-title fw-bolder mb-2">Документ готов к скачиванию</div>
                                    <a href="<?php echo $doc_upload['attachments'];?>" class="btn btn-sm btn-success mb-3" download>
                                        <i class="bi bi-file-earmark-arrow-up me-1"></i>
                                        <span>Скачать документ</span>
                                    </a>
                                    <div class="message-item-body-comment text-bg-light border rounded-2 p-2">
                                        <div class="message-item-body-comment-title fw-bolder">Комментарий юриста:</div>
                                        <?php echo $doc_upload['content'];?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($comments) { ?>
                        <div class="comments-doc">
                            <h4 class="comments-doc-title mb-3">Сообщения</h4>
                            <div class="message-items">
                                <?php foreach ($comments as $key => $comment) {
                                    $comment_author = userForId($comment['author']); //lawyersForId($lawyers, $comment['author']);
                                    $data_views = '';
                                    if (viewsMess($comment['views'], $user['id'])) {
                                        $data_views = 'vision';
                                        $views = '<div class="message-item-views">
                                            <i class="ri-mail-open-line email-action-icons-item text-white"></i>
                                        </div>';
                                    } else {
                                        $data_views = 'novision';
                                        $views = '<div class="message-item-views">
                                            <i class="ri-mail-unread-line email-action-icons-item text-white"></i>
                                        </div>';
                                    }
                                    if ($comment['author'] == $user['id']) {
                                        $who = 'Вы';
                                        $text_bg = 'info';
                                    } else {
                                        $who = ($comment_author['fio'])? $comment_author['fio'] : $comment_author['username'];
                                        if ($comment_author['roles_mask'] == 131072) {
                                            $text_bg = 'success';
                                        } else {
                                            $text_bg = 'info';
                                        }
                                    }
                                ?>
                                    <div id="mess-<?php echo $comment['comment_id'];?>" class="message-item mb-5" data-views="<?php echo $data_views;?>">
                                        <div class="message-item-header d-flex justify-content-between rounded-top-2 py-2 px-3 bg-<?php echo $text_bg;?>">
                                            <div class="message-item-info">
                                                <div class="message-item-who d-inline fs-18 fw-bolder text-white">
                                                    <?php echo $who;?>
                                                </div>
                                                <div class="message-item-date d-inline fs-14 text-white ms-2">
                                                    <?php echo date('d.m.Y H:m', strtotime($comment['date']));?>
                                                </div>
                                            </div>
                                            <?php echo $views;?>
                                        </div>
                                        <div class="message-item-body border rounded-bottom-2 p-3">
                                            <div class="message-item-body-comment text-bg-light border rounded-2 p-2">
                                                <?php echo $comment['content'];?>
                                            </div>
                                            <?php if ($comment['attachments']) { ?>
                                                <div class="message-item-body-attachments mt-3">
                                                    <a href="<?php echo $comment['attachments'];?>" class="btn btn-sm btn-secondary me-2" target="_blank">
                                                        <i class="ri-eye-line me-1"></i>
                                                        <span>Смотреть файл</span>
                                                    </a>
                                                    <a href="<?php echo $comment['attachments'];?>" class="btn btn-sm btn-success" download>
                                                        <i class="bi bi-file-earmark-arrow-up"></i>
                                                        <span>Скачать файл</span>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row mt-auto">
                <div class="accordion mb-4" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <?php echo $message_title;?>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body">
                                <form class="doc-comment-form" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Сообщение</label>
                                        <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label">Файл (PDF, JPG, PNG, DOC, DOCX — до 10 МБ)</label>
                                        <input class="form-control" type="file" id="message_file" name="message_file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUploadDocument" tabindex="-1" aria-labelledby="modalUploadDocumentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalUploadDocumentLabel">Готовый документ</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="upload-document-form" enctype="multipart/form-data">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Файл (PDF, JPG, PNG, DOC, DOCX — до 10 МБ)</label>
                            <input class="form-control" type="file" id="comment_file" name="comment_file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Комментарий</label>
                            <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary" data-bs-dismiss="modal">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    echo csrf_field();

    // $date = '2025-10-12';
    //
    // echo date('d-m-Y', strtotime($date));
    //
    // echo '<pre>';
    // echo var_dump(validateDate($date, 'Y-m-d'));
    // echo '</pre>';

    insertTemplate('/templates/admin/content/footer', ['data' => $data]);
    ?>

</div>

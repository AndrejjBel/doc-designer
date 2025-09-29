<div id="ssi" class="block-content block-tabs shadow-md bg-light-subtle rounded-2 p-3">
    <div class="row tabs-nav">
        <div class="col-lg-12">
            <ul class="nav nav-pills flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                <?php foreach ($data as $key => $item) {
                    $active_nav = '';
                    if ($key == 0) {
                        $active_nav = ' active';
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link rounded<?php echo $active_nav;?>" id="pills-cloud-tab" data-bs-toggle="pill" href="#pills-<?php echo $key;?>" role="tab" aria-controls="pills-cloud" aria-selected="false">
                            <div class="text-center">
                                <h6 class="mb-0">
                                    <?php echo $item->btn_text;?>
                                </h6>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="row pt-3 tabs-content">
        <div class="col-12">
            <div class="tab-content shadow-md rounded-2" id="pills-tabContent">
                <?php foreach ($data as $key => $item) {
                    $active_tab = '';
                    if ($key == 0) {
                        $active_tab = ' active';
                    }
                    ?>
                    <div class="tab-pane tab-pane-parent bg-body-tertiary rounded-2 fade show<?php echo $active_tab;?> p-3" id="pills-<?php echo $key;?>" role="tabpanel" aria-labelledby="pills-cloud-tab">
                        <h5><?php echo $item->tab_title;?></h5>
                        <div class="mb-0 pb-3 border-bottom">
                            <?php echo htmlspecialchars_decode(nl2br($item->tab_text), ENT_NOQUOTES);?>
                        </div>

                        <?php if (count($item->stages)) { ?>
                            <div class="row block-tabs-child mt-4">
                                <div class="col-lg-12">
                                    <ul class="nav nav-pills flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                                        <?php foreach ($item->stages as $in => $stage) {
                                            $active_nav_st = '';
                                            if ($in == 0) {
                                                $active_nav_st = ' active';
                                            }
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link rounded<?php echo $active_nav_st;?>" id="pills-cloud-tab" data-bs-toggle="pill" href="#pills-child-<?php echo $key.$in;?>" role="tab" aria-controls="pills-cloud" aria-selected="false">
                                                    <div class="text-center">
                                                        <h6 class="mb-0">Этап <?php echo $in+1;?></h6>
                                                    </div>
                                                </a>
                                            </li>

                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="col-12">
                                    <div class="tab-content shadow-sm rounded-2" id="pills-tabContent">
                                        <?php foreach ($item->stages as $it => $stage) {
                                            $active_tab_st = '';
                                            if ($it == 0) {
                                                $active_tab_st = ' active';
                                            }
                                            ?>
                                            <div class="tab-pane tab-pane-child bg-white rounded-2 fade show<?php echo $active_tab_st;?> p-3" id="pills-child-<?php echo $key.$it;?>" role="tabpanel" aria-labelledby="pills-cloud-tab">
                                                <div class="mb-3">
                                                    <?php echo htmlspecialchars_decode(nl2br($stage->stage_text), ENT_NOQUOTES);?>
                                                </div>
                                                <?php if (count($stage->btnsStages)) {
                                                    echo '<div class="d-flex flex-column flex-md-row gap-2 mt-2">';
                                                    foreach ($stage->btnsStages as $it => $btn) {
                                                        ?>
                                                        <a href="/documents/<?php echo $btn->stage_btn_link;?>" class="btn btn-primary text-uppercase" target="_blank"> <?php echo $btn->stage_btn_text;?> </a>
                                                    <?php }
                                                    echo '</div>';
                                                } ?>
                                                <!-- <div class="d-grid gap-2 d-md-block mt-2">
                                                <button class="btn btn-primary text-uppercase" type="button">Создать исковое заявление</button>
                                                <button class="btn btn-primary text-uppercase" type="button">Создать ходатайство</button>
                                            </div> -->
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>

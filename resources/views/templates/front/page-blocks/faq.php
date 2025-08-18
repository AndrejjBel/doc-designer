<div class="block-content block-faq">
    <h4 class="text-center fw-bolder mb-4">С чем мы можем вам помочь?</h4>
    <div class="accordion" id="buyingquestion">
        <?php foreach (faq_arr() as $key => $faq) { ?>
            <div class="accordion-item rounded mb-2">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo $key;?>"
                        aria-expanded="true" aria-controls="collapseOne">
                        <?php echo $faq[0];?>
                    </button>
                </h2>
                <div id="faq-<?php echo $key;?>" class="accordion-collapse border-0 collapse" aria-labelledby="headingOne"
                    data-bs-parent="#buyingquestion">
                    <div class="accordion-body text-muted">
                        <?php echo $faq[1];?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

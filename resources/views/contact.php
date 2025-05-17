<?php insertTemplate('/templates/header', ['data' => $data]); ?>

<!-- Hero Start -->
<section class="bg-half-170 bg-light d-table w-100" style="background: url('/assets/images/contact-detail.jpg') center center;">
    <div class="bg-overlay bg-overlay-white"></div>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title mb-0">Контакты</h4>
                </div>
            </div>  <!--end col-->
        </div><!--end row-->

        <div class="position-breadcrumb">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Контакты</li>
                </ul>
            </nav>
        </div>
    </div> <!--end container-->
</section><!--end section-->
<div class="position-relative">
    <div class="shape overflow-hidden text-color-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
<!-- Hero End -->

<!-- Start Contact -->
<section class="section pt-5 mt-4">
    <div class="container mt-100 mt-60">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0 order-2 order-md-1">
                <div class="card custom-form rounded border-0 shadow p-4">
                    <form method="post" name="myForm" id="myForm" onsubmit="return validateForm()">
                        <p id="error-msg" class="mb-0"></p>
                        <div id="simple-msg"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input name="name" id="name" type="text" class="form-control ps-5" placeholder="Name :">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                        <input name="email" id="email" type="email" class="form-control ps-5" placeholder="Email :">
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Subject</label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="book" class="fea icon-sm icons"></i>
                                        <input name="subject" id="subject" class="form-control ps-5" placeholder="subject :">
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Comments <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="message-circle" class="fea icon-sm icons clearfix"></i>
                                        <textarea name="comments" id="comments" rows="4" class="form-control ps-5" placeholder="Message :"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" id="submit" name="send" class="btn btn-primary">Send Message</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div><!--end custom-form-->
            </div><!--end col-->

            <div class="col-lg-7 col-md-6 order-1 order-md-2">
                <div class="title-heading ms-lg-4">
                    <h4 class="mb-4">Contact Details</h4>
                    <p class="text-muted">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                    <div class="d-flex contact-detail align-items-center mt-3">
                        <div class="icon">
                            <i data-feather="mail" class="fea icon-m-md text-dark me-3"></i>
                        </div>
                        <div class="flex-1 content">
                            <h6 class="title fw-bold mb-0">Email</h6>
                            <a href="mailto:contact@example.com" class="text-primary">contact@example.com</a>
                        </div>
                    </div>

                    <div class="d-flex contact-detail align-items-center mt-3">
                        <div class="icon">
                            <i data-feather="phone" class="fea icon-m-md text-dark me-3"></i>
                        </div>
                        <div class="flex-1 content">
                            <h6 class="title fw-bold mb-0">Phone</h6>
                            <a href="tel:+152534-468-854" class="text-primary">+152 534-468-854</a>
                        </div>
                    </div>

                    <div class="d-flex contact-detail align-items-center mt-3">
                        <div class="icon">
                            <i data-feather="map-pin" class="fea icon-m-md text-dark me-3"></i>
                        </div>
                        <div class="flex-1 content">
                            <h6 class="title fw-bold mb-0">Location</h6>
                            <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin" data-type="iframe" class="video-play-icon text-primary lightbox">View on Google map</a>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
<!-- End contact -->

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

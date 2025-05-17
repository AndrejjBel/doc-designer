<?php insertTemplate('/templates/header', ['data' => $data]);
$locations_home = locations_home();
?>

<section class="bg-half-170 d-table w-100" style="background: url('../public/assets/images/travel/bg.jpg') center center;">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <div class="title-heading mt-4">
                    <h1 class="display-4 fw-bold text-white title-dark mb-3">Путешествие <br> стало проще</h1>
                    <p class="para-desc text-white-50">Отправляйтесь в увлекательное путешествие с нами и откройте для себя мир роскошного отдыха на природе. Насладитесь комфортом и приключениями в уникальных местах!</p>
                </div>
            </div>

            <div class="col-lg-5 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="card shadow rounded border-0 ms-lg-5">
                    <div class="card-body">
                        <h5 class="card-title">Начните поиск здесь</h5>

                        <form class="login-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Регион</label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                            <select id="location" class="form-control ps-5" name="location" value="0">
                                                <?php echo $locations_home['options'];?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Заезд : </label>
                                        <input name="dateStart" type="text" class="form-control start" placeholder="Выберите дату :">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Выезд : </label>
                                        <input name="dateEnd" type="text" class="form-control end" placeholder="Выберите дату :">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-grid">
                                        <button id="search-home-submit" class="btn btn-primary">Искать</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="position-relative">
    <div class="shape overflow-hidden text-color-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Все для путешественников</h4>
                    <p class="text-muted para-desc mb-0 mx-auto">Сайт <span class="text-primary fw-bold">Путешественник</span> постоянно обновляется, что позволяет пользователям получать самую свежую информацию о путешествиях.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0 h-100">
                    <span class="h1 icon-color">
                        <i class="uil uil-award"></i>
                    </span>
                    <div class="card-body p-0 content d-flex flex-column">
                        <h5>Лучшие предложения</h5>
                        <p class="para text-muted mb-0 mt-auto">Только лучшие предложения для путешествий и отдыха!</p>
                    </div>
                    <span class="big-icon text-center">
                        <i class="uil uil-award"></i>
                    </span>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0 h-100">
                    <span class="h1 icon-color">
                        <i class="uil uil-thumbs-up"></i>
                    </span>
                    <div class="card-body p-0 content d-flex flex-column">
                        <h5>Легкий поиск</h5>
                        <p class="para text-muted mb-0 mt-auto">Легкий поиск идеального отдыха - наша специальность!</p>
                    </div>
                    <span class="big-icon text-center">
                        <i class="uil uil-thumbs-up"></i>
                    </span>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0 h-100">
                    <span class="h1 icon-color">
                        <i class="uil uil-favorite"></i>
                    </span>
                    <div class="card-body p-0 content d-flex flex-column">
                        <h5>Лучший рейтинг</h5>
                        <p class="para text-muted mb-0 mt-auto">Отдыхай с нами на одном из рейтинговых сайтов для путешествий!</p>
                    </div>
                    <span class="big-icon text-center">
                        <i class="uil uil-favorite"></i>
                    </span>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 mt-4 pt-2">
                <div class="card features feature-primary feature-full-bg rounded p-4 bg-light text-center position-relative overflow-hidden border-0 h-100">
                    <span class="h1 icon-color">
                        <i class="uil uil-clock"></i>
                    </span>
                    <div class="card-body p-0 content d-flex flex-column">
                        <h5>Поддержка 24/7</h5>
                        <p class="para text-muted mb-0 mt-auto">Ваш надежный компаньон в мире путешествий - поддержка 24/7</p>
                    </div>
                    <span class="big-icon text-center">
                        <i class="uil uil-clock"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-100 mt-60">
        <div class="row align-items-end mb-4 pb-2">
            <div class="col-md-8">
                <div class="section-title text-center text-md-start">
                    <h6 class="text-primary">Узнайте самые</h6>
                    <h4 class="title mb-4">Популярные направления</h4>
                    <p class="text-muted mb-0 para-desc">Найди для себя любимый регион: наслаждайся путешествиями и отдыхом с нами!</p>
                </div>
            </div>

            <div class="col-md-4 mt-4 mt-sm-0">
                <div class="text-center text-md-end">
                    <a href="/location/" class="text-primary h6">Смотреть все <i data-feather="arrow-right" class="fea icon-sm"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4 pt-2">
                <div class="tiny-six-item">
                    <?php echo $locations_home['slider_loc'];?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title">
                    <h4 class="title fw-bold mb-4">Популярные глэмпинги</h4>
                    <p class="text-muted para-desc mb-0 mx-auto">Откройте мир уютных <span class="text-primary fw-bold">глэмпингов:</span> идеальное сочетание комфорта и природы!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-100 mt-60">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-flex flex-wrap popular-glampings-home">
                    <?php popular_glampings_home($data['glamping']);?>
                </div>
            </div>

            <div class="col-lg-12 text-center col-md-4 mt-4 pt-2">
                <a href="/glampings/" class="btn btn-primary">Смотреть все <i data-feather="arrow-right" class="fea icon-sm"></i></a>
            </div>
        </div>
    </div>

    <div class="container mt-100 mt-60">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Отзывы реальных людей о местах отдыха</h4>
                    <p class="text-muted para-desc mx-auto mb-0">Актуальная <span class="text-primary fw-bold">информация</span> от реальных путешественников</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12 mt-4">
                <div class="tiny-three-item reviews">
                    <?php reviews_home($data['reviews']);?>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-100 mt-60">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Отправляйтесь в увлекательное <span class="text-primary">путешествие</span> с нами</h4>
                    <p class="text-muted para-desc mx-auto mb-0"><span class="text-primary">Путешественник</span> - источник вдохновения и информации для всех любителей путешествий</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12 mt-4">
                <p>Путешествия — это увлекательное и захватывающее занятие, которое может принести массу пользы и удовольствия. Для многих людей путешествия становятся неотъемлемой частью их жизни, позволяя расширить кругозор, познакомиться с новыми культурами и традициями, а также отдохнуть от повседневной рутины.</p>
                <p>Путешествия имеют огромное значение для физического и психического здоровья человека. Новые впечатления и эмоции способствуют улучшению настроения, снижению стресса и улучшению общего самочувствия. Кроме того, путешествия способствуют развитию личности, укреплению самооценки и обогащению жизненного опыта.</p>
                <p>Выбор места для путешествия зависит от целей и интересов путешественника. Можно выбрать городской тур для знакомства с архитектурными достопримечательностями, пляжный отдых для релаксации, экскурсии для познания истории и культуры страны, или поездку в природные парки для наслаждения красотой природы.</p>
                <p>Подготовка к путешествию включает в себя оформление необходимых документов, составление маршрута и плана поездки, а также подбор жилья, транспорта и экскурсий. Важно также уделить внимание безопасности и экономии времени и денег во время путешествия.</p>
                <p>Блог о путешествиях — это уникальная возможность поделиться своими впечатлениями, советами и историями успеха или неудач. Рассказывая о своих приключениях, можно вдохновить других на новые путешествия и помочь им избежать ошибок.</p>
                <p>Путешествия играют важную роль в жизни каждого человека, помогая расширить кругозор, насладиться красотой мира и отдохнуть от повседневных забот. Не стоит откладывать путешествия на потом — ведь каждая поездка может стать незабываемым приключением и обогатить вашу жизнь.</p>
                <p>Используйте сайт Путешественник для поиска глэмпингов в России и отдыхайте вдали от городской суеты с комфортом.</p>
            </div>
        </div>

    </div>
</section>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

// rest_api_reviews();

// echo '<pre>';
// var_dump($data['reviews']);
// echo '</pre>';

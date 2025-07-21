<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/admin">Консоль</a></li>
                                <li class="breadcrumb-item active">Добавить пользователя</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Добавить пользователя</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <form id="add-user">
                        <div class="mb-3">
                            <label for="name" class="form-label">Логин <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Логин" required>
                            <span class="help-block"><small>Логин может состоять из латинских букв и цифр, символов "_" и "-", начало и окончание буква</small></span>
                            <div id="name" class="invalid-feedback">Заполните Имя пользователя.</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" autocomplete="new-email" required>
                            <div id="name" class="invalid-feedback">Заполните E-mail пользователя.</div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Роль пользователя</label>
                            <!-- <select class="form-select" name="role" id="role">
                                <?php //echo createRolesOptions('Выберите роль', 131072);?>
                            </select> -->

                            <select class="form-select" name="role" id="role">
                                <option value="262144">СУПЕРАДМИН</option>
                                <option value="524288">СУПЕРРЕДАКТОР</option>
                                <option value="1048576">СУПЕРМОДЕРАТОР</option>
                                <option value="1">АДМИН</option>
                                <option value="1024">РЕДАКТОР</option>
                                <option value="16384">МОДЕРАТОР</option>
                                <option value="8192">МЕНЕДЖЕР</option>
                                <option value="65536">РЕЦЕНЗЕНТ</option>
                                <option value="131072" selected>ПОДПИСЧИК</option>
                                <!-- <option value="0">Выберите роль</option>
                                <option value="1">АДМИН</option>
                                <option value="2">АВТОР</option>
                                <option value="4">СОТРУДНИК</option>
                                <option value="8">КОНСУЛЬТАНТ</option>
                                <option value="16">ПОТРЕБИТЕЛЬ</option>
                                <option value="32">УЧАСТНИК</option>
                                <option value="64">КООРДИНАТОР</option>
                                <option value="128">СОЗДАТЕЛЬ</option>
                                <option value="256">РАЗРАБОТЧИК</option>
                                <option value="512">ДИРЕКТОР</option>
                                <option value="1024">РЕДАКТОР</option>
                                <option value="2048">СОТРУДНИК</option>
                                <option value="4096">ОБСЛУЖИВАЮЩИЙ</option>
                                <option value="8192">МЕНЕДЖЕР</option>
                                <option value="16384">МОДЕРАТОР</option>
                                <option value="32768">ИЗДАТЕЛЬ</option>
                                <option value="65536">РЕЦЕНЗЕНТ</option>
                                <option value="131072" selected>ПОДПИСЧИК</option>
                                <option value="262144">СУПЕРАДМИН</option>
                                <option value="524288">СУПЕРРЕДАКТОР</option>
                                <option value="1048576">СУПЕРМОДЕРАТОР</option>
                                <option value="2097152">ПЕРЕВОДЧИК</option> -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Введите пароль" autocomplete="new-password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            <span class="help-block"><small>Оставьте пустым, если хотите что-бы пароль был сгенерирован</small></span>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="send_email" id="send_email" value="1">
                                <label class="form-check-label" for="send_email">Отправить письмо пользователю с логином и паролем</label>
                            </div>
                        </div>
                        <?php echo csrf_field();?>
                        <button type="submit" name="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php insertTemplate('/templates/admin/content/footer', ['data' => $data]);?>

</div>

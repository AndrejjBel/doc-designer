<header>
    <nav class="navbar bg-body-tertiary">
        <div class="container">
            <div class="navbar-brand">
                Logo
                <!-- <img src="../public/imgages/logo.jpg" alt="Logo" width="auto" height="30" class="d-inline-block align-text-top"> -->
            </div>

            <?php if (is_login()) { ?>
                <div class="navbar-logout-btn d-flex align-items-center justify-content-center">
                    <div class="navbar-logout-btn__navbar-username me-2">
                        <h6 class="mb-0"><?php echo userData('name');?></h6>
                    </div>
                    <form action="/logout" method="post" accept-charset="utf-8">
                        <input type="hidden" name="actions" value="logOut">
                        <button type="submit" class="btn btn-outline-primary">Выйти</button>
                    </form>
                </div>
            <?php } else { ?>
                <a href="/login" class="btn btn-outline-primary">Войти</a>
            <?php } ?>
        </div>
    </nav>
</header>

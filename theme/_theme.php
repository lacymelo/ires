<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="<?= url('/theme/assets/images/favicon.png') ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <title><?= $title ?></title>

    <!-- fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
    <!-- flaticon -->
    <link rel="stylesheet" href="<?= url('/theme/assets/css/flaticon.css') ?>" />

    <!-- vertical-responsive-menu -->
    <link href="<?= url('/theme/assets/css/vertical-responsive-menu.min.css'); ?>" rel="stylesheet" />
    <!-- style -->
    <link href="<?= url('/theme/assets/css/instructor-dashboard.css'); ?>" rel="stylesheet" />
    <!-- responsive -->
    <link href="<?= url('/theme/assets/css/responsive.css'); ?>" rel="stylesheet" />
    <!-- night-mode -->
    <link href="<?= url('/theme/assets/css/night-mode.css'); ?>" rel="stylesheet" />
    <!-- bootstrap.min -->
    <link href="<?= url('/theme/assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <!-- semantic.min -->
    <link href="<?= url('/theme/assets/css/semantic.min.css'); ?>" rel="stylesheet" />
    <!-- owl.carousel -->
    <link href="<?= url('/theme/assets/css/owl.carousel.css'); ?>" rel="stylesheet" />
    <!-- owl.theme.default.min -->
    <link href="<?= url('/theme/assets/css/owl.theme.default.min.css'); ?>" rel="stylesheet" />
    <!-- modal -->
    <link href="<?= url('/theme/assets/css/modals.css'); ?>" rel="stylesheet" />
    <!-- notificação -->
    <link href="<?= url('/theme/assets/css/Lobibox.min.css'); ?>" rel="stylesheet" />
    <link href="<?= url('/theme/assets/css/notifications.css'); ?>" rel="stylesheet" />

</head>

<body>
    <?php if ($logged) : ?>
        <!-- Header Start -->
        <header class="header clearfix">

            <span id="name-page"></span>
            <span id="session-user"></span>
            <span id="session-room"></span>
            <button type="button" id="toggleMenu" class="toggle_menu">
                <i class='fla flaticon-menu-1 collapse_menu--icon'></i>
            </button>

            <button id="collapse_menu" class="collapse_menu">
                <i class="fla flaticon-menu-1 collapse_menu--icon "></i>
                <span class="collapse_menu--label"></span>
            </button>

            <div class="main_logo" id="logo">
			    <a href="<?= url('/home') ?>"><img src="<?= url('/theme/assets/images/logo-ires-preta.svg') ?>" alt="logo-ires"></a>
                <a href="<?= url('/home') ?>"><img src="<?= url('/theme/assets/images/logo-ires-clara.svg') ?>" class="logo-inverse"  alt="logo-ires"></a>        
            </div>

            <div class="search120">
                <div class="ui search">
                    <div class="ui left icon input swdh10">
                        <input class="prompt srch10 text_search" type="text" name="text_search" id="text_search" onkeyup="searchForKeyWord(1)" placeholder="O que você está procurando?">
                        <i class="fla-3x flaticon-search icon icon1"></i>
                    </div>
                </div>
            </div>

            <div class="header_right">
                <ul>
                    <li class="ui dropdown">
                        <a href="#" class="opts_account" title="Conta">
                            <img src="<?= url('/theme/assets/images/profile-user.svg') ?>" alt="">
                        </a>
                        <div class="menu dropdown_account">
                            <div class="channel_my">
                                <div class="profile_link">
                                    <img src="<?= url('/theme/assets/images/profile-user.svg') ?>" alt="">
                                    <div class="pd_content">
                                        <div class="rhte85">
                                            <h6 class="perfil-name">Joginder Singh</h6>
                                        </div>
                                        <span class="perfil-email">gambol943@gmail.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="night_mode_switch__btn">
                                <a href="#" id="night-mode" class="btn-night-mode">
                                    <i class="fla flaticon-moon"></i> Noturno
                                    <span class="fla-right btn-night-mode-switch">
                                        <span class="uk-switch-button"></span>
                                    </span>
                                </a>
                            </div>
                            <a href="<?= url("/logout") ?>" class="item channel_item">Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <!-- Header End -->

        <!-- Left Sidebar Start -->
        <nav class="vertical_nav">
            <div class="left_section menu_left" id="js-menu">
                <div class="left_section">
                    <ul>
                        <li class="menu--item">
                            <a href="<?= url('/home') ?>" class="menu--link" data-page="home" title="Home">
                                <i class='fla flaticon-calendar menu--icon'></i>
                                <span class="menu--label">Nova Reserva</span>
                            </a>
                        </li>

                        <li class="menu--item">
                            <a href="<?= url('/my-reservations') ?>" class="menu--link" data-page="my-reservations" title="Minhas Reservas">
                                <i class='fla flaticon-address-book menu--icon'></i>
                                <span class="menu--label">Minhas Reservas</span>
                            </a>
                        </li>

                        <li class="menu--item menu--admin hidden">
                            <a href="<?= url('/manage-rooms') ?>" class="menu--link" data-page="manage-rooms" title="Gerenciar Salas">
                                <i class='fla flaticon-building menu--icon'></i>
                                <span class="menu--label">Gerenciar Salas</span>
                            </a>
                        </li>

                        <li class="menu--item menu--admin hidden">
                            <a href="<?= url('/manage-resources') ?>" class="menu--link" data-page="manage-resources" title="Gerenciar Recursos">
                                <i class='fla flaticon-box-1 menu--icon'></i>
                                <span class="menu--label">Gerenciar Recursos</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="left_footer">
                    <div class="left_footer_content">
                        <p>&copy; <?= date('Y') ?> <strong>iRes</strong>. Developed by <a href=""> Equipe Home Office</a></p>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Left Sidebar End -->

        <?= $v->section("content"); ?>
    <?php else : ?>
        <?= $v->section("content"); ?>
    <?php endif; ?>


    <?php if ($v->section("footer")) :
        echo $v->section("footer");
    endif; ?>


    <!-- END WRAPPER -->

    <!-- JAVASCRIPT -->
    <!-- demo -->
    <script src="<?= url('/theme/assets/js/demo.js') ?>"></script>
    <!-- vertical-responsive-menu.min -->
    <script src="<?= url('/theme/assets/js/vertical-responsive-menu.min.js') ?>"></script>
    <!-- jquery -->
    <script src="<?= url('/theme/assets/js/jquery-3.3.1.min.js') ?>"></script>
    <!-- bootstrap -->
    <script src="<?= url('/theme/assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- owl.carousel -->
    <script src="<?= url('/theme/assets/js/owl.carousel.js') ?>"></script>
    <!-- semantic -->
    <script src="<?= url('/theme/assets/js/semantic.min.js') ?>"></script>
    <!-- custom -->
    <script src="<?= url('/theme/assets/js/custom.js') ?>"></script>
    <!-- night-mode -->
    <script src="<?= url('/theme/assets/js/night-mode.js') ?>"></script>
    <!-- notificação -->
    <script src="<?= url('/theme/assets/js/Lobibox.js') ?>"></script>
    <script src="<?= url('/theme/assets/js/alert-notification.js') ?>"></script>
    <script src="<?= url('/theme/assets/js/notification-active.js') ?>"></script>
    <!-- pagination  -->
    <script src="<?= url('/vendor/labex/js/pagination.js') ?>"></script>
    <!-- modal-show -->
    <script src="<?= url('/theme/assets/js/showModal.js') ?>"></script>
    <?= $v->section("scripts"); ?>
</body>

</html>
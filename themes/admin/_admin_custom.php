<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--font true type-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400&display=swap');
    </style>
    <!--fim font true type-->

    <?= $head; ?>

    <!-- Google Font: Source Sans Pro -->
    <!--link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/fontawesome-free/css/all.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/jqvmap/jqvmap.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= theme("/assets/css/adminlte.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/daterangepicker/daterangepicker.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/plugins/summernote/summernote-bs4.min.css", CONF_VIEW_THEME_ADMIN); ?>">

    <link rel="stylesheet" href="<?= theme("/assets/plugins/toastr/toastr.min.css", CONF_VIEW_THEME_ADMIN); ?>">

    <link rel="stylesheet" href="<?= theme("/assets/plugins/select2/css/select2.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css", CONF_VIEW_THEME_ADMIN); ?>">

    <link rel="stylesheet" href="<?= theme("/assets/plugins/ekko-lightbox/ekko-lightbox.css", CONF_VIEW_THEME_ADMIN); ?>">

    <link rel="stylesheet" href="<?= theme("/assets/css/dash.css", CONF_VIEW_THEME_ADMIN); ?>">

    <link rel="stylesheet" type="text/css" href="" <?= theme("/assets/css/bootstrap-multiselect.css", CONF_VIEW_THEME_ADMIN); ?>">

    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins//bootstrap4-duallistbox/bootstrap-duallistbox.min.css", CONF_VIEW_THEME_ADMIN); ?>">

    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/fullcalendar/main.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("/assets/plugins/fullcalendar-daygrid/main.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("/assets/plugins/fullcalendar-timegrid/main.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("/assets/plugins/fullcalendar-bootstrap/main.min.css", CONF_VIEW_THEME_ADMIN); ?>">

    <link media="all" rel="stylesheet" type="text/css" href="<?= theme("/assets/highslide/highslide.css", CONF_VIEW_THEME_ADMIN); ?>">

    <!--link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" /-->
    <link rel="stylesheet" type="text/css" href="" <?= theme("/assets/css/jquery.dataTables.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />

    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <link rel="icon" type="image/png" href="<?= url("shared/images/logo2.png") ?>" />

</head>

<div class="ajax_load">
    <div class="ajax_load_box">

        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-center">
                    <div class="col-md-4 col-sm-6 grid-margin stretch-card">
                        <div class="loader-box">
                            <div class="jumping-dots-loader"> <span></span> <span></span> <span></span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>


<?php
$logo = user()->showLogo();
$companyLogo = ($logo ? image($logo, 100, 100) : "");
?>

<body class="hold-transition sidebar-mini layout-footer-fixed">
    <div class="wrapper">
        <input type="hidden" name="today" id="today" value="<?= date("d/m/Y") ?>">
        <input type="hidden" name="today_convert" id="today_convert" value="<?= date("Y-m-d") ?>">
        <?php if (isset(returnScheduling()->date_return)) : ?>
            <input type="hidden" id="scheduling" value="<?= returnScheduling()->date_return ?>">
        <?php else : ?>
            <input type="hidden" id="scheduling" value="1">
        <?php endif ?>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">&nbsp;<a class="nav-link text-primary"></a></li>
                <li class="nav-item">&nbsp;<a class="nav-link text-primary"></a></li>
                <!--li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li-->

                <!--li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= $router->route("dash.dash"); ?>" class="nav-link text-primary"><i class="fas fa-suitcase"> <?= user()->account()->description; ?></i></a>
                </li-->
            </ul>

            <!-- Right navbar links -->
            <!--mexi aqui-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form action="<?= url("/cliente/consulta"); ?>" method="post">
                        <div>
                            <div class="input-group">
                                <input class="form-control txt_numero" type="search" name="search_matricula" id="search_matricula" placeholder="Procurar..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-sidebar">
                                        <i class="fas fa-search fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>


                <!-- Notifications Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars" title="MENU"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $router->route("dash.dash"); ?>" class="nav-link">
                        <i class="fas fa-suitcase" title="<?= user()->account()->description; ?>"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell" title="NOTIFICAÇÕES"></i>
                        <span class="badge badge-danger navbar-badge">1</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Notificações 1</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2" title="NOTIFICAÇÕES"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 dias</span>
                        </a>
                    </div>
                </li>


                <!--li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt" title="EXPANDIR TELA"></i>
                    </a>
                </li-->
                <li class="nav-item">
                    <a href="<?= $router->route("dash.logoff"); ?>" class="nav-link text-danger"><i class="fas fa-power-off" title="SAIR"></i></a>
                </li>
                <!--li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li-->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-blue elevation-">
            <div id="faixaazul">
                <a href="<?= $router->route("dash.dash"); ?>" class="brand-link">
                    <img src="<?= url("/shared/images/logo6.png") ?>" width="200" alt="Logo">
                </a>
            </div>
            <?php
            $photo = user()->showPhoto();
            $userPhoto = ($photo ? image($photo, 300, 300) : theme("/assets/images/avatar.jpg", CONF_VIEW_THEME_ADMIN));
            ?>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $userPhoto; ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <?php if (user()->admin_account == 0 && user()->client == 1) : ?>
                            <a href="<?= url("/usuario/alterar/" . user()->id); ?>" class="d-block"><?= user()->fullName(); ?></a>
                        <?php else : ?>
                            <a href="#" class="d-block"><?= user()->fullName(); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- SidebarSearch Form -->

                <form action="<?= url("/cliente/consulta"); ?>" method="post">
                    <div>
                        <!--div class="input-group">
                            <input class="form-control txt_numero" type="search" name="search_matricula" id="search_matricula" placeholder="Procurar..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
							
						
							
                        </div-->
                        <!--a class="nav-link" data-widget="pushmenu" href="#" role="button">
						<i class="fas fa-bars" title="MENU"></i>
						</a-->
                    </div>
                </form>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                        <?php if (user()->level_id == 1) : ?>
                            <li <?php if ($menu == "dash") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="<?= $router->route("dash.dash"); ?>" <?php if ($submenu == "dash") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <!--li <?php if ($menu == "filter") : ?>class="nav-item menu-open"<?php else : ?>class="nav-item"<?php endif ?>>
                        <a href="#" <?php if ($menu == "filter") : ?>class="nav-link active"<?php else : ?>class="nav-link"<?php endif ?>>
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Filtros
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= $router->route("filter.home"); ?>" <?php if ($submenu == "filterHome") : ?>class="nav-link active"<?php else : ?>class="nav-link"<?php endif ?>>
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cadastrar Filtros</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $router->route("filter.workList"); ?>" <?php if ($submenu == "workList") : ?>class="nav-link active"<?php else : ?>class="nav-link"<?php endif ?>>
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Lista de Trabalho</p>
                                </a>
                            </li>
                        </ul>
                    </li-->
                        <?php if (user()->level_id == 1) : ?>
                            <li <?php if ($menu == "filter") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="<?= $router->route("filter.home"); ?>" <?php if ($submenu == "filterHome") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>Cadastrar Filtros</p>
                                </a>
                            </li>
                        <?php endif ?>
                        <li <?php if ($menu == "workList") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                            <a href="<?= $router->route("filter.workList"); ?>" <?php if ($submenu == "workList") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                <i class="nav-icon fas fa-list"></i>
                                <p>Lista de Trabalho</p>
                            </a>
                        </li>
                        <li <?php if ($menu == "search") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                            <a href="<?= $router->route("filter.search"); ?>" <?php if ($submenu == "search") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                <i class="nav-icon fas fa-search"></i>
                                <p>Consulta</p>
                            </a>
                        </li>

                        <li <?php if ($menu == "schedulings") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                            <a href="<?= $router->route("filter.scheduling"); ?>" <?php if ($submenu == "schedulings") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Agendamentos</p>
                            </a>
                        </li>
                        <li <?php if ($menu == "attendances") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                            <a href="<?= $router->route("filter.attendance"); ?>" <?php if ($submenu == "attendances") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                <i class="nav-icon fas fa-phone"></i>
                                <p>Atendimentos</p>
                            </a>
                        </li>

                        <?php if (user()->level_id == 2) : ?>
                            <li <?php if ($submenu == "tickets-unpaid" || $submenu == "tickets-paid") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="#" <?php if ($submenu == "tickets-unpaid" || $submenu == "tickets-paid") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>
                                        Boletos
                                        <i class="right fas fa-angle-down"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php if (user()->client == 1) : ?>
                                        <li class="nav-item menu-open">
                                            <a href="<?= $router->route("ticket.clientTicketsUnpaid"); ?>" class="nav-link">
                                                <i 
                                                    class="<?php if ($submenu == "tickets-unpaid"): ?>fas <?php else: ?> far <?php endif; ?> fa-circle nav-icon"></i>
                                                <p>Boletos a pagar</p>
                                            </a>
                                        </li>

                                        <li class="nav-item menu-open">
                                            <a href="<?= $router->route("ticket.clientTicketPaid"); ?>" <?php if ($submenu == "tickets-paid") : ?>class="nav-link" <?php else : ?>class="nav-link" <?php endif ?>>
                                                <i class="<?php if ($submenu == "tickets-paid"): ?>fas <?php else: ?> far <?php endif; ?> fa-circle nav-icon"></i>
                                                <p>Boletos pagos</p>
                                            </a>
                                        </li>
                                        
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        

                        <?php if (user()->level_id == 1) : ?>
                            <li <?php if ($menu == "resumo") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="<?= $router->route("filter.resumo"); ?>" <?php if ($submenu == "resumo") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>Resumo</p>
                                </a>
                            </li>

                            <li <?php if ($menu == "user") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="#" <?php if ($menu == "user") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-address-card"></i>
                                    <p>
                                        Meus Usuários
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php if (user()->client == 1) : ?>
                                        <li class="nav-item">
                                            <a href="<?= $router->route("users.home"); ?>" <?php if ($submenu == "home") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Usuários</p>
                                            </a>
                                        </li>
                                    <?php else : ?>
                                        <li class="nav-item">
                                            <a href="<?= $router->route("users.account"); ?>" <?php if ($submenu == "home") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Clientes</p>
                                            </a>
                                        </li>
                                    <?php endif ?>
                                    <!--li class="nav-item">
									<a href="<?= $router->route("users.passwordChange"); ?>" <?php if ($submenu == "password_change") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
										<i class="far fa-circle nav-icon"></i>
										<p>Alteração de Senha</p>
									</a>
								</li-->
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Conta</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li <?php if ($menu == "banks") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="<?= $router->route("banks.home"); ?>" <?php if ($submenu == "banks") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-university"></i>
                                    <p>Bancos e Coeficientes</p>
                                </a>
                            </li>
                            <li <?php if ($menu == "client_blocked") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="<?= $router->route("clients.blocked"); ?>" <?php if ($submenu == "client_blocked") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-users-slash"></i>
                                    <p>Clientes Bloqueados</p>
                                </a>
                            </li>
                            <?php if (user()->account()->use_api == 1 && user()->account()->api==1 ) : ?>
                                <li <?php if ($menu == "consultApi") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                    <a href="<?= $router->route("filter.consultApi"); ?>" <?php if ($submenu == "consultApi") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                        <i class="nav-icon fas fa-search"></i>
                                        <p>Consulta API</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!--li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>
                                        Promotoras
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="https://api.whatsapp.com/send?phone=5521993355486" target="blank" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>AS Promotora</p>
                                        </a>
                                    </li>

                                </ul>
                            </li-->
                            <li <?php if ($menu == "log") : ?>class="nav-item menu-open" <?php else : ?>class="nav-item" <?php endif ?>>
                                <a href="<?= $router->route("dash.log"); ?>" <?php if ($submenu == "log") : ?>class="nav-link active" <?php else : ?>class="nav-link" <?php endif ?>>
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>Log</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (user()->level_id == 1) : ?>
                            <li class="nav-item">
                                <a href="https://api.whatsapp.com/send?phone=5521994157982&text=Ol%C3%A1%2C%20preciso%20de%20ajuda%20com%20Sistema%20Cred" target="blank" class="nav-link">
                                    <i class="nav-icon fas fa-headset"></i>
                                    <p>Suporte</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                <!-- Notification popup -->
                <?php 
                    $ticketToPay = $ticketToPay ?? null;
                    if ($ticketToPay && user()->level_id == 2) {
                        include_once __DIR__."/./tickets/components/notification.php";
                    }
                ?>
                
            </div>
            <!-- /.sidebar -->
        </aside>

        <!--container-->
        <?= $v->section("content"); ?>
        <!-- /.container -->
        <input type="hidden" id="flash" value="<?= flash() ?>" />
        <input type="hidden" id="user_validate" value="<?= user()->password_validate ?>">

        <footer class="main-footer">
            <strong>Copyright &copy; <?= date("Y"); ?> <a href="#" style="color:#6495ED;">Sistema Cred</a>.</strong>
            Todos os direitos reservados.
            <div class="float-right d-none d-sm-inline-block">
                <b>Versão</b> 1.1
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <div class="modal" id="modalPassword2" tabindex="-1" data-backdrop="static" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Altere Sua Senha Antes de usar o Sistema</h5>
                </div>

                <form action="<?= $router->route("users.passwordchangepopup", ['id' => user()->id]); ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nova Senha:</label>
                                <input class="form-control" type="password" name="new_password" placeholder="Nova Senha" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Mudar Senha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php if(isset(returnScheduling()->date_return)): ?>
    <div class="modal" id="modalScheduling" tabindex="-1" data-backdrop="static" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Existe um atendimento agendado para <?= date_fmt2(returnScheduling()->date_return) ?></h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container">
                                <table class="table" >
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Matrícula</th>
                                            <th>CPF</th>
                                            <th>Atendimento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= returnScheduling()->clientDesc()->NOME ?></td>
                                            <td><?= returnScheduling()->clientDesc()->MATRICULA ?></td>
                                            <td><?= returnScheduling()->clientDesc()->CPF ?></td>
                                            <td><a href="<?= url("/cliente/consulta/" . returnScheduling()->clientDesc()->id); ?>"><i class="fas fa-phone"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php endif; ?>
 <!-- jQuery -->
 <script src="<?= url("/shared/scripts/jquery.min.js"); ?>"></script>

<script src="<?= url("/shared/scripts/jquery.form.js"); ?>"></script>

<!-- Pnotify -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/attempt-to-update-packagist/pnotify.js" integrity="sha512-vVCwjYtarAac2AMUNPP0cqRITQ00L8kXCRzUfLInqdz3iPUa/3kuBiXjhcEG4VaBLsBzgcChpq68qzUl1LAZ4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?= url("/shared/scripts/jquery-ui.js"); ?>"></script>

<script src="<?= url("/shared/scripts/jquery.mask.js"); ?>"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="<?= url("/shared/scripts/scripts.js"); ?>"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="<?= theme("/assets/js/popper.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= theme("/assets/plugins/bootstrap/js/bootstrap.bundle.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- ChartJS -->
<script src="<?= theme("/assets/plugins/chart.js/Chart.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Sparkline -->
<script src="<?= theme("/assets/plugins/sparklines/sparkline.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- JQVMap -->
<script src="<?= theme("/assets/plugins/jqvmap/jquery.vmap.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<script src="<?= theme("/assets/plugins/jqvmap/maps/jquery.vmap.usa.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= theme("/assets/plugins/jquery-knob/jquery.knob.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- daterangepicker -->
<script src="<?= theme("/assets/plugins/moment/moment.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<script src="<?= theme("/assets/plugins/daterangepicker/daterangepicker.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= theme("/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Summernote -->
<script src="<?= theme("/assets/plugins/summernote/summernote-bs4.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= theme("/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= theme("/assets/js/adminlte.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Toastr -->
<script src="<?= theme("/assets/plugins/toastr/toastr.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= theme("/assets/js/demo.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= theme("/assets/js/pages/dashboard.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Select2 -->
<script src="<?= theme("/assets/plugins/select2/js/select2.full.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Ekko Lightbox -->
<script src="<?= theme("/assets/plugins/ekko-lightbox/ekko-lightbox.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Filterizr-->
<script src="<?= theme("/assets/plugins/filterizr/jquery.filterizr.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?= theme("/assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>

<script src="<?= theme("/assets/js/bootstrap-multiselect.js", CONF_VIEW_THEME_ADMIN); ?>"></script>

<script src="<?= theme("/assets/js/Financing.min.js?_v=0", CONF_VIEW_THEME_ADMIN); ?>"></script>

<!-- fullCalendar 2.2.5 -->
<script src="<?= theme("/assets/plugins/fullcalendar/main.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<script src="<?= theme("/assets/plugins/fullcalendar-daygrid/main.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<script src="<?= theme("/assets/plugins/fullcalendar-timegrid/main.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<script src="<?= theme("/assets/plugins/fullcalendar-interaction/main.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<script src="<?= theme("/assets/plugins/fullcalendar-bootstrap/main.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>

<script type="text/javascript" src="<?= theme("/assets/highslide/highslide-full.packed.js", CONF_VIEW_THEME_ADMIN) ?>"></script>


<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src=" https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="<?= theme("/assets/js/notification.js", CONF_VIEW_THEME_ADMIN); ?>"></script>


    <script type="text/javascript">
        // Cristiano's code... 

        var path = '<?php echo url(); ?>'

        hs.graphicsDir = '<?= theme("/assets/highslide/graphics/", CONF_VIEW_THEME_ADMIN); ?>'
        hs.align = 'center';
        hs.transitions = ['expand', 'crossfade'];
        hs.outlineType = 'rounded-white';
        hs.fadeInOut = true;
        //hs.dimmingOpacity = 0.75;

        // Add the controlbar
        hs.addSlideshow({
            //slideshowGroup: 'group1',
            interval: 5000,
            repeat: false,
            useControls: true,
            fixedControls: 'fit',
            overlayOptions: {
                opacity: .75,
                position: 'bottom center',
                hideOnMouseOut: true
            }
        });


        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })

        var table = $('#table-tickets').DataTable({
            "ordering": false,
            "paging": true,
            "info": true,
            "lengthChange": true,
            "language": {
                "search": "Procurar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                "lengthMenu": "_MENU_ Resultados por página",
                "zeroRecords": "Nenhum Registro Encontrado",
                "info": "Mostrar página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum Registro Encontrado",
                "infoFiltered": "(filtrar por _MAX_ total de registro)"
            },

            responsive: true
        });

    </script>
    <?= $v->section("scripts"); ?>
</body>

</html>
<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 "><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <br><br>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-usuario">
                        <div class="inner">
							<h6>Usuários</h6>
                             <div class="dashInfo"><?=$users?></div>
							
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="<?= $router->route("users.home"); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
				
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-camp_usuario">
                        <div class="inner">
                            <h6>Campanhas por usuários</h6>
                            <div class="dashInfo">0</div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
				
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-filtroativo">
                        <div class="inner">
                            <h6>Filtros ativos</h6>
                            <div class="dashInfo"><?=$filter_active?></div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-play"></i>
                        </div>
                        <a href="<?= $router->route("filter.home"); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-filtroespera">
                        <div class="inner">
                            <h6>Filtros em espera</h6>
                            <div class="dashInfo"><?=$filter_pause?></div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-pause"></i>
                        </div>
                        <a href="<?= $router->route("filter.home"); ?>" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
				
				<div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-atendimento">
                        <div class="inner">
                            <h6>Atendimentos pessoais</h6>
                            <div class="dashInfo">0</div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
				
				
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-atendimentoMes">
                        <div class="inner">
                            <h6>Atendimentos da equipe no mês</h6>

                            <div class="dashInfo">0</div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
			

            <!--div class="row">
                

            </div-->
            <br>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
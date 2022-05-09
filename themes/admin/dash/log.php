<?php $v->layout("_admin"); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-cog"></i> Registro de Log</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Registo de Log</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid"><br>
                <div class="card"><br>
                    <div class="row mb-2">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <h3 class="m-0">Ações feitas hoje:</h3>
                            </div>
                        </div>
                    </div>
                <?php if (!$log): ?>
               <div class="row" >
                    <div class="col-sm-12 fas fa-info text-danger " align="center">
                        Não existem ações feitas hoje.
                    </div>
                </div><br>
                <?php else: ?>
                <div class="row">
                    <div class="col-sm-12" align="center">
                        <table  id="example1" class="display" >
                            <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Usuário</th>
                                <th>IP</th>
                                <th>Data/Hora</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($log as $logs): ?>
                                <tr>
                                    <td><?php echo $logs->description; ?></td>
                                    <td><?php echo $logs->returnUser()->fullName(); ?></td>
                                    <td><?php echo $logs->ip; ?></td>
                                    <td><?php echo date_fmt($logs->created_at); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                   </div>
                </div><br>
                <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
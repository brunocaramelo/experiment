<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 "><i class="fas fa-lock"></i> Alteração de Senha</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Alteração de Senha</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"><br>
            <div class="card">
                <form action="<?= $router->route("users.passwordChangeAlt",['cod_user' => $cod_user]); ?>" method="post">
                    <div class="card-body">
                        <?= csrf_input(); ?>
                        <input type="hidden" name="action" value="change"/>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Senha Antiga:</label>
                                <input class="form-control" type="password" name="old_password" placeholder="Senha Antiga" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nova Senha:</label>
                                <input class="form-control" type="password" name="new_password" placeholder="Nova Senha" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Confirmar Senha:</label>
                                <input class="form-control" type="password" name="password_confirm" placeholder="Confirmar Senha" required/>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                            <button class="btn btn-success"><i class="fas fa-edit"> Alterar Senha</i></button>
                    </div><!-- /.card-footer -->
                </form><!-- /.form -->
            </div><!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<!-- /.content-wrapper -->
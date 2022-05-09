<?php $v->layout("_login"); ?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="<?=url("/shared/images/logo.png")?>" width="130" alt="Logo">
        </div>
        <div class="card-body">
            <?= flash(); ?>
            <form name="login" action="<?= $router->route("login.forgetPost"); ?>" method="post">
                <?= csrf_input(); ?>
                <br>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Informe seu e-mail">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control mask-doc" name="document" placeholder="CPF">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-file"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control mask-date" name="datebirth" placeholder="Data de Nascimento">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-calendar-alt"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Recuperar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
            <footer>
                <p><h5><a title="Fazer Login" href="<?=$router->route("login.login"); ?>">Voltar e entrar!</a></h5></p>
                <hr style="border:1px solid;color:#D3D3D3;"><p><a href="#" target="_blank">Sistema Cred</a>&copy; <?= date("Y"); ?> - todos os direitos reservados</p>
            </footer>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
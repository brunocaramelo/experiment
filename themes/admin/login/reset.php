<?php $v->layout("_login"); ?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="<?=url("/shared/images/logo.png")?>" width="130" alt="Logo">
        </div>
        <div class="card-body">
            <?= flash(); ?>
            <form name="login" action="<?= $router->route("login.forgetResetPost"); ?>" method="post">
                <?= csrf_input(); ?>
                <br>
                <input type="hidden" name="code" value="<?= $code; ?>"/>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Informe sua nova senha:" required/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input name="password_re" type="password" class="form-control" placeholder="Repita sua nova senha:" required/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Alterar senha</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
            <footer>
                <p><h5><a title="Fazer Login" href="<?=$router->route("login.login"); ?>">Voltar e entrar!</a></h5></p>
                <hr style="border:1px solid;color:#D3D3D3;"><p><a href="#" target="_blank">Sistema Cred</a>&copy; <?= date("Y"); ?> - todos os direitos reservados</p>
            </footer>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</div>
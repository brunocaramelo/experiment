<?php $v->layout("_login"); ?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="<?=url("/shared/images/logo.png")?>" width="130" alt="Logo">
        </div>
        <div class="card-body">
            <!--div class="ajax_response"><?= flash(); ?></div-->
            <form name="login" action="<?= $router->route("login.loginPost"); ?>" method="post">
                <?= csrf_input(); ?>
                <br><input type="text"  name="email" value="<?=flash()?>">
                <!--div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div-->
                <div class="input-group mb-3">
                    <input type="password" class="form-control"  name="password" placeholder="Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
            <footer>
                <p><h5><a title="Recuperar senha" href="<?=$router->route("login.forget"); ?>">Esqueceu sua senha?</a></h5></p>
                <hr style="border:1px solid;color:#6495ED;"><p><a href="">Sistema Cred</a>&copy; <?= date("Y"); ?> - todos os direitos reservados</p>
            </footer>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</div>
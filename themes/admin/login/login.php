<?php $v->layout("_login"); ?>

<div class="login-box">

    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
		<br>
        <div class="card-header text-center">
            <img class="logo" src="<?=url("/shared/images/logo.png")?>" alt="Logo">
        </div>
        <div class="card-body">
            <div class="ajax_response"><?= flash(); ?></div>
            <form name="login" action="<?= $router->route("login.loginPost"); ?>" method="post">
                <?= csrf_input(); ?>
                <br>
				
				
				
				<!-- teste aqui-->
				<div class="label-float">
				  <input type="email"  class="form-control" name="email" placeholder=" " required/>
				  <label>Email</label>
				</div>
				<br/>
				<div class="label-float">
				  <input type="password" class="form-control" name="password" placeholder=" " required/>
				  <label>Senha</label>
				</div>
				<!-- fim de teste-->
				
				<br>
				
				<!-- removi as linhas abaixo para novo login acima-->
                <!--div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div-->
                <!--div class="input-group mb-3">
                    <input type="password" class="form-control"  name="password" placeholder="Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
					
                </div-->
				
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <!--button type="submit" class="btn btn-primary btn-block">Entrar</button-->
                        <button type="submit" class="btn btn-block btn-sm">ENTRAR</button>
						<small style="font-size: 11px; float: right;margin-top: 10px;"><a title="Recuperar senha" href="<?=$router->route("login.forget"); ?>">Esqueceu sua senha?</a></small>
                        
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->
			<br><br><br>

            <!-- /.card-body -->
        </div>
		            <footer>
              
                <hr style="border:1ßpx dotted;color:#318FC2;"><p><a href="">Sistema Cred</a></p>
            </footer>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</div>
<br>
<small style="font-size: 12px; color: #f2f2f2;">&copy; <?= date("Y"); ?> - todos os direitos reservados</small>

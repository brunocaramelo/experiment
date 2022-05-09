<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	
<!--font true type-->
<style>
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400&display=swap');
</style>
<!--fim font true type-->


    <?= $head; ?>

    <!-- Google Font: Source Sans Pro -->
    <!--adriano removeu aqui abaixo, se não esmerdar, remover o código pra ficar limpo-->
    <!--link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"--->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/fontawesome-free/css/all.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= theme("/assets/css/adminlte.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("/assets/css/style.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("/assets/plugins/toastr/toastr.min.css", CONF_VIEW_THEME_ADMIN); ?>">


 <!-- USAR -  PARTICULAS -->
<link rel="stylesheet" href="<?= theme("/assets/css/particles/css/main.css", CONF_VIEW_THEME_ADMIN); ?>">
<link rel="stylesheet" href="<?= theme("/assets/css/particles/css/style-default.css", CONF_VIEW_THEME_ADMIN); ?>">
 <!-- FIM -  PARTICULAS -->
 
    <link rel="icon" type="image/png" href="<?=url("shared/images/logo2.png")?>"/>
</head>

<body class="hold-transition login-page">
  <div class="hh-cover page-cover">
    <!-- Cover Background -->
    <!--div class="cover-bg bg-img " data-image-src="images/bg-default1.jpg"></div-->

    <!-- Particles as background - uncomment below to use particles/snow -->
    <div id="particles-js" class="cover-bg pos-abs full-size bg-color" data-bgcolor="rgba(35, 8, 255, 0.7)"></div>
  </div>
	
<div class="ajax_load">
    <div class="ajax_load_box">
		<!-- MEXI AQUI EM 11/01/2022 - LOADING-->
		<!--div id="loading-test-5" style="height: 300px; width: 100%;z-index: 9999">
		<div class="loading text-warning" data-mdb-parent-selector="#loading-test-5">
		<div class="fas fa-spinner fa-spin fa-2x"></div>
			<br>
		<span class="loading-text text-warning">Aguarde, carregando...</span>
		</div>
		</div-->
		
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

	
	
<?= $v->section("content"); ?>

<script src="<?= url("/shared/scripts/jquery.min.js"); ?>"></script>
<script src="<?= url("/shared/scripts/jquery-ui.js"); ?>"></script>
<script src="<?= url("/shared/scripts/jquery.mask.js"); ?>"></script>
<script src="<?= url("/shared/scripts/login.js"); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= theme("/assets/plugins/bootstrap/js/bootstrap.bundle.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= theme("/assets/js/adminlte.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
<!-- Toastr -->
<script src="<?= theme("/assets/plugins/toastr/toastr.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
 
 <!-- USAR NO FIM DO CÓDIGO -  PARTICULAS -->
  <script src="<?= theme("/assets/css/particles/js/particles.min.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
  <script src="<?= theme("/assets/css/particles/js/particles-init.js", CONF_VIEW_THEME_ADMIN); ?>"></script>
 <!-- fim - USA NAS PARTICULAS -->
</body>
</html>

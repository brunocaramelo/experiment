<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/fontawesome-free/css/all.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= theme("/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= theme("/assets/css/adminlte.min.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="stylesheet" href="<?= theme("/assets/css/style.css", CONF_VIEW_THEME_ADMIN); ?>">
    <link rel="icon" type="image/png" href="<?=url("shared/images/logo_principal.png")?>"/>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="<?=url("/shared/images/logo.png")?>" width="130" alt="Logo">
        </div>
        <div class="card-body">
            <h4><p class="error"><div align="center">&bull;<?= $var_error->code; ?>&bull;</div></p></h4>
            <h1><?= $var_error->title; ?></h1>
            <p><?= $var_error->message; ?></p>
            <a href="<?= $router->route("login.login"); ?>"><?= $var_error->linkTitle; ?></a>
            <footer>
                <hr style="border:1px solid;color:#D3D3D3;"><p><a href="#" target="_blank">Sistema Cred</a>&copy; <?= date("Y"); ?> - todos os direitos reservados</p>
            </footer>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</div>
</body>
</html>
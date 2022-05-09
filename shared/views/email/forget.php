<?php $v->layout("_theme", ["title" => "Redefina sua senha para acessar o SistemaCred"]); ?>

<h2>Esqueceu sua senha <?= $first_name; ?>?</h2>
<p>Você está recebendo este e-mail pois foi solicitado a redefinição de senha no sistema SistemaCred.</p>
<p><a title='Recuperar Senha' href='<?= $forget_link; ?>'>CLIQUE AQUI PARA CRIAR UMA NOVA SENHA</a></p>
<p><b>IMPORTANTE:</b> Se não foi você que solicitou ignore o e-mail. Seus dados permanecem seguros.</p>
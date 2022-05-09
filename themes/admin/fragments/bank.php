<article class="auxs_aux">
    <h3><?=$bank->bank?></h3>
    <a class="remove" href="#" data-action="<?= $router->route("auxiliar.bankDelete"); ?>"
       data-id="<?=$bank->id?>">Deletar</a>
</article>

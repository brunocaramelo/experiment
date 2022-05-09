<article class="auxs_aux">
    <h3><?=$genre->description?></h3>
    <a class="remove" href="#" data-action="<?= $router->route("auxiliar.genreDelete"); ?>"
       data-id="<?=$genre->id?>">Deletar</a>
</article>
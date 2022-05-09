<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-search"></i> Consulta</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Consulta</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <form action="<?= url("/consulta"); ?>" method="post">
                <div class="row"><input type="hidden" name="action" value="search" />
                    <div class="col-4">
                        <label>Data inicial:</label>
                        <input type="text" class="form-control mask-date txt_data" value=<?= $inicial_date ?> id="inicial_date" name="inicial_date">
                    </div>
                    <div class="col-4">
                        <label>Data final:</label>
                        <input type="text" class="form-control mask-date txt_data" value=<?= $final_date ?> id="final_date" name="final_date">
                    </div>
                    <div class="col-md-4" style="margin-top:32px">
                        <button class="btn btn-success">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </form><br>
            <?php
            if ($searchs) : ?>
                <table id="example1" class="display">
                    <thead>
                        <tr>
                            <th>Nome do usuário <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Perfil do usuário <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Convênio <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Matrícula <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>CPF <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Nome <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Idade <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem ">&and;</span></th>
                            <th>Data <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchs as $search) : ?>
                            <tr>
                                <td><b><?= $search->userDesc()->fullName() ?></b></td>
                                <td><b><?= $search->userDesc()->level()->description ?></b></td>
                                <?php if ($search->clientDesc()->CLIENT_ORGAN == 1) : ?>
                                    <td><b>Exército</b></td>
                                <?php endif; ?>
                                <?php if ($search->clientDesc()->CLIENT_ORGAN == 2) : ?>
                                    <td><b>Marinha</b></td>
                                <?php endif; ?>
                                <?php if ($search->clientDesc()->CLIENT_ORGAN == 3) : ?>
                                    <td><b>Aeronáutica</b></td>
                                <?php endif; ?>
                                <?php if ($search->clientDesc()->CLIENT_ORGAN == 4) : ?>
                                    <td><b>Siape</b></td>
                                <?php endif; ?>
                                    <td><b><?= $search->clientDesc()->MATRICULA ?></b></td>
                                <td><b><?= $search->clientDesc()->CPF ?></b></td>
                                <td><b><?= $search->clientDesc()->NOME ?></b></td>
                                <td><b><?= return_age($search->clientDesc()->NASCIMENTO) ?></b></td>
                                <td><b><?= date_fmt_br($search->created_at) ?></b></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?= count($searchs); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table><br>
            <?php endif; ?>
        </div><!-- /.card-body pb-0 -->
    </div><!-- /.card card-solid -->
</div><!-- /.content-wrapper-->
<?php $v->start("scripts");
?>
<script>
    /*$(function () {
            toastr.success("O filtro foi excluído com sucesso...");
        });*/
</script>
<?php

if (!$searchs) :
?>
    <script>
        $(function() {
            toastr.error("Nenhum consulta encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
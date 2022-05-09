<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-phone"></i> Atendimentos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Atendimentos</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div><br>
            <?php
            if ($attendances) : ?>
                <table id="example1" class="display">
                    <thead>
                        <tr>
                            <th>Filtro <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Usuário <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Data <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Telefone</th>
                            <th>Retorno <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Base</th>
                            <th>CPF </th>
                            <th>Cliente <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Dt. Retorno<span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Telefone de Retorno</th>
                            <th>Observação </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendances as $attendance) : ?>
                            <tr>
                                <td><b><?php if(isset($attendance->filterDesc()->title)): echo $attendance->filterDesc()->title; else: echo"Sem filtro"; endif; ?></b></td>
                                <td><b><?= $attendance->userDesc()->fullName() ?></b></td>
                                <td><b><?= date_fmt($attendance->created_at) ?></b></td>
                                <td><b><?= returnPhone($attendance->clientDesc()->TELEFONE_01) ?></b></td>
                                <td><b><?= $attendance->attendanceDesc()->description ?></b></td>
                                <td><b><?php foreach($attendance->organDesc() as $organ): echo $organ->organ; endforeach; ?></b></td>
                                <td><b><?= $attendance->clientDesc()->CPF ?></b></td>
                                <td><b><?= $attendance->clientDesc()->NOME ?></b></td>
                                <?php if ($attendance->scheduling_id != 0) : ?>
                                    <td><b><?= date_fmt2($attendance->schedulingDate()->date_return) ?></b></td>
                                <?php else : ?>
                                    <td><b><?= $attendance->scheduling_id?></b></td>
                                <?php endif; ?>
                                <td><b><?= $attendance->phone ?></b></td>
                                <td><b><?= $attendance->description ?></b></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?= count($attendances); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
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

if (!$attendances) :
?>
    <script>
        $(function() {
            toastr.error("Nenhum atendimento encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
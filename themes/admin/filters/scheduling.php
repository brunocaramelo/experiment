<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-calendar-alt"></i> Agendamentos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Agendamentos</li>
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
            if ($schedulings) : ?>
                <table id="example1" class="display">
                    <thead>
                        <tr>
                            <th>Consultor <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Matrícula <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>CPF <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Retorna em <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Telefone Retorno</th>
                            <th>Observação <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedulings as $scheduling) : ?>
                            <tr>
                                <td><b><?= $scheduling->userDesc()->fullName() ?></b></td>
                                <td><b><?= $scheduling->clientDesc()->MATRICULA ?></b></td>
                                <td><b><?= $scheduling->clientDesc()->CPF ?></b></td>
                                <td><b><?= date_fmt2($scheduling->date_return) ?></b></td>
                                <td><b><?= $scheduling->phone ?></b></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?= count($schedulings); ?></td>
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
    $(function () {

     });
</script>
<?php

if (!$schedulings) :
?>
    <script>
        $(function() {
            toastr.error("Nenhum agendamento encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
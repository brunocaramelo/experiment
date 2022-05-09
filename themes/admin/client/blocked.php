<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users-slash"></i> Clientes Bloqueados</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Clientes Bloqueados</li>
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

            </div><br>
            <?php
            if (count($client_blocked)>0) : ?>
                <table id="filter" class="display">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>Motivo</th>
                            <th>Orgão</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($client_blocked as $each) : ?>
                            <tr>
                                    <td><b><?= $each->MATRICULA; ?></b></td>
                                    <td><b><?= $each->CPF ?></b></td>
                                    <td><b><?= $each->NOME ?></b></td>
                                    <td><b><?= $each->description; ?></b></td>
                            <?php if($each->CLIENT_ORGAN==1): ?>
                                <td><b>Exército</b></td>
                            <?php endif;?>
                            <?php if($each->CLIENT_ORGAN==2): ?>
                                <td><b>Marinha</b></td>
                            <?php endif;?>
                            <?php if($each->CLIENT_ORGAN==3): ?>
                                <td><b>Aeronáutica</b></td>
                            <?php endif;?>
                            <?php if($each->CLIENT_ORGAN==4): ?>
                                <td><b>Siape</b></td>
                            <?php endif;?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?= count($client_blocked); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table>
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

if (!$client_blocked) :
?>
    <script>
        $(function() {
            toastr.error("Nenhum filtro encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
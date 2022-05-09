<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-edit"></i> Filtros</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Filtros</li>
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
                <div class="col-md-4">
                    <?php if (user()->level_id == 1) : ?>
                        <a href="<?= $router->route("filter.filterAdd"); ?>" class="btn btn-success">Novo Filtro</a>
                    <?php endif; ?>
                </div>
                <div class="col-md-5">
                </div>
                <div class="col-md-9">
                </div>
            </div><br>
            <?php
            if ($filters) : ?>
                <table id="filter" class="display">
                    <thead>
                        <tr>
                            <th>Código do Filtro</th>
                            <th>Base</th>
                            <th>Título</th>
                            <th>Situação</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filters as $filter) : ?>
                            <tr style="cursor:pointer">
                                <td><b><?= $filter->codFilter(); ?></b></td>
                                <td><b><?= $filter->organDesc()->organ ?></b></td>
                                <td><b><?= $filter->title ?></b></td>
                                <td><b><span <?php if ($filter->status_filter == "ATIVO") : ?>class="text-success" <?php endif ?> <?php if ($filter->status_filter == "AGUARDANDO") : ?>class="text-primary" <?php endif ?> <?php if ($filter->status_filter == "PAUSADO") : ?>class="text-secondary" <?php endif ?> <?php if ($filter->status_filter == "FINALIZADO") : ?>class="text-danger" <?php endif ?>><?= $filter->status_filter ?></span></b></td>
                                <td><b><?= date_fmt_br2($filter->attendence_of) ?></b></td>
                                <td><b><?= date_fmt_br2($filter->until_attendence_of) ?></b></td>
                                <td>
                                    <a href="<?= url("/filtro/copy/{$filter->cod}"); ?>" class="" title="Copiar" ><i class="fas fa-copy"></i>
                                        </a>
                                </td>
                                <td><a href="<?= url("/filtro/alterar/{$filter->cod}"); ?>" class="" title="Consultar"><i class="fas fa-search"></i></a></td>
                                <td>
                                    <a href="#" class="text-danger" title="Excluir" data-post="<?= url("/filtro/excluir/{$filter->cod}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja excluir esse filtro e todos os dados relacionados a ele? Essa ação não pode ser desfeita!" data-client_cod="<?= $filter->cod; ?>"><i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?= count($filters); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table>
                <?= $paginator; ?>
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

if (!$filters) :
?>
    <script>
        $(function() {
            toastr.error("Nenhum filtro encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
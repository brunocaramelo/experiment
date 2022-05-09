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
                    <a href="<?= $router->route("filter.filterAdd"); ?>" class="btn btn-success">Novo Filtro</a>
                </div>
                <div class="col-md-5">
                </div>
            </div><br>
            <?php
            if($filters):?>
                <table id="example1" class="display" >
                <thead>
                    <tr>
                        <th>NOME</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($filters as $filter): ?>
                      <tr>
                            <td><?=$filter->nome;?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?=count($filters);?></td>
                    
                    </tfoot>
                </table><br>
            <?php endif;?>
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

if(!$filters):
    ?>
    <script>
        $(function () {
            toastr.error("Nenhum filtro encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
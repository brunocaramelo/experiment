<?php $v->layout("_admin"); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-university"></i> Bancos e Coeficientes</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Bancos e Coeficientes</li>
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
                    <a href="<?= $router->route("banks.bankAdd"); ?>" class="btn btn-success">Novo Banco</a>
                </div>
                <div class="col-md-5">
                </div>
            </div><br>
            <?php
            if($banks):?>
                <table id="example1" class="display" >
                <thead>
                    <tr>
                        <th>Banco</th>
                        <th>Status</th>
                        <th>Excluir</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($banks as $bank): ?>
                        <tr>
                            <td><a href="<?= url("/banco-e-coeficiente/alterar/{$bank->cod}"); ?>" class="" title="Consultar"><?=$bank->bank?></a></td>
                            <td><?php if($bank->status=="1"):?>Ativo<?php else:?>Inativo<?php endif?></td>
                            <td>
                                <a href="#" class="text-danger" title="Excluir" data-post="<?= url("/banco-e-coeficiente/excluir/{$bank->id}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja excluir esse banco e todos os dados relacionados a ele? Essa ação não pode ser desfeita!" data-client_cod="<?= $filter->cod; ?>"><i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?=count($banks);?></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table><br>
            <?php endif;?>
        </div><!-- /.card-body -->
    </div><!-- /.card card-solid -->
</div><!-- /.content-wrapper-->
<?php $v->start("scripts");
if(!$banks):
    ?>
    <script>
        $(function () {
            toastr.error("Nenhum banco encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
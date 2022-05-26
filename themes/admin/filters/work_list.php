<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-file"></i> Lista de Trabalho</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Lista de Trabalho</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <form action="<?= url("/lista-de-trabalho"); ?>" method="post">
                <div class="row"><input type="hidden" name="action" value="search" />
                    <div class="col-md-2">
                        <label>Base:</label>
                        <select class="form-control" name="organ">
                            <option <?php if ($organ == "") : ?> selected <?php endif; ?> value="">Todos</option>
                            <option <?php if ($organ == 1) : ?> selected <?php endif; ?> value="1">Exército</option>
                            <option <?php if ($organ == 2) : ?> selected <?php endif; ?> value="2">Marinha</option>
                            <option <?php if ($organ == 3) : ?> selected <?php endif; ?>value="3">Aeronáutica</option>
                            <option <?php if ($organ == 4) : ?> selected <?php endif; ?>value="4">Siape</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Titulo:</label>
                        <input class="form-control" type="text" name="s" placeholder="Procurar..." value="<?= $search; ?>" aria-label="Search">
                    </div>
                    <div class="col-md-8" style="margin-top:32px">
                        <button class="btn btn-success">
                            <i class="fas fa-search fa-fw"></i>
                        </button>

                    </div>
                </div>
            </form>
            <br>
            <?php
            if ($filters) : ?>
                <table id="filter1" class="display">
                    <thead>
                        <tr>
                            <th>Código do Filtro <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Base <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Título <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Situação <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                            <th>Início <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Fim <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                            <th>Atendimento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filters as $filter) : ?>
                            
                                <tr style="cursor:pointer" onclick="document.location = '<?= url("/lista-de-trabalho/cliente/{$filter->id}/first"); ?>';"  title="Registrar Atendimento">
                                    <td><b><?= $filter->codFilter(); ?></b></td>
                                    <td><b><?= $filter->organDesc()->organ ?></b></td>
                                    <td><b><?= $filter->title ?></b></td>
                                    <td><b><span <?php if ($filter->status_filter == "ATIVO") : ?>class="text-success" <?php endif ?> <?php if ($filter->status_filter == "AGUARDANDO") : ?>class="text-primary" <?php endif ?> <?php if ($filter->status_filter == "PAUSADO") : ?>class="text-secondary" <?php endif ?> <?php if ($filter->status_filter == "FINALIZADO") : ?>class="text-danger" <?php endif ?>><?= $filter->status_filter ?></span></b></td>
                                    <td><b><?= date_fmt_br2($filter->attendence_of) ?></b></td>
                                    <td><b><?= date_fmt_br2($filter->until_attendence_of) ?></b></td>
                                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i class="fas fa-phone"></i></td>
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
                    </tfoot>
                </table>
                <?= $paginator; ?>
            <?php endif; ?>
        </div><!-- /.card-body pb-0 -->
    </div><!-- /.card card-solid -->
</div><!-- /.content-wrapper-->
<?php $v->start("scripts");
if (!$filters) :
?>
    <script>
        $(function() {
            toastr.error("Nenhuma lista de trabalho encontrada");
        });
    </script>
<?php
endif;
$v->end(); ?>
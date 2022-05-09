<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-suitcase"></i> Clientes Bloqueados</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $router->route("users.account"); ?>">Clientes </a></li>
                        <li class="breadcrumb-item active">Clientes Bloqueados</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-9">
                </div>
            </div><br>
            <?php
            if ($users) : ?>
                <table id="filter" class="display">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr style="cursor:pointer">
                                <td><?= $user->user_name; ?></td>
                                <td><?= $user->email; ?></td>
                                <td>
                                    <a href="#" class="text-danger" title="Excluir" data-post="<?= url("/clientes/bloqueados/excluir/{$user->id}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja desbloquear esse acesso?" data-user="<?= $user->id; ?>"><i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        endforeach; ?>
                    </tbody>
                </table><br>
            <?php endif; ?>
        </div><!-- /.card-body pb-0 -->
    </div><!-- /.card card-solid -->
</div><!-- /.content-wrapper-->
<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-suitcase"></i> Clientes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Clientes</li>
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
                <div class="col-md-1">
                    <?php if (user()->level_id == 1) : ?>
                        <a href="<?= $router->route("users.accountAdd"); ?>" class="btn btn-success">Novo Cliente</a>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-9">
                </div>
            </div><br>
            <?php
            if ($accounts) : ?>
                <table id="filter" class="display">
                    <thead>
                        <tr>
                            <th>Clientes</th>
                            <th>Usuários Cadastrado</th>
                            <th>Vencimento</th>
                            <th>Status</th>
                            <th>Acessos</th>
                            <th>Usuários Bloqueados</th>
                            <th>Boleto</th>
                            <th>Usuários</th>
                            <th>Alterar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row=0; $count_user=0; foreach ($accounts as $account) : ?>
                            <tr style="cursor:pointer">
                                <td><b><?= $account->description; ?></b></td>
                                <td><b><?= $account->userCount(); ?></b></td>
                                <td><b><?= date_fmt2($account->expiration); ?></b></td>
                                <td><b><?php if ($account->status == "1") : ?><a href="#" class="" title="Mudar Status" data-post="<?= url("/clientes/status/{$account->id}"); ?>" data-action="delete" data-confirm="Deseja Desativar Essa Conta?" data-account="<?= $account->id; ?>"><span style="color:green">Ativa</span></a><?php endif ?> <?php if ($account->status == "3") : ?><a href="#" class="" title="Mudar Status" data-post="<?= url("/clientes/status/{$account->id}"); ?>" data-action="delete" data-confirm="Deseja Ativar Essa Conta?" data-account="<?= $account->id; ?>"><span style="color:red">Desativada<span></a><?php endif ?></b></td>
                                <td><b><a href="<?= url("/clientes/acessos/{$account->id}"); ?>" class="" title="Acessos"><?php foreach($account->countAccess() as $count_access): echo $count_access->count_access; endforeach;?></a></b></td>
                                <td><b><a href="<?= url("/clientes/bloqueado/{$account->id}"); ?>" class="" title="Usuários bloqueados"><?php echo $account->userBloquedCount();?></a></b></td>
                                <td>
                                    <a href="<?= url("/boletos/cadastrar/cliente/{$account->id}") ?>">
                                    <!-- 
                                        Quando não houver boletos vinculados ao usuário,
                                        exibir "Incluir boleto", quando houver, exibir "Ver boletos"
                                    -->
                                        Incluir boleto
                                    </a>
                                </td>
                                <td><b><a href="<?= url("/clientes/usuario/{$account->id}"); ?>" class="" title="Usuários"><i class="fas fa-users"></i></a></b></td>
                                <td><b><a href="<?= url("/clientes/alterar/{$account->id}"); ?>" class="" title="Alterar"><i class="fas fa-edit"></i></a></b></td>
                                <td>
                                    <a href="#" class="text-danger" title="Excluir" data-post="<?= url("/clientes/excluir/{$account->id}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja excluir essa conta e todos os dados relacionados a ela? Essa ação não pode ser desfeita!" data-account="<?= $account->id; ?>"><i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $count_user += $account->userCount();
                            $row ++;
                        endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b><?php echo $row ?></b></td>
                            <td><b><?= $count_user ?></b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table><br>
            <?php endif; ?>
        </div><!-- /.card-body pb-0 -->
    </div><!-- /.card card-solid -->
</div><!-- /.content-wrapper-->
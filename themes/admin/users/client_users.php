<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user"></i> Usuários</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Usuários</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"><br>
            <div class="row">
                <?php if ($client == 0) : ?>
                    <div class="col-md-4">
                        <a href="<?= $router->route("users.user"); ?>" class="btn btn-success">Novo Usuário</a>
                    </div>
                    <div class="col-md-5">
                    </div>
                <?php else : ?>
                    <div class="col-md-9">
                    </div>
                <?php endif; ?>
                <div class="form-inline col-md-3">
                    <form action="<?= url("/clientes/usuario/{$account_id}"); ?>" method="post">
                        <div class="input-group">
                            <input type="hidden" name="action" value="search" />
                            <input class="form-control" type="text" name="s" placeholder="Procurar..." value="<?= $search; ?>" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn" style="border-style:solid;border-color:#D3D3D3">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-4">
                    <select class="form-control" id="show_style">
                        <option value='1' selected>Em quadros</option>
                        <option value='2'>Em lista</option>
                    </select>
                </div>
                <div class="col-md-8">
                </div>
            </div>
            <br><br><br>
            <div class="row" id="show_quadros">

                <?php
                if ($users) :
                    foreach ($users as $user) :
                        $userPhoto = ($user->showPhoto() ? image($user->photo, 300, 300) :
                            theme("/assets/images/avatar.jpg", CONF_VIEW_THEME_ADMIN));
                ?>
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user shadow">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-primary">
                                    <h3 class="widget-user-username"><?= str_limit_chars($user->fullName(), 20); ?></h3>
                                    <h5 class="widget-user-desc"><?=$user->email?></h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="<?= $userPhoto; ?>" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">Status</h5>
                                                <span class="description-text"><?php $user->status == 1 ? "ATIVO" : "INATIVO"; ?>Ativo</span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">Desde</h5>
                                                <span class="description-text"><?= date_fmt($user->created_at, "d/m/Y"); ?></span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">Alterar Senha</h5>
                                                <?php if (($user_admin == 1 || $client == 0) || ($user->id == user()->id)) : ?>
                                                    <a href="#"><i class="fas fa-edit" data-toggle="modal" data-target="#modalPassword"></i></a>
                                                <?php endif; ?>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <?php if (($user_admin == 1 || $client == 0) || ($user->id == user()->id)) : ?>
                                                    <h5 class="description-header">Gerenciar</h5>
                                                    <a href="<?= url("/usuario/alterar/{$user->id}"); ?>"><i class="fas fa-edit"></i></a>
                                                <?php endif; ?>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                <?php endforeach;
                endif;
                ?>
            </div>
            <div id="show_list" class="row" style="display:none">
                <div class="col-md-12">
                    <table id="filter" class="display">
                        <thead>
                            <tr>
                                <th>Nome <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                                <th>E-mail <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                                <th>Nível <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                                <th>Status <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                                <th>CPF</th>
                                <th>Gênero <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem alfabetica">&and;</span></th>
                                <th>Nascimento <span data-toggle="tooltip" data-placement="top" title="Colocar em ordem">&and;</span></th>
                                <th>Alterar Senha</th>
                                <th>Gerenciar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($users) :
                                foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= str_limit_chars($user->fullName(), 20); ?></td>
                                        <td><?=$user->email?></td>
                                        <td><?= str_uppercase($user->level()->description); ?></td>
                                        <td><?php $user->status == 1 ? "ATIVO" : "INATIVO"; ?>Ativo</td>
                                        <td><?= $user->document ?></td>
                                        <td><?php if ($user->genre == 1) : echo "Masculino";
                                            endif;
                                            if ($user->genre == 2) : echo "Feminino";
                                            endif;
                                            if ($user->genre != 1 && $user->genre != 2) : echo "Indefinido";
                                            endif; ?></td>
                                        <td><?= date_fmt($user->datebirth, "d/m/Y") ?></td>
                                        <td>
                                            <?php if (($user_admin == 1 || $client == 0) || ($user->id == user()->id)) : ?>
                                                <a href="#"><i class="fas fa-edit" data-toggle="modal" data-target="#modalPassword"></i></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php if (($user_admin == 1 || $client == 0) || ($user->id == user()->id)) : ?>
                                                <a href="<?= url("/usuario/alterar/{$user->id}"); ?>"><i class="fas fa-edit"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= $paginator; ?>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Senha</h5>
                <button type="button" class="close" id="close_document" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= $router->route("users.passwordChangeAlt", ['id' => $user->id]); ?>" method="post">
                    <div class="card-body">
                        <input type="hidden" name="action" value="change" />
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nova Senha:</label>
                                <input class="form-control" type="password" name="new_password" placeholder="Nova Senha" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Confirmar Senha:</label>
                                <input class="form-control" type="password" name="password_confirm" placeholder="Confirmar Senha" required />
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button class="btn btn-success"><i class="fas fa-edit"> Alterar Senha</i></button>
                    </div><!-- /.card-footer -->
                </form><!-- /.form -->

            </div>

        </div>
    </div>
</div>
<?php $v->start("scripts"); ?>
<script>
    $("#show_style").change(function() {
        if ($("#show_style").val() == 1) {
            $("#show_list").hide();
            $("#show_quadros").show();
        }
        if ($("#show_style").val() == 2) {
            $("#show_list").show();
            $("#show_quadros").hide();
        }
    })
</script>
<?php
if (!empty(flash())) :
?>
    <script>
        $(function() {
            toastr.success("O usuário foi excluído com sucesso...");
        });
    </script>
<?php
endif;
if (!$users) :
?>
    <script>
        $(function() {
            toastr.error("Nenhum usuário encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
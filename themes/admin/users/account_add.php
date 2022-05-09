<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-suitcase"></i> Cadastrar Cliente</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $router->route("users.account"); ?>">Clientes</a></li>
                        <li class="breadcrumb-item active">Cadastrar Cliente</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"><br>
            <div class="card">
                <form action="<?= $router->route("users.accountCreat"); ?>" enctype="multipart/form-data" method="post">
                    <div class="card-body">
                        <?= csrf_input(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nome da Empresa:</label>
                                <input type="text" class="form-control" name="company_name" maxlength="255" placeholder="Nome da Empresa" required>
                            </div>
                            <div class="col-md-6">
                                <label>CNPJ:</label>
                                <input class="form-control mask-doc-company" type="text" name="document" placeholder="CNPJ" required />
                            </div>
                            <div class="col-md-6">
                                <label>UF:</label>
                                <input class="form-control" type="text" name="uf" placeholder="UF" required />
                            </div>
                            <div class="col-md-6">
                                <label>E-mail:</label>
                                <input class="form-control" type="email" name="email" placeholder="E-mail" required />
                            </div>
                            <div class="col-md-6">
                                <label>Telefone do Responsável:</label>
                                <input class="form-control mask-tel" type="text" name="tel" placeholder="Telefone" />
                            </div>
                            <div class="col-md-6">
                                <label>Celular do Responsável:</label>
                                <input class="form-control mask-cel" type="text" name="cel" placeholder="Celular" />
                            </div>
                            <div class="col-md-6">
                                <label>Uso da Api de Consulta:</label>
                                <select class="form-control" name="use_api" id="use_api">
                                    <option value="1">SIM</option>
                                    <option value="0">NAO</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Api:</label>
                                <select class="form-control" name="api" id="api">
                                    <option value="1">Econsig</option>
                                    <option value="2">Credlink</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Quantidade de usuários:</label>
                                <input class="form-control txt_numero" type="text" name="user_count" placeholder="Quantidade de usuários" required />
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row" id="dados_api_econsig">
                            <div class="col-md-5"></div>
                            <div class="col-md-7">
                                <h2><b>Dados da Api Econsig</b></h2>
                            </div>
                            <div class="col-md-3">
                                <label>Usuário</label>
                                <input type="text" class="form-control" name="user_econsig" maxlength="100" placeholder=" "  />
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <label>Senha</label>
                                <input type="password" class="form-control" name="password_econsig" maxlength="100" placeholder=" "  />
                            </div>
                        </div>
                        <div class="row" id="dados_api_credlink" style="display:none">
                            <div class="col-md-5"></div>
                            <div class="col-md-7">
                                <h2><b>Dados da Api CredLink</b></h2>
                            </div>
                            <div class="col-md-3">
                                <label>Usuário</label>
                                <input type="text" class="form-control" name="user_credlink" maxlength="100" placeholder=" "  />
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <label>Sigla</label>
                                <input type="text" class="form-control" name="sigla_credlink" maxlength="100" placeholder=" "  />
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <label>Senha</label>
                                <input type="password" class="form-control" name="password_credlink" maxlength="100" placeholder=" "  />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success"><i class="fas fa-edit"> Criar Cliente</i></button>
                    </div><!-- /.card-footer -->
                </form>
            </div>
        </div>
    </section>
</div>
<?php $v->start("scripts"); ?>
<script>
    $(document).ready(function() {
        $("#use_api").change(function() {
            if ($("#use_api").val() == 0) {
                $("#api").prop('disabled', true);
                $("#dados_api_econsig").hide();
                $("#dados_api_credlink").hide();
            } else {
                $("#api").prop('disabled', false);
                if ($("#api").val() == 1) {
                    $("#dados_api_econsig").show();
                    $("#dados_api_credlink").hide();
                } else {
                    $("#dados_api_econsig").hide();
                    $("#dados_api_credlink").show();
                }
            }
        })
        $("#api").change(function() {
            if ($("#api").val() == 1) {
                $("#dados_api_econsig").show();
                $("#dados_api_credlink").hide();
            } else {
                $("#dados_api_econsig").hide();
                $("#dados_api_credlink").show();
            }
        })
    });
</script>
<?php $v->end(); ?>
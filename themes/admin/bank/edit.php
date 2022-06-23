<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-university"></i> Alterar Banco</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $router->route("banks.home"); ?>">Bancos e Coeficiente</a></li>
                        <li class="breadcrumb-item active">Alterar Banco</li>
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
                <form action="<?= url("/banco-e-coeficiente/alterar/{$bank->id}"); ?>" method="post">
                    <div class="card-body">
                        <?= csrf_input(); ?>
                        <input type="hidden" name="action" value="update" />
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nome:</label>
                                <input type="text" class="form-control" name="name" maxlength="255" value="<?= $bank->bank; ?>" placeholder="Nome" required>
                            </div>
                            <div class="col-sm-2" style="margin-top:40px">
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="status" <?php if ($bank->status == 1) : echo "checked";
                                                                                endif; ?> id="checkboxPrimary1">
                                        <label for="checkboxPrimary1">
                                            Ativo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <hr>
                        <div class="card card-black-50">
                            <div class="card-header">
                                <h3 class="card-title">Coeficientes</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Descrição:</label>
                                            <input type="text" class="form-control" name="description" id="description" maxlength="255" placeholder="Descrição">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Órgão:</label>
                                            <select class="form-control select2bs4" style="width: 100%;" id="organ" name="organ">
                                                <?php foreach ($organs as $organ) : ?>
                                                    <option <?php if ($organ->id == 1) : echo "selected";
                                                            endif; ?> value="<?= $organ->organ ?>"><?= $organ->organ; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Coeficiente:</label>
                                            <input type="text" class="form-control coefficient" name="coefficient" id="coefficient" maxlength="255" placeholder="Coeficiente">
                                        </div>
                                        <div class="col-2">
                                            <label>Data Validade Inicial:</label>
                                            <input type="text" class="form-control mask-date txt_data" id="expiration_date_init" name="expiration_date_init">
                                        </div>
                                        <div class="col-2">
                                            <label>Data Validade Final:</label>
                                            <input type="text" class="form-control mask-date txt_data" id="expiration_date_end" name="expiration_date_end">
                                        </div>
                                    </div>
                                    <div class="row" id="div_row"></div>
                                    <br>
                                    <div class="row">
                                        <div class="col-2">
                                            <input type="button" class="btn btn-light" id="btn-adicionar-coeficiente" value="Adicionar Coeficiente">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>Descrição</th>
                                            <th>Órgão</th>
                                            <th>Coeficiente:</th>
                                            <th>Data Validade Inicial:</th>
                                            <th>Data Validade Final:</th>
                                            <th>Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($coeficients) :
                                            $i = 1;
                                            foreach ($coeficients as $coeficient) : ?>
                                                <tr class='delete-line_<?= $i ?>'>
                                                    <td><?= $coeficient->description ?></td>
                                                    <td><?= returnOrganReverse($coeficient->organ_id) ?></td>
                                                    <td><?= $coeficient->coeficient ?></td>
                                                    <td><?= date_fmt2($coeficient->expiration_date_init) ?></td>
                                                    <td><?= date_fmt2($coeficient->expiration_date_end) ?></td>
                                                    <td><i class='fas fa-trash text-danger' onclick='remove(<?= $i ?>)' style='cursor:pointer'></i></td>
                                                </tr>
                                                <input type='hidden' name='description_old_<?= $i ?>' id='description_old_<?= $i ?>' value='<?= $coeficient->description ?>'>
                                                <input type='hidden' name='coefficient_old_<?= $i ?>' id='coefficient_old_<?= $i ?>' value='<?= $coeficient->coeficient ?>'>
                                                <input type='hidden' name='organ_old_<?= $i ?>' id='organ_old_<?= $i ?>' value='<?= returnOrganReverse($coeficient->organ_id) ?>'>
                                                <input type='hidden' name='expiration_date_init_old_<?= $i ?>' id='expiration_date_init_old_<?= $i ?>' value='<?= date_fmt2($coeficient->expiration_date_init) ?>'>
                                                <input type='hidden' name='expiration_date_end_old_<?= $i ?>' id='expiration_date_end_old_<?= $i ?>' value='<?= date_fmt2($coeficient->expiration_date_end) ?>'>
                                        <?php $i++;
                                            endforeach;
                                        endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" name="count_coeficient_old" id="count_coeficient_old" value="<?php if($coeficients): echo count($coeficients); else: echo "0"; endif; ?>">
                        <input type="hidden" name="count_coeficient" id="count_coeficient">
                        <div class="col-md-12" id="data-coeficiente">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success"><i class="fas fa-edit"> Editar Banco</i></button>
                    </div><!-- /.card-footer -->
                </form>
            </div>
        </div>
    </section>
    <?php $v->start("scripts"); ?>
    <script>
        $(document).ready(function() {
            $("#btn-adicionar-coeficiente").click(function() {
                var rowCount = $("#table tr").length-$("#count_coeficient_old").val();
                if ($("#description").val() == "" || $("#coefficient").val() == "" || $("#expiration_date_init").val() == "" || $("#expiration_date_end").val() == "") {
                    alert("Preencha todos os campos")
                } else {
                    $("#count_coeficient").val("");
                    $("#count_coeficient").val(rowCount)
                    $("#table tbody").append("<tr class='delete-line_" + rowCount + "'>");
                    $("#table tbody").append("<td class='delete-line_" + rowCount + "'>" + $("#description").val() + "</td>");
                    $("#table tbody").append("<td class='delete-line_" + rowCount + "'>" + $("#organ").val() + "</td>");
                    $("#table tbody").append("<td class='delete-line_" + rowCount + "'>" + $("#coefficient").val() + "</td>");
                    $("#table tbody").append("<td class='delete-line_" + rowCount + "'>" + $("#expiration_date_init").val() + "</td>");
                    $("#table tbody").append("<td class='delete-line_" + rowCount + "'>" + $("#expiration_date_end").val() + "</td>");
                    $("#table tbody").append("<td class='delete-line_" + rowCount + "'><i class='fas fa-trash text-danger' onclick='remove2(" + rowCount + ")'  table-click='" + rowCount + "' style='cursor:pointer'></i></td>");
                    $("#table tbody").append("</tr>");
                    $("#data-coeficiente").append("<input type='hidden' name='description_" + rowCount + "' id='description_" + rowCount + "' value='" + $("#description").val() + "'>");
                    $("#data-coeficiente").append("<input type='hidden' name='coefficient_" + rowCount + "' id='coefficient_" + rowCount + "' value='" + $("#coefficient").val() + "'>");
                    $("#data-coeficiente").append("<input type='hidden' name='organ_" + rowCount + "' id='organ_" + rowCount + "' value='" + $("#organ").val() + "'>");
                    $("#data-coeficiente").append("<input type='hidden' name='expiration_date_init_" + rowCount + "' id='expiration_date_init_" + rowCount + "' value='" + $("#expiration_date_init").val() + "'>");
                    $("#data-coeficiente").append("<input type='hidden' name='expiration_date_end_" + rowCount + "' id='expiration_date_end_" + rowCount + "' value='" + $("#expiration_date_end").val() + "'>");
                    $("#description").val("")
                    $("#coefficient").val("")
                    $("#expiration_date_init").val("")
                    $("#expiration_date_end").val("")
                }

            })
            remove2 = function(item) {
                $('.delete-line_' + item).remove();
                $('#description_' + item).remove();
                $('#coefficient_' + item).remove();
                $('#expiration_date_init_' + item).remove();
                $('#expiration_date_end_' + item).remove();
                $('#organ_' + item).remove();
                $("#count_coeficient").val("");
                $("#count_coeficient").val(item - 1)
            }

            remove = function(item) {
                $('.delete-line_' + item).remove();
                $('#description_old_' + item).remove();
                $('#coefficient_old_' + item).remove();
                $('#expiration_date_init_old_' + item).remove();
                $('#expiration_date_end_old_' + item).remove();
                $('#organ_old_' + item).remove();
                count_coeficient_old = $("#count_coeficient_old").val() - 1
                $("#count_coeficient_old").val("");
                $("#count_coeficient_old").val(count_coeficient_old)
            }

        })
    </script>
    <?php $v->end(); ?>
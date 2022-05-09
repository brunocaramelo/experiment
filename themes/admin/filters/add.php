<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-edit"></i> Cadastrar Filtro</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $router->route("filter.home"); ?>">Filtros</a></li>
                        <li class="breadcrumb-item active">Cadastrar Filtro</li>
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
                <form action="<?= $router->route("filter.add"); ?>" enctype="multipart/form-data" method="post">
                    <div class="card-body">
                        <?= csrf_input(); ?>
                        <input type="hidden" name="action" value="create" />
						
                        <div class="linha1">
						<div class="row">
                            <div class="col-md-4">
                                <label>Órgão:</label>
                                <select class="form-control select2bs4" id="organ" name="organ" required>
                                    <?php foreach ($organs as $organ) : ?>
                                        <option <?php if ($organ->id == 1) : echo "selected";
                                                endif; ?> value="<?= $organ->id ?>"><?= $organ->organ; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Título:</label>
                                <input type="text" class="form-control" name="title" maxlength="255" placeholder="Título" required>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Usuários Ativos:</label>
									
                                    <select class="form-control selectoption" multiple="multiple" data-select="false" name="user[]" id="user">
                                        <?php foreach ($users as $user) : ?>
                                            <option value="<?= $user->id ?>"><?= $user->fullname(); ?></option>
                                        <?php endforeach ?>
                                    </select>
										
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-12">
                                <label>Descrição do Filtro:</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
					</div>
						<hr>
						
						
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="release_next_customer" id="checkboxPrimary1">
                                        <label for="checkboxPrimary1">
                                            (Liberar próximo cliente apenas ao utilizar todos os telefones ou registrar um atendimento com sucesso para o cliente atual.)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<br>
                        <hr>
						
                        <div class="row">
                            <br>
                            <div class="col-4"></div>
                            <div class="col-8">
                                <h5>Coeficiente padrão para simulações no filtro</h5>
                            </div>

                            <div class="col-md-4">
                                <label>Coeficiente:</label>
                                <input type="text" class="form-control coefficient" name="coefficient" maxlength="255" placeholder="Coeficiente">
                            </div>
                            <div class="col-md-8"></div>
                        </div>
						
						<br>
                        <!--div class="row">
                            <div class="col-sm-12">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="filter_by_coefficient" id="checkboxPrimary2">
                                        <label for="checkboxPrimary2">
                                            (Filtrar pelo Coeficiente.)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div-->
                        <hr>
                        <div class="row">
                            <br>
                            <div class="col-5"></div>
                            <div class="col-7">
                                <h5>Filtro Selecionado</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="dont_ignore_client" id="checkboxPrimary3">
                                        <label for="checkboxPrimary3">
                                            Não ignorar clientes atendidos
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="ignore_actived_filters" id="checkboxPrimary4">
                                        <label for="checkboxPrimary4">
                                            Ignorar filtros ativos(Nesta função, ao criar os filtros com os mesmos critérios de filtros já ativos, pode repetir clientes).
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--div class="row">
                            <div class="col-sm-12">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="dont_ignore_client_campaing" id="checkboxPrimary4">
                                        <label for="checkboxPrimary4">
                                            Não ignorar clientes reservados em filtros ativos
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="filter_only_client" id="checkboxPrimary5">
                                        <label for="checkboxPrimary5">
                                            Filtrar apenas clientes que ainda não foram abordados pelos consultores da sua empresa.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div-->
                        <div class="row">
                            <div class="col-2">
                                <label>Idade de:</label>
                                <input type="text" class="form-control" name="age_of" maxlength="3">
                            </div>
                            <div class="col-2">
                                <label>Idade Até:</label>
                                <input type="text" class="form-control" name="age_until" maxlength="3">
                            </div>
                            <div class="col-2" id="div_indicative">
                                <label>Indicativo:</label>
                                <select class="form-control select2bs4 " style="width: 100%;" id="indicative" name="indicative[]" multiple>
                                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-2" id="div_legal_regime" style="display:none">
                                <label>Regime Jurídico:</label>
                                <select class="form-control selectoption" style="width: 100%;" id="legal_regime" name="legal_regime[]" multiple>
                                    <?php if (!empty($legal_regime)) :
                                        foreach ($legal_regime as $legal_regime_each) : ?>
                                            <option value="<?= $legal_regime_each->id ?>"><?= $legal_regime_each->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-3" id="div_category_exercito_marinha">
                                <label>Categorias:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="category_exercito_marinha" name="category_exercito_marinha[]" multiple>
                                    <?php if (!empty($categories)) :
                                        foreach ($categories as $category) : ?>
                                            <option value="<?= $category->id ?>"><?= $category->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-3" id="div_category_aeronautica" style="display:none">
                                <label>Categorias:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="category_aeronautica" name="category_aeronautica[]" multiple >
                                    <?php if (!empty($category_aeronautica)) :
                                        foreach ($category_aeronautica as $category_aeronautica_each) : ?>
                                            <option value="<?= $category_aeronautica_each->id ?>"><?= $category_aeronautica_each->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-3" id="div_category_siape" style="display:none">
                                <label>Categorias:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="category_siape" name="category_siape[]" multiple>
                                    <?php if (!empty($category_siape)) :
                                        foreach ($category_siape as $category_siape_each) : ?>
                                            <option value="<?= $category_siape_each->id ?>"><?= $category_siape_each->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-3" id="div_patent_exercito">
                                <label>Patente:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="patent_exercito" name="patent_exercito[]" multiple>
                                    <?php if (!empty($patents)) :
                                        foreach ($patents as $patent) : ?>
                                            <option value="<?= $patent->id ?>"><?= $patent->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-3" id="div_patent_marinha" style="display:none">
                                <label>Patente:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="patent_marinha" name="patent_marinha[]" multiple>
                                    <?php if (!empty($patent_marinha)) :
                                        foreach ($patent_marinha as $patent_marinha_each) : ?>
                                            <option value="<?= $patent_marinha_each->id ?>"><?= $patent_marinha_each->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-3" id="div_patent_aeronautica" style="display:none">
                                <label>Patente:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="patent_aeronautica" name="patent_aeronautica[]" multiple>
                                    <?php if (!empty($patent_aeronautica)) :
                                        foreach ($patent_aeronautica as $patent_aeronautica_each) : ?>
                                            <option value="<?= $patent_aeronautica_each->id ?>"><?= $patent_aeronautica_each->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-3" id="div_organ_siape" style="display:none">
                                <label>Órgão Siape:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="organ_siape" name="organ_siape[]" multiple>
                                    <?php foreach ($organ_siape as $organ_siape_each) : ?>
                                        <option value="<?= $organ_siape_each->id ?>"><?= $organ_siape_each->description; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label>Margem de:</label>
                                <input type="text" class="form-control mask-money" name="margin_of" id="margin_of" maxlenght="11">
                            </div>
                            <div class="col-2">
                                <label>Até:</label>
                                <input type="text" class="form-control mask-money" maxlenght="11" name="until_margin_of" id="until_margin_of">
                            </div>
                            <div class="col-2">
                                <label>Margem 5% de:</label>
                                <input type="text" class="form-control mask-money" maxlength="11" id="margin_percent" name="margin_percent">
                            </div>
                            <div class="col-2">
                                <label>Até:</label>
                                <input type="text" class="form-control mask-money" maxlength="11" id="until_margin_percent" name="until_margin_percent">
                            </div>
                            
                        </div>
						<hr>
						<!-- mexi aqui - 11/01/2022-->
						<br>

						<div class="linha1">
						    <div class="row">
                            <div class="col">
								<label>Correntista dos Bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>

                                <select class="form-control selectoption" id="bank" name="bank[]" multiple>
                                    <?php if (!empty($banks)) :
                                        foreach ($banks as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <!--mexi aqui dia 24/01/2022 reposicionamento de combos-->
								<div class="col" id="loan_exercito">
                                <label>Desconto nos Bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption" id="bank_discount_exercito" name="bank_discount_exercito[]" multiple>
                                    <?php if (!empty($bank_loan_exercito)) :
                                        foreach ($bank_loan_exercito as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col" id="loan_marinha" style="display:none">
                                <label>Desconto nos Bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption" id="bank_discount_marinha" name="bank_discount_marinha[]" multiple>
                                    <?php if (!empty($bank_loan_marinha)) :
                                        foreach ($bank_loan_marinha as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
							
                            <div class="col" id="loan_aero" style="display:none">
                                <label>Desconto nos Bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption" id="bank_discount_aero" name="bank_discount_aero[]" multiple>
                                    <?php if (!empty($bank_loan_aero)) :
                                        foreach ($bank_loan_aero as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col" id="loan_siape" style="display:none">
                                <label>Desconto nos Bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption" id="bank_discount_siape" name="bank_discount_siape[]" multiple>
                                    <?php if (!empty($bank_loan_siape)) :
                                        foreach ($bank_loan_siape as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
								
							<!-- fim de reposicionamento-->	
								
							<!-- segundo item resposicionado em 24/01/2022-->
								<div class="col" id="dont_loan_exercito">
                                <label>Não possui desconto nos bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption" style="width: 100%;" id="bank_dont_descount_exercito" name="bank_dont_discount_exercito[]" multiple>
                                    <?php if (!empty($bank_loan_exercito)) :
                                        foreach ($bank_loan_exercito as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col" id="dont_loan_marinha" style="display:none">
                                <label>Não possui desconto nos bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption " style="width: 100%;" id="bank_dont_descount_marinha" name="bank_dont_discount_marinha[]" multiple>
                                    <?php if (!empty($bank_loan_marinha)) :
                                        foreach ($bank_loan_marinha as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col" id="dont_loan_aero" style="display:none">
                                <label>Não possui desconto nos bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption " style="width: 100%;" id="bank_dont_descount_aero" name="bank_dont_discount_aero[]" multiple>
                                    <?php if (!empty($bank_loan_aero)) :
                                        foreach ($bank_loan_aero as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col" id="dont_loan_siape" style="display:none">
                                <label>Não possui desconto nos bancos:
                                    <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                </label>
                                <select class="form-control selectoption " style="width: 100%;" id="bank_dont_descount_siape" name="bank_dont_discount_siape[]" multiple>
                                    <?php if (!empty($bank_loan_siape)) :
                                        foreach ($bank_loan_siape as $bank) : ?>
                                            <option value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
							<!-- fim de segundo reposicionamento-->	
								
								
                          </div>
					</div>
						<!-- fim-->
						<hr>
						<br>		
						<div class="linha1">
                        <div class="row">
                            
                            <div class="col-2">
                                <label>Valor da Parcela:</label>
                                <input type="text" class="form-control mask-money" maxlength="11" name="portion">
                            </div>
                            <div class="col-2">
                                <label>Até:</label>
                                <input type="text" class="form-control mask-money" maxlength="11" name="until_portion">
                            </div>
                            <div class="col-3">
                                <label>Número de Parcelas Restantes:</label>
                                <input type="text" class="form-control txt_numero" maxlength="3" name="rest_portion">
                            </div>
                            <div class="col-2">
                                <label>Até:</label>
                                <input type="text" class="form-control txt_numero" maxlength="3" name="until_rest_portion">
                            </div>
                        </div>
						</div>
						
						<hr>
						<br>
                        <div class="row">
                            
                            <div class="col-4">
                                <label>Estado:</label>
                                <select class="form-control selectoption " style="width: 100%;" id="state" name="state[]" multiple>
                                    <?php foreach ($states as $state) : ?>
                                        <option value="<?= $state->uf_codigo ?>"><?= $state->uf_descricao; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <label>Cidade:</label>
                                <select class="form-control select2bs4 " style="width: 100%;" id="city" name="city[]" multiple>

                                </select>
                            </div>
                        </div><br>
                        <hr>
                        <div class="row">
                            <br>
                            <div class="col-5"></div>
                            <div class="col-7">
                                <h5>Reciclagem de Mailing</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label>Retorno de Atendimento:</label>
                                <select class="form-control select2bs4 " style="width: 100%;" id="attendance_retorn" name="attendance_retorn">
                                    <option value="">--Selecione--</option>
                                    <?php if (!empty($attendence_returns)) :
                                        foreach ($attendence_returns as $attendence_return) : ?>
                                            <option value="<?= $attendence_return->id ?>"><?= $attendence_return->description ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <label>Atendimentos de:</label>
                                <input type="text" class="form-control mask-date txt_data" id="attendence_of" name="attendence_of">
                            </div>
                            <div class="col-4">
                                <label>Até:</label>
                                <input type="text" class="form-control mask-date txt_data" id="until_attendence_of" name="until_attendence_of">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success"><i class="fas fa-edit"></i> Criar Filtro</button>
                    </div><!-- /.card-footer -->
                </form><!-- /.form -->
            </div><!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--modal bank-->
<div class="modal fade" id="modalBank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="bank">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bancos</h5>
                <button type="button" class="close" id="close_bank" onclick="close_modal()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="create">
                    <form class="ajax_form" action="<?= $router->route("auxiliar.bankAdd"); ?>" name="gallery" method="post" enctype="multipart/form-data">

                        <label>
                            <input type="text" class="form-control" name="bank" placeholder="Banco:" />
                        </label>
                        <label>
                            <button class="btn btn-success"><i class="fas fa-edit"> Adicionar Novo</i></button>
                        </label>
                    </form>
                </div>
                <main class="content">
                    <section class="auxs2">
                        <?php if (!empty($banks)) :
                            foreach ($banks as $bank) :
                                $v->insert("fragments/bank", ["bank" => $bank]);
                            endforeach;
                        endif; ?>
                    </section>
                </main>

            </div>

        </div>
    </div>
</div>
<?php $v->start("scripts"); ?>
<script src="<?= url("/shared/scripts/filter_add.js"); ?>"></script>
<?php $v->end(); ?>
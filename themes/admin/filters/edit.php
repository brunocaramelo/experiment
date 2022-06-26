<?php $v->layout("_admin"); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-edit"></i> Alterar Filtro</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $router->route("filter.home"); ?>">Filtros</a></li>
                        <li class="breadcrumb-item active">Alterar Filtro</li>
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
                <form action="<?= url("/filtro/alterar/{$filter->cod}"); ?>" enctype="multipart/form-data" id="form" method="post">
                    <?= csrf_input(); ?>
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="status_filter" id="status_filter" value="<?= $filter->status_filter ?>" />
                    <input type="hidden" name="organ_text" id="organ_text" value="<?= $filter->organ_id ?>" />
                    <input type="hidden" name="filter_id" id="filter_id" value="<?= $filter->id ?>" />
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="true">Dados do Filtro</a>
                            <a class="nav-item nav-link" id="report-tab" data-toggle="tab" href="#report" role="tab" aria-controls="report" aria-selected="true">Registros</a>
                            <a class="nav-item nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="attendance" aria-selected="false">Clientes Atendidos</a>
                            <a class="nav-item nav-link" id="csv-tab" data-toggle="tab" href="#csv" role="tab" aria-controls="csv" aria-selected="false">Arquivo CSV</a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="row">
                            <?php if ($filter->status_filter == "AGUARDANDO" || $filter->status_filter == "PAUSADO") : ?>
                                <div class="col-md-2"><button class="btn btn-lg btn-outline-success" id="btn_editar"><i class="fas fa-edit"> Salvar Filtro</i></button></div>
                                <?php if ($filter->waiting == 0) : ?>
                                    <div class="col-md-2"><a href="" class="btn btn-lg btn-outline-success" data-post="<?= url("/filtro/mudar/{$filter->cod}"); ?>" <?php if ($filter->status_filter == "FINALIZADO") : ?> aria-disabled="true" <?php endif; ?> data-action="play" data-client_cod="<?= $filter->cod; ?>"><i class="fas fa-play"> Iniciar filtro</i></a></div>
                                <?php else : ?>
                                    <?php if ($filter->status_filter == "FINALIZADO") : ?>
                                        <div class="col-md-2"><button class="btn btn-lg btn-outline-success" disabled><i class="fas fa-play"> Reiniciar filtro</i></button></div>
                                    <?php else : ?>
                                        <div class="col-md-2"><a href="" class="btn btn-lg btn-outline-success" data-post="<?= url("/filtro/mudar/{$filter->cod}"); ?>" data-action="play" <?php if ($filter->status_filter == "FINALIZADO") : ?> aria-disabled="true" <?php endif; ?> data-client_cod="<?= $filter->cod; ?>"><i class="fas fa-play"> Reiniciar filtro</i></a></div>
                                    <?php endif; ?>
                                    
                                <?php endif ?>
                            <?php else : ?>
                                <div class="col-md-2"><button class="btn btn-lg btn-outline-success" disabled><i class="fas fa-edit"> Salvar Filtro</i></button></div>
                                <?php if ($filter->status_filter == "FINALIZADO") : ?>
                                    <div class="col-md-2"><button class="btn btn-lg btn-outline-secondary" disabled><i class="fas fa-pause"> Pausar filtro</i></button></div>
                                <?php else : ?>
                                    <div class="col-md-2"><a href="" class="btn btn-lg btn-outline-secondary" data-post="<?= url("/filtro/mudar/{$filter->cod}"); ?>" data-action="pause" data-client_cod="<?= $filter->cod; ?>"><i class="fas fa-pause"> Pausar filtro</i></a></div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="col-md-2"><a href="<?= url("/filtro/copy/{$filter->cod}"); ?>" class="btn btn-lg btn-outline-primary"> Duplicar filtro</i></a></div>
                            <!--div class="col-md-2"><a href="#" class="btn btn-lg btn-outline-primary"> Duplicar filtro</i></a></div-->
                            <div class="col-md-2"><a href="" class="btn btn-lg btn-outline-danger" data-post="<?= url("/filtro/excluir/{$filter->cod}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja excluir esse filtro e todos os dados relacionados a ele? Essa ação não pode ser desfeita!" data-client_cod="<?= $filter->cod; ?>"><i class="fas fa-trash"> Excluir filtro</i></a></div>
                            <?php if ($filter->status_filter == "FINALIZADO") : ?>
                                <div class="col-md-2"><button class="btn btn-lg btn-outline-dark" disabled><i class="fas fa-check"> Finalizar filtro</i></button></div>
                            <?php else : ?>
                                <div class="col-md-2"><a href="" class="btn btn-lg btn-outline-dark" data-post="<?= url("/filtro/mudar/{$filter->cod}"); ?>" data-action="finish" data-confirm="ATENÇÃO: Deseja finalizar esse filtro?" data-client_cod="<?= $filter->cod; ?>"><i class="fas fa-check"> Finalizar filtro</i></a></div>
                            <?php endif; ?>

                            <div class="col-md-1"></div>
                        </div><br>
                        <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Órgão:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="organ" name="organ" required>
                                        <?php foreach ($organs as $organ) : ?>
                                            <option <?php if ($organ->id == $filter->organ_id) : echo "selected";
                                                    endif; ?> value="<?= $organ->id ?>"><?= $organ->organ; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Título:</label>
                                    <input type="text" class="form-control" name="title" id="title" maxlength="255" value="<?= $filter->title ?>" placeholder="Título" required>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Usuários Ativos:</label>
                                        <select class="form-control  select2bs4" multiple="multiple" name="user[]" id="user">
                                            <?php foreach ($users as $user) :
                                                $user_selected = 0;
                                                foreach ($filter_user as $each) :
                                                    if ($each->user_id == $user->id) : $user_selected = 1;
                                                    endif;
                                                endforeach;
                                            ?>
                                                <option <?php if ($user_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $user->id ?>"><?= $user->fullname(); ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <div class="col-md-12">
                                    <label>Descrição do Filtro:</label>
                                    <textarea class="form-control" name="description" id="description"><?= $filter->description ?></textarea>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Quantidade de Clientes no Filtro:</label>
                                    <?= $clintCount ?>
                                </div>
                                <div class="col-md-8">
                                    <label>Quantidade de Clientes Atendidos:</label>
                                    <?php if($attendanceCount): echo count($attendanceCount); else: echo 0;endif; ?>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" name="release_next_customer" <?php if ($filter->release_next_customer == 1) : ?> checked <?php endif; ?> id="checkboxPrimary1">
                                            <label for="checkboxPrimary1">
                                                (Liberar próximo cliente apenas ao utilizar todos os telefones ou registrar um atendimento com sucesso para o cliente atual.)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <hr>
                            <div class="row">
                                <br>
                                <div class="col-4"></div>
                                <div class="col-8">
                                    <h5>Coeficiente padrão para simulações no filtro</h5>
                                </div>

                                <div class="col-md-4">
                                    <label>Coeficiente:</label>
                                    <input type="text" class="form-control coefficient" name="coefficient" value="<?= $filter->coefficient ?>" maxlength="255" placeholder="Coeficiente">
                                </div>
                                <div class="col-md-8"></div>
                            </div><br>
                            <!--div class="row">
                                <div class="col-sm-12">
                                    
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" name="filter_by_Coefficient" id="checkboxPrimary2" <?php if ($filter->filter_by_coefficient == 1) : ?> checked <?php endif; ?>>
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
                                            <input type="checkbox" name="dont_ignore_client" id="checkboxPrimary3" <?php if ($filter->dont_ignore_client == 1) : ?> checked <?php endif; ?>>
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
                                            <input type="checkbox" name="ignore_actived_filters" id="checkboxPrimary4" <?php if ($filter->ignore_actived_filters == 1) : ?> checked <?php endif; ?>>
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
                                            <input type="checkbox" name="dont_ignore_client_campaing" id="checkboxPrimary4" <?php if ($filter->dont_ignore_client_campaing == 1) : ?> checked <?php endif; ?>>
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
                                            <input type="checkbox" name="filter_only_client" id="checkboxPrimary5" <?php if ($filter->filter_only_client == 1) : ?> checked <?php endif; ?>>
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
                                    <input type="text" class="form-control" name="age_of" maxlength="3" value="<?= $filter->age_of ?>">
                                </div>
                                <div class="col-2">
                                    <label>Idade Até:</label>
                                    <input type="text" class="form-control" name="age_until" maxlength="3" value="<?= $filter->age_until ?>">
                                </div>
                                <div class="col-2" id="div_indicative">
                                    <label>Indicativo:</label>
                                    <select class="form-control select2bs4" disabled style="width: 100%;" id="indicative" name="indicative[]" multiple>
                                        <?php for ($i = 1; $i <= 8; $i++) :
                                            $indicative_selected = 0;
                                            foreach ($filter_indicatives as $filter_indicative) :
                                                if ($i == $filter_indicative->indicative_id) : $indicative_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($indicative_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-2" id="div_legal_regime" style="display:none">
                                    <label>Regime Jurídico:</label>
                                    <select class="form-control  select2bs4" style="width: 100%;" id="legal_regime" name="legal_regime[]" multiple>
                                        <?php foreach ($legal_regimes as $legal_regime) :
                                            $legal_regime_selected = 0;
                                            foreach ($filter_legal_regimes as $filter_legal_regime) :
                                                if ($legal_regime->id == $filter_legal_regime->legal_regime_id) : $legal_regime_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($legal_regime_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $legal_regime->id ?>"><?= $legal_regime->description ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <div class="col-3" id="div_category_exercito_marinha">
                                    <label>Categorias:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="category_exercito_marinha" name="category_exercito_marinha[]" multiple>
                                        <?php foreach ($categories as $category) :
                                            $category_selected = 0;
                                            foreach ($filter_categories as $filter_category) :
                                                if ($category->id == $filter_category->category_id) : $category_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($category_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $category->id ?>"><?= $category->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="div_category_aeronautica">
                                    <label>Categorias:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="category_aeronautica" name="category_aeronautica[]" multiple>
                                        <?php foreach ($category_aeronautica as $category) :
                                            $category_selected = 0;
                                            foreach ($filter_categories as $filter_category) :
                                                if ($category->id == $filter_category->category_id) : $category_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($category_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $category->id ?>"><?= $category->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="div_category_siape">
                                    <label>Categorias:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="category_siape" name="category_siape[]" multiple>
                                        <?php foreach ($category_siape as $category) :
                                            $category_selected = 0;
                                            foreach ($filter_categories as $filter_category) :
                                                if ($category->id == $filter_category->category_id) : $category_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($category_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $category->id ?>"><?= $category->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="div_patent_exercito">
                                    <label>Patente:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="patent_exercito" name="patent_exercito[]" multiple>
                                        <?php foreach ($patents as $patent) :
                                            $patent_selected = 0;
                                            foreach ($filter_patents as $filter_patent) :
                                                if ($patent->id == $filter_patent->patent_id) : $patent_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($patent_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $patent->id ?>"><?= $patent->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="div_patent_marinha">
                                    <label>Patente:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="patent_marinha" name="patent_marinha[]" multiple>
                                        <?php foreach ($patent_marinha as $patent) :
                                            $patent_selected = 0;
                                            foreach ($filter_patents as $filter_patent) :
                                                if ($patent->id == $filter_patent->patent_id) : $patent_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($patent_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $patent->id ?>"><?= $patent->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="div_patent_aeronautica">
                                    <label>Patente:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="patent_aeronautica" name="patent_aeronautica[]" multiple>
                                        <?php foreach ($patent_aeronautica as $patent) :
                                            $patent_selected = 0;
                                            foreach ($filter_patents as $filter_patent) :
                                                if ($patent->id == $filter_patent->patent_id) : $patent_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($patent_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $patent->id ?>"><?= $patent->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="div_organ_siape" style="display:none">
                                    <label>Órgão Siape:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="organ_siape" name="organ_siape[]" multiple>
                                        <?php foreach ($organ_siape as $organ_siape_each) :
                                            $organ_siape_selected = 0;
                                            foreach ($filter_organ_siapes as $filter_organ_siape) :
                                                if ($organ_siape_each->id == $filter_organ_siape->organ_siape_id) : $organ_siape_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($organ_siape_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $organ_siape_each->id ?>"><?= $organ_siape_each->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label>Margem de:</label>
                                    <input type="text" class="form-control mask-money" name="margin_of" id="margin_of" value="<?= $filter->margin_of ?>" maxlenght="11">
                                </div>
                                <div class="col-2">
                                    <label>Até:</label>
                                    <input type="text" class="form-control mask-money" maxlenght="11" id="until_margin_of" value="<?= $filter->until_margin_of ?>" name="until_margin_of">
                                </div>
                                <div class="col-2">
                                    <label>Margem 5% de:</label>
                                    <input type="text" class="form-control mask-money" maxlength="11" id="margin_percent" value="<?= $filter->margin_percent ?>" name="margin_percent">
                                </div>
                                <div class="col-2">
                                    <label>Até:</label>
                                    <input type="text" class="form-control mask-money" maxlength="11" id="until_margin_percent" value="<?= $filter->until_margin_percent ?>" name="until_margin_percent">
                                </div>
                                <div class="col-4">
                                    <label>Correntista dos Bancos:
                                        <!--i class="far fa-question-circle" style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank" name="bank[]" multiple>
                                        <?php if (!empty($banks)) :
                                            foreach ($banks as $bank) :
                                                $bank_selected = 0;
                                                foreach ($filter_bank_account as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3" id="loan_exercito">
                                    <label>Desconto nos Bancos:
                                        <!--i class="far fa-question-circle" style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_discount_exercito" name="bank_discount_exercito[]" multiple>
                                        <?php if (!empty($bank_loan_exercito)) :
                                            foreach ($bank_loan_exercito as $bank) :
                                                $bank_discount_selected = 0;
                                                foreach ($filter_bank_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="loan_marinha">
                                    <label>Desconto nos Bancos:
                                        <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_discount_marinha" name="bank_discount_marinha[]" multiple>
                                        <?php if (!empty($bank_loan_marinha)) :
                                            foreach ($bank_loan_marinha as $bank) :
                                                $bank_discount_selected = 0;
                                                foreach ($filter_bank_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="loan_aero">
                                    <label>Desconto nos Bancos:
                                        <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_discount_aero" name="bank_discount_aero[]" multiple>
                                        <?php if (!empty($bank_loan_aero)) :
                                            foreach ($bank_loan_aero as $bank) :
                                                $bank_discount_selected = 0;
                                                foreach ($filter_bank_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-3" id="loan_siape">
                                    <label>Desconto nos Bancos:
                                        <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_discount_siape" name="bank_discount_siape[]" multiple>
                                        <?php if (!empty($bank_loan_siape)) :
                                            foreach ($bank_loan_siape as $bank) :
                                                $bank_discount_selected = 0;
                                                foreach ($filter_bank_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label>Valor da Parcela:</label>
                                    <input type="text" class="form-control mask-money" maxlength="11" name="portion" value="<?= $filter->portions ?>">
                                </div>
                                <div class="col-2">
                                    <label>Até:</label>
                                    <input type="text" class="form-control mask-money" maxlength="11" name="until_portion" value="<?= $filter->until_portion ?>">
                                </div>
                                <div class="col-3">
                                    <label>Número de Parcelas Restantes:</label>
                                    <input type="text" class="form-control txt_numero" maxlength="3" name="rest_portion" value="<?= $filter->rest_portion ?>">
                                </div>
                                <div class="col-2">
                                    <label>Até:</label>
                                    <input type="text" class="form-control txt_numero" maxlength="3" name="until_rest_portion" value="<?= $filter->until_rest_portion ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" id="dont_loan_exercito">
                                    <label>Não possui desconto nos bancos:
                                        <!--i class="far fa-question-circle" style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_dont_descount" name="bank_dont_discount[]" multiple>
                                        <?php if (!empty($bank_loan_exercito)) :
                                            foreach ($bank_loan_exercito as $bank) :
                                                $bank_not_discount_selected = 0;
                                                foreach ($filter_bank_not_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_not_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_not_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-4" id="dont_loan_marinha">
                                    <label>Não possui desconto nos bancos:
                                        <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_dont_descount_marinha" name="bank_dont_discount_marinha[]" multiple>
                                        <?php if (!empty($bank_loan_marinha)) :
                                            foreach ($bank_loan_marinha as $bank) :
                                                $bank_not_discount_selected = 0;
                                                foreach ($filter_bank_not_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_not_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_not_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-4" id="dont_loan_aero">
                                    <label>Não possui desconto nos bancos:
                                        <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_dont_descount_aero" name="bank_dont_discount_aero[]" multiple>
                                        <?php if (!empty($bank_loan_aero)) :
                                            foreach ($bank_loan_aero as $bank) :
                                                $bank_not_discount_selected = 0;
                                                foreach ($filter_bank_not_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_not_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_not_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-4" id="dont_loan_siape">
                                    <label>Não possui desconto nos bancos:
                                        <!--i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalBank"></i-->
                                    </label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="bank_dont_descount_siape" name="bank_dont_discount_siape[]" multiple>
                                        <?php if (!empty($bank_loan_siape)) :
                                            foreach ($bank_loan_siape as $bank) :
                                                $bank_not_discount_selected = 0;
                                                foreach ($filter_bank_not_discount as $each) :
                                                    if ($each->bank_id == $bank->id) : $bank_not_discount_selected = 1;
                                                    endif;
                                                endforeach;
                                        ?>
                                                <option <?php if ($bank_not_discount_selected == 1) : echo "selected";
                                                        endif; ?> value="<?= $bank->id ?>"><?= $bank->bank ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label>Estado:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="state" name="state[]" multiple>
                                        <?php foreach ($states as $state) :
                                            $state_selected = 0;
                                            foreach ($filter_state as $each) :
                                                if ($each->state_id == $state->uf_codigo) : $state_selected = 1;
                                                endif;
                                            endforeach;
                                        ?>
                                            <option <?php if ($state_selected == 1) : echo "selected";
                                                    endif; ?> value="<?= $state->uf_codigo ?>"><?= $state->uf_descricao; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <div class="col-4">
                                    <label>Cidade:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="city" name="city[]" multiple>
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
                                    <select class="form-control select2bs4" style="width: 100%;" id="attendance_retorn" name="attendance_retorn">
                                        <option value="">--Selecione--</option>
                                        <?php if (!empty($attendence_returns)) :
                                            foreach ($attendence_returns as $attendence_return) : ?>
                                                <option value="<?= $attendence_return->id ?>" <?php if ($filter->attendance_retorn_id == $attendence_return->id) : ?> selected <?php endif; ?>><?= $attendence_return->description ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label>Atendimentos de:</label>
                                    <input type="text" class="form-control mask-date txt_data" id="attendence_of" name="attendence_of" value="<?= date_fmt_br($filter->attendence_of) ?>">
                                </div>
                                <div class="col-4">
                                    <label>Até:</label>
                                    <input type="text" class="form-control mask-date txt_data" id="until_attendence_of" name="until_attendence_of" value="<?= date_fmt_br($filter->until_attendence_of) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
                            RELATÓRIO
                        </div>
                        <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                            <?php
                            if (!$attendances) : ?>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 fas fa-info text-danger " align="center">
                                        Não existem Atendimentos para esse filtro.
                                    </div>
                                </div><br>
                            <?php else : ?>
                                <table id="example3" class="display">
                                    <thead>
                                        <tr>
                                            <th>Filtro</th>
                                            <th>Usuário</th>
                                            <th>Data</th>
                                            <th>Telefone</th>
                                            <th>Retorno</th>
                                            <th>Base</th>
                                            <th>CPF</th>
                                            <th>Cliente</th>
                                            <th>Retorno em</th>
                                            <th>Telefone de Retorno</th>
                                            <th>Observação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($attendances as $attendance) : ?>
                                            <tr>
                                                <td><?php if (isset($attendance->filterDesc()->title)) : echo $attendance->filterDesc()->title;
                                                    else : echo "Sem filtro";
                                                    endif; ?></td>
                                                <td><?= $attendance->userDesc()->fullName() ?></td>
                                                <td><?= date_fmt($attendance->created_at) ?></td>
                                                <td><?= returnPhone($attendance->clientDesc()->TELEFONE_01) ?></td>
                                                <td><?= $attendance->attendanceDesc()->description ?></td>
                                                <td><?php foreach ($attendance->organDesc() as $organ) : echo $organ->organ;
                                                    endforeach; ?></td>
                                                <td><?= $attendance->clientDesc()->CPF ?></td>
                                                <td><?= $attendance->clientDesc()->NOME ?></td>
                                                <?php if ($attendance->scheduling_id != 0) : ?>
                                                    <td><?= date_fmt2($attendance->schedulingDate()->date_return) ?></td>
                                                <?php else : ?>
                                                    <td><?= $attendance->scheduling_id ?></td>
                                                <?php endif; ?>
                                                <td><?= $attendance->phone ?></td>
                                                <td><?= $attendance->description ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <td>Total: <?= count($attendances); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tfoot>
                                </table><br>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane fade" id="csv" role="tabpanel" aria-labelledby="csv-tab">
                        <table id="table2csv" class="table">
                            <thead>
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Matrícula</th>
                                <th scope="col">Telefone 1</th>
                                <th scope="col">Telefone 2</th>
                                <th scope="col">Telefone 3</th>
                                <th scope="col">Telefone 4</th>
                                <th scope="col">Telefone 5</th>
                                <th scope="col">Telefone 6</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientesAtendidos as $clienteAtendido): ?>

                                    <tr>
                                        <td><?= $clienteAtendido->id ?></td>
                                        <td><?= $clienteAtendido->CPF ?></td>
                                        <td><?= $clienteAtendido->MATRICULA ?></td>
                                        <td><?= $clienteAtendido->telefone_01 ?></td>
                                        <td><?= $clienteAtendido->telefone_02 ?></td>
                                        <td><?= $clienteAtendido->telefone_03 ?></td>
                                        <td><?= $clienteAtendido->telefone_04 ?></td>
                                        <td><?= $clienteAtendido->telefone_05 ?></td>
                                        <td><?= $clienteAtendido->telefone_06 ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                    
                            </tbody>
                            </table>
                        </div>
                    </div>
                </form>
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
<script src="<?= url("/shared/scripts/filter_edit.js"); ?>"></script>
<script>
    $(document).ready(function() {
            $('#table2csv').DataTable({
                "language": {
                    "search": "Procurar:",
                    "lengthMenu": "_MENU_ Resultados por página",
                    "zeroRecords": "Nenhum Registro Encontrado",
                    "infoEmpty": "Nenhum Registro Encontrado",
                },
                dom: 'Bfrtip',
                buttons: [
                'excel',
                ],
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
            });
        });
</script>
<?php $v->end(); ?>
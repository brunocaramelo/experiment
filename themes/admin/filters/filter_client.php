<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user"></i> Cliente</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $router->route("filter.workList"); ?>">Lista de Trabalho</a></li>
                        <li class="breadcrumb-item active">Cliente</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .subtitle {
            font-weight: bold;
            color: #fff;
            background-color: rgb(68, 68, 211);
            padding: 5px 3px;
            margin: 0 0 25px 0;
        }
		hr.style-one {
			border: 0;
			height: 1px;
			background: #333;
			background-image: linear-gradient(to right, #ccc, #333, #ccc);
		}		
		hr.style-three {
			border: 0;
			border-bottom: 1px dashed #ccc;
			background: #999;
		}

        #btnOpenCalcFin{
            position: fixed;
            right: 20px;
            bottom: 70px;
            z-index: 2;
            border-radius: 100%;
        }

        .ui-calc-financ {
            display: none;
            position: fixed;
            bottom: 70px;
            right: 30px;
            z-index: 3;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: #66666652 0px 1px 5px 2px;
        }

        .ui-calc-financ h1{
            font-size: 1.4rem;
        }

        .ui-calc-financ .close{
            background-color: #fff;
            border-radius: 100%;
            padding: 10px;
            opacity: 1;
            right: -15px;
            top: -17px;
            position: absolute;
        }

        #resultado {
            word-break: break-word;
            max-width: 370px;
            margin: 0 auto;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
			<table width="65%" border="0" style="margin: 10px 20px 0px 20px;">
			  <tbody>
				<tr>
				  <td width="50px">
					  
					<?php if (user()->account()->use_api == 1) : ?>
						<form action="<?= $router->route("filter.filterClientUpdate"); ?>" method="post">
							<input type="hidden" name="client_id" value="<?= $client->id ?>">
							<input type="hidden" name="filter_id" value="<?= $filter_id ?>">
							<input type="hidden" name="search" value="<?= $search ?>">
							<input type="hidden" name="update" value="data">
							<input type="hidden" name="url_redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
							<button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="ATUALIZAR DADOS"><i class="fas fa-sync"></i></button>
						</form>
					<?php endif; ?>
					  
					</td>
				  <td>
					  
					<?php if ($release_next_customer == 0) : ?>
							<a href="<?= url("/lista-de-trabalho/cliente/{$filter_id}/next") ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PRÓXIMO CLIENTE"><i class="fas fa-forward"></i></a>
							<?php else :
							if ($count_attendance > 0) : ?>
								<a href="<?= url("/lista-de-trabalho/cliente/{$filter_id}/next") ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PRÓXIMO CLIENTE"><i class="fas fa-forward"></i></a>
							<?php else : ?>
								<button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" disabled title="PRÓXIMO CLIENTE"><i class="fas fa-forward"></i></button>
						<?php endif;
						endif;
						?>
					  
					  
					</td>
				  <td align="right">

						<!--button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="GERAR PDF"><i class="far fa-file-pdf"></i></button-->
						<!--a href="< ?= url("/cliente/consultapdf/{$client->id}") ?>" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="GERAR PDF"-->
							</a>
					  
					  <i onclick="window.open('<?= url("/cliente/consultapdf/{$client->id}") ?>','_blank')" class='fas fa-file-pdf fa-x3' style='font-size:35px;color:#755553;cursor:pointer' data-toggle="tooltip" data-placement="top" title="GERAR PDF"></i>
					  
					  
					</td>
				</tr>
			  </tbody>
			</table>
<!-- FIM MEXI AQUI -->			
			
            <div class="col-md-12">
                
				
                <div class="card card-outline">
                    <div class="card-header">
                        <b>
                            <h4><?= "{$client->organDesc()->organ} - <span style='color:blue'>{$client->NOME}" ?></span></h4>
                        </b>
                    </div>				
				
                    <div class="card-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Órgão:</label><br>
                                <span style="color:blue">
                                    <span style="color:blue"><?php if ($client->ORGAO != 0) : foreach ($client->organFilterDesc() as $each_organ) : echo $each_organ->description;
                                                                    endforeach;
                                                                endif; ?></span>
                                </span>
                            </div>
						</div>
						<hr class="style-one">
							
                        <div class="row">
							<div class="col-md-3">
								<label>Matrícula:</label><br>
								<span style="color:blue;"><?= $client->MATRICULA ?></span>
							</div>
                            <div class="col-md-3">
                                <label>CPF:</label><br>
                                <span style="color:blue"><?= mask(cpfZeros($client->CPF), "###.###.###-##") ?></span>
                            </div>
							<?php if ($client_update_value == 0) : ?>
                                <div class="col-md-3">
                                    <label>Nascimento:</label><br>
                                    <span style="color:blue"><?= date_fmt2($client->NASCIMENTO) ?>(<?= return_age($client->NASCIMENTO) ?> Anos)</span>
                                    <!--span style="color:blue"><?= date_fmt2($client->birth) ?> (<?= return_age($client->birth) ?> Anos)</span-->
                                    <!--span style="color:blue"><?= $client->NASCIMENTO ?> Anos)</span-->
                                </div>
                            <?php else : ?>
                                <div class="col-md-3">
                                    <label>Nascimento:</label><br>
                                    <span style="color:blue"><?= date_fmt2($client_update->nascimento) ?>(<?= return_age($client_update->nascimento) ?> Anos)</span>
                                </div>
                            <?php endif; ?>							

							<div class="col-md-3">
                                <label>RJUR:</label><br>
                                <span style="color:blue"><?= $client->RUUR ?></span>
                            </div>
						</div>
						
					<hr class="style-three">

					<div class="row">

                            <div class="col-md-3">
                                <label>Nome:</label><br>
                                <span style="color:blue"><?= $client->NOME ?></span>
                            </div>
                            <div class="col-md-3">
                                <label>Categoria:</label><br>
                                <span style="color:blue"><?= $client->CATEGORIAS ?></span>
                            </div>
                            <div class="col-md-3">
                                <label>Situação:</label><br>
                                <span style="color:blue"><?= $client->SITUACAO ?></span>
                            </div>
                            <div class="col-md-3">
                                <label>Patente:</label><br>
                                <span style="color:blue"><?= $client->PATENTE ?></span>
                            </div>
						</div>
						
						<hr class="style-three">
				
						<div class="row">
                            
                            <div class="col-md-3">
                                <label>Banco:</label><br>
                                <span style="color:blue"><?php if ($client->BANCO != 0) : echo $client->clientBank()->bank;
                                                            endif; ?></span>
                            </div>
                            <div class="col-md-3">
                                <label>Agencia:</label><br>
                                <span style="color:blue"><?= $client->AGENCIA ?></span>
                            </div>
                            <div class="col-md-6">
                                <label>Conta:</label><br>
                                <span style="color:blue"><?= $client->CONTA ?></span>
                            </div>
						</div>
						
						<hr class="style-three">
							
						<div class="row">
                            <?php if ($client_update_value == 0) : ?>
                                <div class="col-md-12">
                                    <label>Endereço:</label><br>
                                    <span style="color:blue"><?= $client->ENDERECO . " " . $client->BAIRRO . "," . $client->CIDADE . "-" . $client->UF . "," . $client->CEP ?></span>
                                </div>
                            <?php else : ?>
                                <div class="col-md-12">
                                    <label>Endereço:</label><br>
                                    <span style="color:blue"><?= $client_update->endereco . " " . $client_update->bairro . "," . $client_update->cidade . "-" . $client_update->uf . "," . $client_update->cep ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="col-md-2">
                                <label>Bruto:</label><br>
                                <span style="color:blue"><?php if ($client->BRUTO != "") : ?><?= "R$" . $client->BRUTO ?><?php endif; ?></span>
                            </div>
                            <div class="col-md-2">
                                <label>Desconto:</label><br>
                                <span style="color:blue"><?php if ($client->DESCONTO != "") : ?><?= "R$" . $client->DESCONTO ?><?php endif; ?></span>
                            </div>
                            <div class="col-md-2">
                                <label>Líquido:</label><br>
                                <span style="color:blue"><?php if ($client->LIQUIDO != "") : ?><?= "R$" . $client->LIQUIDO ?><?php endif; ?></span>
                            </div>
                            <div class="col-md-2">
                                <label>Margem 30%:</label><br>
                                <span style="color:blue"><?php if ($client->MARGEM_CONSIG != "") : ?><?= "R$" . $client->MARGEM_CONSIG ?><?php endif; ?></span>
                            </div>
                            <div class="col-md-2">
                                <label>Margem 5%:</label><br>
                                <span style="color:blue"><?php if ($client->MARGEM_CARTAO != "") : ?><?= "R$" . $client->MARGEM_CARTAO ?><?php endif; ?></span>
                            </div>
                            <div class="col-md-2">
                                <label>Margem de aproximadamente 5%:</label><br>
                                <span style="color:blue"><?php if ($client->MARGEM_UTIL_CARTAO != "") : ?><?= "R$" . $client->MARGEM_UTIL_CARTAO ?><?php endif; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
			<hr class="style-one">
			<br>


                <div class="card card-outline tab-content p-3" id="nav-tabContent">

                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="true">Empréstimo</a>
                            <a class="nav-item nav-link" id="descont-tab" data-toggle="tab" href="#descont" role="tab" aria-controls="descont" aria-selected="true">Outros</a>
                            <a class="nav-item nav-link" id="inss-tab" data-toggle="tab" href="#inss" role="tab" aria-controls="inss" aria-selected="true">Meu INSS</a>
                        </div>
                    </nav>
                    <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
                        <div class="row">
                            <table id="escalation" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Discriminação</th>
                                        <th>Valor</th>
                                        <th>Prazo</th>
                                        <th>Parc.</th>
                                        <th>Total</th>
                                        <th>Saldo Aprox</th>
                                        <th>Coef</th>
                                        <th>Líquido Cliente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>MARGEM</td>
                                        <td><input typ="text" name="margin" <?php if ($client->MARGEM_CONSIG != "") : ?>value="<?= "R$" . $client->MARGEM_CONSIG ?>" <?php endif; ?>></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php if (isset($client_contract)) :
                                        foreach ($client_contract as $i => $each_contract) :
                                    ?>
                                            <tr>
                                                <td><?php if ($each_contract->BANCO_EMPRES != "") : ?><?= "EMPRESTIMO " . $each_contract->BANCO_EMPRES ?><?php endif; ?></td>
                                                <td><?php if ($each_contract->VALOR != "") : ?><?= "R$" . $each_contract->VALOR ?><?php endif; ?></td>
                                                <?php if ($client->CLIENT_ORGAN != 1) : ?>
                                                    <td><?= date_month_year($each_contract->PRAZO) ?></td>
                                                <?php else : ?>
                                                    <td></td>
                                                <?php endif; ?>
                                                <?php if ($each_contract->VALOR != "") : ?>
                                                    <td><input class="txt_numero" typ="text" id="parcela_<?= $i ?>" onblur="calcula_valor_total(<?= $i ?>)" <?php if ($each_contract->PRAZO != "") : ?> value=<?= calculaDiffDate($each_contract->PRAZO); ?> <?php endif; ?> /></td>
                                                    <td><input type="hidden" id="valor_total_input_<?= $i ?>" value="<?= str_price($each_contract->VALOR) ?>"><label id="valor_todal_<?= $i ?>"><?php if ($each_contract->PRAZO != "") : ?> <?= "R$ " . str_price(calculaDiffDate($each_contract->PRAZO) * $each_contract->VALOR); ?> <?php endif; ?></label></td>
                                                    <td><input typ="text" name="saldo_aproximado" /></td>
                                                    <td><?= $client->coefficient ?></td>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                <?php endif; ?>
                                            </tr>
                                    <?php endforeach;
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>
				<hr class="style-three">	
                    </div>
					
					
                    <div class="tab-pane fade" id="descont" role="tabpanel" aria-labelledby="descont-tab">
                        <div class="row">
							
                            <?php if (count($client_contract_others) != 0) : ?>
                                <table id="escalation2" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Discriminação</th>
                                            <th>Valor da Despesa</th>
                                            <th>Prazo</th>
                                        </tr>
                                        <?php
                                        $valor_receita = 0;
                                        $valor_desconto = 0;
                                        foreach ($client_contract_others as $each_contract_others) :
                                        ?>
                                            <tr>
                                                <td><?= $each_contract_others->BANCO_EMPRES ?></td>
                                                <td><?php if ($each_contract_others->VALOR != "") : ?><?= "R$" . $each_contract_others->VALOR ?><?php endif; ?></td>
                                                <td><?= $each_contract_others->PRAZO ?></td>
                                            </tr>
                                        <?php
                                            $valor_receita += str_price_invert($each_contract_others->VALOR);
                                            $valor_desconto += str_price_invert($each_contract_others->VALOR);
                                        endforeach;
                                        ?>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td><b>TOTAL</b></td>
                                            <td><b><?= str_price($valor_desconto) ?></b></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
							
						<hr class="style-three">	

                            <?php endif; ?>
                        </div>
                    </div>
					
					
                    <div class="tab-pane fade" id="inss" role="tabpanel" aria-labelledby="inss-tab">
                        <div class="row">
                            <?php if (isset($client_benefit)) : ?>
                                <br>
                                <div class="col-md-6"></div>
                                <div class="col-md-6"><b>BENEFÍCIOS</b></div>
                                <table id="escalation2" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Número do Beneficio</th>
                                            <th>Código do Beneficio</th>
                                            <th>Situação do Beneficio</th>
                                            <th>Beneficio</th>
                                            <th>Dib</th>
                                            <th>Valor do Benefício</th>
                                            <th>Banco</th>
                                            <th>Agencia</th>
                                            <th>Conta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($client_benefit as $each_client_benefit) :
                                        ?>
                                            <tr>
                                                <td><?= $each_client_benefit->benefit_number ?></td>
                                                <td><?= $each_client_benefit->benefit_cod ?></td>
                                                <td><?= $each_client_benefit->situacao_beneficio ?></td>
                                                <td><?= $each_client_benefit->nome ?></td>
                                                <td><?= $each_client_benefit->dib ?></td>
                                                <td><?= "R$" . str_price($each_client_benefit->valor) ?></td>
                                                <td><?= $each_client_benefit->banco ?></td>
                                                <td><?= $each_client_benefit->agencia ?></td>
                                                <td><?= $each_client_benefit->conta ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                            <?php if (isset($client_loan)) : ?>
                                <br>
                                <div class="col-md-6"></div>
                                <div class="col-md-6"><b>EMPRÉSTIMOS</b></div>
                                <table id="escalation2" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Contrato</th>
                                            <th>Banco</th>
                                            <th>Início do Contrato</th>
                                            <th>Valor</th>
                                            <th>Quantidade de Parcelas</th>
                                            <th>Parcelas em Aberto</th>
                                            <th>Valor das Parcelas</th>
                                            <th>Quitação</th>
                                            <th>Taxa</th>
                                            <th>Início do Desconto</th>
                                            <th>Término do Desconto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($client_loan as $each_client_loan) :
                                        ?>
                                            <tr>
                                                <td><?= $each_client_loan->contrato ?></td>
                                                <td><?= $each_client_loan->banco ?></td>
                                                <td><?= $each_client_loan->inicio_contrato ?></td>
                                                <td><?= "R$" . str_price($each_client_loan->valor) ?></td>
                                                <td><?= $each_client_loan->parcela ?></td>
                                                <td><?= $each_client_loan->parcela_aberta ?></td>
                                                <td><?= "R$" . str_price($each_client_loan->valor_parcela) ?></td>
                                                <td><?= "R$" . str_price($each_client_loan->quitacao) ?></td>
                                                <td><?= $each_client_loan->taxa ?></td>
                                                <td><?= $each_client_loan->inicio_desconto ?></td>
                                                <td><?= $each_client_loan->termino_desconto ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                            <?php if (!isset($client_benefit) && !isset($client_loan)) : ?>
                                <br>
                                <!--div class="col-md-5"></div-->
                                <div class="col-md-7 text-danger">
									<span style="margin:10px 0px 0px 0px; padding: 10px 0px 0px 10px;text-transform: uppercase;font-weight: bold;">Nenhum Benefício encontrado</span>
							     </div>
                                <br>&nbsp;<br>
                            <?php endif; ?>
                        </div>
						
						
                        <?php if(user()->account_id!=66): ?>
                        <div class="row" style="margin: 0px 0px 0px 10px;">
                            <!--div class="col-md-5"></div>
                            <div class="col-md-3"-->
                                <form action="<?= $router->route("filter.filterClientUpdate"); ?>" method="post">
                                    <input type="hidden" name="client_id" value="<?= $client->id ?>">
                                    <input type="hidden" name="filter_id" value="<?= $filter_id ?>">
                                    <input type="hidden" name="update" value="inss">
                                    <input type="hidden" name="search" value="<?= $search ?>">
                                    <input type="hidden" name="url_redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                    <button class="btn btn-primary" <?php if (isset($client_benefit) || isset($client_loan)) : ?> disabled <?php endif; ?>><i class="fas fa-redo"></i>&nbsp;Atualizar INSS</button>
                                </form>
                            <!--/div-->
                        <!--/div-->
							&nbsp;&nbsp;
                        <?php endif;?>
                    </div>
			<hr class="style-three">	
                </div>
					
			<hr class="style-one">	
					<br>
                <div class="card card-outline tab-content p-3" id="nav-tabContent">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="tel-tab" data-toggle="tab" href="#tel" role="tab" aria-controls="tel" aria-selected="true">Telefone</a>
                            <a class="nav-item nav-link" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="true">E-mail</a>
							
							<span style="margin: 0px 0px 0px 50px;">
											<?php if (user()->account()->use_api == 1) : ?>
												
													<form action="<?= $router->route("filter.filterClientUpdate"); ?>" method="post">
														<input type="hidden" name="client_id" value="<?= $client->id ?>">
														<input type="hidden" name="filter_id" value="<?= $filter_id ?>">
														<input type="hidden" name="search" value="<?= $search ?>">
														<input type="hidden" name="update" value="data">
														<input type="hidden" name="url_redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
														&nbsp;
														<button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="ATUALIZAR DADOS">
															<i class="fas fa-sync"></i>
														</button>
													</form>
												<?php endif; ?>
							</span>

							
							
                        </div>
                    </nav>
                    <div class="tab-pane fade show active" id="tel" role="tabpanel" aria-labelledby="tel-tab">
                        <div class="row">
                            <table class="tdHover"  cellpadding="5">
								<thead>
                                    <tr>
										<th width="90px" data-toggle="tooltip" data-placement="top" title="Clique no ícone abaixo para copiar o número" align="center">&nbsp;&nbsp;&nbsp;&nbsp;Copiar</th>
                                        <th>Telefones</th>
                                        <!--th>Ações</th-->
                                    </tr>
                                </thead>                                
								<tbody>

                                    <?php if ($client_update_value == 0) : ?>
                                        <?php $i = 0;

                                        if ($client->TELEFONE_01 != "") : ?>
                                            <?php if ($client->TELEFONE_01 != "0") : $i = 1; ?>
                                                <tr>
                                                    <td align="center">
														&nbsp;
														<input type="hidden" id="phone1" value="<?= returnPhone($client->TELEFONE_01) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="1" data-value="<?= returnPhone($client->TELEFONE_01); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
													
													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_01; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
													<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client->TELEFONE_01) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i>  
													</td>													

                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client->TELEFONE_02 != "") : ?>
                                            <?php if ($client->TELEFONE_02 != "0") : $i = 2; ?>
                                                <tr>
													<td align="center">
														
													 <input type="hidden" id="phone2" value="<?= returnPhone($client->TELEFONE_02) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="2" data-value="<?= returnPhone($client->TELEFONE_02); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
                                                    <td>
													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_01; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
													<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client->TELEFONE_02) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i>  
													</td>	                                                    
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client->TELEFONE_03 != "") : ?>
                                            <?php if ($client->TELEFONE_03 != "0") : $i = 3; ?>
												<tr>
													<td>
                                                        &nbsp;
                                                        <input type="hidden" id="phone3" value="<?= returnPhone($client->TELEFONE_03) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="3" data-value="<?= returnPhone($client->TELEFONE_03); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_01; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
													<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client->TELEFONE_03) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i>  
													</td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client->TELEFONE_04 != "") : ?>
                                            <?php if ($client->TELEFONE_04 != "0") : $i = 4; ?>
                                                <<tr>
                                                    <td align="center">
                                                        &nbsp;
                                                        <input type="hidden" id="phone4" value="<?= returnPhone($client->TELEFONE_04) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="4" data-value="<?= returnPhone($client->TELEFONE_04); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_01; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
													<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client->TELEFONE_04) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i>  
													</td>
                                                    </td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client->TELEFONE_05 != "") : ?>
                                            <?php if ($client->TELEFONE_05 != "0") : $i = 5; ?>
                                                <tr>
                                                    <td>
                                                        &nbsp;
                                                        <input type="hidden" id="phone5" value="<?= returnPhone($client->TELEFONE_05) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="5" data-value="<?= returnPhone($client->TELEFONE_05); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_01; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
													<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client->TELEFONE_05) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i>  
													</td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client->TELEFONE_06 != "") : ?>
                                            <?php if ($client->TELEFONE_06 != "0") : $i = 6; ?>
                                                <tr>
                                                    <td align="center">
                                                        
                                                        <input type="hidden" id="phone6" value="<?= returnPhone($client->TELEFONE_06) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="6" data-value="<?= returnPhone($client->TELEFONE_06); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_01; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
													<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client->TELEFONE_06) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i> 
													</td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>

                                    <?php else : ?>

                                        <?php $i = 0;

                                        if ($client_update->telefone_01 != "") : ?>
                                            <?php if ($client->telefone_01 != "0") : $i = 1; ?>
                                                <tr>
                                                    <td align="center">
														<input type="hidden" id="phone1" value="<?= returnPhone($client_update->telefone_01) ?>">
															<i class="far fa-copy copy-phone" style="cursor:pointer" data-order="1" data-value="<?= returnPhone($client_update->telefone_01); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
                                                    <td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_01; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP"> 
														
														<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client_update->telefone_01) ?></span>
														
														
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i> 
													</td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client_update->telefone_02 != "") : ?>
                                            <?php if ($client_update->telefone_02 != "0") : $i = 2; ?>
                                                <tr>
                                                    <td align="center">
                                                        <input type="hidden" id="phone2" value="<?= returnPhone($client_update->telefone_02) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="2" data-value="<?= returnPhone($client_update->telefone_02); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
                                                    <td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_02; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
														
														<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client_update->telefone_02) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i> 
													</td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client_update->telefone_03 != "") : ?>
                                            <?php if ($client_update->telefone_03 != "0") : $i = 3; ?>
                                                <tr>
                                                    <td>&nbsp;
													<input type="hidden" id="phone3" value="<?= returnPhone($client_update->telefone_03) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="3" data-value="<?= returnPhone($client_update->telefone_03); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>

													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_03; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
														
														<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client_update->telefone_03) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i> 
													</td>
													
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client_update->telefone_04 != "") : ?>
                                            <?php if ($client_update->telefone_04 != "0") : $i = 4; ?>
                                                <tr>
                                                    <td>
														&nbsp;
                                                        <input type="hidden" id="phone4" value="<?= returnPhone($client_update->telefone_04) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="4" data-value="<?= returnPhone($client_update->telefone_04); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
													
													<td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_04; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
														
														<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client_update->telefone_04) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i> 
													</td>
													
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client_update->telefone_05 != "") : ?>
                                            <?php if ($client_update->telefone_05 != "0") : $i = 5; ?>
                                                <tr>
                                                    <td>
                                                        &nbsp;
                                                        <input type="hidden" id="phone6" value="<?= returnPhone($client_update->telefone_06) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="6" data-value="<?= returnPhone($client_update->telefone_06); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
                                                    <td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_06; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
														
														<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client_update->telefone_06) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i> 
													</td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>
                                        <?php if ($client_update->telefone_06 != "") : ?>
                                            <?php if ($client_update->telefone_06 != "0") : $i = 6; ?>
                                                <tr>
                                                    <td>
                                                        &nbsp;
                                                        <input type="hidden" id="phone6" value="<?= returnPhone($client_update->telefone_06) ?>">
                                                        <i class="far fa-copy copy-phone" style="cursor:pointer" data-order="6" data-value="<?= returnPhone($client_update->telefone_06); ?>" data-toggle="tooltip" data-placement="top" title="Copiar Telefone"></i>
													</td>
                                                    <td style='cursor:pointer' onclick=" window.open('https://api.whatsapp.com/send?phone=55<?= $client_update->telefone_06; ?>','_blank')" data-toggle="tooltip" data-placement="top" title="ABRIR WHATSAPP">
														
														<span style="color:blue;" class="copy-paste-phone" data-order="1"><?= returnPhone($client_update->telefone_06) ?></span>
														<i class="fab fa-whatsapp-square fa-2x" style="margin-left: 25px"></i> 
													</td>
                                                </tr>
                                        <?php endif;
                                        endif; ?>

                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                        <div class="row">
                            <table class="tdHover">
								<thead>
                                    <tr>
                                        <th>E-mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($client_update_value == 0) : ?>
                                        <tr>
                                            <td><span style="color:blue"><?= $client->EMAIL ?></span></td>
                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <td><span style="color:blue"><?= $client_update->email ?></span></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
		
			<hr class="style-one">	
					<br>

                <form action="<?= $router->route("filter.clientAttendance"); ?>" method="post">
                    <input type="hidden" name="url_redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <div class="card card-outline">
                        <div class="card-header">
                            <h4>ATENDIMENTOS</h4>
                        </div>
                        <input type="hidden" name="client_id" value="<?= $client->id ?>">
                        <input type="hidden" name="filter_id" value="<?= $filter_id ?>">
                        <input type="hidden" name="count_cel" value="<?= $i ?>">
                        <input type="hidden" name="search" value="<?= $search ?>">
                        <div class="card-body pad">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Telefone de contato:</label>
                                    <input class="form-control mask-cel" type="text" <?php if ($blocked_client > 0) : echo "disabled";
                                                                                        endif; ?> name="cel" placeholder="Telefone" id="cel" required />
                                </div>
                                <div class="col-md-3">
                                    <label>Retorno de Atendimento:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" <?php if ($blocked_client > 0) : echo "disabled";
                                                                                                    endif; ?> id="attendance_retorn" name="attendance_retorn" required>
                                        <option value="">--Selecione--</option>
                                        <?php if (!empty($attendence_returns)) :
                                            foreach ($attendence_returns as $attendence_return) : ?>
                                                <option value="<?= $attendence_return->id ?>"><?= $attendence_return->description ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Observações:</label>
                                    <input class="form-control" type="text" name="description" <?php if ($blocked_client > 0) : echo "disabled";
                                                                                                endif; ?> placeholder="Observação" />
                                </div>
                            </div>
                            <div class="row" id="scheduling_div" style="display:none">
                                <div class="col-md-4">
                                    <label>Retorna em:</label>
                                    <input class="form-control mask-date3" type="text" <?php if ($blocked_client > 0) : echo "disabled";
                                                                                        endif; ?> name="date_return" id="date_return" placeholder="Retorna em" />
                                </div>
                                <div class="col-md-4">
                                    <label>Agendar para:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" <?php if ($blocked_client > 0) : echo "disabled";
                                                                                                    endif; ?> id="scheduling_for" name="scheduling_for">
                                        <option value="">--Selecione--</option>
                                        <?php foreach ($users as $user) : ?>
                                            <option value="<?= $user->id ?>"><?= $user->fullname(); ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Telefone para agendamento:</label>
                                    <input class="form-control mask-cel" type="text" <?php if ($blocked_client > 0) : echo "disabled";
                                                                                        endif; ?> name="phone_scheduling" id="phone_scheduling" placeholder="Telefone para agendamento" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php if ($blocked_client == 0) : ?>
                        <hr>
                        <div class="">
                            <button class="btn btn-success"><i class="fas fa-phone"></i> Registrar Atendimento</button>
                        </div><!-- /.card-footer -->
                    <?php endif; ?>
                </form>

			<hr class="style-one">	
					<br>

		
				<div class="card-header">
					<h4>ATENDIMENTOS FEITOS</h4>
				</div>
                <?php
                if ($attendance) : ?>
                    <table id="example3" class="display">
                        <thead>
                            <tr>
                                <th>Filtro</th>
                                <th>Usuário</th>
                                <th>Data</th>
                                <th>Retorno</th>
                                <th>Telefone Utilizado</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendance as $attendance_each) : ?>
                                <tr>
                                    <td><?php if (isset($attendance_each->filterDesc()->title)) : echo $attendance_each->filterDesc()->title;
                                        else : echo "Sem filtro";
                                        endif; ?></td>
                                    <td><?= $attendance_each->userDesc()->fullName() ?></td>
                                    <td><?= date_fmt($attendance_each->created_at) ?></td>
                                    <td><?= $attendance_each->attendanceDesc()->description ?></td>
                                    <td><?= $attendance_each->phone ?></td>
                                    <td><?= $attendance_each->description ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table><br>
                <?php else : ?>
                    <div class="row">
						
                            
				<button class="btn btn-warning"><i class="fas fa-info"></i>&nbsp;&nbsp;Nenhum atendimento registrado para esse cliente</button>
                    </div>
		
			<hr class="style-one">	
					<br>
                <?php endif; ?>
                <br>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
</div>
<!--modal document_secundary_complements-->
<button class="btn btn-primary" id="btnOpenCalcFin"><i class="fas fa-calculator"></i></button>

<div class="ui-calc-financ" tabindex="-1" role="dialog" aria-hidden="true">
    <a href="javascript:;" class="close"><i class="fa fa-times"></i></a>
    <form>
        <div class="row">
            <div class="col-sm text-center">
                <h1>Financiamento com prestações fixas</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h4 class="subtitle">
                    Simule o financiamento com prestações fixas
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="row form-group">
                    <div class="col-md-5 text-right">Nº de meses</div>
                    <div class="col-md-5">
                        <input type="tel" id="meses" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                    </div>
                    <div class="col-md-2">&nbsp;</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5 text-right">Taxa de juros mensal</div>
                    <div class="col-md-5">
                        <input type="tel" id="taxa" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                    </div>
                    <div class="col-md-2">%</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5 text-right">Valor de prestação</div>
                    <div class="col-md-7">
                        <input type="tel" id="parcela" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-5 text-right">Valor financiado</div>
                    <div class="col-md-7">
                        <input type="tel" id="financiado" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm text-right">
                <a href="https://www3.bcb.gov.br/CALCIDADAO/publico/exibirMetodologiaFinanciamentoPrestacoesFixas.do?method=exibirMetodologiaFinanciamentoPrestacoesFixas" target="_blank">Metodologia</a>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-6">
                <button class="btn btn-success" id="btn_calcular" type="button">Calcular</button>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-warning" id="bnt_resetar" type="reset">Limpar</button>
            </div>
        </div>
    </form>
		<div class="row">
			<div class="col-sm-12 text-center pt-5">
				<p id="resultado"></p>
			</div>
		</div>
			

        
    
</div>
<!-- /.content-wrapper -->
<?php $v->start("scripts"); ?>

<script>
    $('#modalScheduling').modal('hide');
    var fin = new Financing();

    // ativa a debug de equação
    fin.equationSolverActive = true;

    function processCalc() {
        try {
            console.log({
                prazo: fin.term,
                taxa: fin.tax,
                parcela: fin.installment,
                financiado: fin.total,
                devedor: fin.totalPayment,
                juros: fin.fee,
            });

            if (fin.term > 0) $("#meses").val(fin.term.toFixed(0));

            if (fin.tax > 0) $("#taxa").val(fin.tax);

            if (fin.installment > 0)
                $("#parcela").val(fin.installment.toFixed(2));

            if (fin.total > 0) $("#financiado").val(fin.total.toFixed(2));

            if (fin.hasError) {
                $("#resultado").html(
                    "Houve uma falha no cálculo, por favor reveja os parâmetros informados!"
                );
            } else {
                $("#resultado").html(
                    "O total desse financiamento de <strong>" +
                    fin.term.toFixed(0) +
                    "</strong> parcelas de <strong>" +
                    fin.installment.toFixed(2) +
                    "</strong> reais é <strong>" +
                    (fin.term * fin.installment).toFixed(2) +
                    "</strong> reais, sendo <strong>" +
                    fin.fee.toFixed(2) +
                    "</strong> de juros."
                );
            }
        } catch (e) {
            console.log(e);
        }
    }
</script>

<script>
    function validateFields() {
        var meses = $("#meses").val();
        var taxa = $("#taxa").val();
        var parcela = $("#parcela").val();
        var financiado = $("#financiado").val();

        fin.term = meses;
        fin.tax = taxa;
        fin.installment = parcela;
        fin.total = financiado;

        return true;
    }
</script>

<script>
    $(document).ready(function() {
        $("#btnOpenCalcFin").bind('click', function(){
            $(".ui-calc-financ").show();

            $("#btnOpenCalcFin").hide();
        });

        $("#btn_calcular").click(function() {
            $("#resultado").html('');

            if (validateFields()) {
                processCalc();
            }

            return false;
        });

        $(".ui-calc-financ input").bind('keyup', function(evt) {
            if(evt.keyCode == 13) {
                $("#btn_calcular").click();
            }

            evt.stopPropagation();

            return false;
        });

        $("#bnt_resetar").click(function() {
            $("#resultado").html('');
        });

        $(".ui-calc-financ .close").bind('click', function(){
            $(".ui-calc-financ").hide();
            $("#btnOpenCalcFin").show();
        });

        $("#attendance_retorn").change(function() {

            if ($("#attendance_retorn").val() == 14) {
                $("#scheduling_div").show();
                $('#scheduling_for').prop('required', true);
                $('#date_return').prop('required', true);
                $('#phone_scheduling').prop('required', true);
            } else {
                $("#scheduling_div").hide();
                $("#date_return").val("");
                $("#phone_scheduling").val("");
                $("#scheduling_for").val("");
                $('#scheduling_for').prop('required', false);
                $('#date_return').prop('required', false);
                $('#phone_scheduling').prop('required', false);
            }
        });

        $(".copy-phone").click(function() {
            var clicked = $(this);
            var data = clicked.data();
            
            copyById(data.order);
        });

        function copyById(id) {
            var inputTest = "";
            
            inputTest = document.getElementById("phone" + id);
            inputTest.type = 'text';
            inputTest.select();
            document.execCommand("copy");
            inputTest.type = 'hidden';

            return inputTest.value;
        }

        $(".copy-paste-phone").click(function() {
            var clicked = $(this);
            var data = clicked.data();

            var phone = copyById(data.order);

            $("#cel").val(phone);

            triggerSIP(phone);
        });

        function triggerSIP(phone) {
            phone = phone.replace(/[^0-9]/g,'');

            ['sip'].forEach((protocol) => {
                var frame = $("<iframe>")
                .attr("id", "sip-" + phone)
                .attr("src", protocol + ":" + phone)
                .hide();

                $('body').append(frame);

                setTimeout((_) => $("#sip-" + phone).remove(), 1000);
            });
        }
    });
</script>

<?php $v->end(); ?>
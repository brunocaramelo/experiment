<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<style>
	label {
		display: block;
		font-weight: bold;		
	}
hr.style-three {
    border: 0;
    border-bottom: 1px dashed #ccc;
    background: #999;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
	<div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-search"></i> Consulta API</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Consulta API</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <form action="<?= url("/consulta-api"); ?>" method="post">
                <div class="row"><input type="hidden" name="action" value="search" />
                    <div class="col-md-3">
                        <label>Escolha uma opção:</label>
                        <select class="form-control" id="show_style">
                            <option value='0'<?php if ($type == "") : ?>selected<?php endif; ?>>--Selecione--</option>
                            <option value='1' <?php if ($type == "cpf") : ?>selected<?php endif; ?>>CPF</option>
                            <option value='2' <?php if ($type == "cnpj") : ?>selected<?php endif; ?>>CNPJ</option>
                            <option value='3' <?php if ($type == "telefone") : ?>selected<?php endif; ?>>Telefone</option>
                        </select>
                    </div>
                    <div class="col-md-3 cpf">
                        <label>CPF:</label>
                        <input class="form-control txt_numero" type="text" name="s" id="cpf" maxlength="11" placeholder="Procurar..." <?php if ($type == "cpf") : ?>value="<?= $searchs_input; ?>" <?php endif; ?> aria-label="Search">
                    </div>
                    <div class="col-md-3 cnpj">
                        <label>CNPJ:</label>
                        <input class="form-control txt_numero" type="text" name="s2" id="cnpj" maxlength="20" placeholder="Procurar..." <?php if ($type == "cnpj") : ?>value="<?= $searchs_input; ?>" <?php endif; ?> aria-label="Search">
                    </div>
                    <div class="col-md-3 telefone">
                        <label>Telefone:</label>
                        <input class="form-control mask-cel" type="text" name="s3" id="tel" maxlength="11" placeholder="Procurar..." <?php if ($type == "telefone") : ?>value="<?= $searchs_input; ?>" <?php endif; ?> aria-label="Search">
                    </div>
                    <div class="col-md-6 btn_search" style="margin-top:32px">
                        <button class="btn btn-success">
                            <i class="fas fa-search fa-fw"></i>
                        </button>

                    </div>
                </div>
            </form>
            <br>
            
	<!--nova formatação-->
		<?php
            if ($searchs) : ?>

                <?php foreach ($searchs as $key => $search) : ?>
                    <?php if ($type == "cpf" || $type == "telefone") : ?>
                        <?php if ($key == "data") : ?>
			
			
    <section class="content">
		<div class="col-md-12">
			<!--div class="card card-outline p-3 mt-3"-->

				<div class="row">
					<div class="col-md-4">			
						<?php if (isset($search->nome)) : ?>   
								<label>Nome:</label>
					<span style="color:blue;">
						<?= $search->nome; ?>
							<!--?php echo "<label>Nome:</label> " . $search->nome; ?-->
						<?php endif; ?>	
					</span>	

					</div>

					<div class="col-md-2">
						<label>Sexo:</label>
						<?php if (isset($search->sexo)) : ?>
						<span style="color:blue;">
						<?php $x = $search->sexo == "F" ? "Feminino" : "Masculino"; echo $x; ?>
						</span>	
						<?php endif; ?>	
					</div>

					<div class="col-md-2">
						<label>Nascimento:</label>
						<span style="color:blue;">
							<?php if (isset($search->nascimento)) :
								$pos = strripos($search->nascimento, "/");

								if ($pos === false) :
							?>

							<?php echo date_fmt2($search->nascimento);
							else :
								echo $search->nascimento;
							?>
							<?php endif;
							endif; ?>
						</span>	
					</div> 
					<div class="col-md-2">
						<label>RG:</label>
						<span style="color:blue;">
						<?php if (isset($search->rg)) : ?>
						<?php echo $search->rg;
						else :
							echo "Sem registro";
						?>
						<?php endif; ?>
						</span>	
					</div>
				
					<div class="col-md-1">
						<label>Idade:</label>
						<span style="color:blue;">
						<?php if (isset($search->nascimento)) :

						$pos = strripos($search->nascimento, "/");

						if ($pos === false) :
					?>

					<?php return_age($search->nascimento);
						else :
						return_age2($search->nascimento);
						?>

					<?php endif;
					endif; ?>
						</span>
					</div>
			</div>	
		
					<!--/div-->
			<hr class="style-three">
		
				<div class="row">
					<div class="col-md-6">
						<label>Nome da mãe:</label>
						<span style="color:blue;">
						<?php if (isset($search->mae)) : ?>

						<?php echo $search->mae;
						?>

						<?php endif; ?>
						</span>
					</div>
					<div class="col-md-2">
						<label>CPF da mãe:</label>
						<span style="color:blue;">
						<?php if (isset($search->mae_cpf)) : ?>
						<?php echo $search->mae_cpf;
						?>
						<?php endif; ?>
						</span>		
					</div>
					<div class="col-md-2">	
						&nbsp;
					</div>
					<div class="col-md-2">	
						&nbsp;
					</div>
				</div>

			<hr class="style-three">
			

				<div class="row">
					<div class="col-md-6">
					<label>Endereço:</label>
						<span style="color:blue;">
							<?php if (isset($search->enderecos)) :

								foreach ($search->enderecos as $each) :
									$logradouro = $each->logradouro;
									$numero = $each->numero;
									$complemento = $each->complemento;
									$bairro = $each->bairro;
									$cidade = $each->cidade;
									$uf = $each->uf;
									$cep = $each->cep;
								endforeach;
								?>
								<?php echo $logradouro . " " . $numero . " " . $complemento . " " . $bairro . " " . $cidade . " " . $uf . " -  " . $cep; ?>
							<?php endif;
							?>
						</span>	
					</div>
					<div class="col-md-2">
					<label>Telefones:</label>
						<span style="color:blue;">
							<?php if (isset($search->telefones)) : ?>

								<?php foreach ($search->telefones as $key => $each) :
									echo $each->numero . "<br>";
								endforeach; ?>

							<?php endif;
							?>
						</span>	
					</div>
					<div class="col-md-4">
					<label>E-mails:</label>
						<span style="color:blue;">
							<?php if (isset($search->emails)) : ?>

									<?php foreach ($search->emails as $key => $each) :
										echo $each->email . "<br>";
									endforeach; ?>

								<?php endif;
								?>
						</span>	
					</div>
				</div>	

			<hr class="style-three">
			
		<?php
					$veiculo = "";
					$placa = "";
					$fabricacao = "";
					$modelo = "";


					foreach ($search->veiculos as $each) :
						$veiculo = $each->veiculo;
						$placa = $each->placa;
						$fabricacao = $each->fabricacao;
						$modelo = $each->modelo;
					?>				
					<div class="card-body pad">
						<div class="row">
							<div class="col-md-1">
								<label>Veículo:</label>
								<span style="color:blue;">
									<?= $veiculo ?>
								</span>
							</div>
							<div class="col-md-1">
								<label>Placa:</label>
								<span style="color:blue;">
									<?= $placa ?>
								</span>
							</div>							
							<div class="col-md-1">
								<label>Fabricação:</label>
								<span style="color:blue;">
									<?= $fabricacao ?>
								</span>
							</div>							
							
							<div class="col-md-1">
								<label>Modelo:</label>
								<span style="color:blue;">
									<?= $modelo ?>
								</span>
							</div>							

						</div>
					</div>
				<?php endforeach; ?>
		
			<?php if (isset($search->veiculo)) : ?>
						<?php echo $search->veiculo;
						else :
							echo "Não há veículo cadastrado!";
						?>
						<?php endif; ?>
		
			<hr class="style-three">
		
				
			<?php
				$empresa = "";
				$cnpj = "";
				$cnae = "";
				$participacao = "";
				$abertura = "";

				foreach ($search->sociedades as $each) :
					$empresa = $each->empresa;
					$cnpj = $each->cnpj;
					$cnae = $each->cnae;
					$participacao = $each->participacao;
					$abertura = $each->abertura;
				?>
				<div class="row">
		

					<h4>Sociedades:</h4>
					<br>

					<div class="col-md-6">
					<label>Empresa:</label>
						<span style="color:blue;">
							<?= $empresa ?>
						</span>
					</div>
					<div class="col-md-2">
					<label>CNPJ:</label>
						<span style="color:blue;">
							<?= $cnpj ?>
						</span>
					</div>
					<div class="col-md-2">
					<label>CNae:</label>
						<span style="color:blue;">
							<?= $cnae ?>
						</span>
					</div>
					<div class="col-md-2">
					<label>Participação:</label>
						<span style="color:blue;">
							<?= $participacao ?>
						</span>
					</div>
					<div class="col-md-1">
					<label>Abertura:</label>
						<span style="color:blue;">
							<?= $abertura ?>
						</span>
					</div>
		</div>
<?php
				$cpf = "";
				$nome = "";
				$telefones = "";
				foreach ($each->socios as $each2) :
					$cpf = $each2->cpf;
					$nome = $each2->nome;
					$telefones = $each2->telefones;
				?>			
				<div class="row">
					<div class="col-md-6">
					<label>CPF:</label>
						<span style="color:blue;">
							<?= $cpf ?>
						</span>
					</div>
					<div class="col-md-6"> 
					<label>Nome:</label>
						<span style="color:blue;">
							<?= $nome ?>
						</span>
					</div>
					<div class="col-md-6">
					<label>Telefone:</label>
						<span style="color:blue;">
							<?= $telefones ?>
						</span>
					</div>
					 <?php endforeach; ?>
				</div>
			 <?php endforeach; ?>
		</div>
	<?php endif; ?>
 	 <?php else :
			if (isset($search->cnpj)) :
			?>
			<div class="row">
				<div class="col-md-12">
				<h4>DADOS CADASTRAIS</h4>
				<br>
					<div class="col-md-2">
					<label>Telefone:</label>
						<span style="color:blue;">
							
						</span>
					</div>
					<?php if (isset($search->razao_social)) : ?>
						<div class="col-md-2">
						<label>Razão Social:</label>
							<span style="color:blue;">
							<?php echo $search->razao_social; ?>	
							</span>
						</div>
					<?php endif; ?>
					
					<?php if (isset($search->cnpj)) : ?>
						<div class="col-md-2">
						<label>CNPJ:</label>
							<span style="color:blue;">
							<?php echo $search->cnpj; ?>	
							</span>
						</div>
					<?php endif; ?>
					
					<?php if (isset($search->inscricao_estadual)) : ?>
						<div class="col-md-2">
						<label>Incrição Estadual:</label>
							<span style="color:blue;">
							<?php echo $search->inscricao_estadual; ?>
							</span>
						</div>
					<?php endif; ?>
					
					<?php if (isset($search->data_abertura)) : ?>
						<div class="col-md-1">
						<label>Data de Abertura:</label>
							<span style="color:blue;">
							<?php echo $search->data_abertura; ?>

							</span>
						</div>
					<?php endif; ?>	
					
					<?php if (isset($search->situacao)) : ?>
						<div class="col-md-2">
						<label>Situação:</label>
							<span style="color:blue;">
							<?php echo $search->situacao; ?>
							</span>
						</div>
					<?php endif; ?>	
					<?php if (isset($search->situacao_data)) : ?>
					<div class="col-md-1">
					<label>Situação Data:</label>
						<span style="color:blue;">
						<?php echo $search->situacao_data; ?>
						</span>
					</div>
					<?php endif; ?>					
				</div>
			</div>
			
			<hr class="style-three">

			<div class="row">
				<div class="col-md-12">
					<h4>SETOR DE ATUAÇÃO E FATURAMENTO</h4>
					<br>
					
					<?php if (isset($search->cnae)) : ?>
					<div class="col-md-2">
					<label>CNAE:</label>
						<span style="color:blue;">
							<?php echo $search->cnae; ?>
						</span>
					</div>
					<?php endif; ?>
					
					<?php if (isset($search->cnae_descricao)) : ?>
					<div class="col-md-2">
					<label>CNAE Descrição:</label>
						<span style="color:blue;">
						<?php echo $search->cnae_descricao; ?>
						</span>
					</div>
					<?php endif; ?>
					
					<?php if (isset($search->faturamento_presumido)) : ?>
					<div class="col-md-2">
					<label>Faturamento Presumido:</label>
						<span style="color:blue;">
						<?php echo $search->faturamento_presumido; ?>
						</span>
					</div>
					<?php endif; ?>

					<?php if (isset($search->capital_social)) : ?>
					<div class="col-md-2">
					<label>Capital Social:</label>
						<span style="color:blue;">
						<?php echo $search->capital_social; ?>
						</span>
					</div>
					<?php endif; ?>
					
					<?php if (isset($search->score)) : ?>
					<div class="col-md-2">
					<label>Score:</label>
						<span style="color:blue;">
						<?php echo $search->score; ?>
						</span>
					</div>
					<?php endif; ?>

					<?php if (isset($search->funcionarios)) : ?>
					<div class="col-md-2">
					<label>Funcionários:</label>
						<span style="color:blue;">
						<?php echo $search->funcionarios; ?>
						</span>
					</div>
					<?php endif; ?>
				</div>
			</div>
			
			<hr class="style-three">

			<div class="row">
				<div class="col-md-12">
					<h4>ENDEREÇOS</h4>
					<br>
					
					<div class="col-md-6">
					<!--label>Enderecos:</label-->
						<span style="color:blue;">
						<?php if (isset($search->enderecos)) :
							foreach ($search->enderecos as $each) :
								$logradouro = $each->logradouro;
								$numero = $each->numero;
								$complemento = $each->complemento;
								$bairro = $each->bairro;
								$cidade = $each->cidade;
								$uf = $each->uf;
								$cep = $each->cep;
							endforeach;
						?>
							<?php echo $logradouro . " " . $numero . " " . $complemento . " " . $bairro . " " . $cidade . " " . $uf . " -  " . $cep; ?>
						<?php endif;
						?>	
						</span>
					</div>
				</div>
			</div>
			
			<hr class="style-three">

			<div class="row">
				<div class="col-md-12">
					<h4>CONTATOS</h4>
					<br>

					<?php if (isset($search->telefones)) : ?>					
					<div class="col-md-6">
					<label>Telefone:</label>
						<span style="color:blue;">
							<?php foreach ($search->telefones as $key => $each) :
								echo $each->numero . "<br>";
							endforeach; ?>
						</span>
					</div>
					<?php endif;
					?>

					<?php if (isset($search->emails)) : ?>
					<div class="col-md-6">
					<label>Email:</label>
						<span style="color:blue;">
							<?php foreach ($search->emails as $key => $each) :
							echo $each->email . "<br>";
							endforeach; ?>
						</span>
					</div>
					<?php endif;
					?>
				</div>
			</div>
			
			<hr class="style-three">

			<div class="row">
				<div class="col-md-12">
					<h4>Sociedades</h4>
					<br>
					<?php
						$cpf = "";
						$nome = "";
						$cargo = "";
						$participacao = "";
						$entrada = "";
						if (isset($each->socios)) :
							foreach ($search->socios as $each) :
								if (isset($each->cpf)) :
									$cpf = $each->cpf;
								endif;
								if (isset($each->nome)) :
									$nome = $each->nome;
								endif;
								if (isset($each->cargo)) :
									$cargo = $each->cargo;
								endif;
								if (isset($each->participacao)) :
									$participacao = $each->participacao;
								endif;
								if (isset($each->entrada)) :
									$entrada = $each->entrada;
								endif;
						?>					
					
					<div class="col-md-4">
					<label>Nome:</label>
						<span style="color:blue;">
							<?= $nome ?>
						</span>
					</div>

					<div class="col-md-2">
					<label>CPF:</label>
						<span style="color:blue;">
							<?= $cpf ?>
						</span>
					</div>

					<div class="col-md-2">
					<label>Cargo:</label>
						<span style="color:blue;">
							<?= $cargo ?>
						</span>
					</div>

					<div class="col-md-2">
					<label>Participacao:</label>
						<span style="color:blue;">
							<?= $participacao ?> 
						</span>
					</div>

					<div class="col-md-2">
					<label>Entrada:</label>
						<span style="color:blue;">
							<?= $entrada ?>
						</span>
					</div>
				</div>
		</div>
			<?php endforeach;
			endif; ?>
					
				
		<?php endif; ?>
	<?php endif; ?>
<?php endforeach; ?>
		
            <?php else: ?>
                <div class="row" >
                    <i class="col-sm-12 fas fa-info text-danger " align="center">                        
                    </i>&nbsp; Nenhum registro encontrado.
                </div><br>
            <?php endif; ?>
			
			<hr class="style-three">
		
		</div><!--fecha col12-->
	</section>
			
	

                                                	


			
<!-- fim de formatação -->			

</div><!-- /.content-wrapper-->
<?php $v->start("scripts"); ?>
<script>
    $(function() {
 
        if ($("#show_style").val() == '0') {
            $(".cpf").hide();
            $(".cnpj").hide();
            $(".telefone").hide();
            $(".btn_search").hide();
        }

        if ($("#show_style").val() == 1) {
            $(".cpf").show();
            $(".cnpj").hide();
            $(".telefone").hide();
            $(".btn_search").show();
        }
        if ($("#show_style").val() == 2) {
            $(".cpf").hide();
            $(".cnpj").show();
            $(".telefone").hide();
            $(".btn_search").show();
        }
        if ($("#show_style").val() == 3) {
            $(".cpf").hide();
            $(".cnpj").hide();
            $(".telefone").show();
            $(".btn_search").show();
        }

        $("#cnpj").click(function() {
            $("#cpf").val("")
            $("#tel").val("")
        })
        $("#cpf").click(function() {
            $("#cnpj").val("")
            $("#tel").val("")
        })
        $("#tel").click(function() {
            $("#cnpj").val("")
            $("#cpf").val("")
        })

        $("#show_style").change(function() {

            if ($("#show_style").val() == '0') {
                $(".cpf").hide();
                $(".cnpj").hide();
                $(".telefone").hide();
                $(".btn_search").hide();
            }

            if ($("#show_style").val() == 1) {
                $(".cpf").show();
                $(".cnpj").hide();
                $(".telefone").hide();
                $(".btn_search").show();
            }
            if ($("#show_style").val() == 2) {
                $(".cpf").hide();
                $(".cnpj").show();
                $(".telefone").hide();
                $(".btn_search").show();
            }
            if ($("#show_style").val() == 3) {
                $(".cpf").hide();
                $(".cnpj").hide();
                $(".telefone").show();
                $(".btn_search").show();
            }
        })

    })
</script>
<?php $v->end(); ?>
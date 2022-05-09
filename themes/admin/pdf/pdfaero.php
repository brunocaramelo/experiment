<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contra-cheque</title>
    <link href="css/c_cheque.css" rel="stylesheet" type="text/css">
    <!--link rel="stylesheet" href="<?= theme("/assets/css/c_cheque.css", CONF_VIEW_THEME_ADMIN); ?>"-->
</head>
<style>
      body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
		font-family: 'Titillium Web', sans-serif;
		color: #000;
        text-transform: uppercase;
		font-size: 9pt;
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
hr.style-three {
    border: 0;
    border-bottom: 1px dashed #ccc;
    background: #ccc;
}
    .page {
        width: 19cm;
        min-height: 29.7cm;
        padding: 0.5cm;
        margin: 1.5cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 3px;
        background: white;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
    }


    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    table,
    td {
        border-collapse: collapse;
    }

    .tbody {
        border: 1px solid #e2e2e2 !important;
        padding: 3px 10px;
    }


.table-wrapper{
	font-family: 'Titillium Web', sans-serif;	
    margin: 20px 50px 70px;
    box-shadow: 0px 35px 50px rgba( 0, 0, 0, 0.2 );
}
	h1 {
		font-size: 15px;
		padding: 10px 0px 0px 5px;
	}
	
.fl-table {
    border-radius: 5px;
    /*font-size: 12px;*/
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    /*white-space: nowrap;*/
    background-color: #f9f9f9;
}
	
.fl-table .fristTD {
		padding: 20px 0px 0px 10px;
	}
	
	
.fl-table td, .fl-table th {
    padding: 3px 10px;
}

.fl-table td {
    border-right: 1px solid #fff;
    /*font-size: 12px;*/
}
.fl-table td:last-child  {
    border-right: none;
}
.fl-table thead th {
    background: #f9f9f9;
}


.fl-table thead th:nth-child(odd) {
    color: #000;
    background: #e2e2e2;
}

.fl-table tr:nth-child(even) {
    background: #F8F8F8;
}

/* Responsive */

@media (max-width: 767px) {
    .fl-table {
        display: block;
        width: 100%;
    }

    .fl-table thead, .fl-table tbody, .fl-table thead th {
        display: block;
    }
    .fl-table thead th:last-child{
        border-bottom: none;
    }
    .fl-table thead {
        float: left;
    }
    .fl-table tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .fl-table td, .fl-table th {
        padding: 20px .625em .625em .625em;
        /*height: 60px;*/
        vertical-align: middle;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
        /*width: 120px;*/
        /*font-size: 13px;*/
        text-overflow: ellipsis;
    }
    .fl-table thead th {
        text-align: left;
        border-bottom: 1px solid #f7f7f9;
    }
    .fl-table tbody tr {
        display: table-cell;
    }
    .fl-table tbody tr:nth-child(odd) {
        background: none;
    }
    .fl-table tr:nth-child(even) {
        background: transparent;
    }
    .fl-table tr td:nth-child(odd) {
        background: #F8F8F8;
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tr td:nth-child(even) {
        border-right: 1px solid #E6E4E4;
    }
  
}	
	label {
		display: block;
		font-size: 7pt !important;
		font-weight: bold;
		
		
	}
.rwd-table {
  margin: auto;
  min-width: 300px;
  max-width: 100%;
  border-collapse: collapse;
  font-size: 8pt !important; 
}
.rwd-table tr:first-child {
  border-top: none;
  background: #e1e1e1;

}

.rwd-table tr {
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
  background-color: #e2e2e2;
}

.rwd-table tr:nth-child(odd):not(:first-child) {
  background-color: #ebf3f9;
}


.rwd-table td {
  display: block;
}

.rwd-table td:first-child {
  margin-top: .5em;
}

.rwd-table td:last-child {
  margin-bottom: .5em;
}


.rwd-table th,
.rwd-table td {
  text-align: left;
}

.rwd-table {
  color: #000;
  border-radius: .4em;
  overflow: hidden;
}

.rwd-table tr {
  border-color: #bfbfbf;
}


@media screen and (max-width: 601px) {
  .rwd-table tr:nth-child(2) {
    border-top: none;
  }
}
@media screen and (min-width: 600px) {
  .rwd-table tr:hover:not(:first-child) {
    background-color: #d8e7f3;
	  color: #000;
  }
  .rwd-table td:before {
    display: none;
  }
  .rwd-table th,
  .rwd-table td {
    display: table-cell;
  }
  .rwd-table th:first-child,
  .rwd-table td:first-child {
    padding-left: 0;
  }
  .rwd-table th:last-child,
  .rwd-table td:last-child {
    padding-right: 0;
  }
  .rwd-table th,
  .rwd-table td {
    padding: 1px 0px 0px 10px !important;
  }
}
</style>

<body>



<!--nova formatacao-->
<div class="page">
	
<div class="table-wrapper">  
<table class="fl-table" width="100%">

  <tbody>
    
		<tr>
			<td colspan="4" scope="col" style="border-bottom: 1px solid #e1e1e1;text-align: center;"><h1>CONTRA-CHEQUE</h1></td>
		</tr>

    
    <tr>
      <td width="34%" class="fristTD">
		  <label>Matr&Iacute;cula:</label>
			<?= $client->MATRICULA ?>
		</td>
      <td colspan="2" class="fristTD">
		  <label>Patente:</label>
		<?= $client->PATENTE ?>&nbsp;
		</td>
      <td width="36%"  style="padding: 20px 0px 0px 15px;">
		  <label >Categoria:</label>
		  <?= $client->CATEGORIAS ?>
		</td>
    </tr>
    <tr>
      <td colspan="3">
		  <label>Nome:</label>
		<?= $client->NOME ?>
		</td>
      <td>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td width="50%">
				<label>Nascimento:</label>
			  <?= $client->NASCIMENTO ?>
			  </td>
            <td width="50%">
				<label>CPF:</label>
			   <?= $client->CPF ?>
			  </td>
            </tr>
          </tbody>
      </table></td>
    </tr>

    <tr>
      <td colspan="3">
		  <label>Endere&Ccedil;o:</label>
			<?= $client->ENDERECO ?>
		</td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td width="50%">
				<label>CEP</label>
				<?= $client->CEP ?>
			  </td>
            <td width="50%">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="4">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td width="50%">
					<label>Bairro:</label>
        		<?= $client->BAIRRO ?>
			  </td>
			  <td width="40%"> 
					<label>Cidade:</label>
			  <?= $client->CIDADE ?>
			  </td>
            <td width="10%">
				<label>UF:</label>
			  <?= $client->UF ?>
			  </td>
            </tr>
          </tbody>
      </table>
      </td>
      </tr>
    <tr>
      <td colspan="4"><hr class="style-three"></td>
    </tr>
    <tr>
      <td colspan="4">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td width="46%">
				<label>BRUTO:</label>
			  <?= "R$" . $client->BRUTO ?>
			  </td>
            <td >
				<label>DESCONTO:</label>
				<?= "R$" . $client->DESCONTO ?>
			  </td>
            <td width="35%">
				<label>L&Iacute;QUIDO:</label>
				<?= "R$" . $client->LIQUIDO ?>
			  </td>
          </tr>
          <tr>
            <td>
				<label>BANCO:</label>
			  <?= $client->BANCO ?>
			  </td>
            <td>
				<label>AGÊNCIA:</label>
			  <?= $client->AGENCIA ?>
			  </td>
            <td>
				<label>CONTA:</label>
			  <?= $client->CONTA ?>
			  </td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
		  
		  <table class="rwd-table" width="100%">
        <tbody>
			
                    <tr>
						<td width="46%"><b>DISCRIMINA&Ccedil;&Atilde;O</b></td>
                        <td width="19%"><b>RECEITA</b></td>
                        <td width="20%"><b>DESPESA</b></td>
                        <td width="15%"><b>PRAZO</b></td>
                    </tr>
              <?php
                    $valor_receita = 0;
                    $valor_desconto = 0;
                    if (isset($client_contract)) :
                        foreach ($client_contract as $i => $each_contract) :
                    ?>	     
          <tr>
            <td>
				<?php if ($each_contract->BANCO_EMPRES != "") : ?>EMPRESTIMO <?= $each_contract->BANCO_EMPRES ?><?php endif; ?>
			  </td>
            <td >
				
			  </td>
            <td >
				<?= "R$" . $each_contract->VALOR; ?>
			  </td>
            <td><?= date_month_year($each_contract->PRAZO) ?>&nbsp;</td>
          </tr>
			
			<?php
			$valor_receita += str_price_invert($each_contract->VALOR);
			endforeach;
			endif;
			?>		
          <tr>
            <td><div><b>TOTAL</b></div></td>
            <td><b></b></td>
            <td><?= "R$" . str_price($valor_desconto) ?></td>
            <td>
				<?= "R$" . str_price(str_price_invert(str_price($valor_receita)) - str_price_invert(str_price($valor_desconto))) ?>
			  </td>
          </tr>
          
        </tbody>
      </table>
		  
			 </td>
    </tr>
  </tbody>
</table>
	</div>
	</div>
       
    <!--fecha page-->

</body>

</html>
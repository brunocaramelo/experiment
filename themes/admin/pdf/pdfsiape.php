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
        font: 7.5pt "Verdana";
	  	text-transform: uppercase;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 256mm;
        outline: 2cm #FFEAEA solid;
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
table, td {
  border-collapse: collapse;
}
.tbody {
	border: 1px solid #000 !important;
	padding: 3px;
}
#tb {
		width: 100%;
        margin: 0;
        padding: 0;
		border: 1px solid #000;
	
}#tb th{
		border: 1px solid #000;
		font-weight: normal;
	
}
#tb td {
	text-align: center;
	border: 1px solid #000;
	padding: 2px;
	margin: 0px;
}
#tb .td_desc, #tb .td_receita, #tb td div {
	border-bottom: 1px solid #f2f2f2;
	padding: 1px 0px 1px 0px;
}

#tb .td_desc{
	text-align: left;
	border-bottom: #000;
	padding: 0px 0px 0px 5px;
}
#tb .td_receita,  #tb .td_despesa {
	border-bottom: #000;	
	text-align: right;
	padding: 0px 5px 0px 0px;
}


.lf, .lf2, .lf_ompag, .lf_pagadora {
	display: inline-block;
			}
.rows {
	display: inline-block;
	border-left: 1px solid #f30;
	height: 40px;
	margin: 0px !important;
}
.lf2 {
	border-left: 1px solid #000;
	padding-left: 5px;
	text-align: center !important;
}
.lf_ompag {
	width: 20%;
	padding-left: 5px;
	text-align: center !important;
}
.lf_pagadora {
	width: 78%;
	border-left: 1px solid #000;
	padding-left: 5px;
	text-align: center !important;
}

</style>
<body>
	
	<div class="page">
		<h2>CONTRA-CHEQUE</h2>
		
		
		<div class="tbody">
		<table  id="tb">
		  <tbody>
			<tr>
			  <td>
				<div>Matr&iacute;cula<br>1 99 131313 9</div>
			</td>
			  <td>
				<div class="lf_ompag">OM PAG<br>123021</div>
				<div class="lf_pagadora">NOME OM PAGADORA<br>GAP RIO DE JANEIRO</div>
			</td>
			  <td>
				<div>OM APOIADA<br>232005</div>
			</td>
			  <td>
				<div>PAGAMENTO<br>NOV05</div>
			</td>
			</tr>
			<tr>
			  <td>
				 <div>QUALIF<br>MJ IN</div>
			</td>
			  <td>
				<div class="lf">NOME<br>GUSTAVO DE CARVALHO</div>
				<div class="lf2">REF<br>00000</div>
			</td>
			  <td>
				<div class="lf">TIPO<br>MM</div>			
				<div class="lf2">PRAZO<br>0000000000</div>
			</td>
			  <td>
				<div>CPF<br>15111895110</div>
			</td>
			</tr>
		  </tbody>
		</table>
		</div>
	
		<br>
		

		<div class="tbody">
		<table id="tb">
		  <thead>
			<tr>
			  <th>DISCRIMINA&Ccedil;&Atilde;O</th>
			  <th>ORD</th>
			  <th>CAIXA</th>
			  <th>%</th>
			  <th>RECEITA</th>
			  <th>DESPESA</th>
			  <th>PRAZO</th>
			  <th>IR</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
				<td class="td_desc">
					<div>SOLDO</div>
					<div>ADC MILITAR</div>
					<div>DC HABILITA&Ccedil;&Atilde;O</div>
					<div>ADC TEMP SERVI&Ccedil;O</div>
					<div>ADC CO COT</div>
					<div>ETAPA ML MENSAL</div>
					<div>AUX FARD RENOV</div>
					<div>ADC NATAL MIL</div>
					<div>ASS PRE ESCOLAR</div>
					<div>FAMHS</div>
					<div>MONGERAL</div>
					<div>DESC PRE-ESCOLA</div>
					<div>FAMHS DEPEND.</div>
					<div>PENS&Atilde;O MILITAR</div>
					<div>PENS&Atilde;O MILITAR</div>
					<div>ACERTO MP 263</div>
					<div>1/2 G NATAL MIL  </div>
					<div>IMP RENDA</div>
					<div>I RENDA 13</div>				
				</td>

				<td>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>01</div>
					<div>02</div>
					<div>03</div>
					<div>04</div>
					<div>05</div>
					<div>06</div>
					<div>07</div>
					<div>08</div>
					<div>09</div>
					<div>10</div>
					<div>11</div>
					<div>12</div>
					<div>13</div>
					<div>14</div>
					<div>15</div>				
				</td>
				
				<td>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>D38</div>
					<div>D46</div>
					<div>D50</div>
					<div>D64</div>
					<div>D80</div>
					<div>L30</div>
					<div>L48</div>
					<div>L71</div>
					<div>L80</div>
					<div>M02</div>
					<div>M02</div>
					<div>S06</div>
					<div>999</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</td>
				
				<td>
					<div>100</div>
					<div>25</div>
					<div>20</div>
					<div>18</div>
					<div>&nbsp;</div>
					<div>*</div>
					<div>&nbsp;</div>
					<div>*</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>4</div>
					<div>*</div>
					<div>*</div>
					<div>*</div>
					<div>*</div>
					<div>*</div>
					<div>*</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</td>
				
				<td class="td_receita">
					<div>4.269,00</div>
					<div>1.067,25</div>
					<div>853,80</div>
					<div>768,42</div>
					<div>20,28</div>
					<div>80,30</div>
					<div>4.269,00</div>
					<div>6.978,75</div>
					<div>89,00</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</td>

				<td class="td_despesa">
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>90,72</div>
					<div>69,86</div>
					<div>13,35</div>
					<div>115,14</div>
					<div>104,68</div>
					<div>523,40</div>
					<div>99,42</div>
					<div>3.087,19</div>
					<div>1.148,75</div>
					<div>1.375,28</div>				
				</td>
				
				<td>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>11/05</div>
					<div>11/05</div>
					<div>11/05</div>
					<div>05/07</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>11/05</div>					
					<div>03 DEP	</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>11/05</div>					
					<div>11/05</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</td>
				
				<td>
					<div>+</div>					
					<div>+</div>
					<div>+</div>
					<div>+</div>
					<div>+</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>+</div>
					<div>-</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>-</div>
					<div>-</div>					
					<div>-</div>					
					<div>-</div>					
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
				</td>

			</tr>

		  </tbody>
		</table>
		</div>
	
		<br>
		
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
            <td><?= date_month_year($each_contract->PRAZO) ?></td>
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
		
	</div><!--fecha page-->	
		
		
</body>
</html>

<?php
$router->get("/banco-e-coeficiente", "Banks:home","banks.home");
$router->get("/banco-e-coeficiente/cadastrar", "Banks:bankAdd","banks.bankAdd");
$router->post("/banco-e-coeficiente/cadastrar", "Banks:bankAdd","banks.bankAdd");
$router->get("/banco-e-coeficiente/alterar/{cod}", "Banks:bankUpdate","Banks.bankUpdate");
$router->post("/banco-e-coeficiente/alterar/{cod}", "Banks:bankUpdate","Banks.bankUpdate");
$router->post("/banco-e-coeficiente/excluir/{cod}", "Banks:filterDelete","Banks.filterDelete");
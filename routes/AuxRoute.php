<?php
$router->post("/cadastro/document", "Auxiliar:documentAdd","auxiliar.documentAdd");
$router->post("/cadastro/document/delete","Auxiliar:documentDelete","auxiliar.documentDelete");
$router->get("/cadastro/document/select","Auxiliar:documentSelect","auxiliar.documentSelect");

$router->get("/city/select/{state}","Auxiliar:citySelect","auxiliar.citySelect");
$router->get("/city/selected/{filter}","Auxiliar:citySelected","auxiliar.citySelected");

$router->post("/cadastro/bank", "Auxiliar:bankAdd","auxiliar.bankAdd");
$router->post("/cadastro/bank/delete","Auxiliar:bankDelete","auxiliar.bankDelete");
$router->get("/cadastro/bank/select","Auxiliar:bankSelect","auxiliar.bankSelect");

$router->get("/filter/bank-coeficient/select/{bank}","Auxiliar:bankCoeficientSelect","auxiliar.bankCoeficientSelect");
$router->get("/filter/bank-coeficient/value/{coeficient}","Auxiliar:coeficientValue","auxiliar.coeficientValue");

$router->get("/resume/attendance/user/{inicial_date}/{final_date}/{user_id}", "Auxiliar:resumeAttendanceUser","auxiliar.resumeAttendanceUser");
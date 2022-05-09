<?php
////FILTRO
$router->get("/filtro", "Filters:home","filter.home");
$router->get("/filtro/{page}", "Filters:home","filter.homeSearch");
$router->get("/filtro/cadastrar", "Filters:filterAdd","filter.filterAdd");
$router->post("/filtro/cadastrar", "Filters:filterAdd","filter.filterAdd");
$router->get("/filtro/alterar/{cod}", "Filters:filterChange","filter.filterChange");
$router->get("/filtro/copy/{cod}", "Filters:filterCopy","filter.filterCopy");
$router->post("/filtro/alterar/{cod}", "Filters:filterEdit","filter.filterChange");
$router->post("/filtro/excluir/{cod}", "Filters:filterDelete","filter.filterDelete");
$router->post("/filtro/copiar/{cod}", "Filters:filterCopy","filter.filterCopy");
$router->post("/filtro/mudar/{cod}", "Filters:filterChange","filter.filterChange");

////LISTA DE TRABALHO
$router->get("/lista-de-trabalho", "Filters:workList","filter.workList");
$router->post("/lista-de-trabalho", "Filters:workList","filter.workListPost");
$router->get("/lista-de-trabalho/{search}/{page}", "Filters:workList","filter.workListSearch");
$router->get("/lista-de-trabalho/cliente/{id}/{order}", "Filters:filterClient","filter.filterClient");
$router->get("/lista-de-trabalho/cliente/{id}/next", "Filters:filterClientNext","filter.filterClientNext");
$router->get("/lista-de-trabalho/consulta/{filter_id}/{id_cliente}", "Filters:filterClient","filter.filterClient");
$router->post("/lista-de-trabalho/cliente/atualizar", "Filters:filterClientUpdate","filter.filterClientUpdate");
$router->post("/lista-de-trabalho/cliente/atendimento", "Filters:clientAttendance","filter.clientAttendance");
$router->post("/cliente/consulta", "Filters:filterClientSearch","filter.filterClientSearch");
$router->get("/cliente/consulta/{id_cliente}", "Filters:filterClientSearch","filter.filterClientSearch");

////ATENDIMENTO
$router->get("/atendimentos", "Filters:attendance","filter.attendance");
////AGENDAMENTO
$router->get("/agendamento", "Filters:scheduling","filter.scheduling");
////RESUMO
$router->get("/resumo", "Filters:resumo","filter.resumo");
$router->post("/resumo", "Filters:resumo","filter.resumo");
$router->get("/resumo/search/{inicial_date}/{final_date}", "Filters:resumoSearch","filter.resumoSearch");
////CONSULTA
$router->get("/consulta", "Filters:search","filter.search");
$router->post("/consulta", "Filters:search","filter.searchPost");
$router->get("/consulta/search/{inicial_date}/{final_date}", "Filters:searchSearch","filter.searchSearch");

//////API
$router->get("/consulta-api", "Filters:consultApi","filter.consultApi");
$router->post("/consulta-api", "Filters:consultApi","filter.consultApiPost");
$router->get("/consulta-api/{search}/{type}", "Filters:consultApiSearch","filter.consultApiSearch");

//////PDF
$router->get("/cliente/consultapdf/{id_cliente}", "Filters:filterClientPdf","filter.filterClientPdf");
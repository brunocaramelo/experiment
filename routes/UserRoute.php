<?php
$router->get("/usuario", "Users:home","users.home");
$router->get("/clientes", "Users:account","users.account");
$router->get("/clientes/cadastrar", "Users:accountAdd","users.accountAdd");
$router->post("/clientes/cadastrar", "Users:accountCreat","users.accountCreat");
$router->post("/clientes/excluir/{account}", "Users:accountDelete","users.accountDelete");
$router->get("/clientes/alterar/{account}", "Users:accountUpdate","users.accountUpdate");
$router->post("/clientes/alterar/{account}", "Users:accountUpdated","users.accountUpdated");
$router->get("/clientes/acessos/{account}", "Users:accountAccess","users.accountAccess");
$router->post("/clientes/acessos/excluir/{user}", "Users:accountAccessDelete","users.accountAccessDelete");
$router->post("/clientes/status/{account}", "Users:statusAccount","users.statusAccount");
$router->get("/clientes/usuario/{account_id}", "Users:accountUser","users.accountUser");
$router->get("/clientes/usuario/{account_id}/{search}/{page}", "Users:accountUser","users.accountUserSearch");
$router->post("/clientes/usuario/{account_id}", "Users:accountUser","users.accountUserPost");
$router->get("/clientes/bloqueado/{account}", "Users:accountBloqued","users.accountBloqued");
$router->post("/clientes/bloqueados/excluir/{user}", "Users:accountBloquedDelete","users.accountBloquedDelete");
$router->post("/usuario", "Users:home","users.homePost");
$router->get("/usuario/{search}/{page}", "Users:home","users.homeSearch");
$router->get("/usuario/cadastrar", "Users:user","users.user");
$router->post("/usuario/cadastrar", "Users:user","users.userPost");
$router->get("/usuario/alterar/{user_id}", "Users:user","users.userId");
$router->post("/usuario/alterar/{user_id}", "UserNotAdmin:user","users.userIdPost");
$router->post("/usuario/deletar/{user_id}", "Users:user","users.userIdPostDelete");
$router->get("/usuario/senha", "Users:passwordChange","users.passwordChange");
$router->post("/usuario/senha/{id}", "Users:passwordChange","users.passwordChangeAlt");
$router->post("/usuario/senha/popup/{id}", "UserNotAdmin:passwordChangePopup","users.passwordchangepopup");

<?php

$router->get("/boletos/cliente/{accountId}", "Ticket:index","ticket.index");
$router->get("/boletos/cadastrar/cliente/{accountId}", "Ticket:create","ticket.create");
$router->post("/boletos/cadastrar/cliente/{accountId}", "Ticket:store","ticket.store");
$router->get("/boletos/alterar/{id}/cliente/{accountId}", "Ticket:edit","ticket.edit");
$router->post("/boletos/alterar/{id}/cliente/{accountId}", "Ticket:update","ticket.update");
$router->post("/boletos/remover/{id}/cliente/{accountId}", "Ticket:destroy","ticket.destroy");

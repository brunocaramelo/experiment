<?php

$router->get("/boletos", "Ticket:index", "ticket.index");
$router->get("/boletos/cliente/{accountId}", "Ticket:getAllTicketsOfClient","ticket.getAllTicketsOfClient");
$router->get("/boletos-a-pagar", "Ticket:clientTicketsUnpaid", "ticket.clientTicketsUnpaid");
$router->get("/boletos-pagos", "Ticket:clientTicketPaid", "ticket.clientTicketPaid");
$router->get("/boletos/cadastrar/cliente/{accountId}", "Ticket:create","ticket.create");
$router->post("/boletos/cadastrar/cliente/{accountId}", "Ticket:store","ticket.store");

$router->get("/boletos/alterar/{id}/cliente/{accountId}", "Ticket:edit","ticket.edit");
$router->get("/boletos/alterar/{id}/cliente/{accountId}/editRedirectToIndex", "Ticket:editRedirectToIndex","ticket.editRedirectToIndex");

$router->post("/boletos/alterar/{id}/cliente/{accountId}", "Ticket:update","ticket.update");
$router->post("/boletos/alterar/{id}/cliente/{accountId}/updateRedirectToIndex", "Ticket:updateRedirectToIndex","ticket.updateRedirectToIndex");

$router->post("/boletos/remover/{id}/cliente/{accountId}", "Ticket:destroy","ticket.destroy");
$router->post("/boletos/remover/{id}/cliente/{accountId}/destroyRedirectToIndex", "Ticket:destroyRedirectToIndex","ticket.destroyRedirectToIndex");

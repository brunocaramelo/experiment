<?php
$router->get("/dash", "Dash:dash", "dash.dash");
$router->get("/dash/estrategico", "Dash:home", "dash.home");
$router->post("/dash/home", "Dash:home", "dash.homePost");
$router->get("/log", "Dash:log", "dash.log");
$router->get("/logoff", "Logoff:logoff", "dash.logoff");

//notification center
$router->post("/notifications/count", "Notifications:count","notifications.count");
$router->post("/notifications/list", "Notifications:list","notifications.list");


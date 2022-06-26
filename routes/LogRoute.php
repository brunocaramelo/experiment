<?php

$router->namespace("Source\App");
$router->group(null);

$router->group("/");

$router->get("/", "LogIn:root", "login.root");
$router->get("/login", "LogIn:root", "login.login");
$router->post("/login", "LogIn:login", "login.loginPost");
$router->post("/login1", "LogIn:login1", "login.loginPost1");
$router->get("/recuperar", "LogIn:forget", "login.forget");
$router->post("/recuperar", "LogIn:forget", "login.forgetPost");
$router->get("/recuperar/{code}", "LogIn:forgetReset", "login.forgetReset");
$router->post("/recuperar/resetar", "LogIn:forgetReset", "login.forgetResetPost");
$router->get("/desbloquear/{code}", "LogIn:unlock", "login.unlock");


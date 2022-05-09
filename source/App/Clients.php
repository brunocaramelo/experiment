<?php

namespace Source\App;

use Source\Models\Client;

/**
 * Description of Users
 *
 * @author Luiz
 */
class Clients extends Admin
{

    /**
     * Users constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function blocked(?array $data): void
    {
       $client_blocked = (new Client())->returnClientBlocked();

       $head = $this->seo->render(
        CONF_SITE_NAME . " | Atendimentos",
        CONF_SITE_DESC,
        url("/"),
        url("/assets/images/image.png"),
        false
    );

    echo $this->view->render("client/blocked", [
        "menu" => "client_blocked",
        "submenu" => "client_blocked",
        "head" => $head,
        "client_blocked" => $client_blocked
    ]);
    }

}
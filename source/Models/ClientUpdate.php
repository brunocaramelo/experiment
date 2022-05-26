<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use CoffeeCode\DataLayer\Connect;

/**
 * Description of Level
 *
 * @author Luiz
 */
class ClientUpdate extends DataLayer {

    public function __construct() {
        parent::__construct("client_update", ["client_id","account_id"]);
    }

    public function getClientesAtendidosByCod($cod)
    {
        return Connect::getInstance()->query(
            "SELECT a.*, 
                    c.CPF, 
                    c.MATRICULA FROM sistem80_cred_base.client as c
                INNER JOIN attendances as a
                    ON c.id = a.client_id
                INNER JOIN filters as f
                    ON a.filter_id = f.id
                WHERE f.cod = '{$cod}'"
        )
        ->fetchAll();
    }

}
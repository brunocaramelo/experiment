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
            c.ID,
            c.CPF,
            c.MATRICULA,
            cu.*
                FROM sistem80_cred_base.client as c
                INNER JOIN attendances as a
                    ON c.ID = a.client_id
                INNER JOIN filters as f
                    ON a.filter_id = f.id
                INNER JOIN client_update as cu
                    ON cu.client_id = c.ID
                WHERE f.cod = '{$cod}'"
        )
        ->fetchAll();
    }
}
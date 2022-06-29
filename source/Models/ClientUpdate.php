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

    public function getClientesToCsvByFilterId($filterId)
    {
        return Connect::getInstance()->query(
            "SELECT	c.ID, 
            c.CPF, 
            c.MATRICULA,
            fq.cod,
            cu.id as cu_id,
            cu.*
            FROM filter_queue as fq
                INNER JOIN sistem80_cred_base.client as c
                    ON fq.client_id = c.id
                INNER JOIN accounts as a
                    ON fq.account_id = a.id
                INNER JOIN client_update as cu
                    ON cu.client_id = c.id
                    
            WHERE fq.filter_id = '{$filterId}'"
        )
        ->fetchAll();
    }
}
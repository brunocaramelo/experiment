<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use CoffeeCode\DataLayer\Connect;

/**
 * Description of Level
 *
 * @author Luiz
 */
class Organ extends DataLayer {

    public function __construct() {
        parent::__construct("organs", ["organ", "status"]);
    }

    public function getAllOrgans()
    {
        return Connect::getInstance()
            ->query(
                "SELECT o.*, 
                        co.id as client_organ_id, 
                        co.account_id as client_organ_account_id 
                            FROM organs as o
                                LEFT JOIN client_organ as co
                                ON o.id = co.organ_id"
            )
            ->fetchAll();
    }

}
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
                        co.id AS client_organ_id, 
                        co.account_id AS client_organ_account_id 
                            FROM organs AS o
                                LEFT JOIN client_organ AS co
                                ON o.id = co.organ_id"
            )
            ->fetchAll();
    }

    public function getOrgansByAccountIdOfLoggedUserId()
    {
        $loggedUserId = user()->account_id;
        return Connect::getInstance()
            ->query(
                "SELECT 
                    o.id, 
                    o.organ 
                    FROM client_organ AS co
                        INNER JOIN organs AS o
                            ON co.organ_id = o.id
                        WHERE co.account_id = '{$loggedUserId}'"
            )
            ->fetchAll();
    }

}
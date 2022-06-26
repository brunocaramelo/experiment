<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Source\Support\Message;
use CoffeeCode\DataLayer\Connect;

class ClientOrgan extends DataLayer
{
    public function __construct()
    {
        parent::__construct("client_organ", []);
    }

    public function getClientOrgansByAccountId($accountId)
    {
        return Connect::getInstance()
            ->query(
                "SELECT * FROM client_organ as co
                    LEFT JOIN accounts as a 
                        ON co.account_id = a.id
                    LEFT JOIN organs as o
                        ON co.organ_id = o.id
                    WHERE account_id = '{$accountId}';"
            )
            ->fetchAll();
    }
}

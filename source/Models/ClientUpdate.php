<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class ClientUpdate extends DataLayer {

    public function __construct() {
        parent::__construct("client_update", ["client_id","account_id"]);
    }

}
<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class Filter_cliet extends DataLayer {

    public function __construct() {
        parent::__construct("filter_clients", ["filter_id", "client_id"]);
    }

}
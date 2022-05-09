<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class FilterClientUser extends DataLayer {

    public function __construct() {
        parent::__construct("filter_client_user", ["filter_id", "client_id", "user_id"]);
    }

}
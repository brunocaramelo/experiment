<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class Filter_user extends DataLayer {

    public function __construct() {
        parent::__construct("filter_users", ["user_id","filter_id"]);
    }

}
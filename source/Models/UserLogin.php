<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class UserLogin extends DataLayer {

    public function __construct() {
        parent::__construct("user_login", ["user_id"]);
    }

}
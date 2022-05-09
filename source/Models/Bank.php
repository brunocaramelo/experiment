<?php

namespace Source\Models;
use Exception;
use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class Bank extends DataLayer {

    public function __construct() {
        parent::__construct("banks", ["bank"]);
    }

}
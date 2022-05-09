<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class Organ extends DataLayer {

    public function __construct() {
        parent::__construct("organs", ["organ", "status"]);
    }

}
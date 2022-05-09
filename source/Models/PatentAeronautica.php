<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class PatentAeronautica extends DataLayer {

    public function __construct() {
        parent::__construct("patents_aeronautica", ["description"]);
    }

}
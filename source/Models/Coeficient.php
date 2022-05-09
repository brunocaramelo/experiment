<?php

namespace Source\Models;
use Exception;
use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class Coeficient extends DataLayer {

    public function __construct() {
        parent::__construct("coeficients", ["description"]);
    }

}
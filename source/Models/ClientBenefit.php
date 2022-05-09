<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class ClientBenefit extends DataLayer {

    public function __construct() {
        parent::__construct("client_benefit", ["benefit_number"]);
    }

}
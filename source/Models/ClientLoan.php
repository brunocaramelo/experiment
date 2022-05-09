<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class ClientLoan extends DataLayer {

    public function __construct() {
        parent::__construct("client_loan", ["contrato"]);
    }

}
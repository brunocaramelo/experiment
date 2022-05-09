<?php

namespace Source\Models;
use Exception;
use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class BankLoanSiape extends DataLayer {

    public function __construct() {
        parent::__construct("bank_loan_siape", ["bank"]);
    }

}
<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class Filter_bank_not_discount extends DataLayer {

    public function __construct() {
        parent::__construct("filter_bank_not_discounts", ["bank_id","filter_id"]);
    }

}
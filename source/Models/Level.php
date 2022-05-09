<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Source\Support\Message;

/**
 * Description of Level
 *
 * @author Luiz
 */
class Level extends DataLayer {

    public function __construct() {
        parent::__construct("levels", ["description", "status"]);
    }

}

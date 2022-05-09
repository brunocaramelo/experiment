<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class DeleteAttendance extends DataLayer {

    public function __construct() {
        parent::__construct("delete_attendance", []);
    }

}
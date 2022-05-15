<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Source\Support\Message;

class Ticket extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tickets", []);
    }
}
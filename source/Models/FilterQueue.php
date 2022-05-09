<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterQueue extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_queue", ["filter_id"]);
    }
}
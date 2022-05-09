<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterCity extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_city", ["filter_id"]);
    }
}
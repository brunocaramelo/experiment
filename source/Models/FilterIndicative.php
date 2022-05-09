<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterIndicative extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_indicative", ["filter_id"]);
    }
}
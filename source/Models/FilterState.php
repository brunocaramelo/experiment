<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterState extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_state", ["filter_id"]);
    }
}
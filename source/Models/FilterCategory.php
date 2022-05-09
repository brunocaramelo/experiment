<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterCategory extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_category", ["filter_id"]);
    }
}
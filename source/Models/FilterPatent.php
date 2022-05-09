<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterPatent extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_patent", ["filter_id"]);
    }
}
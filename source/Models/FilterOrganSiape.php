<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterOrganSiape extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_organ_siape", ["filter_id"]);
    }
}
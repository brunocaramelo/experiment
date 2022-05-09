<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterLegalRegime extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_legal_regime", ["filter_id"]);
    }
}
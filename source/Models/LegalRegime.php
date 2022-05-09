<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class LegalRegime extends DataLayer
{
    public function __construct()
    {
        parent::__construct("legal_regime", ["description"]);
    }
}
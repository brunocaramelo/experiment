<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class BankCod extends DataLayer
{
    public function __construct()
    {
        parent::__construct("banks_cod", ["bank"]);
    }

}
<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class ClientBeneficio extends DataLayer
{
    public function __construct()
    {
        parent::__construct("client_beneficio", ["client_id"]);
    }
}
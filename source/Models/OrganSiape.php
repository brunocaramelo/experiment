<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class OrganSiape extends DataLayer{

    public function __construct()
    {
        parent::__construct("organ_siape", ["description"]);
    }

}
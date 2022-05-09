<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class OrganFilter extends DataLayer
{
    public function __construct()
    {
        parent::__construct("organ_filter", ["description"]);
    }
}
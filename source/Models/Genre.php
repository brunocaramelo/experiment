<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class Genre extends DataLayer
{
    public function __construct()
    {
        parent::__construct("genres", ["description"]);
    }
}
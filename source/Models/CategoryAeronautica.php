<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class CategoryAeronautica extends DataLayer{

    public function __construct()
    {
        parent::__construct("categories_aeronautica", ["description"]);
    }

}
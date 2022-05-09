<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class CategorySiape extends DataLayer{

    public function __construct()
    {
        parent::__construct("categories_siape", ["description"]);
    }

}
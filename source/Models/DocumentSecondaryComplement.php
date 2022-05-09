<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class DocumentSecondaryComplement extends DataLayer{

    public function __construct()
    {
        parent::__construct("document_secondary_complements", ["description"]);
    }

}
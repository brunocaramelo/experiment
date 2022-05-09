<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FilterQueueConsult extends DataLayer
{
    public function __construct()
    {
        parent::__construct("filter_queue_consult", ["client_id"]);
    }
}
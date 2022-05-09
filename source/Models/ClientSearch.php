<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class ClientSearch extends DataLayer
{
    public function __construct()
    {
        parent::__construct("client_search", ["client_id"]);
    }

        /**
     * @return Client|null
     */
    public function clientDesc(): ?Client {
        if ($this->client_id) {
            return (new Client())->findById($this->client_id);
        }
        return null;
    }

    /**
     * @return User|null
     */
    public function userDesc(): ?User {
        if ($this->user_id) {
            return (new User())->findById($this->user_id);
        }
        return null;
    }
}
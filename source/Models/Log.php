<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Description of Log
 *
 * @author Luiz
 */
class Log extends DataLayer {

    public function __construct() {
        parent::__construct("log", ["user", "ip", "description"]);
    }

    /**
     * @return User|null
     */
    public function returnUser(): ?User {
        if ($this->user) {
            return (new User())->findById($this->user);
        }
        return null;
    }
}

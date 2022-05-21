<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Source\Support\Message;
use CoffeeCode\DataLayer\Connect;

class Ticket extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tickets", []);
    }

    public function getTicketsOrderedByDueDate()
    {
        return Connect::getInstance()
            ->query(
                "SELECT t.*, 
                    a.description 
                        FROM tickets as t
                            INNER JOIN accounts as a
                            ON t.account_id = a.id
                        ORDER BY t.due_date ASC"
            )
            ->fetchAll();
    }

    public function getUnpaidTicketsOfClientOrderedByDueDate()
    {
        $userAccountId = user()->account_id;
        return Connect::getInstance()
            ->query(
                "SELECT t.*, a.description 
                    FROM tickets as t
                    INNER JOIN accounts as a
                        ON t.account_id = a.id
                        WHERE t.account_id={$userAccountId} AND t.status = 'Boleto não pago'
                            ORDER BY t.due_date"

            )
            ->fetchAll();
    }

    public function getFirstTicketToPayByUserAccountId()
    {
        $userAccountId = user()->account_id;
        return Connect::getInstance()
                ->query(
                    "SELECT t.*, a.description 
                        FROM tickets as t
                        INNER JOIN accounts as a
                            ON t.account_id = a.id
                            WHERE t.account_id={$userAccountId} AND t.status = 'Boleto não pago'
                                ORDER BY t.due_date"
                )->fetch(true);
    }

    public function getPaidTicketsOfClientOrderedByDueDate()
    {
        $userAccountId = user()->account_id;
        return Connect::getInstance()
            ->query(
                "SELECT t.*, a.description 
                FROM tickets as t
                INNER JOIN accounts as a
                    ON t.account_id = a.id
                    WHERE t.account_id={$userAccountId} AND t.status = 'Boleto pago'
                        ORDER BY t.due_date"

            )
            ->fetchAll();
    }
}
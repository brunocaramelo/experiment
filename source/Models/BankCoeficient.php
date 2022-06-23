<?php

namespace Source\Models;
use Exception;
use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;


/**
 * Description of Level
 *
 * @author Luiz
 */
class BankCoeficient extends DataLayer {

    public function __construct() {
        parent::__construct("bank_coeficients", ["bank"]);
    }

   /**
     * Método para salvar ou alterar um usuário
     * @return bool
     */
    public function save(): bool {

        if (empty($this->id)) {

            if (!$this->validateBank() || !parent::save()) {
                return false;
            }

            $log = new Log();

            $log->account_id = User::UserLog()->account_id;
            $log->user = User::UserLog()->id;
            $log->ip = $_SERVER["REMOTE_ADDR"];
            $log->description = "Inclusão do banco " . $this->bank;
            $log->save();
            
        } else {

            if (!$this->validateBank() ||!parent::save()) {
                return false;
            }

            if ($this->status == 1 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Alteração do banco " . $this->bank;
                $log->save();
            }

            if ($this->status == 2 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Exclusão do banco " . $this->bank;
                $log->save();
            }

            if ($this->status == 3 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Bloqueio do banco " . $this->bank;
                $log->save();
            }
        }

        return true;
    }

    /**
     * Método para validação de Banco
     * @return bool
     */
    protected function validateBank(): bool {

        $user = User::UserLog();

        if (empty($this->bank)) {
            $this->fail = new Exception("Informe um Banco");
            return false;
        }

        $filterByBank = null;
        if (!$this->id) {
            $filterByBank = $this->find("bank = :bank and status!=2 and account_id=:account_id", "bank={$this->bank}&account_id={$user->UserLog()->account_id}")->count();
        } else {
            $filterByBank = $this->find("bank = :bank AND id != :id  and status!=2 and account_id=:account_id", "bank={$this->bank}&account_id={$user->UserLog()->account_id}&id={$this->id}")->count();
        }

        if ($filterByBank) {
            $this->fail = new Exception("Banco já cadastrado.");
            return false;
        }
        return true;
    }

    public function returnBankCoeficient($organ)
    {
        $user = User::UserLog();

        $connect = Connect::getInstance();

        $today = date("Y-m-d");

		$query = "select * from bank_coeficients where account_id='".$user->account_id."' and id in (select bank_coeficient_id from coeficients where organ_id='".$organ."' and expiration_date_init<='".$today."' and expiration_date_end>='".$today."')";

        $bank = $connect->query($query);
        return $bank->fetchAll();
        //return $query;
    }
}
<?php


namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use CoffeeCode\DataLayer\Connect;
use Exception;

class Account extends DataLayer
{
    public function __construct()
    {
        parent::__construct("accounts", ["description", "status"]);
    }

    /**
     * Método para salvar ou alterar um usuário
     * @return bool
     */
    public function save(): bool
    {

        if (empty($this->id)) {

            if (!$this->validateEmail() || !$this->validatePhone() || !parent::save()) {
                return false;
            }

            $log = new Log();

            $log->account_id =  User::UserLog()->account_id;
            $log->user =  User::UserLog()->id;
            $log->ip = $_SERVER["REMOTE_ADDR"];
            $log->description = "Inclusão de cliente " . $this->description;
            $log->save();
        } else {

            if (!$this->validateEmail() || !$this->validatePhone() || !parent::save()) {
                return false;
            }

            if ($this->status == 1 && User::UserLog()) {
                $log = new Log();

                $log->account_id =  User::UserLog()->account_id;
                $log->user =  User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Alteração de cliente " . $this->description;
                $log->save();
            }

            if ($this->status == 2 &&  User::UserLog()) {
                $log = new Log();

                $log->account_id =  User::UserLog()->account_id;
                $log->user =  User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Exclusão de cliente " . $this->description;
                $log->save();
            }

            if ($this->status == 3 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Bloqueio de cliente " . $this->description;
                $log->save();
            }
        }

        return true;
    }

    public function save2(): bool {
        parent::save();

        return true;
    }
	
    /**
     * Método para validação de E-mail ao incluir cliente
     * @return bool
     */
    protected function validateEmail(): bool
    {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->fail = new Exception("Informe um e-mail válido");
            return false;
        }

        $userByEmail = null;
        if (!$this->id) {
            $userByEmail = $this->find("email = :email and status!=2", "email={$this->email}")->count();
        } else {
            $userByEmail = $this->find("email = :email AND id != :id and status!=2", "email={$this->email}&id={$this->id}")->count();
        }

        if ($userByEmail) {
            $this->fail = new Exception("E-mail já cadastrado");
            return false;
        }
        return true;
    }

    /**
     * Método para validação de E-mail ao incluir cliente
     * @return bool
     */
    protected function validatePhone(): bool
    {
        if (empty($this->cel) && empty($this->tel)) {
            $this->fail = new Exception("é necessário preencher telefone ou celular");
            return false;
        }

        return true;
    }

    public function userCount()
    {
        if ($this->id) {
            return (new User())->find("account_id=:c and status!=2 and client=1 and admin_account=0", "c={$this->id}")->count();
        }
        return null;
    }

    public function userBloquedCount()
    {
        if ($this->id) {
            return (new User())->find("account_id=:c and status!=2 and client=1 and admin_account=0 and error_code!=''", "c={$this->id}")->count();
        }
        return null;
    }

    public function countAccess()
    {
        $connect = Connect::getInstance();

        $clients = $connect->query(" SELECT COUNT(user_login.id) as count_access FROM user_login INNER JOIN users on users.id=user_login.user_id WHERE users.account_id=" . $this->id . " ");

        return $clients->fetchAll();
    }

    public function countAccessDetails()
    {
        $connect = Connect::getInstance();

        $clients = $connect->query(" SELECT users.id,user_name,email,user_login.created_at as created_at,ip FROM user_login INNER JOIN users on users.id=user_login.user_id WHERE users.account_id=" . $this->id . " ");

        return $clients->fetchAll();
    }
}

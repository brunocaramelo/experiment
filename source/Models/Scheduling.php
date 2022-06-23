<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;
use Source\Support\Message;
use CoffeeCode\DataLayer\Connect;

class Scheduling extends DataLayer {

    /** @var MESSAGE */
    protected $message;

    public function __construct() {
        parent::__construct("schedulings", ["phone", "attendance_return_id"]);
        $this->message = new Message();
    }

    /**
     * Método para salvar ou alterar um usuário
     * @return bool
     */
    public function save(): bool {

        if (empty($this->id)) {

            if (!parent::save()) {
                return false;
            }

            $log = new Log();

            $log->account_id = User::UserLog()->account_id;
            $log->user = User::UserLog()->id;
            $log->ip = $_SERVER["REMOTE_ADDR"];
            $log->description = "Inclusão do agendamento " . $this->cod;
            $log->save();
            
        } else {

            if (!parent::save()) {
                return false;
            }

            if ($this->status == 1 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Alteração do agendamento " . $this->cod;
                $log->save();
            }

            if ($this->status == 2 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Exclusão do agendamento " . $this->cod;
                $log->save();
            }

            if ($this->status == 3 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Bloqueio do agendamento " . $this->cod;
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
     * @return User|null
     */
    public function userDesc(): ?User {
        if ($this->user_id) {
            return (new User())->findById($this->user_id);
        }
        return null;
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

    public static function returnScheduling(): ?Scheduling {
        $hoje = date("Y-m-d");
        $user_id = User::UserLog()->id;
        $scheduling = (new Scheduling())->find("user_id=:id and date_return<=:d and status!=2","id={$user_id}&d={$hoje}")->limit(1)->order("id ASC")->fetch();
        if($scheduling){
          return (new Scheduling())->findById($scheduling->id);
        }
        return null;
    }

}

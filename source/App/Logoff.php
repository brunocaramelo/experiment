<?php

namespace Source\App;

use Source\Models\User;
use Source\Models\Log;
use Source\Core\Controller;
use Source\Models\UserLogin;

class Logoff extends Controller {

    public function __construct($router) {
        parent::__construct($router, CONF_VIEW_ADMIN);

        $this->user = User::UserLog();
    } 
    
    /**
    * 
    * @return void
    */
   public function logoff(): void {
       $this->message->info("Você saiu com sucesso {$this->user->first_name}.")->flash();

       $log = new Log();

       $log->account_id = $this->user->account_id;
       $log->user = $this->user->id;
       $log->ip = $_SERVER["REMOTE_ADDR"];
       $log->description = "Usuário " . $this->user->fullName()." saiu do sistema";
       $log->save();

       $user_login = (new UserLogin())->find("user_id=:u","u={$this->user->id}")->fetch();

       if($user_login){
        $user_login->destroy();
       }

       User::logout();
       redirect("/login");
   }
}
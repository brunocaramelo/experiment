<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\User;
use Source\Core\Session;
use Source\Models\Attendance;
use Source\Models\DeleteAttendance;
use Source\Models\DocumentSecondaryComplement;
use Source\Models\Genre;
use Source\Models\Level;
use Source\Models\Scheduling;
use Source\Models\UserLogin;
use Source\Models\Filter;
use Source\Models\Ticket as TicketModel;

/**
 * Description of Admin
 *
 * @author Luiz
 */
class Admin extends Controller {

    /**
     * @var \Source\Models\User|null
     */
    protected $user;

    /**
     * Admin constructor.
     */
    public function __construct($router) {
        parent::__construct($router, CONF_VIEW_ADMIN);

        $this->user = User::UserLog();

        $diasemana= date('w');
        $hoje = date("Y-m-d");

        if($this->user->account()->id!=35){
        if($diasemana==5){
           $delete_attendance_count = (new DeleteAttendance())->find("DATE_FORMAT(created_at,'%Y-%m-%d')=:h","h={$hoje}")->count();
           if($delete_attendance_count==0){
              $delete_attendance = new DeleteAttendance();
              $delete_attendance->save();

              $attendance_delete = (new Attendance())->find("attendance_return_id in (1,2,3,7,8,10,11,17,18) and filter_id in (select id from filters where status=2 or status_filter='ENCERRADO')")->fetch(true);
              foreach($attendance_delete as $each_attendance_Delete){
                 $each_attendance_Delete->destroy();
              }
           }
        }
        }else{
            if($diasemana==1 || $diasemana==2 || $diasemana==3 || $diasemana==4 || $diasemana==5 || $diasemana==6 || $diasemana==7){
                $delete_attendance_count = (new DeleteAttendance())->find("DATE_FORMAT(created_at,'%Y-%m-%d')=:h","h={$hoje}")->count();
                if($delete_attendance_count==0){
                   $delete_attendance = new DeleteAttendance();
                   $delete_attendance->save();
     
                   $attendance_delete = (new Attendance())->find("attendance_return_id in (1,2,3,7,8,10,11,17,18) and filter_id in (select id from filters where status=2 or status_filter='ENCERRADO')")->fetch(true);
                   foreach($attendance_delete as $each_attendance_Delete){
                      $each_attendance_Delete->destroy();
                   }
                }
             }
        }

        
        /*if($user_log->created_at){

        }

        $user_login = (new UserLogin())->find("ip=:ip","ip={$_SERVER["REMOTE_ADDR"]}")->fetch();
        if(!$user_login){ 
            $session = new Session();
            $session->unset("authUserSistemaCred");
            $this->message->info("Para acessar é preciso logar-se")->flash();
            redirect("/login");
        }*/

        
        if (!$this->user) { 
            $this->message->info("Para acessar é preciso logar-se")->flash();
            redirect("/login");
        }

        $user_login = (new UserLogin())->find("user_id=:id","id={$this->user->id}")->fetch();

        if(!isset($user_login)){
            $session = new Session();
            $session->unset("authUserSistemaCred");
            $this->message->info("Para acessar é preciso logar-se")->flash();
            redirect("/login"); 
        }

        if(diffMinutesSession($user_login->created_at,date("Y-m-d H:i:s"))>30){
            if($user_login){
                $user_login->destroy();
            }
            $session = new Session();
            $session->unset("authUserSistemaCred");
            $this->message->info("Para acessar é preciso logar-se")->flash();
            redirect("/login");
        }else{
            $user_login->created_at = date("Y-m-d H:i:s");
            $user_login->save();
        }

        ///verifica se usuário foi bloqueado ou excluído
        /*if ($this->user->status != 1) {

            $user_login = (new UserLogin())->find("ip=:ip","ip={$_SERVER["REMOTE_ADDR"]}")->fetch();

            if($user_login){
             $user_login->destroy();
            }
            $session = new Session();
            $session->unset("authUserSistemaCred");
            $this->message->info("Para acessar é preciso logar-se")->flash();
            redirect("/login");
        }*/

        ////verifica se a sessão existe
        
        /*if (!$this->user) { 
            $user_login = (new UserLogin())->find("ip=:ip","ip={$_SERVER["REMOTE_ADDR"]}")->fetch();
            if($user_login){ 
                $userRecover = new User();
                $userRecover->recoverSession($user_login->user_id);
            }else{

                $this->message->info("Para acessar é preciso logar-se")->flash();
                redirect("/login");
            }
        }*/
        ////////Verifica se usuário já está validado

        if ($this->user->validate == 0 && empty($data["action"])) {
            $this->message->info("Por favor, conclua seu cadastro e valide seus dados para usar o sistema.")->flash();
            $userId = $this->user->id;
            $userEdit = (new User())->findById($userId);

            if($userEdit==null){
                redirect("/error");
            }

            $head = $this->seo->render(
                CONF_SITE_NAME . " | " . "Perfil de {$userEdit->fullName()}",
                CONF_SITE_DESC,
                url("/"),
                url("/assets/images/image.png"),
                false
            );

            $level = (new Level())->find()->fetch(true);
            $genres = (new Genre())->find()->order("description")->fetch(true);
            $document_secondary_complements = (new DocumentSecondaryComplement())->find()->order("description")->fetch(true);

            $firstTicketToPayGreatherThanToday = (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday();
            echo $this->view->render("users/user_alt", [
                "menu" => "user",
                "submenu" => "home",
                "head" => $head,
                "genres" => $genres,
                "document_secondary_complements" => $document_secondary_complements,
                "user" => $userEdit,
                "user_admin" => $this->user->admin_account,
                "user_client" => $this->user->client,
                "level" => $level,
                "user_validate" => 0,
                "firstTicketToPayGreatherThanToday" => $firstTicketToPayGreatherThanToday
            ]);
            exit;
        }
    }

}

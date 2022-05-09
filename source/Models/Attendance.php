<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;
use Source\Support\Message;
use CoffeeCode\DataLayer\Connect;

class Attendance extends DataLayer {

    /** @var MESSAGE */
    protected $message;

    public function __construct() {
        parent::__construct("attendances", ["attendance_return_id"]);
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
            $log->description = "Inclusão do atendimento " . $this->cod;
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
                $log->description = "Alteração do atendimento " . $this->cod;
                $log->save();
            }

            if ($this->status == 2 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Exclusão do atendimento " . $this->cod;
                $log->save();
            }

            if ($this->status == 3 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Bloqueio do atendimento " . $this->cod;
                $log->save();
            }
        }

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
     * @return AttendanceReturn|null
     */
    public function attendanceDesc(): ?AttendanceReturn {
        if ($this->attendance_return_id) {
            return (new AttendanceReturn())->findById($this->attendance_return_id);
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

    /**
     * @return Scheduling|null
     */
    public function schedulingDate(): ?Scheduling {
        if ($this->scheduling_id) {
            return (new Scheduling())->findById($this->scheduling_id);
        }
        return null;
    }

    
    /**
     * @return Filter|null
     */
    public function filterDesc(): ?Filter {
        if ($this->filter_id) {
            return (new Filter())->findById($this->filter_id);
        }
        return null;
    }

    /**
     * @return Client|null
     */
    public function organDesc() {
        $connect = Connect::getInstance();

        $organs = $connect->query("SELECT organ FROM filters INNER JOIN organs on organs.id=filters.organ_id WHERE filters.id = ".$this->filter_id." ");

        return $organs->fetchAll();
    }

    public function countAttendanceByReturn($inicial_date,$final_date){
        $user = User::UserLog();
        $connect = Connect::getInstance();
        $states = $connect->query("SELECT attendance_returns.id as attendance_return_id,count_attendance FROM (SELECT attendance_return_id,COUNT(attendances.id) as count_attendance FROM attendance_returns
        LEFT JOIN attendances ON attendance_returns.id=attendances.attendance_return_id 
        WHERE (account_id='".$user->account_id."' OR account_id IS null) and attendances.status=1
        AND attendances.created_at BETWEEN '".$inicial_date."' and '".$final_date."'
        GROUP BY attendance_return_id ) AS tab
		  right JOIN attendance_returns on tab.attendance_return_id=attendance_returns.id
		  ORDER BY attendance_returns.id");

        return $states->fetchAll();
    
    }

    public function countAttendanceByFilter($filter){
        $connect = Connect::getInstance();

        $attandance = $connect->query("SELECT count(client_id) AS count_client from(SELECT client_id,filter_id FROM  attendances WHERE filter_id='".$filter."' GROUP BY client_id,filter_id) as tab");
        return $attandance->fetchAll();
    }
}
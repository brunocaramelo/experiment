<?php


namespace Source\App;


use Source\Models\DocumentSecondaryComplement;
use Source\Models\User;
use CoffeeCode\DataLayer\Connect;
use Source\Models\Bank;
use Source\Support\Message;
use Source\Models\Ticket as TicketModel;

class Auxiliar extends Admin{

    /**
     * Register constructor.
     * @param $router
     */

    public function __construct($router) {
        parent::__construct($router);
    }

    /**
     * @param array|null $data]
     */
    public function documentAdd(?array $data): void {

        if(empty($data["document_secondary_complement"])){
            $callback["message"] = "Preencha os campos necessários";
            echo json_encode($callback);
            return;
        }

        $user = User::UserLog();

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $data = (object) $post;

        $count_document = (new DocumentSecondaryComplement())->find("description=:d and account_id=:account","d={$data->document_secondary_complement}&account={$this->user->account_id}")->count();

        if(!$count_document==0){
            $callback["message"] = "Valor já cadastrado";
            echo json_encode($callback);
            return;
        }

        $document = new DocumentSecondaryComplement();

        $document->description = $data->document_secondary_complement;
        $document->account_id = $user->account_id;
        if(!$document->save()){
            $callback["message"] = $document->fail()->getMessage();
            echo json_encode($callback);
            return;

        }

        $callback["auxs"] = $this->view->render("fragments/document_secondary_complement",["document_secondary_complement" => $document]);
        echo json_encode($callback);
        return;

    }

    /**
     * @param array|null $data
     */
    public function documentDelete(?array $data): void {

        if(empty($data["id"])){
            return;
        }

        $user = User::UserLog();

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $document = (new DocumentSecondaryComplement())->find("id=:id","id={$id}")->fetch();

        if($document){
            $document->destroy();
        }

        $callback["remove"] = true;
        echo json_encode($callback);

    }

    /**
     *
     */
    public function documentSelect(){

        $documents = (new DocumentSecondaryComplement())->find()->order("description")->fetch(true);

        $documentList = null;

        foreach ($documents as $document) {

            $documentList[] = $document->data();
        }

        echo json_encode(["document" => $documentList]);
    }

    public function citySelect($data){

        $connect = Connect::getInstance();

        $cities = $connect->query("SELECT cidade_codigo,cidade_descricao FROM sistem80_cep.cidade WHERE Uf_codigo = ".$data["state"]." ORDER BY cidade_descricao");
        
        echo json_encode(["cities" => $cities->fetchAll()]);
    
    }

    public function citySelected($data){

        $connect = Connect::getInstance();

        $cities_selected = $connect->query("SELECT city_id FROM filter_city WHERE filter_id = ".$data["filter"]." ");
        
        echo json_encode(["cities_selected" => $cities_selected->fetchAll()]);
    
    }

    /**
     * @param array|null $data]
     */
    public function bankAdd(?array $data): void {

        if(empty($data["bank"])){
            $callback["message"] = "Preencha os campos necessários";
            echo json_encode($callback);
            return;
        }

        $user = User::UserLog();

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $data = (object) $post;

        $count_bank = (new Bank())->find("bank=:d and account_id=:account","d={$data->bank}&account={$this->user->account_id}")->count();

        if(!$count_bank==0){
            $callback["message"] = "Valor já cadastrado";
            echo json_encode($callback);
            return;
        }

        $bank = new Bank();

        $bank->bank = $data->bank;
        $bank->account_id = $user->account_id;
        if(!$bank->save()){
            $callback["message"] = $bank->fail()->getMessage();
            echo json_encode($callback);
            return;

        }

        $callback["auxs2"] = $this->view->render("fragments/bank",["bank" => $bank]);
        echo json_encode($callback);
        return;

    }

    /**
     * @param array|null $data
     */
    public function bankDelete(?array $data): void {

        if(empty($data["id"])){
            return;
        }

        $user = User::UserLog();

        $id = filter_var($data["id"], FILTER_VALIDATE_INT);

        $bank = (new Bank())->find("id=:id","id={$id}")->fetch();

        if($bank){
            $bank->destroy();
        }

        $callback["remove"] = true;
        echo json_encode($callback);

    }

    /**
     *
     */
    public function bankSelect(){

        $banks = (new Bank())->find()->order("bank")->fetch(true);

        $bankList = null;

        foreach ($banks as $bank) {

            $bankList[] = $bank->data();
        }

        echo json_encode(["bank" => $bankList]);
    }

    public function resumeAttendanceUser(array $data){
        $user = User::UserLog();
        $connect = Connect::getInstance();

        $resume = $connect->query("SELECT attendance_return_id,COUNT(attendances.id) as count_attendance,attendance_returns.description FROM attendance_returns
        LEFT JOIN attendances ON attendance_returns.id=attendances.attendance_return_id 
        WHERE (account_id='".$user->account_id."' OR account_id IS null) and attendances.status=1
        AND attendances.created_at between '".$data['inicial_date']."' and '".$data['final_date']."'
        AND user_id='".$data['user_id']."'
        GROUP BY attendance_return_id ORDER BY attendance_return_id");

        /*$resumeList = null;

        foreach ($resume->fetchAll() as $resume) {

            $resumeList[] = $resume->data();
        }*/

        echo json_encode(["resume" => $resume->fetchAll()]);
    }
}
<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;
use Source\Support\Message;
use CoffeeCode\DataLayer\Connect;

class Filter extends DataLayer {

    /** @var MESSAGE */
    protected $message;

    public function __construct() {
        parent::__construct("filters", ["organ_id", "title"]);
        $this->message = new Message();
    }

    /**
     * Método para salvar ou alterar um usuário
     * @return bool
     */
    public function save(): bool {

        if (empty($this->id)) {

            if (!$this->validateTitle() || !parent::save()) {
                return false;
            }

            $log = new Log();

            $log->account_id = User::UserLog()->account_id;
            $log->user = User::UserLog()->id;
            $log->ip = $_SERVER["REMOTE_ADDR"];
            $log->description = "Inclusão do filtro " . $this->title;
            $log->save();
            
        } else {

            if (!$this->validateTitle() ||!parent::save()) {
                return false;
            }

            if ($this->status == 1 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Alteração do filtro " . $this->title;
                $log->save();
            }

            if ($this->status == 2 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Exclusão do filtro " . $this->title;
                $log->save();
            }

            if ($this->status == 3 && User::UserLog()) {
                $log = new Log();

                $log->account_id = User::UserLog()->account_id;
                $log->user = User::UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Bloqueio do filtro " . $this->title;
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
     * Método para validação de Título ao incluir filtro
     * @return bool
     */
    protected function validateTitle(): bool {

        $user = User::UserLog();

        if (empty($this->title)) {
            $this->fail = new Exception("Informe um Título");
            return false;
        }

        $filterByTitle = null;
        if (!$this->id) {
            $filterByTitle = $this->find("title = :title and status!=2 and account_id=:account_id", "title={$this->title}&account_id={$user->UserLog()->account_id}")->count();
        } else {
            $filterByTitle = $this->find("title = :title AND id != :id  and status!=2 and account_id=:account_id", "title={$this->title}&account_id={$user->UserLog()->account_id}&id={$this->id}")->count();
        }

        if ($filterByTitle) {
            $this->fail = new Exception("Título já cadastrado para outro filtro.");
            return false;
        }
        return true;
    }

    /**
     * Método para gerar próximo código do filtro
     * @return int
     */
    public function codFilter(): int{

        $cod = explode("-", $this->cod);
        
        return preg_replace('/[^0-9]/', '',$cod[0]);
    }

    /**
     * @return Organ|null
     */
    public function organDesc(): ?Organ {
        if ($this->organ_id) {
            return (new Organ())->findById($this->organ_id);
        }
        return null;
    }

    /**
     * @return Category|null
     */
    public function categoryDesc($organ) {
        $connect = Connect::getInstance();

        if($organ==1){
          $states = $connect->query("SELECT description FROM filter_category INNER JOIN categories on categories.id=filter_category.category_id WHERE filter_id = ".$this->id."");
        }
        if($organ==2){
            $states = $connect->query("SELECT description FROM filter_category INNER JOIN categories on categories.id=filter_category.category_id WHERE filter_id = ".$this->id."");
        }
        if($organ==3){
            $states = $connect->query("SELECT description FROM filter_category INNER JOIN categories_aeronautica on categories_aeronautica.id=filter_category.category_id WHERE filter_id = ".$this->id."");
        }
        if($organ==4){
            $states = $connect->query("SELECT description FROM filter_category INNER JOIN categories_siape on categories_siape.id=filter_category.category_id WHERE filter_id = ".$this->id."");
        }
        return $states->fetchAll();
    }



    /**
     * @return Patent|null
     */
    public function patentDesc($organ) {
        $connect = Connect::getInstance();

        if($organ==1){
          $states = $connect->query("SELECT description FROM filter_patent INNER JOIN patents on patents.id=filter_patent.patent_id WHERE filter_id = ".$this->id."");
          return $states->fetchAll();
        }
        if($organ==2){
            $states = $connect->query("SELECT description FROM filter_patent INNER JOIN patents_marinha on patents_marinha.id=filter_patent.patent_id WHERE filter_id = ".$this->id."");
            return $states->fetchAll();
        }
        if($organ==3){
            $states = $connect->query("SELECT description FROM filter_patent INNER JOIN patents_aeronautica on patents_aeronautica.id=filter_patent.patent_id WHERE filter_id = ".$this->id."");
            return $states->fetchAll();
        }
        if($organ==4){
            $states = "";
        }
        
    }

    public function legalRegimeDesc() {
        $connect = Connect::getInstance();

        $states = $connect->query("SELECT description FROM filter_legal_regime INNER JOIN legal_regime on legal_regime.id=filter_legal_regime.legal_regime_id WHERE filter_id = ".$this->id."");

        return $states->fetchAll();
    }


    /**
     * @return Filter_bank_account|null
     */
    public function returnBankAccount() {
        $connect = Connect::getInstance();

        $states = $connect->query("SELECT bank FROM filter_bank_accounts INNER JOIN banks on banks.id=filter_bank_accounts.bank_id WHERE filter_id = ".$this->id."");

        return $states->fetchAll();
    }


    /**
     * @return Filter_bank_account|null
     */
    public function returnState() {
        $connect = Connect::getInstance();

        $states = $connect->query("SELECT uf_descricao FROM filter_state INNER JOIN sistem80_cep.uf as uf on uf.uf_codigo=filter_state.state_id WHERE filter_id = ".$this->id."");

        return $states->fetchAll();
    }

    public function returnCity() {
        $connect = Connect::getInstance();
        
        $states = $connect->query("SELECT cidade_descricao FROM filter_city INNER JOIN sistem80_cep.cidade as ct on ct.cidade_codigo=filter_city.city_id WHERE filter_id = ".$this->id."");

        return $states->fetchAll();
    }

    /**
     * 
     */
    public function returnBankDescount($organ) {
        $connect = Connect::getInstance();

        if($organ==1){
          $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_exercito on bank_loan_exercito.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==2){
            $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_marinha on bank_loan_marinha.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==3){
            $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_aero on bank_loan_aero.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==4){
            $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_siape on bank_loan_siape.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        return $states->fetchAll();
    }

    /**
     * 
     */
    public function returnBankNotDescount($organ) {
        $connect = Connect::getInstance();

        if($organ==1){
            $states = $connect->query("SELECT bank FROM filter_bank_not_discounts INNER JOIN bank_loan_exercito on bank_loan_exercito.id=filter_bank_not_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==2){
            $states = $connect->query("SELECT bank FROM filter_bank_not_discounts INNER JOIN bank_loan_marinha on bank_loan_marinha.id=filter_bank_not_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==3){
            $states = $connect->query("SELECT bank FROM filter_bank_not_discounts INNER JOIN bank_loan_aero on bank_loan_aero.id=filter_bank_not_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==4){
            $states = $connect->query("SELECT bank FROM filter_bank_not_discounts INNER JOIN bank_loan_siape on bank_loan_siape.id=filter_bank_not_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        return $states->fetchAll();
    }

    /**
     * @return Patent|null
     */
    public function stateDesc(): ?Patent {
        if ($this->patent_id) {
            return (new Patent())->findById($this->patent_id);
        }
        return null;
    }



    /*public function showState(){
        $connect = Connect::getInstance();

        $states = $connect->query("SELECT uf_codigo,uf_descricao FROM sistem80_cep.uf WHERE uf_codigo = ".$this->state."");

        return $states->fetchAll();
    
    }

    public function showCity(){
        $connect = Connect::getInstance();

        $states = $connect->query("SELECT cidade_codigo,cidade_descricao FROM sistem80_cep.cidade WHERE cidade_codigo = ".$this->city."");

        return $states->fetchAll();
    
    }*/
    /**
     * @return Client|null
     */
    public function clientDesc() {
        $connect = Connect::getInstance();

        $clients = $connect->query("SELECT * FROM clients WHERE filter_id = ".$this->id." ORDER BY name");

        return $clients->fetchAll();
    }

    public function returnIndicative() {

        if ($this->id) {
            return (new FilterIndicative())->find("filter_id=:f","f={$this->id}")->fetch(true);
        }
        return null;   

    }

    /**
     * 
     */
    /*public function returnBankDescount($organ) {
        $connect = Connect::getInstance();

        if($organ==1){
          $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_exercito on bank_loan_exercito.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==2){
            $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_marinha on bank_loan_marinha.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==3){
            $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_aero on bank_loan_aero.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        if($organ==4){
            $states = $connect->query("SELECT bank FROM filter_bank_discounts INNER JOIN bank_loan_siape on bank_loan_siape.id=filter_bank_discounts.bank_id WHERE filter_id = ".$this->id."");
        }
        return $states->fetchAll();
    }*/

    public function searchFilterQueue($filter){
        $connect = Connect::getInstance();
        $query = "select client_id from filter_queue ";
        $query .= " where attendance_finish=0 and filter_id='".$filter."' ";
        $query .= " and client_id not in (select client_id from filter_client_user where account_id='" . User::UserLog()->account_id . "' and filter_id= '" . $filter . "' and user_id<>'" . User::UserLog()->id . "') ";
        $query .= " and client_id not in (select client_id from blocked_client where account_id='" . User::UserLog()->account_id . "' and status=1) ";
        $query .= " and client_id not in (select client_id from schedulings where account_id='" . User::UserLog()->account_id . "' and user_id!='" . User::UserLog()->id . "' and status=1) ";
        $query .= " and client_id not in (select client_id from filter_queue_consult where account_id='" . User::UserLog()->account_id . "' and user_id!='" . User::UserLog()->id . "' and status=1) ";
        $query .= " ORDER BY rand() limit 1 ";
        $clients = $connect->query($query);

        $client_data = null;

        foreach ($clients->fetchAll() as $client) {

            $client_data = $client->client_id;
        }

        return $client_data;
    }

}
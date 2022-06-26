<?php

namespace Source\App;

use Source\Models\Bank;
use Source\Models\BankCoeficient;
use Source\Models\Coeficient;
use Source\Models\Organ;
use Source\Models\Ticket as TicketModel;

/**
 * Description of Users
 *
 * @author Luiz
 */
class Banks extends Admin
{

    /**
     * Users constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * @param array|null $data
     */
    public function home(?array $data): void
    {

        $banks = (new BankCoeficient())->find("account_id=:id and status!=2", "id={$this->user->account_id}")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Bancos e Coeficientes",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("bank/home", [
            "menu" => "banks",
            "submenu" => "banks",
            "head" => $head,
            "banks" => $banks,
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday();
        ]);
    }

    /**
     * @param array|null $data
     */
    public function bankAdd(?array $data): void
    {

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {

            if (!empty($data['csrf'])) {

                if ($_REQUEST && !csrf_verify($_REQUEST)) {

                    $json["message"] = "Erro ao enviar o formulário, atualize a página";
                    echo json_encode($json);
                    return;
                }
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $status = 0;


            if (isset($data["status"])) {
                $status = 1;
            }

            $createBank = new BankCoeficient();
            $createBank->bank = $data["name"];
            $createBank->status = $status;
            $createBank->account_id = $this->user->account_id;


            if (!$createBank->save()) {
                $json["message"] = $createBank->fail()->getMessage();
                echo json_encode($json);
                return;
            }
            if ($data["count_coeficient"] > 0) {
                for ($i = 0; $i < $data["count_coeficient"]; $i++) {
                    $coeficient = new Coeficient();
                    $coeficient->description = $data["description_$i"];
                    $coeficient->organ_id = returnOrgan($data["organ_$i"]);
                    $coeficient->coeficient = $data["coefficient_$i"];
                    $coeficient->expiration_date_init = date_fmt_back($data["expiration_date_init_$i"]);
                    $coeficient->expiration_date_end = date_fmt_back($data["expiration_date_end_$i"]);
                    $coeficient->bank_coeficient_id = $createBank->id;
                    if (!$coeficient->save()) {
                        $json["message"] = $coeficient->fail()->getMessage();
                        echo json_encode($json);
                        return;
                    }
                }
            }
            $this->message->info("Banco cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/banco-e-coeficiente/cadastrar");
            echo json_encode($json);
            return;
        }
        $organs = (new Organ())->find()->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Bancos e Coeficientes",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("bank/add", [
            "menu" => "banks",
            "submenu" => "banks",
            "head" => $head,
            "organs" => $organs,
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday();
        ]);
    }

    /**
     * @param array|null $data
     */
    public function bankUpdate(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {


            $bank_coeficiente = (new BankCoeficient())->find("id=:id", "id={$data["cod"]}")->fetch();
            $status = 0;

            if (isset($data["status"])) {
                $status = 1;
            }
            $bank_coeficiente->bank = $data["name"];
            $bank_coeficiente->status = $status;

            if (!$bank_coeficiente->save()) {
                $json["message"] = $bank_coeficiente->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $coeficients = (new Coeficient())->find("bank_coeficient_id=:b", "b={$bank_coeficiente->id}")->fetch(true);
            if($coeficients){
                foreach($coeficients as $coeficient){
                 $coeficient->destroy();
                }
            }

            if ($data["count_coeficient_old"] > 0 && $data["count_coeficient_old"]!="") {
                for ($i = 1; $i <= $data["count_coeficient_old"]; $i++) {
                    $coeficient = new Coeficient();
                    $coeficient->description = $data["description_old_$i"];
                    $coeficient->organ_id = returnOrgan($data["organ_old_$i"]);
                    $coeficient->coeficient = $data["coefficient_old_$i"];
                    $coeficient->expiration_date_init = date_fmt_back($data["expiration_date_init_old_$i"]);
                    $coeficient->expiration_date_end = date_fmt_back($data["expiration_date_end_old_$i"]);
                    $coeficient->bank_coeficient_id = $bank_coeficiente->id;
                    $coeficient->save();
                }
            }

            if ($data["count_coeficient"] > 0 && $data["count_coeficient"]!="") {
                for ($i = 1; $i <= $data["count_coeficient"]; $i++) {
                    $coeficient = new Coeficient();
                    $coeficient->description = $data["description_$i"];
                    $coeficient->organ_id = returnOrgan($data["organ_$i"]);
                    $coeficient->coeficient = $data["coefficient_$i"];
                    $coeficient->expiration_date_init = date_fmt_back($data["expiration_date_init_$i"]);
                    $coeficient->expiration_date_end = date_fmt_back($data["expiration_date_end_$i"]);
                    $coeficient->bank_coeficient_id = $bank_coeficiente->id;
                    $coeficient->save();
                }
            }

            $this->message->info("Banco alterado com sucesso...")->flash();
            $json["redirect"] = url("/banco-e-coeficiente/alterar/".$bank_coeficiente->cod);
            echo json_encode($json);
            return;

        }

        $bank_coeficiente = (new BankCoeficient())->find("cod=:cod", "cod={$data["cod"]}")->fetch();
        $organs = (new Organ())->find()->fetch(true);

        $coeficients = (new Coeficient())->find("bank_coeficient_id=:b", "b={$bank_coeficiente->id}")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Bancos e Coeficientes Alterar",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("bank/edit", [
            "menu" => "banks",
            "submenu" => "banks",
            "head" => $head,
            "bank" => $bank_coeficiente,
            "organs" => $organs,
            "coeficients" => $coeficients,
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }


    /**
     * @param array|null $data
     */
    public function bankDelete(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);


        $bank_coeficiente = (new BankCoeficient())->find("id=:id", "id={$data["cod"]}")->fetch();

        $coeficients = (new Coeficient())->find("bank_coeficient_id=:b", "b={$bank_coeficiente->id}")->fetch(true);
        if($coeficients){
            foreach($coeficients as $coeficient){
             $coeficient->destroy();
            }
        }

        if($bank_coeficiente){
          $bank_coeficiente->destroy();
        }

        $this->message->info("Banco excluído com sucesso...")->flash();
        $json["redirect"] = url("/banco-e-coeficiente");
        echo json_encode($json);
        return;
    }
}

<?php

namespace Source\App;

use Source\Models\Attendance;
use Source\Models\AttendanceReturn;
use Source\Models\Category;
use Source\Models\Organ;
use Source\Models\Patent;
use Source\Models\User;
use Source\Models\Bank;
use Source\Models\BankLoanAero;
use Source\Models\BankLoanExercito;
use Source\Models\BankLoanMarinha;
use Source\Models\BankLoanSiape;
use Source\Models\BlockedClient;
use Source\Models\CategoryAeronautica;
use Source\Models\CategorySiape;
use Source\Models\Client;
use Source\Models\ClientBenefit;
use Source\Models\ClientLoan;
use Source\Models\ClientSearch;
use Source\Models\ClientUpdate;
use Source\Models\Filter as ModelsFilter;
use Source\Models\Filter_bank_account;
use Source\Models\Filter_bank_discount;
use Source\Models\Filter_bank_not_discount;
use Source\Models\Filter_user;
use Source\Models\FilterCategory;
use Source\Models\FilterCity;
use Source\Models\FilterClientUser;
use Source\Models\FilterIndicative;
use Source\Models\FilterLegalRegime;
use Source\Models\FilterOrganSiape;
use Source\Models\FilterPatent;
use Source\Models\FilterQueue;
use Source\Models\FilterQueueConsult;
use Source\Models\FilterState;
use Source\Models\LegalRegime;
use Source\Models\Log;
use Source\Models\OrganSiape;
use Source\Models\PatentAeronautica;
use Source\Models\PatentMarinha;
use Source\Models\Scheduling;
use Source\Support\Pager;
use Dompdf\Dompdf;
use Source\Data\CrediLink;

/**
 * Description of Users
 *
 * @author Luiz
 */
class Filters extends Admin
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

        /*$filter = new ModelsFilter();
     
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Filtros",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/teste", [
            "menu" => "filter",
            "submenu" => "filterHome",
            "head" => $head,
            "filters" => $filter->searchClient($this->user->base_client,1)
        ]);
        exit;*/

        if ($this->user->admin_account == 1) {

            $filter = (new ModelsFilter())->find("account_id=:id and status!=2 and status_filter!='FINALIZADO'", "id={$this->user->account_id}");
        } else {
            $filter = (new ModelsFilter())->find("account_id=:id and status!=2 and status_filter!='FINALIZADO' and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "id={$this->user->account_id}");
        }

        $pager = new Pager(url("/filtro/"));
        $pager->pager($filter->count(), 10, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Filtros",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/home", [
            "menu" => "filter",
            "submenu" => "filterHome",
            "head" => $head,
            "filters" => $filter->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }


    /**
     * @param array|null $data
     */
    public function filterAdd(?array $data): void
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

            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = (object)$post;

            if ($data->organ == 1) {
                if (isset($data->bank_dont_descount_exercito) && isset($data->bank_discount_exercito)) {
                    $result = array_merge($data->bank_dont_descount_exercito, $data->bank_discount_exercito);
                    $copia = array_unique($result);
                    if (count($copia) != count($result)) {
                        $json["message"] = "Um banco com desconto não pode ser selecionado como banco sem desconto";
                        echo json_encode($json);
                        return;
                    }
                }
            }

            if ($data->organ == 2) {
                if (isset($data->bank_dont_descount_marinha) && isset($data->bank_discount_marinha)) {
                    $result = array_merge($data->bank_dont_descount_marinha, $data->bank_discount_marinha);
                    $copia = array_unique($result);
                    if (count($copia) != count($result)) {
                        $json["message"] = "Um banco com desconto não pode ser selecionado como banco sem desconto";
                        echo json_encode($json);
                        return;
                    }
                }
            }

            if ($data->organ == 3) {
                if (isset($data->bank_dont_descount_aero) && isset($data->bank_discount_aero)) {
                    $result = array_merge($data->bank_dont_descount_aero, $data->bank_discount_aero);
                    $copia = array_unique($result);
                    if (count($copia) != count($result)) {
                        $json["message"] = "Um banco com desconto não pode ser selecionado como banco sem desconto";
                        echo json_encode($json);
                        return;
                    }
                }
            }

            if ($data->organ == 4) {
                if (isset($data->bank_dont_descount_siape) && isset($data->bank_discount_siape)) {
                    $result = array_merge($data->bank_dont_descount_siape, $data->bank_discount_siape);
                    $copia = array_unique($result);
                    if (count($copia) != count($result)) {
                        $json["message"] = "Um banco com desconto não pode ser selecionado como banco sem desconto";
                        echo json_encode($json);
                        return;
                    }
                }
            }



            $release_next_customer = 0;
            $filter_by_coefficient = 0;
            $dont_ignore_client = 0;
            $dont_ignore_client_campaing = 0;
            $filter_only_client = 0;
            $ignore_actived_filters = 0;
            $margin_of = null;
            $until_margin_of = null;
            $margin_percent = null;
            $until_margin_percent = null;

            if (isset($data->release_next_customer)) {
                $release_next_customer = 1;
            }
            /*if (isset($data->filter_by_coefficient)) {
                $filter_by_coefficient = 1;
            }*/
            if (isset($data->dont_ignore_client)) {
                $dont_ignore_client = 1;
            }
            if (isset($data->dont_ignore_client_campaing)) {
                $dont_ignore_client_campaing = 1;
            }
            if (isset($data->filter_only_client)) {
                $filter_only_client = 1;
            }
            if (isset($data->margin_of)) {
                $margin_of = $data->margin_of;
            }
            if (isset($data->until_margin_of)) {
                $until_margin_of = $data->until_margin_of;
            }
            if (isset($data->margin_percent)) {
                $margin_percent = $data->margin_percent;
            }
            if (isset($data->until_margin_percent)) {
                $until_margin_percent = $data->until_margin_percent;
            }
            if (isset($data->ignore_actived_filters)) {
                $ignore_actived_filters = $data->ignore_actived_filters;
            }
            $filterCreate = new ModelsFilter();
            $filterCreate->organ_id = $data->organ;
            $filterCreate->title = $data->title;
            $filterCreate->description = $data->description;
            $filterCreate->release_next_customer = $release_next_customer;
            $filterCreate->coefficient = $data->coefficient;
            $filterCreate->filter_by_coefficient = $filter_by_coefficient;
            $filterCreate->dont_ignore_client = $dont_ignore_client;
            $filterCreate->dont_ignore_client_campaing = $dont_ignore_client_campaing;
            $filterCreate->ignore_actived_filters = $ignore_actived_filters;
            $filterCreate->filter_only_client = $filter_only_client;
            $filterCreate->age_of = $data->age_of;
            $filterCreate->age_until = $data->age_until;
            $filterCreate->margin_of = str_replace([".", ","], ["", "."], $margin_of);
            $filterCreate->until_margin_of = str_replace([".", ","], ["", "."], $until_margin_of);
            $filterCreate->margin_percent = str_replace([".", ","], ["", "."], $margin_percent);
            $filterCreate->until_margin_percent = str_replace([".", ","], ["", "."], $until_margin_percent);
            $filterCreate->portions = str_replace([".", ","], ["", "."], $data->portion);
            $filterCreate->until_portion = str_replace([".", ","], ["", "."], $data->until_portion);
            $filterCreate->rest_portion = $data->rest_portion;
            $filterCreate->until_rest_portion = $data->until_rest_portion;
            $filterCreate->attendance_retorn_id = $data->attendance_retorn;
            $filterCreate->attendence_of = date_fmt_back($data->attendence_of);
            $filterCreate->until_attendence_of = date_fmt_back($data->until_attendence_of);
            $filterCreate->status = 1;
            $filterCreate->status_filter = "ATIVO";
            $filterCreate->waiting = 1;
            $filterCreate->account_id = $this->user->account_id;

            if (!$filterCreate->save()) {
                $json["message"] = $filterCreate->fail()->getMessage();
                echo json_encode($json);
                return;
            }
            if (isset($data->user)) {
                foreach ($data->user as $user) {
                    //echo "usuarios".$user."<br>";
                    $filter_user = new Filter_user();
                    $filter_user->user_id = $user;
                    $filter_user->filter_id = $filterCreate->id;
                    $filter_user->status = 1;
                    $filter_user->save();
                }
            } else {
                if ($this->user->client == 1) {
                    $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
                } else {
                    $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
                }

                foreach ($users as $user) {
                    //echo "usuarios".$user."<br>";
                    $filter_user = new Filter_user();
                    $filter_user->user_id = $user->id;
                    $filter_user->filter_id = $filterCreate->id;
                    $filter_user->status = 1;
                    $filter_user->save();
                }
            }

            if (isset($data->bank)) {
                foreach ($data->bank as $bank) {
                    //echo "bancos".$bank."<br>";
                    $filter_bank_account = new Filter_bank_account();
                    $filter_bank_account->bank_id = $bank;
                    $filter_bank_account->filter_id = $filterCreate->id;
                    $filter_bank_account->status = 1;
                    $filter_bank_account->save();
                }
            }

            if ($data->organ == "1") {

                if (isset($data->bank_discount_exercito)) {
                    foreach ($data->bank_discount_exercito as $bank_discount) {
                        //echo "bank discount".$bank_discount."<br>";
                        $filter_bank_discount = new Filter_bank_discount();
                        $filter_bank_discount->bank_id = $bank_discount;
                        $filter_bank_discount->filter_id = $filterCreate->id;
                        $filter_bank_discount->status = 1;
                        $filter_bank_discount->save();
                    }
                }

                if (isset($data->bank_dont_discount_exercito)) {
                    foreach ($data->bank_dont_discount_exercito as $bank_dont_discount) {
                        //echo "bank not discount".$bank_dont_discount."<br>";
                        $filter_bank_not_discount = new Filter_bank_not_discount();
                        $filter_bank_not_discount->bank_id = $bank_dont_discount;
                        $filter_bank_not_discount->filter_id = $filterCreate->id;
                        $filter_bank_not_discount->status = 1;
                        $filter_bank_not_discount->save();
                    }
                }
            }

            if ($data->organ == "2") {

                if (isset($data->bank_discount_marinha)) {
                    foreach ($data->bank_discount_marinha as $bank_discount) {
                        //echo "bank discount".$bank_discount."<br>";
                        $filter_bank_discount = new Filter_bank_discount();
                        $filter_bank_discount->bank_id = $bank_discount;
                        $filter_bank_discount->filter_id = $filterCreate->id;
                        $filter_bank_discount->status = 1;
                        $filter_bank_discount->save();
                    }
                }

                if (isset($data->bank_dont_discount_marinha)) {
                    foreach ($data->bank_dont_discount_marinha as $bank_dont_discount) {
                        //echo "bank not discount".$bank_dont_discount."<br>";
                        $filter_bank_not_discount = new Filter_bank_not_discount();
                        $filter_bank_not_discount->bank_id = $bank_dont_discount;
                        $filter_bank_not_discount->filter_id = $filterCreate->id;
                        $filter_bank_not_discount->status = 1;
                        $filter_bank_not_discount->save();
                    }
                }
            }

            if ($data->organ == "3") {

                if (isset($data->bank_discount_aero)) {
                    foreach ($data->bank_discount_aero as $bank_discount) {
                        //echo "bank discount".$bank_discount."<br>";
                        $filter_bank_discount = new Filter_bank_discount();
                        $filter_bank_discount->bank_id = $bank_discount;
                        $filter_bank_discount->filter_id = $filterCreate->id;
                        $filter_bank_discount->status = 1;
                        $filter_bank_discount->save();
                    }
                }

                if (isset($data->bank_dont_discount_aero)) {
                    foreach ($data->bank_dont_discount_aero as $bank_dont_discount) {
                        //echo "bank not discount".$bank_dont_discount."<br>";
                        $filter_bank_not_discount = new Filter_bank_not_discount();
                        $filter_bank_not_discount->bank_id = $bank_dont_discount;
                        $filter_bank_not_discount->filter_id = $filterCreate->id;
                        $filter_bank_not_discount->status = 1;
                        $filter_bank_not_discount->save();
                    }
                }
            }

            if ($data->organ == "4") {

                if (isset($data->bank_discount_siape)) {
                    foreach ($data->bank_discount_siape as $bank_discount) {
                        //echo "bank discount".$bank_discount."<br>";
                        $filter_bank_discount = new Filter_bank_discount();
                        $filter_bank_discount->bank_id = $bank_discount;
                        $filter_bank_discount->filter_id = $filterCreate->id;
                        $filter_bank_discount->status = 1;
                        $filter_bank_discount->save();
                    }
                }

                if (isset($data->bank_dont_descount_siape)) {
                    foreach ($data->bank_dont_descount_siape as $bank_dont_discount) {
                        //echo "bank not discount".$bank_dont_discount."<br>";
                        $filter_bank_not_discount = new Filter_bank_not_discount();
                        $filter_bank_not_discount->bank_id = $bank_dont_discount;
                        $filter_bank_not_discount->filter_id = $filterCreate->id;
                        $filter_bank_not_discount->status = 1;
                        $filter_bank_not_discount->save();
                    }
                }
            }

            if (isset($data->state)) {
                foreach ($data->state as $state) {
                    $filter_state = new FilterState();
                    $filter_state->state_id = $state;
                    $filter_state->filter_id = $filterCreate->id;
                    $filter_state->status = 1;
                    $filter_state->save();
                }
            }

            if (isset($data->city)) {
                foreach ($data->city as $city) {
                    $filter_city = new FilterCity();
                    $filter_city->city_id = $city;
                    $filter_city->filter_id = $filterCreate->id;
                    $filter_city->status = 1;
                    $filter_city->save();
                }
            }

            if (isset($data->indicative)) {
                foreach ($data->indicative as $indicative) {
                    $filter_indicative = new FilterIndicative();
                    $filter_indicative->indicative_id = $indicative;
                    $filter_indicative->filter_id = $filterCreate->id;
                    $filter_indicative->status = 1;
                    $filter_indicative->save();
                }
            }

            if ($data->organ == 1) {
                if (isset($data->category_exercito_marinha)) {
                    foreach ($data->category_exercito_marinha as $category) {
                        $filter_category = new FilterCategory();
                        $filter_category->category_id = $category;
                        $filter_category->filter_id = $filterCreate->id;
                        $filter_category->status = 1;
                        $filter_category->save();
                    }
                }


                if (isset($data->patent_exercito)) {
                    foreach ($data->patent_exercito as $patent) {
                        $filter_patent = new FilterPatent();
                        $filter_patent->patent_id = $patent;
                        $filter_patent->filter_id = $filterCreate->id;
                        $filter_patent->status = 1;
                        $filter_patent->save();
                    }
                }
            }

            if ($data->organ == 2) {
                if (isset($data->category_exercito_marinha)) {
                    foreach ($data->category_exercito_marinha as $category) {
                        $filter_category = new FilterCategory();
                        $filter_category->category_id = $category;
                        $filter_category->filter_id = $filterCreate->id;
                        $filter_category->status = 1;
                        $filter_category->save();
                    }
                }


                if (isset($data->patent_marinha)) {
                    foreach ($data->patent_marinha as $patent) {
                        $filter_patent = new FilterPatent();
                        $filter_patent->patent_id = $patent;
                        $filter_patent->filter_id = $filterCreate->id;
                        $filter_patent->status = 1;
                        $filter_patent->save();
                    }
                }
            }

            if ($data->organ == 3) {

                if (isset($data->category_aeronautica)) {
                    foreach ($data->category_aeronautica as $category) {
                        $filter_category = new FilterCategory();
                        $filter_category->category_id = $category;
                        $filter_category->filter_id = $filterCreate->id;
                        $filter_category->status = 1;
                        $filter_category->save();
                    }
                }

                if (isset($data->patent_aeronautica)) {
                    foreach ($data->patent_aeronautica as $patent) {
                        $filter_patent = new FilterPatent();
                        $filter_patent->patent_id = $patent;
                        $filter_patent->filter_id = $filterCreate->id;
                        $filter_patent->status = 1;
                        $filter_patent->save();
                    }
                }
            }

            if ($data->organ == 4) {
                if (isset($data->category_siape)) {
                    foreach ($data->category_siape as $category) {
                        $filter_category = new FilterCategory();
                        $filter_category->category_id = $category;
                        $filter_category->filter_id = $filterCreate->id;
                        $filter_category->status = 1;
                        $filter_category->save();
                    }
                }

                if (isset($data->legal_regime)) {
                    foreach ($data->legal_regime as $legal_regime) {
                        $filter_legal_regime = new FilterLegalRegime();
                        $filter_legal_regime->legal_regime_id = $legal_regime;
                        $filter_legal_regime->filter_id = $filterCreate->id;
                        $filter_legal_regime->status = 1;
                        $filter_legal_regime->save();
                    }
                }

                if (isset($data->organ_siape)) {
                    foreach ($data->organ_siape as $organ_siape) {
                        $filter_organ_siape = new FilterOrganSiape();
                        $filter_organ_siape->organ_siape_id = $organ_siape;
                        $filter_organ_siape->filter_id = $filterCreate->id;
                        $filter_organ_siape->status = 1;
                        $filter_organ_siape->save();
                    }
                }
            }

            $client_filters = (new Client())->returnClient($filterCreate->organ_id, $filterCreate->returnIndicative(), $filterCreate->categoryDesc($filterCreate->organ_id), $filterCreate->patentDesc($filterCreate->organ_id), $filterCreate->returnState(), $filterCreate->returnCity(), $filterCreate->legalRegimeDesc(), $filterCreate->returnBankAccount(), $filterCreate->portions, $filterCreate->until_portion, $filterCreate->rest_portion, $filterCreate->until_rest_portion, $filterCreate->returnBankDescount($filterCreate->organ_id), $filterCreate->returnBankNotDescount($filterCreate->organ_id), $filterCreate->margin_of, $filterCreate->until_margin_of, $filterCreate->margin_percent, $filterCreate->until_margin_percent, $filterCreate->age_of, $filterCreate->age_until, $filterCreate->attendance_retorn_id, $filterCreate->attendence_of, $filterCreate->until_attendence_of, $ignore_actived_filters, $dont_ignore_client);

            //echo $client_filters;exit;

            if (!$client_filters || $client_filters == 0) {

                $log = (new Log())->find("description=:d", "d=Inclusão do filtro " . $filterCreate->title)->fetch();

                if ($log) {
                    $log->destroy();
                }

                $filterCreate->destroy();
                if (isset($filter_user)) {
                    $filter_user->destroy();
                }
                if (isset($filter_bank_account)) {
                    $filter_bank_account->destroy();
                }
                if (isset($filter_bank_discount)) {
                    $filter_bank_discount->destroy();
                }
                if (isset($filter_bank_not_discount)) {
                    $filter_bank_not_discount->destroy();
                }
                if (isset($filter_state)) {
                    $filter_state->destroy();
                }
                if (isset($filter_city)) {
                    $filter_city->destroy();
                }
                if (isset($filter_indicative)) {
                    $filter_indicative->destroy();
                }
                if (isset($filter_category)) {
                    $filter_category->destroy();
                }
                if (isset($filter_patent)) {
                    $filter_patent->destroy();
                }
                if (isset($filter_legal_regime)) {
                    $filter_legal_regime->destroy();
                }
                if (isset($filter_organ_siape)) {
                    $filter_organ_siape->destroy();
                }

                if ($client_filters == 0) {
                    $json["message"] = "Houve um erro ao criar o filtro!";
                } else {
                    $json["message"] = "Nenhum cliente encontrado com esse filtro!";
                }

                echo json_encode($json);
                return;
            }

            foreach ($client_filters as $order => $client_filter) {
                $queue = new FilterQueue();
                $queue->filter_id = $filterCreate->id;
                $queue->client_id = $client_filter->id;
                $queue->account_id = $this->user->account_id;
                $queue->attendance_finish = 0;
                $queue->ordering = $order;
                $queue->status = "1";
                $queue->save();
            }

            if ($queue->find()->count() == 0) {

                $log = (new Log())->find("description=:d", "d=Inclusão do filtro " . $filterCreate->title)->fetch();

                if ($log) {
                    $log->destroy();
                }

                $filterCreate->destroy();
                if (isset($filter_user)) {
                    $filter_user->destroy();
                }
                if (isset($filter_bank_account)) {
                    $filter_bank_account->destroy();
                }
                if (isset($filter_bank_discount)) {
                    $filter_bank_discount->destroy();
                }
                if (isset($filter_bank_not_discount)) {
                    $filter_bank_not_discount->destroy();
                }
                if (isset($filter_state)) {
                    $filter_state->destroy();
                }
                if (isset($filter_city)) {
                    $filter_city->destroy();
                }
                if (isset($filter_indicative)) {
                    $filter_indicative->destroy();
                }
                if (isset($filter_category)) {
                    $filter_category->destroy();
                }
                if (isset($filter_patent)) {
                    $filter_patent->destroy();
                }
                if (isset($filter_legal_regime)) {
                    $filter_legal_regime->destroy();
                }
                if (isset($filter_organ_siape)) {
                    $filter_organ_siape->destroy();
                }
                $json["message"] = "Houve um erro ao criar o filtro!";
            }

            $this->message->info("Filtro cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/filtro/alterar/" . $filterCreate->cod);
            echo json_encode($json);
            return;
        }


        $organs = (new Organ())->find()->fetch(true);
        $categories = (new Category())->find()->fetch(true);
        $patents = (new Patent())->find()->fetch(true);
        $attendence_returns = (new AttendanceReturn())->find()->fetch(true);
        $banks = (new Bank())->find()->fetch(true);
        $legal_regime = (new LegalRegime())->find()->fetch(true);
        $category_siape = (new CategorySiape())->find()->fetch(true);
        $category_aeronautica = (new CategoryAeronautica())->find()->fetch(true);
        $patent_marinha = (new PatentMarinha())->find()->fetch(true);
        $patent_aeronautica = (new PatentAeronautica())->find()->fetch(true);
        $bank_loan_exercito = (new BankLoanExercito())->find()->fetch(true);
        $bank_loan_marinha = (new BankLoanMarinha())->find()->fetch(true);
        $bank_loan_aero = (new BankLoanAero())->find()->fetch(true);
        $bank_loan_siape = (new BankLoanSiape())->find()->fetch(true);

        $organ_siape = (new OrganSiape())->find()->fetch(true);

        if ($this->user->client == 1) {
            $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
        } else {
            $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
        }

        if ($this->user->client == 1) {
            $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
        } else {
            $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
        }

        $states = (new User())->showState();


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Filtros",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/add", [
            "menu" => "filter",
            "submenu" => "filterHome",
            "head" => $head,
            "filters" => "",
            "organs" => $organs,
            "users" => $users,
            "states" => $states,
            "categories" => $categories,
            "patents" => $patents,
            "attendence_returns" => $attendence_returns,
            "banks" => $banks,
            "legal_regime" => $legal_regime,
            "category_siape" => $category_siape,
            "category_aeronautica" => $category_aeronautica,
            "patent_aeronautica" => $patent_aeronautica,
            "patent_marinha" => $patent_marinha,
            "organ_siape" => $organ_siape,
            "bank_loan_exercito" => $bank_loan_exercito,
            "bank_loan_marinha" => $bank_loan_marinha,
            "bank_loan_aero" => $bank_loan_aero,
            "bank_loan_siape" => $bank_loan_siape
        ]);
    }

    /**
     * @param array|null $data
     */
    public function filterChange(?array $data): void
    {

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $this->message->info("Filtro cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/filtro/cadastrar");
            echo json_encode($json);
            return;
        }

        //play
        if (!empty($data["action"]) && $data["action"] == "play") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $filter = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();

            $filter->status_filter = "ATIVO";
            $filter->waiting = 1;

            $filter->save();

            $this->message->info("Filtro iniciado com sucesso...")->flash();
            $json["redirect"] = url("/filtro/alterar/" . $data["cod"]);
            echo json_encode($json);
            return;
        }

        //pause
        if (!empty($data["action"]) && $data["action"] == "pause") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $filter = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();

            $filter->status_filter = "PAUSADO";

            $filter->save();

            $this->message->info("Filtro pausado com sucesso...")->flash();
            $json["redirect"] = url("/filtro/alterar/" . $data["cod"]);
            echo json_encode($json);
            return;
        }

        //edtar
        if (!empty($data["action"]) && $data["action"] == "edit") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $filter = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();

            $filter->status_filter = "PAUSADO";

            $filter->save();

            $this->message->info("Filtro disponível para editar...")->flash();
            $json["redirect"] = url("/filtro/alterar/" . $data["cod"]);
            echo json_encode($json);
            return;
        }

        //finalizar
        if (!empty($data["action"]) && $data["action"] == "finish") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $filter = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();

            $filter->status_filter = "FINALIZADO";

            $filter->save();

            $filter_queues = (new FilterQueue())->find("filter_id=:f", "f={$filter->id}")->fetch(true);

            if (isset($filter_queues)) {
                foreach ($filter_queues as $filter_queue) {
                    $filter_queue->destroy();
                }
            }

            $this->message->info("Filtro finalizado com sucesso...")->flash();
            $json["redirect"] = url("/filtro");
            echo json_encode($json);
            return;
        }


        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $filter = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();

        $filter_user = (new Filter_user())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_bank_account = (new Filter_bank_account())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_bank_discount = (new Filter_bank_discount())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_bank_not_discount = (new Filter_bank_not_discount())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_state = (new FilterState())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_indicative = (new FilterIndicative())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_category = (new FilterCategory())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_patent = (new FilterPatent())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_legal_regime = (new FilterLegalRegime())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_organ_siapes = (new FilterOrganSiape())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $organs = (new Organ())->find()->fetch(true);
        $categories = (new Category())->find()->fetch(true);
        $patents = (new Patent())->find()->fetch(true);
        $attendence_returns = (new AttendanceReturn())->find()->fetch(true);
        $banks = (new Bank())->find()->fetch(true);
        $legal_regimes = (new LegalRegime())->find()->fetch(true);
        $category_siape = (new CategorySiape())->find()->fetch(true);
        $category_aeronautica = (new CategoryAeronautica())->find()->fetch(true);
        $patent_marinha = (new PatentMarinha())->find()->fetch(true);
        $patent_aeronautica = (new PatentAeronautica())->find()->fetch(true);
        $bank_loan_exercito = (new BankLoanExercito())->find()->fetch(true);
        $bank_loan_marinha = (new BankLoanMarinha())->find()->fetch(true);
        $bank_loan_aero = (new BankLoanAero())->find()->fetch(true);
        $bank_loan_siape = (new BankLoanSiape())->find()->fetch(true);

        $organ_siape = (new OrganSiape())->find()->fetch(true);

        if ($this->user->client == 1) {
            $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
        } else {
            $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
        }

        if ($this->user->client == 1) {
            $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
        } else {
            $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
        }

        $states = (new User())->showState();


        $clientCount = (new FilterQueue())->find("filter_id=:id", "id={$filter->id}")->count();

        $attendanceCount = (new Attendance())->find("filter_id=:id", "id={$filter->id}")->count();

        $attendances = (new Attendance())->find(" filter_id=:f AND account_id=:id AND status!=2", "f={$filter->id}&id={$this->user->account_id}")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Filtros",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        $clientesAtendidos = (new ClientUpdate())->getClientesAtendidosByCod($data['cod']);
        echo $this->view->render("filters/edit", [
            "menu" => "filter",
            "submenu" => "filterHome",
            "head" => $head,
            "filter" => $filter,
            "organs" => $organs,
            "users" => $users,
            "states" => $states,
            "categories" => $categories,
            "patents" => $patents,
            "attendence_returns" => $attendence_returns,
            "banks" => $banks,
            "filter_user" => $filter_user,
            "filter_bank_account" => $filter_bank_account,
            "filter_bank_discount" => $filter_bank_discount,
            "filter_bank_not_discount" => $filter_bank_not_discount,
            "legal_regimes" => $legal_regimes,
            "category_siape" => $category_siape,
            "category_aeronautica" => $category_aeronautica,
            "patent_marinha" => $patent_marinha,
            "patent_aeronautica" => $patent_aeronautica,
            "organ_siape" => $organ_siape,
            "bank_loan_exercito" => $bank_loan_exercito,
            "bank_loan_marinha" => $bank_loan_marinha,
            "bank_loan_aero" => $bank_loan_aero,
            "bank_loan_siape" => $bank_loan_siape,
            "filter_state" => $filter_state,
            "clintCount" => $clientCount,
            "filter_indicatives" => $filter_indicative,
            "filter_categories" => $filter_category,
            "filter_patents" => $filter_patent,
            "filter_legal_regimes" => $filter_legal_regime,
            "filter_organ_siapes" => $filter_organ_siapes,
            "attendanceCount" => $attendanceCount,
            "attendances" => $attendances,
            "clientesAtendidos" => $clientesAtendidos,
        ]);
    }

    /**
     * @param array|null $data
     */
    public function filterEdit(?array $data): void
    {
        if (!empty($data['csrf'])) {

            if ($_REQUEST && !csrf_verify($_REQUEST)) {

                $json["message"] = "Erro ao enviar o formulário, atualize a página";
                echo json_encode($json);
                return;
            }
        }

        $filterUpdate = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();


        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $data = (object)$post;

        $filterUpdate->title = $data->title;
        $filterUpdate->description = $data->description;

        if (!$filterUpdate->save()) {
            $json["message"] = $filterUpdate->fail()->getMessage();
            echo json_encode($json);
            return;
        }

        $filter_users = (new Filter_user())->find("filter_id=:filter_id", "filter_id={$filterUpdate->id}")->fetch(true);

        if (isset($filter_users)) {
            foreach ($filter_users as $filter_users_destroy) {
                $filter_users_destroy->destroy();
            }
        }

        if (isset($data->user)) {
            foreach ($data->user as $user) {
                //echo "usuarios".$user."<br>";
                $filter_user = new Filter_user();
                $filter_user->user_id = $user;
                $filter_user->filter_id = $filterUpdate->id;
                $filter_user->status = 1;
                $filter_user->save();
            }
        } else {
            if ($this->user->client == 1) {
                $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
            } else {
                $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
            }

            foreach ($users as $user) {
                //echo "usuarios".$user."<br>";
                $filter_user = new Filter_user();
                $filter_user->user_id = $user->id;
                $filter_user->filter_id = $filterUpdate->id;
                $filter_user->status = 1;
                $filter_user->save();
            }
        }

        $this->message->info("Filtro atualizado com sucesso...")->flash();
        $json["redirect"] = url("/filtro/alterar/" . $filterUpdate->cod);
        echo json_encode($json);
        return;
    }

    /**
     * @param array|null $data
     */
    public function workList(?array $data): void
    {
        if (!empty($data["action"])) {
            if (empty($data["s"]) && empty($data["organ"])) {

                echo json_encode(["redirect" => url("/lista-de-trabalho")]);
                return;
            } else {
                $s = $data["s"] . "_" . $data["organ"];
                echo json_encode(["redirect" => url("/lista-de-trabalho/{$s}/1")]);
                return;
            }
        }

        $search = null;
        $organ = null;
        $search_organ = null;


        /*if ($this->user->admin_account == 1) {

            $filters = (new ModelsFilter())->find("account_id=:cod and status!=2 and status_filter='ATIVO'", "cod={$this->user->account_id}");
        } else {
            $filters = (new ModelsFilter())->find("account_id=:cod and status!=2 and status_filter='ATIVO and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "id={$this->user->account_id}");
        }*/

        if ($this->user->admin_account == 1) {

            $filters = (new ModelsFilter())->find("account_id=:id and status!=2 and status_filter='ATIVO'", "id={$this->user->account_id}");
        } else {
            $filters = (new ModelsFilter())->find("account_id=:id and status!=2 and status_filter='ATIVO' and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "id={$this->user->account_id}");
        }


        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $pieces_search = explode("_", $data["search"]);
            $search = $pieces_search[0];
            $organ = $pieces_search[1];
            $search_organ = $search . "_" . $organ;
            if ($this->user->admin_account == 1) {
                if (!empty($search) && !empty($organ)) {
                    $filters = (new ModelsFilter())->find("MATCH(title) AGAINST(:s) and organ_id=:o and account_id=:cod and status!=2 and status_filter='ATIVO'", "o={$organ}&s={$search}&cod={$this->user->account_id}");
                } else {
                    if (!empty($search)) {
                        $filters = (new ModelsFilter())->find("MATCH(title) AGAINST(:s) and account_id=:cod and status!=2 and status_filter='ATIVO'", "s={$search}&cod={$this->user->account_id}");
                    }
                    if (!empty($organ)) {
                        $filters = (new ModelsFilter())->find("organ_id=:o and account_id=:cod and status!=2 and status_filter='ATIVO'", "o={$organ}&cod={$this->user->account_id}");
                    }
                }
            } else {

                if (!empty($search) && !empty($organ)) {
                    $filters = (new ModelsFilter())->find("MATCH(title) AGAINST(:s) and organ_id=:o and account_id=:cod and status!=2 and status_filter='ATIVO' and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "o={$organ}&s={$search}&cod={$this->user->account_id}");
                } else {
                    if (!empty($search)) {
                        $filters = (new ModelsFilter())->find("MATCH(title) AGAINST(:s) and account_id=:cod and status!=2 and status_filter='ATIVO' and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "s={$search}&cod={$this->user->account_id}");
                    }
                    if (!empty($organ)) {
                        $filters = (new ModelsFilter())->find("organ_id=:o and account_id=:cod and status!=2 and status_filter='ATIVO' and id in (select filter_id from filter_users where user_id='" . $this->user->id . "') ", "o={$organ}&cod={$this->user->account_id}");
                    }
                }
            }
        }

        $all = ($search_organ  ?? "all");
        $pager = new Pager(url("/lista-de-trabalho/$all/"));
        $pager->pager($filters->count(), 10, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Lista de Trabalho",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/work_list", [
            "menu" => "workList",
            "submenu" => "workList",
            "head" => $head,
            "search" => $search,
            "organ" => $organ,
            "filters" => $filters->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * excluir filtro
     */
    public function filterDelete(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $filterDelete = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();


        if ($filterDelete == null) {
            $json["message"] = "Você tentou deletar um filtro que não existe";
            echo json_encode($json);
            return;
        }

        $filterDelete->status = 2;

        if (!$filterDelete->save()) {
            $json["message"] = $filterDelete->fail()->getMessage();
            echo json_encode($json);
            return;
        }

        $filter_queue = (new FilterQueue())->find("filter_id=:filter", "filter={$filterDelete->id}")->fetch(true);

        if (isset($filter_queue)) {
            foreach ($filter_queue as $queue) {
                $queue->destroy();
            }
        }

        $this->message->info("O filtro foi excluído com sucesso")->flash();
        $json["redirect"] = url("/filtro");

        echo json_encode($json);
        return;
    }

    /**
     * excluir filtro
     */
    public function filterCopy(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $filter = (new ModelsFilter())->find("cod=:cod and status!=2", "cod={$data["cod"]}")->fetch();

        $filter_bank_account = (new Filter_bank_account())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_bank_discount = (new Filter_bank_discount())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_bank_not_discount = (new Filter_bank_not_discount())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_state = (new FilterState())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_indicative = (new FilterIndicative())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_category = (new FilterCategory())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_patent = (new FilterPatent())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_legal_regime = (new FilterLegalRegime())->find("filter_id=:id", "id={$filter->id}")->fetch(true);

        $filter_organ_siapes = (new FilterOrganSiape())->find("filter_id=:id", "id={$filter->id}")->fetch(true);


        $filter_user = (new Filter_user())->find("filter_id=:id", "id={$filter->id}")->fetch(true);


        $organs = (new Organ())->find()->fetch(true);
        $categories = (new Category())->find()->fetch(true);
        $patents = (new Patent())->find()->fetch(true);
        $attendence_returns = (new AttendanceReturn())->find()->fetch(true);
        $banks = (new Bank())->find()->fetch(true);
        $legal_regime = (new LegalRegime())->find()->fetch(true);
        $category_siape = (new CategorySiape())->find()->fetch(true);
        $category_aeronautica = (new CategoryAeronautica())->find()->fetch(true);
        $patent_marinha = (new PatentMarinha())->find()->fetch(true);
        $patent_aeronautica = (new PatentAeronautica())->find()->fetch(true);
        $bank_loan_exercito = (new BankLoanExercito())->find()->fetch(true);
        $bank_loan_marinha = (new BankLoanMarinha())->find()->fetch(true);
        $bank_loan_aero = (new BankLoanAero())->find()->fetch(true);
        $bank_loan_siape = (new BankLoanSiape())->find()->fetch(true);

        $organ_siape = (new OrganSiape())->find()->fetch(true);

        $organ_siape = (new OrganSiape())->find()->fetch(true);

        if ($this->user->client == 1) {
            $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
        } else {
            $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
        }

        if ($this->user->client == 1) {
            $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
        } else {
            $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
        }

        $states = (new User())->showState();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Filtros",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/copy", [
            "menu" => "filter",
            "submenu" => "filterHome",
            "head" => $head,
            "filter" => $filter,
            "organs" => $organs,
            "users" => $users,
            "states" => $states,
            "categories" => $categories,
            "patents" => $patents,
            "attendence_returns" => $attendence_returns,
            "banks" => $banks,
            "filter_user" => $filter_user,
            "filter_bank_account" => $filter_bank_account,
            "filter_bank_discount" => $filter_bank_discount,
            "filter_bank_not_discount" => $filter_bank_not_discount,
            "legal_regime" => $legal_regime,
            "category_siape" => $category_siape,
            "category_aeronautica" => $category_aeronautica,
            "patent_marinha" => $patent_marinha,
            "patent_aeronautica" => $patent_aeronautica,
            "organ_siape" => $organ_siape,
            "bank_loan_exercito" => $bank_loan_exercito,
            "bank_loan_marinha" => $bank_loan_marinha,
            "bank_loan_aero" => $bank_loan_aero,
            "bank_loan_siape" => $bank_loan_siape,
            "filter_state" => $filter_state,
            "filter_indicatives" => $filter_indicative,
            "filter_categories" => $filter_category,
            "filter_patents" => $filter_patent,
            "filter_legal_regimes" => $filter_legal_regime,
            "filter_organ_siapes" => $filter_organ_siapes
        ]);
    }

    public function filterClientNext(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $filter_client_user = (new FilterClientUser())->find("filter_id=:f and user_id=:u", "f={$data['id']}&u={$this->user->id}")->fetch();
        $filter_client_user->destroy();

        redirect("/lista-de-trabalho/cliente/" . $data['id'] . "/first");
    }
    /**
     * @param array|null $data
     */
    public function filterClient(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //$filter_queue_consult_count = (new FilterQueueConsult())->find("filter_id=:filter_id and user_id=:user", "filter_id={$data['id']}&user={$this->user->id}")->count();

        $filter_client_user = (new FilterClientUser())->find("filter_id=:f and user_id=:u", "f={$data['id']}&u={$this->user->id}")->fetch();

        if (isset($filter_client_user)) {
            $queue = $filter_client_user->client_id;
        } else {
            $queue = (new ModelsFilter())->searchFilterQueue($data['id']);
            $filter_client = new FilterClientUser();
            $filter_client->filter_id = $data['id'];
            $filter_client->client_id = $queue;
            $filter_client->user_id = $this->user->id;
            $filter_client->account_id = $this->user->account_id;
            $filter_client->status = 1;
            $filter_client->save();
        }


        if ($data["order"] == "first") {

            /*if ($filter_queue_consult_count == 0) {
                $queue = (new FilterQueue())->find("filter_id=:filter_id and attendance_finish=0 and status=1 and client_id not in (select client_id from blocked_client where account_id='" . $this->user->account_id . "' and status=1) and client_id not in (select client_id from schedulings where account_id='" . $this->user->account_id . "' and user_id!='" . $this->user->id . "'and status=1) and client_id not in (select client_id from filter_client_user where filter_id= '" . $data['id'] . "' and user_id<>'" . $this->user->id . "') and (user_id is null or user_id='" . $this->user->id . "') ", "filter_id={$data['id']}")->limit(1)->order("ordering ASC")->fetch();
            } else {
                $queue = (new FilterQueue())->find("filter_id=:filter_id and attendance_finish=0 and status=1 and client_id not in (select client_id from blocked_client where account_id='" . $this->user->account_id . "' and status=1) and client_id not in (select client_id from schedulings where account_id='" . $this->user->account_id . "' and user_id!='" . $this->user->id . "' and status=1) and client_id not in (select client_id from filter_client_user where filter_id= '" . $data['id'] . "' and user_id<>'" . $this->user->id . "') and ordering > (select ordering from filter_queue_consult where filter_id='" . $data['id'] . "' and user_id='" . $this->user->id . "')  and (user_id is null or user_id='" . $this->user->id . "') ", "filter_id={$data['id']}")->limit(1)->order("ordering ASC")->fetch();
            }*/
        } else {

            /* if ($filter_queue_consult_count == 0) {
                $queue = (new FilterQueue())->find("filter_id=:filter_id and attendance_finish=0 and status=1 and client_id not in (select client_id from blocked_client where account_id='" . $this->user->account_id . "' and status=1) and client_id not in (select client_id from schedulings where account_id='" . $this->user->account_id . "' and user_id!='" . $this->user->id . "' and status=1) and ordering>:o and client_id not in (select client_id from filter_client_user where filter_id= '" . $data['id'] . "' and user_id<>'" . $this->user->id . "') and (user_id is null or user_id='" . $this->user->id . "') ", "filter_id={$data['id']}&o={$data['order']}")->limit(1)->order("ordering ASC")->fetch();
            } else {
                $queue = (new FilterQueue())->find("filter_id=:filter_id and attendance_finish=0 and status=1 and client_id not in (select client_id from blocked_client where account_id='" . $this->user->account_id . "' and status=1) and client_id not in (select client_id from schedulings where account_id='" . $this->user->account_id . "' and user_id!='" . $this->user->id . "' and status=1) and ordering>:o and ordering > (select ordering from filter_queue_consult where filter_id='" . $data['id'] . "' and client_id not in (select client_id from filter_client_user where filter_id= '" . $data['id'] . "' and user_id<>'" . $this->user->id . "') and user_id='" . $this->user->id . "')  and (user_id is null or user_id='" . $this->user->id . "') ", "filter_id={$data['id']}&o={$data['order']}")->limit(1)->order("ordering ASC")->fetch();
            }

            $queue_update = (new FilterQueue())->find("filter_id=:filter_id and ordering<:o", "filter_id={$data['id']}&o={$queue->ordering}")->order("ordering ASC")->limit(1)->fetch();

            $filter_queue_consult_list = (new FilterQueueConsult())->find("filter_id=:filter_id and user_id=:user", "filter_id={$data['id']}&user={$this->user->id}")->fetch(true);

            if (isset($filter_queue_consult_list)) {
                foreach ($filter_queue_consult_list as $filter_queue_consult_each) {
                    $filter_queue_consult_each->destroy();
                }
            }

            $filter_queue_consult = new FilterQueueConsult();
            $filter_queue_consult->filter_id = $data['id'];
            $filter_queue_consult->ordering = 0;
            $filter_queue_consult->user_id = $this->user->id;
            $filter_queue_consult->account_id = $this->user->account_id;
            $filter_queue_consult->status = 1;
            $filter_queue_consult->save();*/
        }


        if (!isset($queue)) {
            $this->message->info("Nenhum Cliente encontrado para esse filtro")->flash();
            redirect("/lista-de-trabalho");
        }

        //$filter_client_user_delete = (new FilterClientUser())->find("filter_id=:filter_id and client_id=:client_id and user_id=:user", "filter_id={$queue->filter_id}&client_id={$queue->client_id}&user={$this->user->id}")->fetch();
        /*if(isset($filter_client_user_delete)){
          $filter_client_user_delete->destroy();
        }*/

        /*if (!isset($filter_client_user_delete)) {
            $filter_client_user = new FilterClientUser();

            $filter_client_user->filter_id = $queue->filter_id;
            $filter_client_user->client_id = $queue->client_id;
            $filter_client_user->user_id = $this->user->id;
            $filter_client_user->status = 1;
            $filter_client_user->save();
        }*/
        $client = (new Client())->find("id=:id", "id={$queue}")->fetch();

        $filter = (new ModelsFilter())->findById($data['id']);

        $client_contract = $client->returnClientContract($filter->organ_id);

        //echo $client_contract; exit;


        if ($filter->organ_id == 2) {
            $client_contract_others = $client->returnClientContractOthers($filter->organ_id);
        } else {
            $client_contract_others = [];
        }
        //echo $client_contract_others; exit;
        $attendence_returns = (new AttendanceReturn())->find()->fetch(true);

        if ($this->user->client == 1) {
            $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
        } else {
            $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
        }

        $blocked_client = (new BlockedClient())->find("client_id=:c", "c={$client->id}")->count();

        $attendance = (new Attendance())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch(true);

        $client_update = (new ClientUpdate())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch();

        $client_update_value = 0;

        $count_attendance = (new Attendance())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->count();

        if (isset($client_update)) {
            $client_update_value = 1;
        }


        $client_benefit = (new ClientBenefit())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch(true);

        $client_loan = (new ClientLoan())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch(true);


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Cliente",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/filter_client", [
            "menu" => "workList",
            "submenu" => "workList",
            "head" => $head,
            "search" => 0,
            "client" => $client,
            "filter_id" => $filter->id,
            "attendence_returns" => $attendence_returns,
            "client_contract" => $client_contract,
            "users" => $users,
            "release_next_customer" => $filter->release_next_customer,
            "client_contract_others" => $client_contract_others,
            "blocked_client" => $blocked_client,
            "order" => 0,
            "attendance" => $attendance,
            "client_update_value" => $client_update_value,
            "client_update" => $client_update,
            "count_attendance" => $count_attendance,
            "client_benefit" => $client_benefit,
            "client_loan" => $client_loan
        ]);
    }


    /**
     * @param array|null $data
     */
    public function filterClientSearch(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);


        if (!isset($data['id_cliente'])) {
            $search_matricula = preg_replace("/[^0-9]/", "", $data['search_matricula']);

            if ($search_matricula == 0 || $search_matricula == "") {
                $this->message->info("Nenhum Cliente encontrado para essa matrícula")->flash();
                $json["redirect"] = url("/lista-de-trabalho");

                echo json_encode($json);
                return;
            }

            $search_mat_cpf = removeZero($search_matricula);

            $client = (new Client())->find("(MATRICULA=:s) OR CPF=:s", "s={$search_mat_cpf}")->fetch();


            if (!isset($client)) {
                $this->message->info("Nenhum Cliente encontrado para essa matrícula")->flash();

                $json["redirect"] = url("/lista-de-trabalho");

                echo json_encode($json);
                return;
            }


            $client_search = new ClientSearch();

            $client_search->client_id = $client->id;
            $client_search->user_id = $this->user->id;
            $client_search->account_id = $this->user->account_id;
            $client_search->status = 1;
            if (!$client_search->save()) {
                $json["message"] = $client_search->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $json["redirect"] = url("/cliente/consulta/{$client->id}");
            echo json_encode($json);
            return;
        } else {

            $client = (new Client())->find("id=:id", "id={$data['id_cliente']}")->fetch();

            $client_contract = $client->returnClientContract($client->CLIENT_ORGAN);

            if ($client->CLIENT_ORGAN == 2) {
                $client_contract_others = $client->returnClientContractOthers($client->CLIENT_ORGAN);
            } else {
                $client_contract_others = [];
            }

            $attendence_returns = (new AttendanceReturn())->find()->fetch(true);

            if ($this->user->client == 1) {
                $users = (new User())->find("account_id=:account and status=1 and admin_account=0 and client=1", "account={$this->user->account_id}")->fetch(true);
            } else {
                $users = (new User())->find("status=1 and admin_account=0 and client=1")->fetch(true);
            }

            $blocked_client = (new BlockedClient())->find("client_id=:c", "c={$client->id}")->count();

            $attendance = (new Attendance())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch(true);

            $client_update = (new ClientUpdate())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch();

            $client_update_value = 0;

            //$count_attendance = (new Attendance())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->count();

            if (isset($client_update)) {
                $client_update_value = 1;
            }

            $client_benefit = (new ClientBenefit())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch(true);

            $client_loan = (new ClientLoan())->find("account_id=:account and client_id=:c", "account={$this->user->account_id}&c={$client->id}")->fetch(true);

            $head = $this->seo->render(
                CONF_SITE_NAME . " | Cliente",
                CONF_SITE_DESC,
                url("/"),
                url("/assets/images/image.png"),
                false
            );

            echo $this->view->render("filters/filter_client", [
                "menu" => "workList",
                "submenu" => "workList",
                "head" => $head,
                "search" => 1,
                "client" => $client,
                "filter_id" => 0,
                "attendence_returns" => $attendence_returns,
                "client_contract" => $client_contract,
                "users" => $users,
                "release_next_customer" => "1",
                "client_contract_others" => $client_contract_others,
                "blocked_client" => $blocked_client,
                "attendance" => $attendance,
                "client_update_value" => $client_update_value,
                "client_update" => $client_update,
                "count_attendance" => 0,
                "client_benefit" => $client_benefit,
                "client_loan" => $client_loan
            ]);
        }
    }

    /**
     * Busca atualização e salva dados do cliente
     * Utilizando API da CrediLink
     */
    private function updateClientFromCrediLink(Client $client): void
    {
        $client->CPF = cpfZeros($client->CPF);

        $credi = new CrediLink;
        $update = $credi->getDataFromCpfCnpj($client->CPF);

        $update->client_id = $client->id;
        $update->account_id = $this->user->account_id;
        $update->status = 1;

        if (!$update->save()) {
            $jsonRedirect["message"] = $update->fail()->getMessage();
            echo json_encode($jsonRedirect);
            return;
        }
    }

    public function filterClientUpdate(?array $data): void
    {

        if ($this->user->Account()->api == 2) {
            /**
             * Exemplo de uso com a CrediLink
             */

            $client = (new Client())->find("id=:id", "id={$data['client_id']}")->fetch();
            
            $this->updateClientFromCrediLink($client);
            
            $link = explode("/", $data["url_redirect"]);

            if (isset($link[4])) {
                $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3] . "/" . $link[4];
            } else {
                $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3];
            }

            $this->message->info("Dados atualizados com sucesso...")->flash();
            if ($data["search"] == 0) {
                $jsonRedirect["redirect"] = url("/lista-de-trabalho/cliente/" . $data["filter_id"] . "/first");
            } else {
                $jsonRedirect["redirect"] = url($link_redirect);
            }
            echo json_encode($jsonRedirect);
            return;

            /**
             * Exemplo CrediLink Termina aqui
             */
        } else {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            if ($data['update'] == "data") {

                $client = (new Client())->find("id=:id", "id={$data['client_id']}")->fetch();
                /*$clients = (new Client())->find("filter_id=:id", "id={$data['cod']}")->fetch(true);*/


                $client_cpf = cpfZeros($client->CPF);
                $curl = curl_init();
                curl_setopt_array($curl, array(

                    CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cpf/{$client_cpf}",
                    //CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cpf/14179893788",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "x-login: {$this->user->Account()->user_api}",
                        "x-api-key: {$this->user->Account()->password_api}",
                        "Accept: application/json",
                        "Content-Type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    // Decodifica o formato JSON e retorna um Objeto
                    $json = json_decode($response);
                    $count_registro = 0;
                    foreach ($json as $i => $registro) {
                        $count_registro = $i;
                    }
                    if ($count_registro == "data") {

                        $client_delete = (new ClientUpdate())->find("client_id=:id and account_id=:account", "id={$data['client_id']}&account={$this->user->account_id}")->fetch();
                        if (isset($client_delete)) {
                            $client_delete->destroy();
                        }

                        $client_update = (new ClientUpdate());
                        $client_update->client_id = $data['client_id'];
                        $client_update->account_id = $this->user->account_id;
                        $client_update->status = 1;
                        if (!$client_update->save()) {
                            $jsonRedirect["message"] = $client_update->fail()->getMessage();
                            echo json_encode($jsonRedirect);
                            return;
                        }
                    }

                    // Loop para percorrer o Objeto
                    foreach ($json as $registro) :

                        if (isset($registro->nascimento)) {
                            //$client->NASCIMENTO = date_fmt_back($registro->nascimento);
                            $client_update->nascimento = date_fmt_back($registro->nascimento);
                            $client_update->save();
                            /*if (!$client->save()) {
                            $jsonRedirect["message"] = $client->fail()->getMessage();
                            echo json_encode($jsonRedirect);
                            return;
                        }*/
                        }

                        if (isset($registro->enderecos)) {
                            foreach ($registro->enderecos as $each) :
                                $logradouro = $each->logradouro;
                                $numero = $each->numero;
                                $complemento = $each->complemento;
                                $bairro = $each->bairro;
                                $cidade = $each->cidade;
                                $uf = $each->uf;
                                $cep = $each->cep;
                            endforeach;

                            /*$client->ENDERECO = $logradouro . " " . $numero . " " . $complemento;
                        $client->BAIRRO = $bairro;
                        $client->CIDADE = $cidade;
                        $client->UF = $uf;
                        $client->CEP = $cep;
                        if (!$client->save()) {
                            $jsonRedirect["message"] = $client->fail()->getMessage();
                            echo json_encode($jsonRedirect);
                            return;
                        }*/
                            $client_update->endereco = $logradouro . " " . $numero . " " . $complemento;
                            $client_update->bairro = $bairro;
                            $client_update->cidade = $cidade;
                            $client_update->uf = $uf;
                            $client_update->cep = $cep;
                            $client_update->save();
                        }

                        if (isset($registro->telefones)) {
                            foreach ($registro->telefones as $key => $each) :
                                if ($key == 0) {
                                    /*$client->TELEFONE_01 = $each->numero;
                                if (!$client->save()) {
                                    $jsonRedirect["message"] = $client->fail()->getMessage();
                                    echo json_encode($jsonRedirect);
                                    return;
                                }*/
                                    $client_update->telefone_01 = $each->numero;
                                    $client_update->save();
                                }
                                if ($key == 1) {
                                    /*$client->TELEFONE_02 = $each->numero;
                                if (!$client->save()) {
                                    $jsonRedirect["message"] = $client->fail()->getMessage();
                                    echo json_encode($jsonRedirect);
                                    return;
                                }*/
                                    $client_update->telefone_02 = $each->numero;
                                    $client_update->save();
                                }
                                if ($key == 2) {
                                    /*$client->TELEFONE_03 = $each->numero;
                                if (!$client->save()) {
                                    $jsonRedirect["message"] = $client->fail()->getMessage();
                                    echo json_encode($jsonRedirect);
                                    return;
                                }*/
                                    $client_update->telefone_03 = $each->numero;
                                    $client_update->save();
                                }
                                if ($key == 3) {
                                    /*$client->TELEFONE_04 = $each->numero;
                                if (!$client->save()) {
                                    $jsonRedirect["message"] = $client->fail()->getMessage();
                                    echo json_encode($jsonRedirect);
                                    return;
                                }*/
                                    $client_update->telefone_04 = $each->numero;
                                    $client_update->save();
                                }
                                if ($key == 4) {
                                    /*$client->TELEFONE_05 = $each->numero;
                                if (!$client->save()) {
                                    $jsonRedirect["message"] = $client->fail()->getMessage();
                                    echo json_encode($jsonRedirect);
                                    return;
                                }*/
                                    $client_update->telefone_05 = $each->numero;
                                    $client_update->save();
                                }
                                if ($key == 5) {
                                    /*$client->TELEFONE_06 = $each->numero;
                                if (!$client->save()) {
                                    $jsonRedirect["message"] = $client->fail()->getMessage();
                                    echo json_encode($jsonRedirect);
                                    return;
                                }*/
                                    $client_update->telefone_06 = $each->numero;
                                    $client_update->save();
                                }
                            endforeach;
                        }
                        if (isset($registro->emails)) {
                            foreach ($registro->emails as $each) :
                                $email = $each->email;
                            endforeach;
                            if (isset($email)) {
                                $client_update->email = $email;
                                $client_update->save();
                                /*$client->EMAIL = $email;
                            if (!$client->save()) {
                                $jsonRedirect["message"] = $client->fail()->getMessage();
                                echo json_encode($jsonRedirect);
                                return;
                            }*/
                            }
                        }
                    endforeach;

                    $link = explode("/", $data["url_redirect"]);

                    if (isset($link[4])) {
                        $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3] . "/" . $link[4];
                    } else {
                        $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3];
                    }

                    $this->message->info("Dados atualizados com sucesso...")->flash();
                    if ($data["search"] == 0) {
                        $jsonRedirect["redirect"] = url("/lista-de-trabalho/cliente/" . $data["filter_id"] . "/first");
                    } else {
                        $jsonRedirect["redirect"] = url($link_redirect);
                    }
                    echo json_encode($jsonRedirect);
                    return;
                }
            } else {

                $client = (new Client())->find("id=:id", "id={$data['client_id']}")->fetch();
                /*$clients = (new Client())->find("filter_id=:id", "id={$data['cod']}")->fetch(true);*/
                $client_cpf = cpfZeros($client->CPF);

                $client_beneficio = (new ClientBenefit())->find("client_id=:c", "c={$data['client_id']}")->fetch(true);

                if (isset($client_beneficio)) {
                    foreach ($client_beneficio as $client) {
                        $client->destroy();
                    }
                }

                $curl = curl_init();

                curl_setopt_array($curl, array(

                    //CURLOPT_URL => "http://consultas.ecorban.com/api/inss/cpf/40861686772",
                    CURLOPT_URL => "http://consultas.ecorban.com/api/inss/cpf/{$client_cpf}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "x-login: {$this->user->Account()->user_api}",
                        "x-api-key: {$this->user->Account()->password_api}",
                        "Accept: application/json",
                        "Content-Type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $json = json_decode($response);
                    //var_dump($json);exit;
                    // Loop para percorrer o Objeto
                    foreach ($json as $registro) {

                        if (isset($registro->beneficios)) {
                            foreach ($registro->beneficios as $each) :

                                $curl2 = curl_init();
                                curl_setopt_array($curl2, array(

                                    CURLOPT_URL => "http://consultas.ecorban.com/api/inss/beneficio/{$each->beneficio}",
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => "",
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => false,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "GET",
                                    CURLOPT_HTTPHEADER => array(
                                        "x-login: {$this->user->Account()->user_api}",
                                        "x-api-key: {$this->user->Account()->password_api}",
                                        "Accept: application/json",
                                        "Content-Type: application/json"
                                    ),
                                ));
                                $response2 = curl_exec($curl2);
                                $err2 = curl_error($curl2);

                                curl_close($curl2);

                                if ($err2) {
                                    echo "cURL Error #:" . $err2;
                                } else {


                                    $link = explode("/", $data["url_redirect"]);

                                    if (isset($link[4])) {
                                        $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3] . "/" . $link[4];
                                    } else {
                                        $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3];
                                    }

                                    $json2 = json_decode($response2);

                                    //echo "<br>======================================<br>";
                                    //var_dump($json2); exit;
                                    foreach ($json2 as $registro2) {
                                        $situacaoBeneficio = "";
                                        $dib = "";
                                        $valorBeneficio = "";
                                        $codigo = "";
                                        $descricao = "";
                                        $codigo_agencia = "";
                                        $codigo_banco = "";
                                        $numero_conta = "";
                                        if (isset($registro2->beneficio)) {
                                            $beneficio = $registro2->beneficio;
                                            if (isset($registro2->situacaoBeneficio)) {
                                                $situacaoBeneficio = $registro2->situacaoBeneficio;
                                            }
                                            if (isset($registro2->dib)) {
                                                $dib = $registro2->dib;
                                            }
                                            if (isset($registro2->valorBeneficio)) {
                                                $valorBeneficio = $registro2->valorBeneficio;
                                            }
                                            $arguments1[] = $registro2->especie;
                                            if (isset($registro2->especie)) {
                                                foreach ($arguments1 as $each2) {
                                                    if (isset($each2->codigo)) {
                                                        $codigo = $each2->codigo;
                                                    }
                                                    if (isset($each2->descricao)) {
                                                        $descricao = $each2->descricao;
                                                    }
                                                }
                                            }

                                            $arguments2[] = $registro2->dadosBancarios;
                                            if (isset($registro2->dadosBancarios)) {
                                                foreach ($arguments2 as $banco) {
                                                    if (isset($banco->banco)) {
                                                        $arguments_banco[] = $banco->banco;
                                                        foreach ($arguments_banco as $each_banco) {
                                                            $codigo_banco = $each_banco->codigo;
                                                        }
                                                    }
                                                    if (isset($banco->agencia)) {
                                                        $arguments_agencia[] = $banco->agencia;
                                                        foreach ($arguments_agencia as $each_agencia) {
                                                            $codigo_agencia = $each_agencia->codigo;
                                                        }
                                                    }
                                                    if (isset($banco->meioPagamento)) {
                                                        $arguments_meio_pagamento[] = $banco->meioPagamento;
                                                        foreach ($arguments_meio_pagamento as $each_meio_pagamento) {
                                                            $numero_conta = $each_meio_pagamento->numero;
                                                        }
                                                    }
                                                }
                                            }

                                            $client_benefit = new ClientBenefit();
                                            $client_benefit->client_id = $data['client_id'];
                                            $client_benefit->benefit_number = $beneficio;
                                            $client_benefit->benefit_cod = $codigo;
                                            $client_benefit->nome = $descricao;
                                            $client_benefit->situacao_beneficio = $situacaoBeneficio;
                                            $client_benefit->dib = $dib;
                                            $client_benefit->valor = $valorBeneficio;
                                            $client_benefit->banco = $codigo_banco;
                                            $client_benefit->agencia = $codigo_agencia;
                                            $client_benefit->conta = $numero_conta;
                                            $client_benefit->account_id = $this->user->account_id;

                                            if (!$client_benefit->save()) {
                                                $jsonRedirect["message"] = $client_benefit->fail()->getMessage();
                                                echo json_encode($jsonRedirect);
                                                return;
                                            }
                                        }

                                        $numero_contrato = "";
                                        $banco_empres = "";
                                        $dataInicioContrato = "";
                                        $valorEmprestado = "";
                                        $quantidadeParcelas = "";
                                        $quantidadeParcelasEmAberto = "";
                                        $saldoQuitacao = "";
                                        $taxa = "";
                                        $competenciaInicioDesconto = "";
                                        $competenciaFimDesconto = "";
                                        $valorParcela = "";

                                        if (isset($registro2->contratosEmprestimo)) {
                                            foreach ($registro2->contratosEmprestimo as $contrato) {
                                                if (isset($contrato->contrato)) {
                                                    $numero_contrato = $contrato->contrato;
                                                }
                                                if (isset($contrato->banco)) {
                                                    $arguments3[] = $contrato->banco;
                                                    foreach ($arguments3 as $banco) {
                                                        $banco_empres = $banco->nome;
                                                    }
                                                }
                                                if (isset($contrato->dataInicioContrato)) {
                                                    $dataInicioContrato = $contrato->dataInicioContrato;
                                                }
                                                if (isset($contrato->valorEmprestado)) {
                                                    $valorEmprestado = $contrato->valorEmprestado;
                                                }
                                                if (isset($contrato->quantidadeParcelas)) {
                                                    $quantidadeParcelas = $contrato->quantidadeParcelas;
                                                }
                                                //prazo
                                                if (isset($contrato->valorParcela)) {
                                                    $valorParcela = $contrato->valorParcela;
                                                }
                                                if (isset($contrato->quantidadeParcelasEmAberto)) {
                                                    $quantidadeParcelasEmAberto = $contrato->quantidadeParcelasEmAberto;
                                                }
                                                if (isset($contrato->saldoQuitacao)) {
                                                    $saldoQuitacao = $contrato->saldoQuitacao;
                                                }
                                                if (isset($contrato->taxa)) {
                                                    $taxa = $contrato->taxa;
                                                }
                                                if (isset($contrato->competenciaInicioDesconto)) {
                                                    $competenciaInicioDesconto = $contrato->competenciaInicioDesconto;
                                                }
                                                if (isset($contrato->competenciaFimDesconto)) {
                                                    $competenciaFimDesconto = $contrato->competenciaFimDesconto;
                                                }

                                                $cliente_loan = new ClientLoan();
                                                $cliente_loan->client_id = $data['client_id'];
                                                $cliente_loan->contrato = $numero_contrato;
                                                $cliente_loan->banco = $banco_empres;
                                                $cliente_loan->inicio_contrato = $dataInicioContrato;
                                                $cliente_loan->valor = $valorEmprestado;
                                                $cliente_loan->parcela = $quantidadeParcelas;
                                                $cliente_loan->parcela_aberta = $quantidadeParcelasEmAberto;
                                                $cliente_loan->valor_parcela = $valorParcela;
                                                $cliente_loan->quitacao = $saldoQuitacao;
                                                $cliente_loan->taxa = $taxa;
                                                $cliente_loan->inicio_desconto = $competenciaInicioDesconto;
                                                $cliente_loan->termino_desconto = $competenciaFimDesconto;
                                                $cliente_loan->account_id = $this->user->account_id;
                                                $cliente_loan->save();
                                            }
                                        }
                                    }
                                }

                            endforeach;
                        }
                    }
                }


                $link = explode("/", $data["url_redirect"]);

                if (isset($link[4])) {
                    $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3] . "/" . $link[4];
                } else {
                    $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3];
                }

                $this->message->info("Dados atualizados com sucesso...")->flash();
                if ($data["search"] == 0) {
                    $jsonRedirect["redirect"] = url("/lista-de-trabalho/cliente/" . $data["filter_id"] . "/first");
                } else {
                    $jsonRedirect["redirect"] = url($link_redirect);
                }
                echo json_encode($jsonRedirect);
                return;
            }
        }

        // $response = file_get_contents("https://consulta.confirmeonline.com.br/IntegracaoRest/webresources/integracao/completo?usuario='MASTER11'&senha='bxTTvK2D'&sigla='TLIMP'&cpfcnpj={$client->CPF}&nome=''&telefone=''");
        //$response = json_decode($response);

        //var_dump($response);

    }

    public function clientAttendance(?array $data): void
    {

        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $data = (object)$post;

        $link = explode("/", $data->url_redirect);

        if (isset($link[4])) {
            $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3] . "/" . $link[4];
        } else {
            $link_redirect = "/" . $link[1] . "/" . $link[2] . "/" . $link[3];
        }

        $scheduling_id = null;

        $scheduling = (new Scheduling())->find("user_id=:u and client_id=:c", "u={$this->user->id}&c={$data->client_id}")->fetch();

        if ($scheduling) {
            $scheduling->destroy();
        }

        if ($data->attendance_retorn == 5) {

            $blocked_client = new BlockedClient();
            $blocked_client->client_id = $data->client_id;
            $blocked_client->motivo = $data->attendance_retorn;
            $blocked_client->account_id = $this->user->account_id;
            $blocked_client->status = 1;
            if (!$blocked_client->save()) {
                //$json["message"] = "Não foi possível fazer o atendimento!";
                $json["message"] = $blocked_client->fail()->getMessage();
                echo json_encode($json);
                return;
            }


            $filter_client_user_delete = (new FilterClientUser())->find("filter_id=:filter_id and user_id=:user", "filter_id={$data->filter_id}&user={$this->user->id}")->fetch();
            if (isset($filter_client_user_delete)) {
                $filter_client_user_delete->destroy();
            }

            $attendance = new Attendance();

            $attendance->client_id = $data->client_id;
            $attendance->user_id = $this->user->id;
            $attendance->filter_id = $data->filter_id;
            $attendance->phone = $data->cel;
            $attendance->attendance_return_id = $data->attendance_retorn;
            $attendance->scheduling_id = $scheduling_id;
            $attendance->description = $data->description;
            $attendance->account_id = $this->user->account_id;
            $attendance->status = 1;


            if (!$attendance->save()) {
                //$json["message"] = "Não foi possível gerar o atendimento!";
                $json["message"] = $attendance->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $filter_queue = (new FilterQueue())->find("client_id=:c and filter_id=:f", "c={$data->client_id}&f={$data->filter_id}")->fetch();
            $filter_queue->attendance_finish = 1;
            $filter_queue->save();


            $filter_id = 0;
            /*if ($data->filter_id) {
                $filter_id = $data->filter_id;
                $qtd_client = (new FilterQueue())->find("filter_id=:f", "f={$data->filter_id}")->count();
                $qtd_attendance = (new Attendance())->countAttendanceByFilter($filter_id);

                foreach ($qtd_attendance as $each_attandance) {
                    if ($each_attandance->count_client == $qtd_client) {
                        $filter = (new ModelsFilter())->find("id=:f", "f={$data->filter_id}")->fetch();
                        $filter->status = 2;
                        $filter->status_filter = "ENCERRADO";
                        $filter->save2();
                    }
                }
            }*/
            $filter_queue_count = (new FilterQueue())->find("filter_id=:f and attendance_finish=0", "f={$data->filter_id}")->count();
            if ($filter_queue_count == 0) {
                $filter_queue_detroy = (new FilterQueue())->find("filter_id=:f", "f={$data->filter_id}")->fetch(true);

                if (isset($filter_queue_detroy)) {
                    foreach ($filter_queue_detroy as $filter_queue_detroy_each) {
                        $filter_queue_detroy_each->destroy();
                    }
                }

                $filter = (new ModelsFilter())->find("id=:f", "f={$data->filter_id}")->fetch();
                if ($filter) {
                    $filter->status_filter = "ENCERRADO";
                    $filter->save2();
                }
            }

            $this->message->info("Dados atualizados com sucesso...")->flash();
            if ($data->search == 0) {
                $jsonRedirect["redirect"] = url("/lista-de-trabalho/cliente/" . $data->filter_id . "/first");
            } else {
                $jsonRedirect["redirect"] = url($link_redirect);
            }
            echo json_encode($jsonRedirect);
            return;
        }

        if ($data->attendance_retorn == 16) {
            $filter_queue = (new FilterQueue())->find("client_id=:c and filter_id=:f", "c={$data->client_id}&f={$data->filter_id}")->fetch();
            $filter_queue->attendance_finish = 1;
            $filter_queue->save();

            $filter_queue_consult = new FilterQueueConsult();
            $filter_queue_consult->client_id = $data->client_id;
            $filter_queue_consult->user_id = $this->user->id;
            $filter_queue_consult->account_id    = $this->user->account_id;
            $filter_queue_consult->status = 1;
            if (!$filter_queue_consult->save()) {
                $json["message"] = $filter_queue_consult->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $filter_client_user_delete = (new FilterClientUser())->find("filter_id=:filter_id and user_id=:user", "filter_id={$data->filter_id}&user={$this->user->id}")->fetch();
            if (isset($filter_client_user_delete)) {
                $filter_client_user_delete->destroy();
            }
        }

        if ($data->attendance_retorn == 9 || $data->attendance_retorn == 12 || $data->attendance_retorn == 15 || $data->attendance_retorn == 16 || $data->attendance_retorn == 13) {
            $filter_queue_consult = new FilterQueueConsult();
            $filter_queue_consult->client_id = $data->client_id;
            $filter_queue_consult->user_id = $this->user->id;
            $filter_queue_consult->account_id    = $this->user->account_id;
            $filter_queue_consult->status = 1;
            if (!$filter_queue_consult->save()) {
                $json["message"] = $filter_queue_consult->fail()->getMessage();
                echo json_encode($json);
                return;
            }
        }
        /*$attendance_count =(new Attendance())->find("user_id=:user and client_id=:client","user={}&client={}");

        if($attendance_count->count()==$data->count_cel){

        }*/

        if ($data->attendance_retorn == 14) {

            $scheduling = new Scheduling();
            $scheduling->client_id = $data->client_id;
            $scheduling->phone = $data->cel;
            $scheduling->attendance_return_id = $data->attendance_retorn;
            $scheduling->date_return = date_fmt_back($data->date_return);
            $scheduling->user_id = $data->scheduling_for;
            $scheduling->account_id = $this->user->account_id;
            $scheduling->status = 1;


            if (!$scheduling->save()) {
                $json["message"] = "Não foi possível gerar o atendimento!";
                //$json["message"] = $filterCreate->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $scheduling_id = $scheduling->id;

            $filter_client_user_delete = (new FilterClientUser())->find("filter_id=:filter_id and user_id=:user", "filter_id={$data->filter_id}&user={$this->user->id}")->fetch();
            if (isset($filter_client_user_delete)) {
                $filter_client_user_delete->destroy();
            }
        }

        $attendance = new Attendance();

        $attendance->client_id = $data->client_id;
        $attendance->user_id = $this->user->id;
        $attendance->filter_id = $data->filter_id;
        $attendance->phone = $data->cel;
        $attendance->attendance_return_id = $data->attendance_retorn;
        $attendance->scheduling_id = $scheduling_id;
        $attendance->description = $data->description;
        $attendance->account_id = $this->user->account_id;
        $attendance->status = 1;


        if (!$attendance->save()) {
            //$json["message"] = "Não foi possível gerar o atendimento!";
            $json["message"] = $attendance->fail()->getMessage();
            echo json_encode($json);
            return;
        }


        $filter_id = 0;
        /*if ($data->filter_id) {
            $filter_id = $data->filter_id;
            $qtd_client = (new FilterQueue())->find("filter_id=:f", "f={$data->filter_id}")->count();
            $qtd_attendance = (new Attendance())->countAttendanceByFilter($filter_id);

            foreach ($qtd_attendance as $each_attandance) {
                if ($each_attandance->count_client == $qtd_client) {
                    $filter = (new ModelsFilter())->find("id=:f", "f={$data->filter_id}")->fetch();
                    $filter->status = 2;
                    $filter->status_filter = "ENCERRADO";
                    $filter->save2();
                }
            }
        }*/

        $filter_queue_count = (new FilterQueue())->find("filter_id=:f and attendance_finish=0", "f={$data->filter_id}")->count();
        if ($filter_queue_count == 0) {
            $filter_queue_detroy = (new FilterQueue())->find("filter_id=:f", "f={$data->filter_id}")->fetch(true);

            if (isset($filter_queue_detroy)) {
                foreach ($filter_queue_detroy as $filter_queue_detroy_each) {
                    $filter_queue_detroy_each->destroy();
                }
            }

            $filter = (new ModelsFilter())->find("id=:f", "f={$data->filter_id}")->fetch();
            if ($filter) {
                $filter->status_filter = "ENCERRADO";
                $filter->save2();
            }
        }

        $this->message->info("Dados atualizados com sucesso...")->flash();
        if ($data->search == 0) {
            $jsonRedirect["redirect"] = url("/lista-de-trabalho/cliente/" . $data->filter_id . "/first");
        } else {
            $jsonRedirect["redirect"] = url("/cliente/consulta/" . $data->client_id);
        }
        echo json_encode($jsonRedirect);
        return;
    }


    public function attendance(?array $data): void
    {
        $attendances = (new Attendance())->find("account_id=:id and status!=2", "id={$this->user->account_id}")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Atendimentos",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/attendance", [
            "menu" => "attendances",
            "submenu" => "attendances",
            "head" => $head,
            "attendances" => $attendances
        ]);
    }

    public function scheduling(?array $data): void
    {
        $schedulings = (new Scheduling())->find("account_id=:id and status!=2", "id={$this->user->account_id}")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Agendamentos",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/scheduling", [
            "menu" => "schedulings",
            "submenu" => "schedulings",
            "head" => $head,
            "schedulings" => $schedulings
        ]);
    }
    public function resumo(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "search") {
            $jsonRedirect["redirect"] = url("/resumo/search/" . date_fmt_back($data["inicial_date"]) . "/" . date_fmt_back($data["final_date"]));
            echo json_encode($jsonRedirect);
            return;
        }

        $inicial_date = Date("Y-m-01");

        $final_date = Date("Y-m-t");

        $users = (new User())->find("account_id=:id", "id={$this->user->account_id}")->order("id")->fetch(true);

        $countAttendanceByUser = (new User())->countAttendanceByUser($inicial_date, $final_date);

        $attendance_returns = (new AttendanceReturn())->find()->order("id")->fetch(true);

        $countAttendanceByReturn = (new Attendance())->countAttendanceByReturn($inicial_date, $final_date);

        $inicial_date = Date("01/m/Y");

        $final_date = Date("t/m/Y");

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Resumo",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/resumo", [
            "menu" => "resumo",
            "submenu" => "resumo",
            "head" => $head,
            "users" => $users,
            "countAttendanceByUser" => $countAttendanceByUser,
            "attendance_returns" => $attendance_returns,
            "countAttendanceByReturn" => $countAttendanceByReturn,
            "inicial_date" => $inicial_date,
            "final_date" => $final_date
        ]);
    }

    public function resumoSearch(?array $data): void
    {
        $users = (new User())->find("account_id=:id", "id={$this->user->account_id}")->order("id")->fetch(true);

        $countAttendanceByUser = (new User())->countAttendanceByUser($data['inicial_date'], $data['final_date']);

        $attendance_returns = (new AttendanceReturn())->find()->order("id")->fetch(true);

        $countAttendanceByReturn = (new Attendance())->countAttendanceByReturn($data['inicial_date'], $data['final_date']);

        $inicial_date = date_fmt_br($data['inicial_date']);

        $final_date = date_fmt_br($data['final_date']);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Resumo",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/resumo", [
            "menu" => "resumo",
            "submenu" => "resumo",
            "head" => $head,
            "users" => $users,
            "countAttendanceByUser" => $countAttendanceByUser,
            "attendance_returns" => $attendance_returns,
            "countAttendanceByReturn" => $countAttendanceByReturn,
            "inicial_date" => $inicial_date,
            "final_date" => $final_date
        ]);
    }

    public function search(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "search") {
            if (empty($data["inicial_date"]) || empty($data["final_date"])) {
                $json["message"] = "Preencha as duas datas";
                echo json_encode($json);
                return;
            }
            $jsonRedirect["redirect"] = url("/consulta/search/" . date_fmt_back($data["inicial_date"]) . "/" . date_fmt_back($data["final_date"]));
            echo json_encode($jsonRedirect);
            return;
        }

        $inicial_date = Date("Y-m-01");

        $final_date = Date("Y-m-t");

        $search = (new ClientSearch())->find("account_id=:id and status!=2 and created_at between :ini and :fim  ", "id={$this->user->account_id}&ini={$inicial_date}&fim={$final_date}")->fetch(true);

        $inicial_date = Date("01/m/Y");

        $final_date = Date("t/m/Y");

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Consulta",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/search", [
            "menu" => "search",
            "submenu" => "search",
            "head" => $head,
            "searchs" => $search,
            "inicial_date" => $inicial_date,
            "final_date" => $final_date
        ]);
    }

    public function searchSearch(?array $data): void
    {

        $inicial_date = date_fmt_back($data["inicial_date"]);

        $final_date = date_fmt_back($data["final_date"]);

        $search = (new ClientSearch())->find("account_id=:id and status!=2 and created_at between :ini and :fim  ", "id={$this->user->account_id}&ini={$inicial_date}&fim={$final_date}")->fetch(true);

        $inicial_date = date_fmt($data["inicial_date"]);

        $final_date = date_fmt($data["final_date"]);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Consulta",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/search", [
            "menu" => "search",
            "submenu" => "search",
            "head" => $head,
            "searchs" => $search,
            "inicial_date" => $inicial_date,
            "final_date" => $final_date
        ]);
    }

    public function consultApi(?array $data): void
    {

        /*$curl = curl_init();
        curl_setopt_array($curl, array(

            CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cnpj/40503887000155",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "x-login: sistemacred",
                "x-api-key: Sist3m@Cred",
                "Accept: application/json",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // Decodifica o formato JSON e retorna um Objeto
            //var_dump($response);
            $json = json_decode($response);
            var_dump($json);
            // Loop para percorrer o Objeto
    
        }
        exit;*/
        if (!empty($data["action"])) {
            if ($data["s"] == "" && $data["s2"] == "" && $data["s3"] == "") {
                $json["message"] = "Preencha um dos campos ou CPF ou CNPJ ou Telefone";
                echo json_encode($json);
                return;
            }

            if ($data["s"] != "" && $data["s2"] != "") {
                $json["message"] = "Você só pode preencher um dos campos, ou CPF ou CNPJ";
                echo json_encode($json);
                return;
            }

            if ($data["s"] != "") {
                echo json_encode(["redirect" => url("/consulta-api/{$data["s"]}/cpf")]);
                return;
            }
            if ($data["s2"] != "") {
                echo json_encode(["redirect" => url("/consulta-api/{$data["s2"]}/cnpj")]);
                return;
            }
            if ($data["s3"] != "") {
                echo json_encode(["redirect" => url("/consulta-api/{$data["s3"]}/telefone")]);
                return;
            }
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Consulta API",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("filters/consult_api", [
            "menu" => "consultApi",
            "submenu" => "consultApi",
            "head" => $head,
            "searchs" => "",
            "searchs_input" => "",
            "type" => ""
        ]);
    }

    public function consultApiSearch(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $curl = curl_init();
        if ($data["type"] == "cpf") {
            curl_setopt_array($curl, array(

                CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cpf/{$data["search"]}",
                //CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/telefone?ddd=21&numero=982673971",
                //CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cnpj/34228016000178",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "x-login: {$this->user->Account()->user_api}",
                    "x-api-key: {$this->user->Account()->password_api}",
                    "Accept: application/json",
                    "Content-Type: application/json"
                ),
            ));
        }
        if ($data["type"] == "cnpj") {
            curl_setopt_array($curl, array(

                CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cnpj/{$data["search"]}",
                //CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cnpj/34228016000178",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "x-login: {$this->user->Account()->user_api}",
                    "x-api-key: {$this->user->Account()->password_api}",
                    "Accept: application/json",
                    "Content-Type: application/json"
                ),
            ));
        }
        if ($data["type"] == "telefone") {
            $info_search = $data["search"];
            $info_type = $data["type"];

            $search1 = str_replace('(', '', $data["search"]);
            $search2 = str_replace(')', '', $search1);
            $search3 = str_replace('-', '', $search2);
            $search4 = substr($search3, 0, 2);
            $search5 = substr($search3, 2, 10);

            curl_setopt_array($curl, array(
                // telefone?ddd={ddd}&numero={numero}
                CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/telefone?ddd={$search4}&numero={$search5}",
                //CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cnpj/34228016000178",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "x-login: {$this->user->Account()->user_api}",
                    "x-api-key: {$this->user->Account()->password_api}",
                    "Accept: application/json",
                    "Content-Type: application/json"
                ),
            ));


            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                // Decodifica o formato JSON e retorna um Objeto
                $json = json_decode($response);

                //var_dump($json);exit;
                // Loop para percorrer o Objeto

                foreach ($json as $search) {

                    if (empty($search)) {
                        $head = $this->seo->render(
                            CONF_SITE_NAME . " | Consulta API",
                            CONF_SITE_DESC,
                            url("/"),
                            url("/assets/images/image.png"),
                            false
                        );

                        echo $this->view->render("filters/consult_api", [
                            "menu" => "consultApi",
                            "submenu" => "consultApi",
                            "head" => $head,
                            "searchs" => '',
                            "searchs_input" => $info_search,
                            "type" => $info_type
                        ]);
                        exit;
                    }

                    //var_dump($search['bool']);
                    if (isset($search[0])) {

                        $data = (array) $search[0];

                        foreach ($data as $data2) {
                            $data3 = json_decode($data2);
                            $data4 = (array) $data3;
                            foreach ($data4 as $data5) {
                                $curl2 = curl_init();
                                curl_setopt_array($curl2, array(

                                    CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cpf/{$data5}",
                                    //CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/telefone?ddd=21&numero=982673971",
                                    //CURLOPT_URL => "http://consultas.ecorban.com/api/dados-cadastrais/cnpj/34228016000178",
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => "",
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => false,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "GET",
                                    CURLOPT_HTTPHEADER => array(
                                        "x-login: {$this->user->Account()->user_api}",
                                        "x-api-key: {$this->user->Account()->password_api}",
                                        "Accept: application/json",
                                        "Content-Type: application/json"
                                    ),
                                ));


                                $response2 = curl_exec($curl2);
                                $err2 = curl_error($curl2);

                                curl_close($curl2);

                                if ($err2) {
                                    echo "cURL Error #:" . $err2;
                                } else {
                                    // Decodifica o formato JSON e retorna um Objeto
                                    $json2 = json_decode($response2);

                                    $head = $this->seo->render(
                                        CONF_SITE_NAME . " | Consulta API",
                                        CONF_SITE_DESC,
                                        url("/"),
                                        url("/assets/images/image.png"),
                                        false
                                    );

                                    echo $this->view->render("filters/consult_api", [
                                        "menu" => "consultApi",
                                        "submenu" => "consultApi",
                                        "head" => $head,
                                        "searchs" => $json2,
                                        "searchs_input" => $info_search,
                                        "type" => $info_type
                                    ]);
                                }
                            }
                        }
                    }
                }
            }


            exit;
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // Decodifica o formato JSON e retorna um Objeto
            $json = json_decode($response);

            $head = $this->seo->render(
                CONF_SITE_NAME . " | Consulta API",
                CONF_SITE_DESC,
                url("/"),
                url("/assets/images/image.png"),
                false
            );

            echo $this->view->render("filters/consult_api", [
                "menu" => "consultApi",
                "submenu" => "consultApi",
                "head" => $head,
                "searchs" => $json,
                "searchs_input" => $data["search"],
                "type" => $data["type"]
            ]);
        }
    }

    public function filterClientPdf(?array $data): void
    {

        $dompdf = new Dompdf();

        //echo $data["id_cliente"];

        $client = (new Client())->find("id=:id", "id={$data['id_cliente']}")->fetch();

        $client_contract = $client->returnClientContract($client->CLIENT_ORGAN);

        if ($client->CLIENT_ORGAN == 2) {
            $client_contract = $client->returnClientContractMarinha();
        }
        $nome_arquivo =  preg_replace('/[ -]+/', '_', $client->NOME);
        ob_start();
        if ($client->CLIENT_ORGAN == 1) {
            $nome_arquivo = "EXERCITO_" . $nome_arquivo;
            echo $this->view->render("pdf/pdfexercito", [
                "client" => $client,
                "client_contract" => $client_contract
            ]);
        }
        if ($client->CLIENT_ORGAN == 2) {
            $nome_arquivo = "MARINHA_" . $nome_arquivo;
            echo $this->view->render("pdf/pdfmarinha", [
                "client" => $client,
                "client_contract" => $client_contract
            ]);
        }
        if ($client->CLIENT_ORGAN == 3) {
            $nome_arquivo = "AERO_" . $nome_arquivo;
            echo $this->view->render("pdf/pdfaero", [
                "client" => $client,
                "client_contract" => $client_contract
            ]);
        }
        if ($client->CLIENT_ORGAN == 4) {
            $nome_arquivo = "SIAPE_" . $nome_arquivo;
            echo $this->view->render("pdf/pdfsiape", [
                "client" => $client,
                "client_contract" => $client_contract
            ]);
        }
        $dompdf->loadHtml(ob_get_clean());

        $dompdf->setPaper("A4", "landscape");

        $dompdf->render();
        $dompdf->stream("{$nome_arquivo}.pdf", ["Atachment" => false]);
    }
}

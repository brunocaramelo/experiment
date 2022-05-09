<?php

namespace Source\App;

use Source\Models\Account;
use Source\Models\User;
use Source\Models\Level;
use Source\Models\Genre;
use Source\Models\DocumentSecondaryComplement;
use Source\Models\UserLogin;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Description of Users
 *
 * @author Luiz
 */
class Users extends Admin
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
        //search redirect

        if (!empty($data["action"])) {
            if (!empty($data["s"])) {
                $users = (new User())->find(
                    "MATCH(first_name, last_name, email) AGAINST(:s) and account_id=:a and status!=2 and admin_account=0 and cliente=1",
                    "s={$data["s"]}&a={$this->user->account_id}"
                );

                $s = str_search($data["s"]);
                echo json_encode(["redirect" => url("/usuario/{$s}/1")]);
                return;
            } else {
                echo json_encode(["redirect" => url("/usuario")]);
                return;
            }
        }

        $search = null;
        $users = (new User())->find("admin_account=0 and status!=2 and client=1 and account_id=:a", "a={$this->user->account_id}");


        if (!empty($data["search"]) && str_search($data["search"]) != "todos") {
            $search = str_search($data["search"]);
            $users = (new User())->find("MATCH(first_name, last_name, email) AGAINST(:s) and account_id=:a and status!=2 and admin_account=0 and client=1", "s={$search}&a={$this->user->account_id}");
        }


        $all = ($search ?? "todos");
        $pager = new Pager(url("/usuario/{$all}/"));
        $pager->pager($users->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Usuários",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/home", [
            "menu" => "user",
            "submenu" => "home",
            "head" => $head,
            "search" => $search,
            "client" => $this->user->client,
            "user_admin" => $this->user->admin_account,
            "users" => $users->order("first_name, last_name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function user(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $user = User::UserLog();

            $base = null;

            $account = (new Account())->find("id=:c", "c={$data["account"]}")->fetch();

            if (isset($account)) {
                $base = $account->base;
            }

            $userAccount = (new User())->find("account_id=:a and status!=2", "a={$account->id}")->count();

            if ($userAccount == $account->login || $userAccount > $account->login) {
                $json["message"] = "Essa conta já atingiu o limite de usuários.";
                echo json_encode($json);
                return;
            }

            $userCreate = new User();
            $userCreate->user_name = $data["user_name"];
            $userCreate->document_secondery = $data["document_secondary"];
            $userCreate->document_secondary_complement = $data["document_secondary_complement"];
            $userCreate->shipping_date = date_fmt_back($data["shipping_date"]);
            $userCreate->first_name = str_title($data["first_name"]);
            $userCreate->last_name = str_title($data["last_name"]);
            $userCreate->zip_code = preg_replace("/[^0-9]/", "", $data["zipcode"]);
            $userCreate->street = $data["street"];
            $userCreate->number = $data["number"];
            $userCreate->complement = $data["complement"];
            $userCreate->district = $data["district"];
            $userCreate->state = $data["state"];
            $userCreate->city = $data["city"];
            $userCreate->email = $data["email"];
            $userCreate->cel_phone = $data["cel"];
            $userCreate->password = "12345678";
            $userCreate->level_id = $data["level"];
            $userCreate->genre = $data["genre"];
            $userCreate->datebirth = date_fmt_back($data["datebirth"]);
            $userCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            //$userCreate->status = $data["status"];
            $userCreate->account_id = $data["account"];
            $userCreate->admin_account = 0;
            $userCreate->validate = 0;
            $userCreate->password_validate = 0;
            $userCreate->client = 1;
            $userCreate->base_client = $base;

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userCreate->photo = $image;
            }

            if (!$userCreate->save()) {
                if (!empty($_FILES["photo"])) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userCreate->photo}");
                }

                $json["message"] = $userCreate->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Usuário cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/usuario/cadastrar");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userUpdate = (new User())->findById($data["user_id"]);

            if (!$userUpdate) {
                echo json_encode(["redirect" => url("/usuario")]);
                return;
            }


            $userUpdate->user_name = $data["user_name"];
            $userUpdate->document_secondery = $data["document_secondary"];
            $userUpdate->document_secondary_complement = $data["document_secondary_complement"];
            $userUpdate->shipping_date = date_fmt_back($data["shipping_date"]);
            $userUpdate->first_name = str_title($data["first_name"]);
            $userUpdate->last_name = str_title($data["last_name"]);
            $userUpdate->zip_code = preg_replace("/[^0-9]/", "", $data["zipcode"]);
            $userUpdate->street = $data["street"];
            $userUpdate->number = $data["number"];
            $userUpdate->complement = $data["complement"];
            $userUpdate->district = $data["district"];
            $userUpdate->state = $data["state"];
            $userUpdate->city = $data["city"];
            $userUpdate->email = $data["email"];
            $userUpdate->cel_phone = $data["cel"];
            $userUpdate->genre = $data["genre"];
            $userUpdate->datebirth = date_fmt_back($data["datebirth"]);
            $userUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);

            if ($this->user->admin_account == 1 || $this->user->client == 0) {
                $userUpdate->level_id = $data["level"];
            }
            $userUpdate->validate = 1;

            //upload photo
            if (!empty($_FILES["photo"])) {

                if ($userUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}");
                    (new Thumb())->flush($userUpdate->photo);
                }


                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userUpdate->photo = $image;
            }

            if (!$userUpdate->save()) {
                $json["message"] = $userUpdate->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Usuário atualizado com sucesso...")->flash();
            echo json_encode(["redirect" => url("/usuario/alterar/{$data["user_id"]}")]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userDelete = (new User())->findById($data["user_id"]);

            if (!$userDelete) {
                $this->message->info("Você tentou deletar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/usuario")]);
                return;
            }

            if ($userDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}");
                (new Thumb())->flush($userDelete->photo);
            }

            $userLogin = (new UserLogin())->find("user_id=:user", "user={$userDelete->id}")->fetch(true);

            if ($userLogin) {
                foreach ($userLogin as $eachUserLogin) {
                    $eachUserLogin->destroy();
                }
            }


            $userDelete->status = 2;

            $userDelete->save();


            $this->message->info("O usuário foi excluído com sucesso")->flash();
            $json["redirect"] = url("/usuario");

            echo json_encode($json);
            return;
        }

        $userEdit = null;
        if (!empty($data["user_id"])) {
            $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
            $userEdit = (new User())->findById($userId);

            if ($userEdit == null) {
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
                "user_validate" => 1
            ]);
        } else {

            if ($this->user->client == 0) {

                $head = $this->seo->render(
                    CONF_SITE_NAME . " | " . "Cadastrar Usuário",
                    CONF_SITE_DESC,
                    url("/"),
                    url("/assets/images/image.png"),
                    false
                );

                $level = (new Level())->find()->fetch(true);
                $genres = (new Genre())->find()->order("description")->fetch(true);
                $document_secondary_complements = (new DocumentSecondaryComplement())->find()->order("description")->fetch(true);
                $accounts = (new Account())->find("status!=2 and description!='Admin'")->fetch(true);

                //var_dump($genres);
                //var_dump($document_secondary_complements);

                echo $this->view->render("users/user", [
                    "menu" => "user",
                    "submenu" => "home",
                    "head" => $head,
                    "user" => $userEdit,
                    "genres" => $genres,
                    "accounts" => $accounts,
                    "document_secondary_complements" => $document_secondary_complements,
                    "level" => $level
                ]);
            } else {
                redirect("/dash");
            }
        }
    }

    /**
     * Alteração de senha
     * @param array|null $data
     */
    public function passwordChange(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //change password
        if (!empty($data["action"]) && $data["action"] == "change") {

            /*if (!empty($data['csrf'])) {

                if ($_REQUEST && !csrf_verify($_REQUEST)) {

                    $json["message"] = "Erro ao enviar o formulário, atualize a página";
                    echo json_encode($json);
                    return;
                }
            }*/

            if ($this->user->client == 1) {
                $user_email = (new User())->find("account_id=:c and id=:id", "c={$this->user->account_id}&id={$data['id']}")->fetch();
            } else {
                $user_email = (new User())->find("id=:id", "id={$data['id']}")->fetch();
            }

            $user_email->password = $data["new_password"];

            if (!$user_email->changePasswordAdmin($data["password_confirm"])) {
                $json["message"] = $user_email->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Sua senha foi alterada com sucesso")->flash();
            echo json_encode(["redirect" => url("/usuario/alterar/{$user_email->id}")]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . "Usuários Alteração de Senha",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/user_password_change", [
            "menu" => "user",
            "submenu" => "password_change",
            "head" => $head,
            "cod_user" => $this->user->cod
        ]);
    }



    /**
     * @param array|null $data
     */
    public function account(): void
    {

        /*if($this->user->account()->status_admin="0"){
         $accounts = (new Account())->find("status!=2 and description<>'Admin'")->fetch(true);
        }else{
         $accounts = (new Account())->find("status!=2 and description<>'Admin' and status_admin=1")->fetch(true); 
        }*/
        $accounts = (new Account())->find("status!=2 and description<>'Admin'")->fetch(true);


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Clientes",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/account", [
            "menu" => "user",
            "submenu" => "home",
            "head" => $head,
            "accounts" => $accounts
        ]);
    }

    public function accountUser(array $data): void
    {
        //search redirect

        if (!empty($data["action"])) {
            if (!empty($data["s"])) {
                $users = (new User())->find(
                    "MATCH(first_name, last_name, email) AGAINST(:s) and status!=2 and admin_account=0 and cliente=1 and account_id=:account_id",
                    "s={$data["s"]}&account_id={$data["account_id"]}"
                );

                $s = str_search($data["s"]);
                echo json_encode(["redirect" => url("/clientes/usuario/{$data["account_id"]}/{$s}/1")]);
                return;
            } else {
                echo json_encode(["redirect" => url("/clientes/usuario/{$data["account_id"]}")]);
                return;
            }
        }

        $search = null;
        $users = (new User())->find("admin_account=0 and status!=2 and client=1 and account_id=:account_id", "account_id={$data["account_id"]}");


        if (!empty($data["search"]) && str_search($data["search"]) != "todos") {
            $search = str_search($data["search"]);
            $users = (new User())->find("MATCH(first_name, last_name, email) AGAINST(:s) and status!=2 and admin_account=0 and client=1 and account_id=:account_id", "s={$search}&account_id={$data["account_id"]}");
        }


        $all = ($search ?? "todos");
        $pager = new Pager(url("/clientes/usuario/{$data["account_id"]}/{$all}/"));
        $pager->pager($users->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Usuários",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/client_users", [
            "menu" => "user",
            "submenu" => "home",
            "head" => $head,
            "search" => $search,
            "client" => $this->user->client,
            "user_admin" => $this->user->admin_account,
            "users" => $users->order("first_name, last_name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render(),
            "account_id" => $data["account_id"]
        ]);
    }

    public function accountAdd(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Clientes Cadastrar",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/account_add", [
            "menu" => "user",
            "submenu" => "home",
            "head" => $head
        ]);
    }

    public function accountCreat(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if ($this->user->email == "adm2@sistemacred.com") {
            $status_admin = "1";
        } else {
            $status_admin = "0";
        }

        $account = new Account();
        $account->description = str_title($data["company_name"]);
        $account->document = preg_replace("/[^0-9]/", "", $data["document"]);
        $account->uf = $data["uf"];
        $account->email = $data["email"];
        $account->cel = $data["cel"];
        $account->tel = $data["tel"];
        $account->use_api = $data["use_api"];
        if ($data["use_api"] == 1) {
            $account->api = $data["api"];
            if ($data["api"] == 1) {
                $account->user_api = $data["user_econsig"];
                $account->sigla_api = null;
                $account->password_api = $data["password_econsig"];
            }else{
                $account->user_api = $data["user_credlink"];
                $account->sigla_api = $data["sigla_credlink"];
                $account->password_api = $data["password_credlink"];
            }
        } else {
            $account->user_api =  null;
            $account->sigla_api =  null;
            $account->password_api =  null;
            $account->api = null;
        }

        $account->login = $data["user_count"];
        $account->base = "sistem80_cred_base_03";
        $account->status_admin =  $status_admin;
        $account->status = "1";

        if (!$account->save()) {
            $json["message"] = $account->fail()->getMessage();
            echo json_encode($json);
            return;
        }

        $user = new User();
        $user->company_name = str_title($data["company_name"]);
        $user->email = $data["email"];
        $user->cel_phone = $data["cel"];
        $user->user_name = $data["company_name"];
        $user->state = $data["uf"];
        $user->email = $data["email"];
        $user->password = "12345678";
        $user->cel_phone = $data["cel"];
        $user->level_id = 1;
        $user->account_id = $account->id;
        $user->status = 1;
        $user->genre = 1;
        $user->client = 1;
        $user->admin_account = 1;
        $user->base_client = "sistem80_cred_base_03";
        $user->validate = 1;

        if (!$user->save3()) {
            $account->destroy();
            $json["message"] = $user->fail()->getMessage();
            echo json_encode($json);
            return;
        }

        $this->message->info("Cliente cadastrado com sucesso...")->flash();
        $json["redirect"] = url("/clientes/cadastrar");

        echo json_encode($json);
        return;
    }

    public function accountDelete(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $accountDelete = (new Account())->findById($data["account"]);

        if (!$accountDelete) {
            $this->message->info("Você tentou deletar uma conta que não existe")->flash();
            echo json_encode(["redirect" => url("/clientes")]);
            return;
        }

        $accountDelete->status = 2;

        $accountDelete->save();

        $userDelete = (new user())->find("account_id=:a", "a={$data["account"]}")->fetch(true);

        foreach ($userDelete as $each_user) {

            $userLogin = (new UserLogin())->find("user_id=:user", "user={$each_user->id}")->fetch(true);

            if ($userLogin) {
                foreach ($userLogin as $eachUserLogin) {
                    $eachUserLogin->destroy();
                }
            }

            $each_user->status = 2;

            $each_user->save();
        }


        $this->message->info("O cliente foi excluído com sucesso")->flash();
        $json["redirect"] = url("/clientes");

        echo json_encode($json);
        return;
    }

    public function accountUpdate(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $account = (new Account())->findById($data["account"]);

        if (!$account) {
            $this->message->info("Você tentou acessar uma conta que não existe")->flash();
            echo json_encode(["redirect" => url("/clientes")]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Clientes Alterar",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/account_update", [
            "menu" => "user",
            "submenu" => "home",
            "head" => $head,
            "account" => $account
        ]);
    }

    public function accountUpdated(array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $account = (new Account())->findById($data["account"]);

        if (!$account) {
            $this->message->info("Você tentou acessar uma conta que não existe")->flash();
            echo json_encode(["redirect" => url("/clientes")]);
            return;
        }

        $account->description = str_title($data["company_name"]);
        $account->document = preg_replace("/[^0-9]/", "", $data["document"]);
        $account->uf = $data["uf"];
        $account->email = $data["email"];
        $account->cel = $data["cel"];
        $account->tel = $data["tel"];
        $account->use_api = $data["use_api"];
        if ($data["use_api"] == 1) {
            $account->api = $data["api"];
            if ($data["api"] == 1) {
                $account->user_api = $data["user_econsig"];
                $account->sigla_api = null;
                $account->password_api = $data["password_econsig"];
            }else{
                $account->user_api = $data["user_credlink"];
                $account->sigla_api = $data["sigla_credlink"];
                $account->password_api = $data["password_credlink"];
            }
        } else {
            $account->user_api =  null;
            $account->sigla_api =  null;
            $account->password_api =  null;
            $account->api = null;
        }
        $account->login = $data["user_count"];

        if (!$account->save()) {
            $json["message"] = $account->fail()->getMessage();
            echo json_encode($json);
            return;
        }

        $user = (new User())->find("account_id=:a and admin_account=1", "a={$account->id}")->fetch();
        $user->email = $data["email"];
        $user->save2();

        $this->message->info("Cliente alterado com sucesso...")->flash();
        $json["redirect"] = url("/clientes/alterar/{$account->id}");

        echo json_encode($json);
        return;
    }

    public function accountAccess(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //$account = (new Account())->find($data["account"])->fetch();

        $account = (new Account())->find("id=:a", "a={$data["account"]}")->fetch();


        if (!isset($account)) {
            $this->message->info("Nenhum cliente acessando")->flash();
            echo json_encode(["redirect" => url("/clientes")]);
            return;
        }

        if (count($account->countAccessDetails()) == 0) {
            $this->message->info("Nenhum cliente acessando")->flash();
            redirect("/clientes");
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Clientes Acesso",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/account_access", [
            "menu" => "user",
            "submenu" => "home",
            "head" => $head,
            "account" => $account->countAccessDetails()
        ]);
    }

    public function accountAccessDelete(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $user_login = (new UserLogin())->find("user_id=:u", "u={$data['user']}")->fetch();
        $user_login->destroy();

        $this->message->info("Acesso excluído com sucesso...")->flash();
        $json["redirect"] = url("/clientes");

        echo json_encode($json);
        return;
    }

    public function statusAccount(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $account = (new Account())->findById($data['account']);
        $users = (new User())->find("account_id=:c and status<>2", "c={$data['account']}")->fetch(true);

        if ($account->status == 1) {
            //$accountAlter = (new account())->find("id=:id","id={$account->id}")->fetch();
            $account->status = 3;
            $account->save2();
            foreach ($users as $user) {
                $user->status = 3;
                $user->save2();
                $user_login = (new UserLogin())->find("user_id=:u", "u={$user->id}")->fetch();
                if ($user_login) {
                    $user_login->destroy();
                }
            }
            $this->message->info("Conta Desativada Com Sucesso")->flash();
        } else {
            $account->status = 1;
            $account->save2();
            foreach ($users as $user) {
                $user->status = 1;
                $user->save2();
            }
            $this->message->info("Conta Ativada Com Sucesso")->flash();
        }
        $json["redirect"] = url("/clientes");

        echo json_encode($json);
        return;
    }

    public function accountBloqued(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //$account = (new Account())->find($data["account"])->fetch();

        //$account = (new Account())->find("id=:a", "a={$data["account"]}")->fetch();

        $users = (new User())->find("account_id=:c and status!=2 and client=1 and admin_account=0 and error_code!=''", "c={$data["account"]}")->fetch(true);


        if (!isset($users)) {
            $this->message->info("Nenhum cliente bloqueado")->flash();
            echo json_encode(["redirect" => url("/clientes")]);
            return;
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Clientes Bloqueados",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("users/account_user_bloqued", [
            "menu" => "user",
            "submenu" => "home",
            "head" => $head,
            "users" => $users
        ]);
    }

    public function accountBloquedDelete(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $user = (new User())->find("id=:u", "u={$data['user']}")->fetch();
        $user->error_attempt = null;
        $user->error_code = null;
        $user->error_date = null;
        $user->save2();

        $this->message->info("Bloqueio excluído com sucesso...")->flash();
        $json["redirect"] = url("/clientes");

        echo json_encode($json);
        return;
    }
}

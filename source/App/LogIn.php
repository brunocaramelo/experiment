<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\User;
use Source\Models\UserLogin;
use Source\Support\Message;

/**
 * Description of LogIn
 *
 * @author Luiz
 */
class LogIn extends Controller
{

    public function __construct($router)
    {
        parent::__construct($router, CONF_VIEW_ADMIN);
    }

    /**
     * Admin access redirect
     */
    public function root(): void
    {
        $user = User::UserLog();

        if ($user) {
            redirect("/dash");
        } else {

            $head = $this->seo->render(
                CONF_SITE_NAME . " | Login",
                CONF_SITE_DESC,
                url("/"),
                theme("assets/images/image.png", CONF_VIEW_THEME_ADMIN),
                false
            );

            echo $this->view->render("login/login", [
                "head" => $head
            ]);
        }
            
    }

    /**
     * @param array|null $data
     */
    public function login1(?array $data): void
    {
        $user = User::UserLog();

        if ($user) {
            redirect("/dash");
        }

        if (!empty($data["email"])) {
            $user = new User();
            $login = $user->login1($data["email"]);


            if ($login) {
                //$json["redirect"] = url("/dash");
                $this->message->info($data["email"])->flash();
                $json["redirect"] = url("/login2");
            } else {
                $json["message"] = $user->fail()->getMessage();
            }
        }

        echo json_encode($json);
        return;
    }

    public function login2(?array $data): void
    {

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Login",
            CONF_SITE_DESC,
            url("/"),
            theme("/assets/images/image.png", CONF_VIEW_THEME_ADMIN),
            false
        );

        echo $this->view->render("login/login1", [
            "head" => $head
        ]);
    }
    /**
     * @param array|null $data
     */
    public function login(?array $data): void
    {
        $user = User::UserLog();

        if ($user) {
            redirect("/dash");
        }

        if (!empty($data["email"]) && !empty($data["password"])) {

            $user = new User();
            $login = $user->login($data["email"], $data["password"], true, 1);

            if ($login) {
                $json["redirect"] = url("/dash");
                $user = User::UserLog();
                $userLogin = new UserLogin();
                $userLogin->user_id = $user->id;
                $userLogin->ip = $_SERVER["REMOTE_ADDR"];
                $userLogin->save();

            } else {
                $json["message"] = $user->fail()->getMessage();
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Login",
            CONF_SITE_DESC,
            url("/"),
            theme("assets/images/image.png", CONF_VIEW_THEME_ADMIN),
            false
        );

        echo $this->view->render("login/login", [
            "head" => $head . 'Hello'
        ]);
    }

    /**
     * @param array|null $data
     */
    public function forget(?array $data): void
    {

        if (User::UserLog()) {
            redirect("/dash");
        }

        if (!empty($data['csrf'])) {
            if ($_REQUEST && !csrf_verify($_REQUEST)) {
                $json["message"] = "Erro ao enviar o formulário, atualize a página";
                echo json_encode($json);
                return;
            }

            if (in_array("", $data)) {
                $json["message"] = "Favor preencher todos os dados";
                echo json_encode($json);
                return;
            }

            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = (object) $post;

            $find = (new User)->find("datebirth=:datebirth and document=:document and email=:email", "datebirth=" . date_fmt_back($data->datebirth) . "&document=" . preg_replace("/[^0-9]/", "", $data->document) . "&email={$data->email}")->fetch();

            if (!empty($find->forget)) {
                $json["message"] = "Uma requisição de nova senha já foi enviada para esse e-mail, Caso queira outra requisição entrar em contato com comercial@aegsoftware.com";
            } else {

                $user = (new User)->forgetEmail(date_fmt_back($data->datebirth), preg_replace("/[^0-9]/", "", $data->document), $data->email);

                if ($user) {
                    $json["success"] = "Acesse seu e-mail para redefinir sua senha";
                } else {
                    $json["message"] = "A informações não estão corretas, usuário inexistente.";
                }
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Recuperar Senha",
            CONF_SITE_DESC,
            url("/"),
            theme("/assets/images/image.png", CONF_VIEW_THEME_ADMIN),
            false
        );

        echo $this->view->render("login/forget", [
            "head" => $head
        ]);
    }

    /**
     * SITE FORGET RESET
     * @param array $data
     * @return void 
     */
    public function forgetReset(array $data): void
    {

        if (!empty($data['csrf'])) {
            if ($_REQUEST && !csrf_verify($_REQUEST)) {
                $json['message'] = $this->message->info("Erro ao enviar, favor use o formulário, atualize a página")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data["password"]) || empty($data["password_re"])) {
                $json["message"] = $this->message->info("Informe e repita a senha para continuar")->render();
                echo json_encode($json);
                return;
            }

            list($email, $code) = explode("|", $data["code"]);
            $user = new User();

            if ($user->reset($email, $code, $data["password"], $data["password_re"])) {
                $this->message->info("Senha alterada com sucesso.")->flash();
                $json["redirect"] = url("/login");
            } else {
                $json["message"] = $this->message->info($user->fail()->getMessage())->render();
            }

            echo json_encode($json);
            return;
        }

        list($email, $code) = explode("|", $data["code"]);
        $find = (new User)->findByEmail($email);

        if (!$find->forget) {
            redirect("/login");
        }

        $head = $this->seo->render(
            "Crie sua nova senha no " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/recuperar"),
            theme("/assets/images/images.png")
        );

        echo $this->view->render("login/reset", [
            "head" => $head,
            "code" => $data["code"]
        ]);
    }

    /**
     * @param array $data
     */
    public function error(array $data): void
    {

        $error = new \stdClass();

        switch ($data['errcode']) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Estamos enfrentando problemas!";
                $error->message = "Parece que nosso serviço não está indisponível no momento. Já estamos resolvendo e agradecemos pela compreenssão";
                $error->linkTitle = "Continue navegando!";
                $error->link = "Muito:" . CONF_MAIL_SUPPORT;
                break;
            case "manutencao":
                $error->code = "OPS";
                $error->title = "Desculpe, Estamos em manutenção!";
                $error->message = "Em Breve retornaremos com novidades em nosso conteúdo";
                $error->linkTitle = "Continue navegando!";
                $error->link = null;
                break;
            default:
                $error->code = $data["errcode"];
                $error->title = "Ooops. Conteúdo indisponível :/";
                $error->message = "Você tentou acessar uma área que não existe";
                $error->linkTitle = "Continue navegando!";
                $error->link = url_back();
                break;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Error ",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("_error", [
            "head" => $head,
            "app" => "dash",
            "var_error" => $error
        ]);
    }
}

<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Source\Core\View;
use Source\Support\Email;
use Source\Support\Message;
use Source\Core\Session;
use CoffeeCode\DataLayer\Connect;
use DateTime;
use Exception;

class User extends DataLayer
{

    /** @var MESSAGE */
    protected $message;

    public function __construct()
    {
        parent::__construct("users", ["email"]);
        $this->message = new Message();
    }

    /**
     * Método para salvar ou alterar um usuário
     * @return bool
     */
    public function save(): bool
    {

        if (empty($this->id)) {

            if (!$this->validateEmail() || !$this->validateUserName() || !$this->validatePassword() || !parent::save()) {
                return false;
            }

            $log = new Log();

            $log->account_id = $this->UserLog()->account_id;
            $log->user = $this->UserLog()->id;
            $log->ip = $_SERVER["REMOTE_ADDR"];
            $log->description = "Inclusão do usuário " . $this->fullName();
            $log->save();
        } else {

            if (!$this->validateEmail() || !$this->validateUserName() || !$this->validatePassword()  || !parent::save()) {
                return false;
            }

            if ($this->status == 1 && $this->UserLog()) {
                $log = new Log();

                $log->account_id = $this->UserLog()->account_id;
                $log->user = $this->UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Alteração do usuário " . $this->fullName();
                $log->save();
            }

            if ($this->status == 2 && $this->UserLog()) {
                $log = new Log();

                $log->account_id = $this->UserLog()->account_id;
                $log->user = $this->UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Exclusão do usuário " . $this->fullName();
                $log->save();
            }

            if ($this->status == 3 && $this->UserLog()) {
                $log = new Log();

                $log->account_id = $this->UserLog()->account_id;
                $log->user = $this->UserLog()->id;
                $log->ip = $_SERVER["REMOTE_ADDR"];
                $log->description = "Bloqueio do usuário " . $this->fullName();
                $log->save();
            }
        }

        return true;
    }

    public function save2(): bool
    {
        parent::save();

        return true;
    }
    /**
     *  Alteração de senha
     *  @return bool
     */
    public function changePassword($old_password, $password_confirm): bool
    {

        if ($password_confirm != $this->password) {
            $this->fail = new Exception("A senha informada não é igual a confirmação.");
            return false;
        }
        if (!is_passwd($old_password)) {
            $this->fail = new Exception("A senha informada não é válida");
            return false;
        }

        $user = $this->findByEmail($this->email);

        if (!passwd_verify($old_password, $user->password)) {

            $this->fail = new Exception("Senha antiga incorreta");

            return false;
        }

        if (!$this->validatePassword()  || !parent::save()) {
            return false;
        }

        $log = new Log();

        $log->account_id = $this->UserLog()->account_id;
        $log->user = $this->UserLog()->id;
        $log->ip = $_SERVER["REMOTE_ADDR"];
        $log->description = "Alteração de senha do usuário " . $this->fullName();
        $log->save();

        return true;
    }

        /**
     *  Alteração de senha
     *  @return bool
     */
    public function changePasswordPopup(): bool
    {

        if (!$this->validatePassword()  || !parent::save()) {
            return false;
        }

        $log = new Log();

        $log->account_id = $this->UserLog()->account_id;
        $log->user = $this->UserLog()->id;
        $log->ip = $_SERVER["REMOTE_ADDR"];
        $log->description = "Alteração de senha do usuário " . $this->fullName();
        $log->save();

        return true;
    }

    /**
     *  Alteração de senha admin
     *  @return bool
     */
    public function changePasswordAdmin($password_confirm): bool
    {
        if ($password_confirm != $this->password) {
            $this->fail = new Exception("A senha informada não é igual a confirmação.");
            return false;
        }

        if (!$this->validatePassword()) {
            return false;
        }

        $log = new Log();

        $log->account_id = $this->UserLog()->account_id;
        $log->user = $this->UserLog()->id;
        $log->ip = $_SERVER["REMOTE_ADDR"];
        $log->description = "Alteração de senha do usuário " . $this->fullName();
        $log->save();

        return true;
    }



    public function save3(): bool
    {
        if (!$this->validatePassword() || !$this->validateEmail() || !parent::save()) {
            return false;
        }

        return true;
    }

    /**
     * Método para validação de E-mail ao incluir usuário
     * @return bool
     */
    protected function validateEmail(): bool
    {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->fail = new Exception("Informe um e-mail válido");
            return false;
        }

        $userByEmail = null;
        if (!$this->id) {
            $userByEmail = $this->find("email = :email and status!=2 and account_id=:account_id", "email={$this->email}&account_id={$this->account_id}")->count();
        } else {
            $userByEmail = $this->find("email = :email AND id != :id  and status!=2 and account_id=:account_id", "email={$this->email}&account_id={$this->account_id}&id={$this->id}")->count();
        }

        if ($userByEmail) {
            $this->fail = new Exception("E-mail já cadastrado");
            return false;
        }
        return true;
    }

    /**
     * Método para validação de nome de Usuário ao incluir usuário
     * @return bool
     */
    protected function validateUserName(): bool
    {

        $userByUserName = null;
        if ($this->user_name != "") {
            if (!$this->id) {
                $userByUserName = $this->find("user_name = :user_name and status!=2 and account_id=:account_id", "user_name={$this->user_name}&account_id={$this->account_id}")->count();
            } else {
                $userByUserName = $this->find("user_name = :user_name AND id != :id  and status!=2 and account_id=:account_id", "user_name={$this->user_name}&account_id={$this->account_id}&id={$this->id}")->count();
            }
        }

        if ($userByUserName) {
            $this->fail = new Exception("Nome de usuário já cadastrado");
            return false;
        }
        return true;
    }
    /**
     * Método para validação de senha para inclusão de usuário já incluinda senha criptografada
     * @return bool
     */
    protected function validatePassword(): bool
    {
        if (empty($this->password) || strlen($this->password) < 5) {
            $this->fail = new Exception("Informe uma senha com pelo menos 5 caracteres");
            return false;
        }

        if (password_get_info($this->password)["algo"]) {
            return true;
        }

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->save2();
        return true;
    }

    protected function validatePassword2($new_password): bool
    {
        if (empty($this->password) || strlen($this->password) < 5) {
            $this->fail = new Exception("Informe uma senha com pelo menos 5 caracteres");
            return false;
        }

        if (password_get_info($this->password)["algo"]) {
            return true;
        }

        $this->password = password_hash($new_password, PASSWORD_DEFAULT);
        $this->save2();
        return true;
    }

    /**
     * Método para achar um usuário pelo e-mail
     * @param string $email
     * @param string $columns
     * @return \Source\Models\User|null
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {

        $find = $this->find("email= :e and status=1", "e={$email}", $columns)->fetch();

        return $find;
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        if ($this->first_name != "") {
            return "{$this->first_name} {$this->last_name}";
        } else {
            return "{$this->company_name}";
        }
    }

    public static function fullNameId($id): string
    {
        $user = (new User)->findByid($id);
        if ($user->first_name != "") {
            return "{$user->first_name} {$user->last_name}";
        } else {
            return "{$user->company_name}";
        }
    }

    /**
     * 
     * @return string|null
     */
    public function showPhoto(): ?string
    {

        if ($this->photo && file_exists(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/{$this->photo}")) {
            return $this->photo;
        }

        return null;
    }


    /**
     * Método para entrar no sistema
     * @param string $email
     * @param string $password
     * @param bool $save
     * @param int $level
     * @return bool
     */
    public function login(string $email, string $password, bool $save = false, int $level = 0): bool
    {

        if (!is_email($email)) {
            $this->fail = new Exception("O E-mail informado não é válido");
            return false;
        }

        //        if ($save) {
        //            setcookie("authEmail", $email, time() + 604800, "/");
        //        } else {
        //            setcookie("authEmail", null, time() - 3600, "/");
        //        }

        if (!is_passwd($password)) {
            $this->fail = new Exception("A senha informada não é válida");
            return false;
        }

        $user = $this->findByEmail($email);

        if (!$user) {
            $this->fail = new Exception("E-mail informado não está cadastrado");
            return false;
        }

        if ($user->status == 2) {
            $this->fail = new Exception("E-mail informado não está cadastrado");
            return false;
        }

        if ($user->status == 3) {
            $this->fail = new Exception("Usuário está bloqueado");
            return false;
        }

        if ($user->error_attempt >= 5) {
            $this->fail = new Exception("Você estourou limite de 5 tentativas, seu login foi bloqueado, clique em 'Esqueceu a senha?' para redefinir.");
            return false;
        }

        if (!passwd_verify($password, $user->password)) {

            $request_limit = $this->request_limit($email);

            if ($request_limit >= 5) {
                $this->fail = new Exception("Você estourou limite de 5 tentativas, seu login foi bloqueado, acesse seu e-mail para desbloquear ou mude sua senha em 'Esqueceu a senha?'.");
            } else {
                $this->fail = new Exception("Senha incorreta");
            }

            return false;
        }

        $user_login = (new UserLogin())->find("user_id=:id", "id={$user->id}")->fetch();

        if (isset($user_login)) {
            if(diffMinutesSession($user_login->created_at,date("Y-m-d H:i:s"))<30){
                $this->fail = new Exception("Usuário já está logado em outra máquina.");
                return false;
            }
            $user_login->destroy();
            $session = new Session();
            $session->unset("authUserSistemaCred");
        }

        /*if ($user_login != 0) {
            $this->fail = new Exception("Usuário já está logado em outra máquina.");
            return false;
        }*/

        (new Session())->regenerate();

        (new Session())->set("authUserSistemaCred", $user->id);

        if (passwd_rehash($user->password)) {
            $user->password = $password;
            $user->save2();
        }

        $user->error_attempt = null;
        $user->error_date = null;
        $user->save2();

        $log = new Log();

        $log->account_id = $user->account_id;
        $log->user = $user->id;
        $log->ip = $_SERVER["REMOTE_ADDR"];
        $log->description = "Usuário " . $user->fullName() . " fez login no sistema";
        $log->save();

        return true;
    }

    public function recoverSession($user)
    {
        (new Session())->set("authUserSistemaCred", $user);
    }

    public function login1(string $email): bool
    {

        if (!is_email($email)) {
            $this->fail = new Exception("O E-mail informado não é válido");
            return false;
        }

        $user = $this->findByEmail($email);

        if (!$user) {
            $this->fail = new Exception("E-mail informado não está cadastrado");
            return false;
        }

        if ($user->status == 2) {
            $this->fail = new Exception("E-mail informado não está cadastrado");
            return false;
        }

        return true;
    }
    /**
     * Método para carregar usuario na session caso a validação tenha sido efetuada
     * @return \Source\Models\User|null
     */
    public static function UserLog(): ?User
    {
        $session = new Session();
        if (!$session->has("authUserSistemaCred")) {
            return null;
        }

        return (new User)->findByid($session->authUserSistemaCred);
    }

    /**
     * Método para sair do sistema
     * @return void
     */
    public static function logout(): void
    {

        $session = new Session();
        $session->unset("authUserSistemaCred");
    }

    /**
     * Método para envio de e-mail para quem esqueceu a senha
     * @param string $email
     * @return bool
     */
    public function forgetEmail(string $datebirth, string $document, string $email): bool
    {

        $user = (new User)->find("datebirth=:datebirth and document=:document and email=:email", "datebirth={$datebirth}&document={$document}&email={$email}")->fetch();

        if (!$user) {
            return false;
        }
        $user->forget = md5(uniqid(rand(), true));
        $user->save2();

        $view = new View("", __DIR__ . "/../../shared/views/email");
        $message = $view->render("forget", [
            "first_name" => $user->first_name,
            "forget_link" => url("recuperar/{$user->email}|{$user->forget}")
        ]);

        (new Email())->bootstrap(
            "Redefina sua senha no " . CONF_SITE_NAME,
            $message,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        )->send();

        return true;
    }

    /**
     * Método para resetar senha do usuário
     * @param string $email
     * @param string $code
     * @param string $password
     * @param string $passwordRe
     * @return bool
     */
    public function reset(string $email, string $code, string $password, string $passwordRe): bool
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->fail = new Exception("A conta para verificação não foi encontrada");
            return false;
        }

        if ($user->forget != $code) {
            $this->fail = new Exception("Desculpe mas o código de verificação não foi encontrado");
            return false;
        }

        if (!is_passwd($password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->fail = new Exception("Sua senha deve ter entre {$min} a {$max} caracteres");
            return false;
        }

        if ($password != $passwordRe) {
            $this->fail = new Exception("Você informou duas senhas diferentes");
            return false;
        }

        $user->password = passwd($password);
        $user->forget = null;
        $user->error_attempt = null;
        $user->error_code = null;
        $user->error_date = null;
        $user->save2();
        return true;
    }

    /**
     * 
     * @param string $email
     * @return int
     */
    public function request_limit(string $email): int
    {

        $find = $this->find("email=:e", "e={$email}")->fetch();
        $find->error_attempt += 1;
        $find->error_date = (new DateTime("now"))->format("Y-m-d H:i:s");
        $find->save2();

        if ($find->error_attempt >= 5 && empty($find->error_code)) {

            $find->error_code = md5(uniqid(rand(), true));
            $find->save2();
        }

        return $find->error_attempt;
    }

    /**
     * @return Level|null
     */
    public function level(): ?Level
    {
        if ($this->level_id) {
            return (new Level())->findById($this->level_id);
        }
        return null;
    }

    /**
     *
     * @return string|null
     */
    public function showLogo(): ?string
    {

        if ($this->account()->logo && file_exists(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/{$this->account()->logo}")) {
            return $this->account()->logo;
        }

        return null;
    }

    /**
     * @return Account|null
     */
    public function account(): ?Account
    {
        if ($this->account_id) {
            return (new Account())->findById($this->account_id);
        }
        return null;
    }

    public function showState()
    {
        $connect = Connect::getInstance();

        $states = $connect->query("SELECT uf_codigo,uf_descricao FROM uf ORDER BY uf_descricao");

        return $states->fetchAll();
    }

    public function countAttendanceByUser($inicial_date, $final_date)
    {
        $user = User::UserLog();
        $connect = Connect::getInstance();

        $states = $connect->query("SELECT users.id,COUNT(attendances.id) as count_attendance FROM users 
        LEFT JOIN attendances ON users.id=attendances.user_id WHERE (users.account_id='" . $user->account_id . "'  OR users.account_id IS null)
        AND (attendances.created_at between '" . $inicial_date . "' and '" . $final_date . "'  OR attendances.created_at IS NULL and users.status=1)
        GROUP BY users.id ORDER BY users.id");

        return $states->fetchAll();
    }
    
}

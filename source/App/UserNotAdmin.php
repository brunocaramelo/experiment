<?php

namespace Source\App;


use Source\Core\Controller;
use Source\Models\Account;
use Source\Models\User;
use Source\Models\UserLogin;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Description of Users
 *
 * @author Luiz
 */
class UserNotAdmin extends Controller{

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
    }

        /**
     * @param array|null $data
     * @throws \Exception
     */
    public function user(?array $data): void {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userUpdate = (new User())->findById($data["user_id"]);
      
            if (!$userUpdate) {
                echo json_encode(["redirect" => url("/usuario")]);
                return;
            }

            //$userUpdate->password = password_hash($data["password_confirm"], PASSWORD_DEFAULT);
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
            $userUpdate->status = $data["status"];

            if($data["status"]==1){
                $account = (new Account())->find("id=:a","a={$userUpdate->account_id}")->fetch();
                if($account->status==3){
                    $json["message"] = "Essa conta está desativada, ative a conta para pode ativar o usuário";
                    echo json_encode($json);
                    return;
                }
            }
			if($data["status"]==3){
				$user_login = (new UserLogin())->find("user_id=:u", "u={$userUpdate->id}")->fetch();
				if($user_login){
				   $user_login->destroy();
				}
			}
            if($this->user->admin_account==1 || $this->user->client==0){
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

        /**
     * Alteração de senha
     * @param array|null $data
     */
    public function passwordChangePopup(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if($data["new_password"]=='12345678'){
            $json["message"] = "Escolha uma senha diferente da padrão";
            echo json_encode($json);
            return;
        }

        $user_email = (new User())->find("id=:id", "id={$data['id']}")->fetch();
        $user_email->password = $data["new_password"];
        $user_email->password_validate = 1;

        if (!$user_email->changePasswordPopup()) {
            $json["message"] = $user_email->fail()->getMessage();
            echo json_encode($json);
            return;
        }

        $this->message->info("Sua senha foi alterada com sucesso")->flash();
        echo json_encode(["redirect" => url("/dash/estrategico")]);
        return;

    }
}
<?php

namespace Source\App;

use Source\Models\Ticket as TicketModel;
use Source\Models\BankCoeficient;
use Source\Models\Coeficient;
use Source\Models\Organ;

/**
 * Description of Ticket
 *
 * @author Luiz
 */
class Ticket extends Admin
{

    /**
     * Ticket constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function index(?array $data)
    {
        $tickets = (new TicketModel())->getTicketsOrderedByDueDate(); // model

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Todos os boletos",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/index", [
            "menu" => "tickets-paid",
            "submenu" => "tickets-paid",
            "head" => $head,
            "tickets" => $tickets,
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    public function getAllTicketsOfClient(?array $data)
    {
        $tickets = (new TicketModel())->getAllTicketsOfClientOrderedByDueDate($data['accountId']); // model

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Todos os boletos",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/index", [
            "menu" => "tickets-paid",
            "submenu" => "tickets-paid",
            "head" => $head,
            "tickets" => $tickets,
            "accountId" => $data['accountId'],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    /**
     * @param array|null $data
     */
    public function clientTicketPaid(?array $data)
    {
        $tickets = (new TicketModel())->getPaidTicketsOfClientOrderedByDueDate(); // model
        $firstTicketToPay = (new TicketModel())->getFirstTicketToPayByUserAccountId() ?? null;
        $firstTicketToPayGreatherThanToday = (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Boletos pagos",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/tickets-paid", [
            "menu" => "tickets-paid",
            "submenu" => "tickets-paid",
            "head" => $head,
            "tickets" => $tickets,
            "ticketToPay" => $firstTicketToPay,
            "firstTicketToPayGreatherThanToday" => $firstTicketToPayGreatherThanToday,
        ]);
    }

    public function clientTicketsUnpaid(?array $data)
    {
        $tickets = (new TicketModel())->getUnpaidTicketsOfClientOrderedByDueDate(); // model
        $firstTicketToPay = (new TicketModel())->getFirstTicketToPayByUserAccountId() ?? null;
        $firstTicketToPayGreatherThanToday = (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Boletos a pagar",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/tickets-unpaid", [
            "menu" => "tickets-unpaid",
            "submenu" => "tickets-unpaid",
            "head" => $head,
            "tickets" => $tickets,
            "ticketToPay" => $firstTicketToPay,
            "firstTicketToPayGreatherThanToday" => $firstTicketToPayGreatherThanToday,
        ]);
    }

    public function markTicketAsPaid(array $data)
    {
        if (!empty($data["action"]) && $data["action"] == "markTicketAsPaid") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $data = (new TicketModel())->getFirstTicketToPayByUserAccountId() ?? null;

            $ticket = (new TicketModel());
            $ticket->status = 'Boleto pago';
            $ticket->id = $data['id'];

            if (!$ticket->save()) {
                $json["message"] = $ticket->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Boleto marcado como pago!")->flash();
            $json["redirect"] = url("/boletos-a-pagar");
            echo json_encode($json);
            return;
        }

        if (!empty($data["action"]) && $data["action"] == "markTicketAsPaidPopup") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $data = (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday() ?? null;

            $ticket = (new TicketModel());
            $ticket->status = 'Boleto pago';
            $ticket->id = $data['id'];

            if (!$ticket->save()) {
                $json["message"] = $ticket->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Boleto marcado como pago!")->flash();
            $json["redirect"] = url("/boletos-a-pagar");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Editar boleto",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/edit", [
            "menu" => "tickets",
            "submenu" => "tickets",
            "head" => $head,
            "ticket" => (new TicketModel())->findById($data['ticketId']),
            "accountId" => $data['accountId'],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }
    
    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function create(?array $data)
    {
        if (user()->level_id != 1) {
            return url('/ops/404');
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Cadastrar boleto",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/create", [
            "menu" => "tickets",
            "submenu" => "tickets",
            "head" => $head,
            "accountId" => $data["accountId"],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    /**
     * Alteração de senha
     * @param array|null $data
     */
    public function store(?array $data)
    {
        $file = $_FILES['pdf'];

        $filename = explode('.', $file['name']);
        
        $newFilename = md5(date('Ymdhis'));
        $extension = $filename[1];

        $dirSeparator = DIRECTORY_SEPARATOR;
        $path = "{$dirSeparator}..{$dirSeparator}..{$dirSeparator}shared{$dirSeparator}pdfs{$dirSeparator}";

        $moveFileTo = __DIR__ . $path . $newFilename . '.' . $extension;

        if ($extension !== 'pdf') {
            $json["message"] = "Erro ao enviar o formulário: formato de arquivo não suportado. Insira PDF.";
            echo json_encode($json);
            return;
        }

        move_uploaded_file($file['tmp_name'], $moveFileTo);

        if (user()->level_id != 1) {
            return url('/ops/404');
        }

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            if (!empty($data['csrf'])) {
                if ($_REQUEST && !csrf_verify($_REQUEST)) {
                    $json["message"] = "Erro ao enviar o formulário, atualize a página";
                    echo json_encode($json);
                    return;
                }
            }

            if (!$data["name"] && !$data["bar_code"] && !$data["due_date"]) {
                $json["message"] = "Erro ao enviar o formulário, não é possível cadastrar um boleto com todos os campos em branco, por favor, tente novamente!";
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $ticket = new TicketModel();
            $ticket->name = $data["name"] ?? null;
            $ticket->bar_code = $data['bar_code'] ?? null;
            $ticket->status = $data['status'];
            $ticket->due_date = $data['due_date'] ?? null;
            $ticket->account_id = $data['accountId'] ?? null;
            $ticket->filename = $newFilename . '.' . $extension;

            if (!$ticket->save()) {
                $json["message"] = $ticket->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Boleto cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/boletos/cliente/{$ticket->account_id}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Cadastrar boleto",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/create", [
            "menu" => "tickets",
            "submenu" => "tickets",
            "head" => $head,
            "accountId" => $data['accountId'],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    /**
     * @param array|null $data
     */
    public function edit(array $data)
    {
        $ticket = (new TicketModel())->findById($data['id']);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Editar boleto",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/edit", [
            "menu" => "tickets",
            "submenu" => "tickets",
            "head" => $head,
            'ticket' => $ticket,
            "accountId" => $data['accountId'],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    /**
     * @param array|null $data
     */
    public function editRedirectToIndex(array $data)
    {
        $ticket = (new TicketModel())->findById($data['id']);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Editar boleto",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/edit-redirect-to-index", [
            "menu" => "tickets",
            "submenu" => "tickets",
            "head" => $head,
            'ticket' => $ticket,
            "accountId" => $data['accountId'],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    public function update(array $data)
    {
        $file = $_FILES['pdf'] ?? [];
        if ($file) {
            $filename = explode('.', $file['name']);
        
            $newFilename = md5(date('Ymdhis'));
            $extension = $filename[1];

            $dirSeparator = DIRECTORY_SEPARATOR;
            $path = "{$dirSeparator}..{$dirSeparator}..{$dirSeparator}shared{$dirSeparator}pdfs{$dirSeparator}";

            $moveFileTo = __DIR__ . $path . $newFilename . '.' . $extension;

            if ($extension !== 'pdf') {
                $json["message"] = "Erro ao enviar o formulário: formato de arquivo não suportado. Insira PDF.";
                echo json_encode($json);
                return;
            }

            move_uploaded_file($file['tmp_name'], $moveFileTo);
        }

        if (!empty($data["action"]) && $data["action"] == "markTicketAsPaid" || $data["action"] == "markTicketAsPaidPopup") {
            return $this->markTicketAsPaid($data);
        }

        if (!empty($data["action"]) && $data["action"] == "edit") {
            if (!empty($data['csrf'])) {
                if ($_REQUEST && !csrf_verify($_REQUEST)) {
                    $json["message"] = "Erro ao enviar o formulário, atualize a página";
                    echo json_encode($json);
                    return;
                }
            }

            if (!$data["name"] && !$data["bar_code"] && !$data["due_date"]) {
                $json["message"] = "Erro ao enviar o formulário, não é possível editar um boleto com todos os campos em branco, por favor, tente novamente!";
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $ticket = new TicketModel();
            $ticket->name = $data["name"] ?? null;
            $ticket->bar_code = $data['bar_code'] ?? null;
            $ticket->due_date = $data['due_date'] ?? null;
            $ticket->status = $data['status'];
            $ticket->id = $data['ticketId'] ?? null;
            if ($file) {
                $ticket->filename = $newFilename . '.' . $extension;
            }
            $ticket->account_id = $data['account_id'] ?? null;

            if (!$ticket->save()) {
                $json["message"] = $ticket->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Boleto editado com sucesso...")->flash();
            $json["redirect"] = url("/boletos/cliente/{$data['account_id']}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Editar boleto",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/edit", [
            "menu" => "tickets",
            "submenu" => "tickets",
            "head" => $head,
            "ticket" => (new TicketModel())->findById($data['ticketId']),
            "accountId" => $data['accountId'],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    public function updateRedirectToIndex(array $data)
    {
        $file = $_FILES['pdf'] ?? [];
        if ($file) {
            $filename = explode('.', $file['name']);
        
            $newFilename = md5(date('Ymdhis'));
            $extension = $filename[1];

            $dirSeparator = DIRECTORY_SEPARATOR;
            $path = "{$dirSeparator}..{$dirSeparator}..{$dirSeparator}shared{$dirSeparator}pdfs{$dirSeparator}";

            $moveFileTo = __DIR__ . $path . $newFilename . '.' . $extension;

            if ($extension !== 'pdf') {
                $json["message"] = "Erro ao enviar o formulário: formato de arquivo não suportado. Insira PDF.";
                echo json_encode($json);
                return;
            }

            move_uploaded_file($file['tmp_name'], $moveFileTo);
        }

        if (!empty($data["action"]) && $data["action"] == "markTicketAsPaid") {

            return $this->markTicketAsPaid($data);
        }

        if (!empty($data["action"]) && $data["action"] == "edit") {
            if (!empty($data['csrf'])) {
                if ($_REQUEST && !csrf_verify($_REQUEST)) {
                    $json["message"] = "Erro ao enviar o formulário, atualize a página";
                    echo json_encode($json);
                    return;
                }
            }

            if (!$data["name"] && !$data["bar_code"] && !$data["due_date"]) {
                $json["message"] = "Erro ao enviar o formulário, não é possível editar um boleto com todos os campos em branco, por favor, tente novamente!";
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $ticket = new TicketModel();
            $ticket->name = $data["name"] ?? null;
            $ticket->bar_code = $data['bar_code'] ?? null;
            $ticket->due_date = $data['due_date'] ?? null;
            $ticket->status = $data['status'];
            $ticket->id = $data['ticketId'] ?? null;
            if ($file) {
                $ticket->filename = $newFilename . '.' . $extension;
            }
            $ticket->account_id = $data['account_id'] ?? null;

            if (!$ticket->save()) {
                $json["message"] = $ticket->fail()->getMessage();
                echo json_encode($json);
                return;
            }

            $this->message->info("Boleto editado com sucesso...")->flash();
            $json["redirect"] = url("/boletos");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Editar boleto",
            CONF_SITE_DESC,
            url("/"),
            url("/assets/images/image.png"),
            false
        );

        echo $this->view->render("tickets/edit", [
            "menu" => "tickets",
            "submenu" => "tickets",
            "head" => $head,
            "ticket" => (new TicketModel())->findById($data['ticketId']),
            "accountId" => $data['accountId'],
            "firstTicketToPayGreatherThanToday" => (new TicketModel())->getFirstTicketToPayByUserAccountIdWhereDueDateGreatherThanToday(),
        ]);
    }

    public function destroy(array $data)
    {
        if (user()->level_id != 1) {
            return;
        }
        
        $ticket = (new TicketModel())->findById($data['id']);
        $ticket->destroy();

        $this->message->info("Boleto excluído com sucesso...")->flash();
        $json["redirect"] = url("/boletos/cliente/{$ticket->account_id}");

        echo json_encode($json);
        return;
    }

    public function destroyRedirectToIndex(array $data)
    {
        if (user()->level_id != 1) {
            return;
        }
        
        $ticket = (new TicketModel())->findById($data['id']);
        $ticket->destroy();

        $this->message->info("Boleto excluído com sucesso...")->flash();
        $json["redirect"] = url("/boletos");

        echo json_encode($json);
        return;
    }
}

<link rel="stylesheet" href="<?= theme("/assets/css/notification_dash.css", CONF_VIEW_THEME_ADMIN); ?>" />

<div class="ticket-notification px-3 py-3 mb-5">
    <div class="notification-body">
        <strong class="notification-text">
            <i class="nav-icon fas fa-exclamation-circle"></i> 
                <span>
                    ATENÇÃO! Há um atendimento agendado para <?= date_fmt2(returnScheduling()->date_return) ?>
                    com o cliente <?= returnScheduling()->clientDesc()->NOME ?>, 
                    de CPF <?= returnScheduling()->clientDesc()->CPF ?>
                    e MATRÍCULA <?= returnScheduling()->clientDesc()->MATRICULA ?>.
                </span>

        </strong>
    </div>
    <div class="notification-body pt-3">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <?php
                        # $redirectTo = $_SERVER['REQUEST_URI'] == '/boletos' ? '/boletos' : "/boletos/cliente/{$ticketToPay->account_id}";
                    ?>

                    <?php
                        // não sei se o id está maiúsculo ou minúsculo
                        // no banco de produção, então fiz isso
                        $client = returnScheduling()->clientDesc();
                        $clientId = $client->id ?? $client->ID;
                    ?>
                    <a href="<?= url("/cliente/consulta/{$clientId}"); ?>" 
                        class="btn btn-success w-100">
                            <i class="nav-icon fas fa-eye"></i> Mostrar cliente
                    </a>
                    
                </div>
                <div class="col-5">
                    
                    <button id="close-notification" class="btn cursor-pointer btn-danger w-100">
                        <i class="nav-icon fas fa-solid fa-eye-slash"></i> Ocultar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

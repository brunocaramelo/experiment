<link rel="stylesheet" href="<?= theme("/assets/css/notification.css", CONF_VIEW_THEME_ADMIN); ?>" />

<div class="ticket-notification px-3 py-3 mb-3">
    <div class="notification-body">
        <strong class="notification-text">
            <i class="nav-icon fas fa-exclamation-circle"></i> O boleto de código de barras 
            <?= $ticketToPay->bar_code ?> vencerá dia <?= date_fmt_br2($ticketToPay->due_date) ?> (daqui a 00 dias).
        </strong>
    </div>
    <div class="notification-body pt-3">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <form action="<?= url("/boletos/alterar/{$ticketToPay->id}/cliente/{$ticketToPay->account_id}") ?>" method="post">
                        <?= csrf_input(); ?>
                        <input type="hidden" name="action" value="edit" />
                        <button type="submit" class="btn btn-success w-100">
                            <i class="nav-icon fas fa-check"></i> Marcar como pago
                        </button>
                    </form>
                </div>
                <div class="col-5">
                    <button id="close-notification" class="btn cursor-pointer btn-danger w-100">
                        <i class="nav-icon fas fa-times"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

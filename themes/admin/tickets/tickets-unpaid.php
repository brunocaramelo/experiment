<?php $v->layout("_admin"); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="nav-icon fas fa-receipt"></i> Boletos a pagar</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Boletos</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

    <!-- Main content -->
    <div class="card card-solid">
      <div class="card-body pb-0">
      <div class="row">
            <?php if (user()->level_id == 1): ?> 
               <div class="col-md-4">
                    <a href="<?= url("/boletos/cadastrar/cliente/{$accountId}"); ?>" class="btn btn-success">Novo Boleto</a>
                </div>
            <?php endif; ?>
                <div class="col-md-5">
            
                </div>
            </div><br>
            <?php
            if($tickets):?>
                <table id="table-tickets" class="display" >
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Código de barras</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                        <th>Cliente</th>
                        <th>Boleto</th>
                        <th>Ações</th>  
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td><?= $ticket->name ?></td>
                            <td><?= $ticket->bar_code ?></td>
                            <td><?= date_fmt_br2($ticket->due_date) ?></td>
                            <td><?= $ticket->status ?></td>
                            <td><?= $ticket->description ?></td>
                            <td>
                                <?php 
                                    if ($ticket->filename):
                                ?>
                                    <a class="btn btn-outline-success" 
                                        href="<?=url("/shared/pdfs/{$ticket->filename}")?>"
                                        download>
                                            Baixar
                                    </a>
                                <?php endif; ?>
                            </td>
                            <?php
                                $ticketToPay = $ticketToPay ?? null; 
                                if (user()->level_id == 1 && $ticketToPay): 
                            ?> 
                                <td>
                                    <a href="<?= url("/boletos/alterar/{$ticket->id}/cliente/{$ticket->account_id}") ?>" 
                                        class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" 
                                        class="btn btn-danger" 
                                        title="Excluir" 
                                        data-post="<?= url("/boletos/remover/{$ticket->id}/cliente/{$ticket->account_id}"); ?>" 
                                        data-action="delete" 
                                        data-confirm="ATENÇÃO: Tem certeza que deseja excluir esse boleto? Essa ação não poderá ser desfeita!" 
                                        data-account="<?= $ticket->id; ?>">
                                            <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            <?php endif; ?>
                            
                            <?php
                                $isUrlBoletoAPagar = url($_SERVER["REQUEST_URI"]) == url('/boletos-a-pagar');
                                $status = $ticketToPay->status ?? null;
                                if (user()->level_id == 2 && $isUrlBoletoAPagar && $status == 'Boleto não pago'): 
                            ?>
                                <td>
                                <form action="<?= url("/boletos/alterar/{$ticketToPay->id}/cliente/{$ticketToPay->account_id}") ?>" method="post">
                                    <?= csrf_input(); ?>
                                    <input type="hidden" name="ticketId" value="<?= $ticketToPay->id ?>" />
                                    <input type="hidden" name="account_id" value="<?= $ticketToPay->account_id ?>" />
                                    <input type="hidden" name="action" value="markTicketAsPaid" />
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="nav-icon fas fa-check"></i> Marcar como pago
                                    </button>
                                </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <td>Total: <?= count($tickets); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table><br>
            <?php endif;?>
        </div><!-- /.card-body -->
    </div><!-- /.card card-solid -->
</div><!-- /.content-wrapper-->
<?php $v->start("scripts");
if(!$tickets):
    ?>
    <script>
        $(function () {
            toastr.error("Nenhum boleto encontrado");
        });
    </script>
<?php
endif;
$v->end(); ?>
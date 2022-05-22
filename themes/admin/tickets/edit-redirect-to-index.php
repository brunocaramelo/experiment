<?php $v->layout("_admin"); ?>
<!-- Content Wrapper. Contains page content -->
<?php if (user()->level_id == 1): ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="nav-icon fas fa-receipt"></i> Editar Boleto</h1>
                    <a class="btn btn-primary mt-3" href="<?= url("/boletos/cliente/{$accountId}") ?>">
                        <i class="fas fa-eye"></i> Boletos deste cliente
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $router->route("ticket.getAllTicketsOfClient"); ?>">Boletos</a></li>
                        <li class="breadcrumb-item active">Editar Boleto</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid"><br>
            <div class="card">
                <form action="<?= url("/boletos/alterar/{$ticket->id}/cliente/{$accountId}/updateRedirectToIndex") ?>" method="post">
                    <input type="hidden" name="ticketId" value="<?= $ticket->id ?>" />
                    <input type="hidden" name="account_id" value="<?= $accountId ?>" />
                    <div class="card-body">
                        <?= csrf_input(); ?>
                        <input type="hidden" name="action" value="edit" />
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group clearfix">
                                <label>Nome</label>
                                    <input value="<?= $ticket->name ?>" 
                                        type="text" 
                                        class="form-control" 
                                        name="name" 
                                        maxlength="255">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group clearfix">
                                <label>Código de barras</label>
                                    <input value="<?= $ticket->bar_code ?>" 
                                        type="text" 
                                        class="form-control" 
                                        name="bar_code" 
                                        maxlength="255">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- checkbox -->
                                <label>Data de vencimento</label>
                                <input value="<?= $ticket->due_date ?>"  type="date" class="form-control" name="due_date">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group clearfix">
                                <label>Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option <?= $ticket->status == 'Boleto não pago' ? 'selected' : '' ?> 
                                            value="Boleto não pago">
                                                Boleto não pago
                                        </option>
                                        <option <?= $ticket->status == 'Boleto pago' ? 'selected' : '' ?> 
                                            value="Boleto pago">
                                                Boleto pago
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                    <div class="container-fluid">
                        <button type="submit" id="save" class="btn btn-success">
                            <i class="fas fa-plus"></i> Editar boleto
                        </button>
                    </div><!-- /.card-footer -->
                </form>
            </div>
        </div>
    </section>
<?php endif; ?>
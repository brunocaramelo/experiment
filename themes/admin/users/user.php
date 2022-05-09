<?php $v->layout("_admin"); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-user"></i> Cadastrar Usuário</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $router->route("dash.dash"); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= $router->route("users.home"); ?>">Usuários</a></li>
                            <li class="breadcrumb-item active">Cadastrar Usuário</li>
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
                    <form action="<?= $router->route("users.userPost"); ?>" enctype="multipart/form-data" method="post">
                        <div class="card-body">
                            <?= csrf_input(); ?>
                            <input type="hidden" name="action" value="create"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Nome de Usuário:</label>
                                    <input type="text" class="form-control" name="user_name" maxlength="255" placeholder="Nome de exibição">
                                </div>
                                <div class="col-md-6">
                                    <label>Nome:</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="Primeiro nome">
                                </div>
                                <div class="col-md-6">
                                    <label>Sobrenome:</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Último nome" >
                                </div>
                                <div class="col-md-6">
                                    <label>CPF:</label>
                                    <input class="form-control mask-doc" type="text" name="document" placeholder="CPF"/>
                                </div>
                                <div class="col-md-6">
                                    <label>Nascimento:</label>
                                    <input type="text" class="form-control mask-date" name="datebirth" placeholder="dd/mm/yyyy"/>
                                </div>
                                <div class="col-md-6">
                                    <label>Gênero:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="genre">
                                    <?php  if(!empty($genres)):
                                                foreach($genres as $genre):?>
                                                    <option value="<?=$genre->id?>"><?=$genre->description?></option>
                                                <?php   endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Foto:(600x600px)</label>
                                    <input type="file" class="form-control" name="photo" >
                                </div>
                                <div class="col-md-3">
                                    <label>RG:</label>
                                    <input class="form-control" type="text" name="document_secondary" placeholder="RG" />
                                </div>
                                <div class="col-md-3">
                                    <label>Orgão Expedidor:<i class="far fa-question-circle"  style="cursor:pointer" data-toggle="modal" data-target="#modalDocumentSecondary"></i></label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="document_secondary_complement" name="document_secondary_complement">
                                        <option value="">--Selecione--</option>
                                        <?php  if(!empty($document_secondary_complements)):
                                                foreach($document_secondary_complements as $document_secondary_complement):?>
                                                    <option value="<?=$document_secondary_complement->id?>"><?=$document_secondary_complement->description?></option>
                                                <?php   endforeach;
                                        endif;?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Data da Expedição:</label>
                                    <input type="text" class="form-control mask-date" name="shipping_date" placeholder="dd/mm/yyyy" />
                                </div>
                                <div class="col-md-4">
                                    <label>CEP:</label>
                                    <input class="form-control mask-cep" type="text" name="zipcode" id="zipcode" placeholder="Digite o CEP" />
                                </div>
                                <div class="col-md-8">
                                    <label>Logradouro:</label>
                                    <input class="form-control" type="text" name="street" id="street" maxlength="100" placeholder="Logradouro" />
                                </div>
                                <div class="col-md-4">
                                    <label>Número:</label>
                                    <input class="form-control" type="text" name="number" maxlength="50" placeholder="Número" />
                                </div>
                                <div class="col-md-8">
                                    <label>Complemento:</label>
                                    <input class="form-control" type="text" name="complement" maxlength="150" placeholder="Complemento" />
                                </div>
                                <div class="col-md-12">
                                    <label>Bairro:</label>
                                    <input class="form-control" type="text" name="district" id="district" placeholder="Bairro"/>
                                </div>
                                <div class="col-md-6">
                                    <label>Estado:</label>
                                    <input class="form-control" type="text" name="state" id="state" maxlength="150" placeholder="Estado" />
                                </div>
                                <div class="col-md-6">
                                    <label>Cidade:</label>
                                    <input class="form-control" type="text" name="city" id="city" maxlength="150" placeholder="Cidade" />
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail:</label>
                                    <input class="form-control" type="email" name="email" placeholder="Melhor e-mail" required/>
                                </div>
                                <div class="col-md-6">
                                    <label>Celular:</label>
                                    <input class="form-control mask-cel" type="text" name="cel" placeholder="Celular" />
                                </div>
                                <div class="col-md-6">
                                    <label>Nível de Acesso:</label>
                                    <select class="form-control" style="width: 100%;" name="level" required>
                                        <?php foreach ($level as $levels): ?>
                                            <option value="<?= $levels->id ?>"><?= str_studly_case($levels->description) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Conta:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="account" required>
                                        <option value="">--Selecione--</option>
                                        <?php foreach ($accounts as $account): ?>
                                            <option value="<?= $account->id ?>"><?=$account->description;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div><br><br><br><br>
                            </div>

                        </div><!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn btn-success"><i class="fas fa-edit"> Criar Usuário</i></button>
                        </div><!-- /.card-footer -->
                    </form><!-- /.form -->
                </div><!-- /.card -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--modal document_secundary_complements-->
    <div class="modal fade" id="modalDocumentSecondary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Orgão Expedidor</h5>
                    <button type="button" class="close" id="close_document" onclick="close_modal()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="create">
                        <form class="ajax_form" action="<?= $router->route("auxiliar.documentAdd"); ?>" name="gallery" method="post"
                              enctype="multipart/form-data">

                            <label>
                                <input type="text" class="form-control" name="document_secondary_complement" placeholder="Orgão Expedidor:"/>
                            </label>
                            <label>
                                <button class="btn btn-success"><i class="fas fa-edit"> Adicionar Novo</i></button>
                            </label>
                        </form>
                    </div>
                    <main class="content">
                        <section class="auxs">
                            <?php if(!empty($document_secondary_complements)):
                                foreach($document_secondary_complements as $document_secondary_complement):
                                   $v->insert("fragments/document_secondary_complement",["document_secondary_complement" => $document_secondary_complement]);
                                endforeach;
                             endif;?>
                        </section>
                    </main>

                </div>

            </div>
        </div>
    </div>
<script>

function close_modal(){
    var  document_secundary_complement = $("select[name='document_secondary_complement']").val();
    
    resetaCombo('document_secondary_complement');

    $.getJSON( path + '/cadastro/document/select', function (data){

        var option = new Array();

        $.each(data.document, function(i, obj){
            option[i] = document.createElement('option');
            $( option[i] ).attr( {value : obj.id} );
            $( option[i] ).append( obj.description );

            if(document_secundary_complement==obj.id) {
                $( option[i] ).attr("selected","selected");
            }

            $("select[name='document_secondary_complement']").append( option[i] );

        });

    });


}

function resetaCombo( el ) {
    $("select[name='"+el+"']").empty();
    var option = document.createElement('option');
    $( option ).attr( {value : ''} );
    $( option ).append( '--Selecione--' );
    $("select[name='"+el+"']").append( option );
}
</script>

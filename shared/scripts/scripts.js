// JQUERY INIT

$(function () {

    if($("#flash").val()!==""){
        toastr.success($("#flash").val());
    }

    //DATA SET

    $("[data-post]").click(function (e) {
        e.preventDefault();
   
        var clicked = $(this);
        var data = clicked.data();
        var load = $(".ajax_load");

        if (data.confirm) {
            var deleteConfirm = confirm(data.confirm);
            if (!deleteConfirm) {
                return;
            }
        }

        $.ajax({
            url: data.post,
            type: "POST",
            data: data,
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //reload
                if (response.reload) {
                    window.location.reload();
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    toastr.error(response.message);
                }

            },
            error: function () {
                ajaxMessage(ajaxResponseRequestError, 5);
                load.fadeOut();
            }
        });
    });

    //FORMS

    $("form:not('.ajax_form')").submit(function (e) {
        //if($("form:not('.ajax_form2')")){
        if($("#action").val()!="search"){

        e.preventDefault();

        var form = $(this);
        var load = $(".ajax_load");

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            uploadProgress: function (event, position, total, completed) {
                var loaded = completed;
                var load_title = $(".ajax_load_box_title");
                load_title.text("Enviando (" + loaded + "%)");

                if (completed >= 100) {
                    load_title.text("Aguarde, carregando...");
                }
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //Success
                if(response.success){
                    toastr.success(response.success);
                }
                //Error
                if (response.message) {
                    //$(".ajax_response").html(response.message).effect("bounce");
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                load.fadeOut(200);
            }


        });
        }
    });

    $(".ajax_form2").submit(function (e) {
        //if($("form:not('.ajax_form2')")){
        e.preventDefault();

        var form = $(this);
        var load = $(".ajax_load");

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            uploadProgress: function (event, position, total, completed) {
                var loaded = completed;
                var load_title = $(".ajax_load_box_title");
                load_title.text("Enviando (" + loaded + "%)");

                if (completed >= 100) {
                    load_title.text("Aguarde, carregando...");
                }
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //Success
                if(response.success){
                    toastr.success(response.success);
                }
                //Error
                if (response.message) {
                    //$(".ajax_response").html(response.message).effect("bounce");
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                load.fadeOut(200);
            }


        });

    });


    $(".ajax_form").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var form_ajax = $(".form_ajax");
        var load = $(".ajax_load");
        var auxs = $(".auxs");
        var auxs2 = $(".auxs2");
        var auxs3 = $(".auxs3");
        var auxs4 = $(".auxs4");
        var auxs5 = $(".auxs5");
        var auxs6 = $(".auxs6");
        var auxs7 = $(".auxs7");
        var auxs8 = $(".auxs8");
        var auxs9 = $(".auxs9");
        var auxs10 = $(".auxs10");
        var auxs11 = $(".auxs11");
        var auxs12 = $(".auxs12");

        $.ajax({
            url: form.attr("action"),
            data: form.serialize(),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            success: function (callback) {
                if(callback.message){
                    toastr.error(callback.message);
                }else{
                    form_ajax.fadeOut( function() {
                       $(this).html("");
                    });
                }

                if(callback.auxs){
                    auxs.prepend(callback.auxs);
                }

                if(callback.auxs2){
                    auxs2.prepend(callback.auxs2);
                }

                if(callback.auxs3){
                    auxs3.prepend(callback.auxs3);
                }

                if(callback.auxs4){
                    auxs4.prepend(callback.auxs4);
                }

                if(callback.auxs5){
                    auxs5.prepend(callback.auxs5);
                }

                if(callback.auxs6){
                    auxs6.prepend(callback.auxs6);
                }

                if(callback.auxs7){
                    auxs7.prepend(callback.auxs7);
                }

                if(callback.auxs8){
                    auxs8.prepend(callback.auxs8);
                }

                if(callback.auxs9){
                    auxs9.prepend(callback.auxs9);
                }

                if(callback.auxs10){
                    auxs10.prepend(callback.auxs10);
                }


                if(callback.auxs11){
                    auxs11.prepend(callback.auxs11);
                }

                if(callback.auxs12){
                    auxs12.prepend(callback.auxs12);
                }
            },
            complete: function () {
                load.fadeOut(200);
            }
        });
    });


    //$("body").on("click","[data-action]", function(e){
      $(".remove").click(function (e) {
        e.preventDefault();

        var r = confirm('Deseja mesmo excluir?')

        if (r == true) {
            var data = $(this).data();
            var div = $(this).parent();

            $.post(data.action, data, function () {
                div.fadeOut();
            }, "json").fail(function () {
                alert("Erro ao processar requisição");
            });
        }
    });


    //TEXT
    $(".txt_text").keypress(function () {
        tecla = event.keyCode;
        if (tecla >= 33 && tecla <= 64 || tecla >= 91 && tecla <= 93 || tecla >= 123 && tecla <= 159 || tecla >= 162 && tecla <= 191) {
            if ((tecla >= 48 && tecla <= 57) || (tecla === 38)) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    });

    //VALIDA CPF
    $(".txt_cpf").blur(function () {
        cpf = $(".txt_cpf").val();
        if ((cpf == "111.111.111-11") || (cpf == "222.222.222-22") || (cpf == "333.333.333-33") || (cpf == "444.444.444-44") || (cpf == "555.555.555-55") || (cpf == "666.666.666-66") || (cpf == "777.777.777-77") || (cpf == "888.888.888-88") || (cpf == "999.999.999-99")) {
            alert("CPF Inválido");
            $(".txt_cpf").val("");
            $(".txt_cpf").focus();
            return false;
        }
        if (cpf != "") {
            var c = cpf.replace(/[\.-]/g, "");
            var i;
            s = c;
            var c = s.substr(0, 9);
            var dv = s.substr(9, 2);
            var d1 = 0;
            var v = false;

            for (i = 0; i < 9; i++) {
                d1 += c.charAt(i) * (10 - i);
            }
            if (d1 == 0) {
                alert("CPF Inválido");
                $(".txt_cpf").val("");
                $(".txt_cpf").focus();
                v = true;
                return false;
            }
            d1 = 11 - (d1 % 11);
            if (d1 > 9)
                d1 = 0;
            if (dv.charAt(0) != d1) {
                alert("CPF Inválido");
                $(".txt_cpf").val("");
                $(".txt_cpf").focus();
                v = true;
                return false;
            }

            d1 *= 2;
            for (i = 0; i < 9; i++) {
                d1 += c.charAt(i) * (11 - i);
            }
            d1 = 11 - (d1 % 11);
            if (d1 > 9)
                d1 = 0;
            if (dv.charAt(1) != d1) {
                alert("CPF Inválido");
                $(".txt_cpf").val("");
                $(".txt_cpf").focus();
                v = true;
                return false;
            }
        }
    });

    //VALIDA DATA
    $(".txt_data").blur(function () {
        var data = $("#" + this.id + "").val();
        var dia = data.substring(0, 2);
        var mes = data.substring(3, 5);
        var ano = data.substring(6, 10);
        var novaData = new Date(ano, (mes - 1), dia);
        var mesmoDia = parseInt(dia, 10) == parseInt(novaData.getDate());
        var mesmoMes = parseInt(mes, 10) == parseInt(novaData.getMonth()) + 1;
        var mesmoAno = parseInt(ano) == parseInt(novaData.getFullYear());
        if ($("#" + this.id + "").val() != "") {
            if (!((mesmoDia) && (mesmoMes) && (mesmoAno)))
            {
                alert("Data Inválida");
                $(this).val("");
                $(this).focus();
                return false;
            }
            //Se a data for válida então retorna true
            return true;
        }
    });

    //CEP
    $("#zipcode").blur(function () {
        var cep = $("#zipcode").val().replace(/[^0-9]/, "");
        var url = "https://viacep.com.br/ws/" + cep + "/json/";
        $.getJSON(url, function (dadosRetorno) {

            $("#street").val(dadosRetorno.logradouro);
            $("#district").val(dadosRetorno.bairro);
            $("#state").val(dadosRetorno.uf);
            $("#city").val(dadosRetorno.localidade);

        });
    });

    //VALIDA NUMERO
    $(".txt_numero").keypress(function () {
        var tecla = (window.event) ? event.keyCode : e.which;
        if (tecla >= 48 && tecla <= 57) {
            return true;
        } else {
            return false;
        }
    });

    // MAKS

    $(".mask-date").mask('00/00/0000');
    $(".mask-date2").mask('00/0000');
    $(".mask-date3").mask('00/00/0000 00:00');
    $(".mask-cep").mask('00000-000');
    $(".mask-tel").mask('(00)0000-0000');
    $(".mask-cel").mask('(00)00000-0000');
    $(".mask-datetime").mask('00/00/0000 00:00');
    $(".mask-month").mask('00/0000', {reverse: true});
    $(".mask-doc").mask('000.000.000-00', {reverse: true});
    $(".mask-doc-company").mask('00.000.000/0000-00', {reverse: true});
    $(".mask-card").mask('0000  0000  0000  0000', {reverse: true});
    $(".mask-money").mask('000.000.000.000.000,00', {reverse: true, placeholder: "0,00"});
    $(".mask-percent").mask('000,00', {reverse: true});
    $(".coefficient").mask('0,000000', {placeholder: "0,000000"});
});

function cont(){

    var content = document.getElementById('div_content').innerHTML;
    impression = window.open('about:blank');
    impression.document.write(content);
    impression.window.print();
    impression.window.close();
}

$(function () {

  $('[data-toggle="tooltip"]').tooltip()

})


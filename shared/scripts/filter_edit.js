$(function () {


    /*$("select ").change(function () {
        var event = document.createEvent('MouseEvents');
        event.initMouseEvent('mousedown', true, true, window);
        element.dispatchEvent(event);

    })*/


    /*   var state = $("select[name='state']").val();
   
       resetaCombo('city');
   
       if (state != "") {
           $.getJSON(path + '/city/select/' + state, function (data) {
   
               var option = new Array();
   
               $.each(data.cities, function (i, obj) {
                   option[i] = document.createElement('option');
                   $(option[i]).attr({ value: obj.cidade_codigo });
                   $(option[i]).append(obj.cidade_descricao);
   
                   if ($("#city_hidden").val() == obj.cidade_codigo) {
                       $(option[i]).attr("selected", "selected");
                   }
   
                   $("select[name='city']").append(option[i]);
   
               });
   
           });
       }*/

    $("#city").empty();

    $("#state :selected").map(function (i, el) {

        $.getJSON(path + '/city/select/' + $(el).val(), function (data) {

            var option = new Array();

            $.each(data.cities, function (i, obj) {

                $("#city").append($("<option></option>").val(obj.cidade_codigo).html(obj.cidade_descricao))
                //option[i] = document.createElement('option');
                //$(option[i]).attr({ value: obj.cidade_codigo });
                //$(option[i]).append(obj.cidade_descricao);

                /*if(document_secundary_complement==obj.id) {
                    $( option[i] ).attr("selected","selected");
                }*/

                //$("select[name='city']").append(option[i]);

            });

        });

    }).get();

    $.getJSON(path + '/city/selected/' + $("#filter_id").val(), function (data2) {
        $.each(data2.cities_selected, function (j, obj_city_selected) {
            //alert(obj_city_selected.city_id)
            //$("#city").val(obj_city_selected.city_id).trigger('change');
            $('#city option[value=' + obj_city_selected.city_id + ']').attr('selected', true).parent().trigger('change');

            /*$('#city').trigger('change'); //This event will fire the change event. 
            $('#city').change(function(){
              $('#city option[value=' + obj_city_selected.city_id + ']').attr('selected', true);              
            });*/
        });
    });

    if ($("#status_filter").val() == "ATIVO") {

        if ($("#organ_text").val() == "4") {
            $("#div_category_siape").show();
            $("#div_category_exercito_marinha").hide();
            $("#div_category_aeronautica").hide();
            $("#div_patent_exercito").hide();
            $("#div_patent_marinha").hide();
            $("#div_patent_aeronautica").hide();
            $("#div_indicative").hide();
            $("#div_legal_regime").show();
            $("#div_organ_siape").show();

            $("#loan_exercito").hide();
            $("#loan_marinha").hide();
            $("#loan_aero").hide();
            $("#loan_siape").show();

            $("#dont_loan_exercito").hide();
            $("#dont_loan_marinha").hide();
            $("#dont_loan_aero").hide();
            $("#dont_loan_siape").show();

        } else {
            if ($("#organ_text").val() == "1") {
                $("#div_category_siape").hide();
                $("#div_category_exercito_marinha").show();
                $("#div_category_aeronautica").hide();
                $("#div_patent_exercito").show();
                $("#div_patent_marinha").hide();
                $("#div_patent_aeronautica").hide();

                $("#loan_exercito").show();
                $("#loan_marinha").hide();
                $("#loan_aero").hide();
                $("#loan_siape").hide();

                $("#dont_loan_exercito").show();
                $("#dont_loan_marinha").hide();
                $("#dont_loan_aero").hide();
                $("#dont_loan_siape").hide();
            }
            if ($("#organ_text").val() == "2") {
                $("#div_category_siape").hide();
                $("#div_category_exercito_marinha").show();
                $("#div_category_aeronautica").hide();
                $("#div_patent_exercito").hide();
                $("#div_patent_marinha").show();
                $("#div_patent_aeronautica").hide();

                $("#loan_exercito").hide();
                $("#loan_marinha").show();
                $("#loan_aero").hide();
                $("#loan_siape").hide();

                $("#dont_loan_exercito").hide();
                $("#dont_loan_marinha").show();
                $("#dont_loan_aero").hide();
                $("#dont_loan_siape").hide();
            }
            if ($("#organ_text").val() == "3") {
                $("#div_category_siape").hide();
                $("#div_category_exercito_marinha").hide();
                $("#div_category_aeronautica").show();
                $("#div_category_aeronautica").prop("disabled", true);
                $("#div_patent_exercito").hide();
                $("#div_patent_marinha").hide();
                $("#div_patent_aeronautica").show();

                $("#loan_exercito").hide();
                $("#loan_marinha").hide();
                $("#loan_aero").show();
                $("#loan_siape").hide();

                $("#dont_loan_exercito").hide();
                $("#dont_loan_marinha").hide();
                $("#dont_loan_aero").show();
                $("#dont_loan_siape").hide();
            }
            $("#div_indicative").show();
            $("#div_legal_regime").hide();
            $("#div_organ_siape").hide();
        }

        $("#form :input").prop("disabled", true);

    } else {
        $("#form :input").prop("disabled", true);
        $("#user").prop("disabled", false);
        $("#title").prop("disabled", false);
        $("#description").prop("disabled", false);
        $("#div_category_aeronautica").prop("disabled", true);
        if (($("#category").val() == 3) && ($("#organ").val() == 1)) {
            $("#patent").prop("disabled", true);
            $("#patent").val("0");
        } else {
            $("#patent").prop("disabled", false);
        }

        if ($("#organ").val() == "4") {
            $("#div_category_siape").show();
            $("#div_category_exercito_marinha").hide();
            $("#div_category_aeronautica").hide();
            $("#div_patent_exercito").hide();
            $("#div_patent_marinha").hide();
            $("#div_patent_aeronautica").hide();
            $("#div_indicative").hide();
            $("#div_legal_regime").show();
            $("#div_organ_siape").show();
            $("#margin_percent").prop("disabled", false);
            $("#until_margin_percent").prop("disabled", false);
            $("#patent").prop("disabled", true);

            $("#margin_percent").prop("disabled", false);
            $("#until_margin_percent").prop("disabled", false);
            $("#margin_of").prop("disabled", false);
            $("#until_margin_of").prop("disabled", false);

            $("#loan_exercito").hide();
            $("#loan_marinha").hide();
            $("#loan_aero").hide();
            $("#loan_siape").show();

            $("#dont_loan_exercito").hide();
            $("#dont_loan_marinha").hide();
            $("#dont_loan_aero").hide();
            $("#dont_loan_siape").show();

        } else {
            $("#div_category_siape").hide();
            $("#patent").prop("disabled", false);
            $("#div_indicative").show();
            $("#div_legal_regime").hide();
            $("#div_organ_siape").hide();
            $("#margin_percent").prop("disabled", true);
            $("#until_margin_percent").prop("disabled", true);
            $("#margin_of").prop("disabled", true);
            $("#until_margin_of").prop("disabled", true);
            if ($("#organ_text").val() == "2" || $("#organ_text").val() == "3") {
                $("#indicative").prop("disabled", true);

                if ($("#organ_text").val() == "3") {
                    $("#div_category_exercito_marinha").hide();
                    $("#div_category_aeronautica").show();
                    $("#div_category_aeronautica").prop("disabled", true);
                    $("#div_patent_exercito").hide();
                    $("#div_patent_marinha").hide();
                    $("#div_patent_aeronautica").show();
                    $("#margin_of").prop("disabled", false);
                    $("#until_margin_of").prop("disabled", false);

                    $("#loan_exercito").hide();
                    $("#loan_marinha").hide();
                    $("#loan_aero").show();
                    $("#loan_siape").hide();

                    $("#dont_loan_exercito").hide();
                    $("#dont_loan_marinha").hide();
                    $("#dont_loan_aero").show();
                    $("#dont_loan_siape").hide();
                } else {
                    $("#div_category_exercito_marinha").show();
                    $("#div_category_aeronautica").hide();
                    $("#div_patent_exercito").hide();
                    $("#div_patent_marinha").show();
                    $("#div_patent_aeronautica").hide();

                    $("#loan_exercito").hide();
                    $("#loan_marinha").show();
                    $("#loan_aero").hide();
                    $("#loan_siape").hide();

                    $("#dont_loan_exercito").hide();
                    $("#dont_loan_marinha").show();
                    $("#dont_loan_aero").hide();
                    $("#dont_loan_siape").hide();
                }

            } else {
                $("#div_category_exercito_marinha").show();
                $("#div_category_aeronautica").hide();
                $("#div_patent_exercito").show();
                $("#div_patent_marinha").hide();
                $("#div_patent_aeronautica").hide();
                $("#indicative").prop("disabled", false);
                $("#margin_of").prop("disabled", false);
                $("#until_margin_of").prop("disabled", false);

                $("#loan_exercito").show();
                $("#loan_marinha").hide();
                $("#loan_aero").hide();
                $("#loan_siape").hide();

                $("#dont_loan_exercito").show();
                $("#dont_loan_marinha").hide();
                $("#dont_loan_aero").hide();
                $("#dont_loan_siape").hide();
            }
        }
        $("#form :input").prop("disabled", true);
        $("#description").prop("disabled", false);
        $("#title").prop("disabled", false);
        $("#user").prop("disabled", false);
        $("#btn_editar").prop("disabled", false);
    }
    $("#organ").change(function () {

        if ($(this).val() == "4") { 
            $("#div_category_siape").show();
            $("#div_category_exercito_marinha").hide();
            $("#div_category_aeronautica").hide();
            $("#div_patent_exercito").hide();
            $("#div_patent_marinha").hide();
            $("#div_patent_aeronautica").hide();
            $("#div_legal_regime").show();
            $("#indicative").val("0");
            $("#div_indicative").hide();
            $("#div_organ_siape").show();
            $("#margin_percent").prop("disabled", false);
            $("#until_margin_percent").prop("disabled", false);
            $("#patent").val("0");
            $("#patent").prop("disabled", true);
            $("#margin_percent").prop("disabled", false);
            $("#until_margin_percent").prop("disabled", false);
            $("#margin_of").prop("disabled", false);
            $("#until_margin_of").prop("disabled", false);

            $("#loan_exercito").hide();
            $("#loan_marinha").hide();
            $("#loan_aero").hide();
            $("#loan_siape").show();

            $("#dont_loan_exercito").hide();
            $("#dont_loan_marinha").hide();
            $("#dont_loan_aero").hide();
            $("#dont_loan_siape").show();

        } else {
            $("#div_category_siape").hide();
            $("#legal_regime").val("0");
            $("#organ_siape").val("0");
            $("#div_indicative").show();
            $("#div_legal_regime").hide();
            $("#div_organ_siape").hide();
            $("#margin_percent").val("");
            $("#margin_percent").prop("disabled", true);
            $("#until_margin_percent").val("");
            $("#until_margin_percent").prop("disabled", true);
            $("#margin_of").val("");
            $("#margin_of").prop("disabled", true);
            $("#until_margin_of").val("");
            $("#until_margin_of").prop("disabled", true);
            $("#patent").prop("disabled", false);

            if ($(this).val() == "2" || $(this).val() == "3") {
                $("#indicative").val("0");
                $("#indicative").prop("disabled", true);
                if ($(this).val() == "3") { 
                    $("#div_category_exercito_marinha").hide();
                    $("#div_category_aeronautica").show();
                    $("#div_patent_exercito").hide();
                    $("#div_patent_marinha").hide();
                    $("#div_patent_aeronautica").show();
                    $("#margin_of").prop("disabled", false);
                    $("#until_margin_of").prop("disabled", false);

                    $("#loan_exercito").hide();
                    $("#loan_marinha").hide();
                    $("#loan_aero").show();
                    $("#loan_siape").hide();

                    $("#dont_loan_exercito").hide();
                    $("#dont_loan_marinha").hide();
                    $("#dont_loan_aero").show();
                    $("#dont_loan_siape").hide();
                } else {
                    $("#div_category_exercito_marinha").show();
                    $("#div_category_aeronautica").hide();
                    $("#div_patent_exercito").hide();
                    $("#div_patent_marinha").show();
                    $("#div_patent_aeronautica").hide();

                    $("#loan_exercito").hide();
                    $("#loan_marinha").show();
                    $("#loan_aero").hide();
                    $("#loan_siape").hide();

                    $("#dont_loan_exercito").hide();
                    $("#dont_loan_marinha").show();
                    $("#dont_loan_aero").hide();
                    $("#dont_loan_siape").hide();
                }

            } else {

                $("#div_category_exercito_marinha").show();
                $("#div_category_aeronautica").hide();
                $("#div_patent_exercito").show();
                $("#div_patent_marinha").hide();
                $("#div_patent_aeronautica").hide();
                $("#indicative").prop("disabled", false);

                if ($("#category").val() == 3) {
                    $("#patent").prop("disabled", true);
                    $("#patent").val("0");
                }

                $("#margin_of").prop("disabled", false);
                $("#until_margin_of").prop("disabled", false);

                $("#loan_exercito").show();
                $("#loan_marinha").hide();
                $("#loan_aero").hide();
                $("#loan_siape").hide();

                $("#dont_loan_exercito").show();
                $("#dont_loan_marinha").hide();
                $("#dont_loan_aero").hide();
                $("#dont_loan_siape").hide();
            }
        }

    });

    $("#category").change(function () {
        if (($("#category").val() == 3) && ($("#organ").val() == 1)) {
            $("#patent").prop("disabled", true);
            $("#patent").val("0");
        } else {
            $("#patent").prop("disabled", false);
        }
    });

    $("#state").change(function () {

        $("#city").empty();

        $("#state :selected").map(function (i, el) {

            $.getJSON(path + '/city/select/' + $(el).val(), function (data) {

                var option = new Array();

                $.each(data.cities, function (i, obj) {
                    $("#city").append($("<option></option>").val(obj.cidade_codigo).html(obj.cidade_descricao))
                    //option[i] = document.createElement('option');
                    //$(option[i]).attr({ value: obj.cidade_codigo });
                    //$(option[i]).append(obj.cidade_descricao);

                    /*if(document_secundary_complement==obj.id) {
                        $( option[i] ).attr("selected","selected");
                    }*/

                    //$("select[name='city']").append(option[i]);

                });

            });

        }).get();

        /*var state = $("select[name='state']").val();

        resetaCombo('city');

        if (state != "") {

        }*/
    })


})
function close_modal() {

    resetaCombo2('bank');
    resetaCombo2('bank_discount');
    resetaCombo2('bank_dont_descount');

    $.getJSON(path + '/cadastro/bank/select', function (data) {

        var option = new Array();
        var option2 = new Array();
        var option3 = new Array();

        $.each(data.bank, function (i, obj) {
            option[i] = document.createElement('option');
            $(option[i]).attr({ value: obj.id });
            $(option[i]).append(obj.bank);

            if (bank == obj.id) {
                $(option[i]).attr("selected", "selected");
            }

            $("select[name='bank']").append(option[i]);

        });

        $.each(data.bank, function (i, obj) {
            option2[i] = document.createElement('option');
            $(option2[i]).attr({ value: obj.id });
            $(option2[i]).append(obj.bank);

            if (bank == obj.id) {
                $(option2[i]).attr("selected", "selected");
            }

            $("select[name='bank_discount']").append(option2[i]);

        });

        $.each(data.bank, function (i, obj) {
            option3[i] = document.createElement('option');
            $(option3[i]).attr({ value: obj.id });
            $(option3[i]).append(obj.bank);

            if (bank == obj.id) {
                $(option3[i]).attr("selected", "selected");
            }

            $("select[name='bank_dont_descount']").append(option3[i]);

        });

    });

}

function resetaCombo2(el) {
    $("select[name='" + el + "']").empty();
}

function resetaCombo(el) {
    $("select[name='" + el + "']").empty();
    var option = document.createElement('option');
    $(option).attr({ value: '' });
    $(option).append('--Selecione--');
    $("select[name='" + el + "']").append(option);
}



$(function () {
    $("form").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var load = $(".ajax_load");

        load.fadeIn(200).css("display", "flex");

        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: form.serialize(),
            dataType: "json",
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

    // MAKS

    $(".mask-date").mask('00/00/0000');
    $(".mask-doc").mask('000.000.000-00', {reverse: true});
});
$(document).ready(function () {
    $("#dataImportacao").val($("#dataServidor").val());
    $("#submitbutton").on("click", function(e) {
        $("#usuario").attr("disabled", "false");
    });
});
    
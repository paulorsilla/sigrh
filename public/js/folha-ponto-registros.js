   
    function novaJustificativa(ocorrencia) {
        url = "/sig-rh/ocorrencia/save-modal/" + ocorrencia;
        $('#JustificativaModal .modal-body').html('carregando...');
        $('#JustificativaModal .modal-body').attr('url', url);
        $('#JustificativaModal .modal-body').load(url);
        $('#JustificativaModal').modal('show');
        
    }

    function editarJustificativa(ocorrencia) {
        url = "/sig-rh/ocorrencia/save-modal/" + ocorrencia;
        $('#JustificativaModal .modal-body').html('carregando...');
        $('#JustificativaModal .modal-body').attr('url', url);
        $('#JustificativaModal .modal-body').load(url);
        $('#JustificativaModal').modal('show');
    }

    function refreshGridJustificativa(ocorrencia) {
//        url = "/sig-rh/conta-corrente/grid-modal?matricula="+matricula;
//        $('#gridContaCorrente').html('carregando...');
//        $('#gridContaCorrente').load(url);
    }

    function fncSalvarJustificativa(obj) {
        $(this).html("aguarde ...").attr("disabled", true);
        form = $("form", $(obj).closest(".modal-content"));
        dados = $(form).serializeObject();

        urlPost = $(".modal-body", $(obj).closest(".modal-content")).attr('url');

        $.post(urlPost, dados, function (data) {
            if (data.success == 1) {

                //$("<option></option>").val(data.id).html(data.descricao).appendTo($("select[name=ca_id]"));
                //$("select[name=ca_id]").val(data.id);
                $("#JustificativaModal").modal('hide');
                refreshGridJustificativa($("input#ocorrencia").val());
            } else {
                $(".modal-body", $(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    }
    
$(document).ready(function () {
        
        $('.modal-body').change('justificativa', function(e) {
            e.preventDefault();
           alert($("#justificativa").val());
        });
        
        var horarios = $('#horarios');
        horarios.hide();

});

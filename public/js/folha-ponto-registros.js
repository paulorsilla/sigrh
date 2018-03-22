    function novaJustificativa(ocorrencia) 
    {
        url = "/sig-rh/ocorrencia/save-modal/" + ocorrencia;
        $('#JustificativaModal .modal-body').html('carregando...');
        $('#JustificativaModal .modal-body').attr('url', url);
        $('#JustificativaModal .modal-body').load(url);
        $('#JustificativaModal').modal('show');
//        $('#JustificativaModal').on("ajax:shown", function() {
//            $("#horarios").hide();
//            alert("boa tarde");
//        });
    }

    function editarJustificativa(ocorrencia) 
    {
        url = "/sig-rh/ocorrencia/save-modal/" + ocorrencia;
        $('#JustificativaModal .modal-body').html('carregando...');
        $('#JustificativaModal .modal-body').attr('url', url);
        $('#JustificativaModal .modal-body').load(url);
        $('#JustificativaModal').modal('show');
    }

    function refreshGridJustificativa(ocorrencia) 
    {
//        url = "/sig-rh/conta-corrente/grid-modal?matricula="+matricula;
//        $('#gridContaCorrente').html('carregando...');
//        $('#gridContaCorrente').load(url);
    }

    function fncSalvarJustificativa(obj) 
    {
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
    
//    function adicionarCampoJustificativa() 
//    {
//        var novaJustificativa = $("#justificativa").clone();
//        var novaLinha = $("<div class='row'><div class='col-md-10'><select class='form-control' id='justificativa' name='justificativa[]' onchange='alterouJustificativa()'>"+novaJustificativa.html()+
//                          "</select><br></div><div class='col-md-2'><button class='btn btn-secondary' type='button' onclick='removerCampoJustificativa($(this))' id='removerJustificativa'><span class='glyphicon glyphicon-minus'></span></button></div></div>");
//        novaLinha.appendTo("#justificativas");
//    }
//    
//    function removerCampoJustificativa(obj)
//    {
//        obj.closest('.row').remove();
//    }
    
    function exibicaoHorarios() 
    {
        var indicarHorario = $("#indicarHorario").val().split(",");
        var justificativa1 = $("#justificativa1").val();
        var justificativa2 = $("#justificativa2").val();
        
        if ( (indicarHorario.indexOf(justificativa1) > -1) || (indicarHorario.indexOf(justificativa2)) > -1 ) {
            $("#horarios").show();
        } else {
            $("#horarios").hide();
        }
    }

    
$(document).ready(function () {
    $("#JustificativaModal").on("shown.bs.modal", function() {
        exibicaoHorarios();
    });

});

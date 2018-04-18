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
                $("#JustificativaModal").modal('hide');
                location.reload();
//                refreshGridJustificativa($("input#ocorrencia").val());
            } else {
                $(".modal-body", $(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    }
    
    function incluirHorario(movimentacaoId) 
    {
        url = "/sig-rh/registro-horario/save-modal/" + movimentacaoId;
        $('#IncluirHorarioModal .modal-body').html('carregando...');
        $('#IncluirHorarioModal .modal-body').attr('url', url);
        $('#IncluirHorarioModal .modal-body').load(url);
        $('#IncluirHorarioModal').modal('show');
    }
    
    function fncSalvarHorario(obj) 
    {
        $(this).html("aguarde ...").attr("disabled", true);
        form = $("form", $(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body", $(obj).closest(".modal-content")).attr('url');

        $.post(urlPost, dados, function (data) {
            if (data.success === 1) {
                $("#IncluirHorarioModal").modal('hide');
                location.reload();
////                refreshGridJustificativa($("input#ocorrencia").val());
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
    
    function excluirHorario(indice, id, registro) 
    {
        if (confirm("Clique em 'OK' para confirmar a exclusão do registro: "+registro+".")) {
            $.ajax({
                method: 'get',
                url: '/sig-rh/registro-horario/delete/'+id,
                success: function(d) {
                    $("#horario"+indice).remove();
                },
            });
        }
    }
    
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
    
    function moverE1S1()
    {
        if ( ($("#entrada1").val() !== "") && ($("#saida1").val() === "") ) {
            $("#saida1").val($("#entrada1").val());
            $("#entrada1").val("");
        }
    }
    
    function moverS1E1()
    {
        if ( ($("#saida1").val() !== "") && ($("#entrada1").val() === "") ) {
            $("#entrada1").val($("#saida1").val());
            $("#saida1").val("");
        }
    }

    function moverS1E2()
    {
        if ( ($("#saida1").val() !== "") && ($("#entrada2").val() === "") ) {
            $("#entrada2").val($("#saida1").val());
            $("#saida1").val("");
        }
    }

    function moverE2S1()
    {
        if ( ($("#entrada2").val() !== "") && ($("#saida1").val() === "") ) {
            $("#saida1").val($("#entrada2").val());
            $("#entrada2").val("");
        }
    }
    
    function moverE2S2()
    {
        if ( ($("#entrada2").val() !== "") && ($("#saida2").val() === "") ) {
            $("#saida2").val($("#entrada2").val());
            $("#entrada2").val("");
        }
    }

    function moverS2E2()
    {
        if ( ($("#saida2").val() !== "") && ($("#entrada2").val() === "") ) {
            $("#entrada2").val($("#saida2").val());
            $("#saida2").val("");
        }
    }
    
$(document).ready(function () {
    $("#JustificativaModal").on("shown.bs.modal", function() {
        exibicaoHorarios();
        $("#moverE1S1").click(function() {
            moverE1S1();
        });
        $("#moverS1E1").click(function() {
            moverS1E1();
        });
        $("#moverS1E2").click(function() {
            moverS1E2();
        });
        $("#moverE2S1").click(function() {
            moverE2S1();
        });
        $("#moverE2S2").click(function() {
            moverE2S2();
        });
        $("#moverS2E2").click(function() {
            moverS2E2();
        });

    });
    $('[data-toggle="tooltip"]').tooltip();

});

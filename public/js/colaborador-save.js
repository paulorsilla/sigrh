    function novaContaCorrente(matricula){
        url = "/sig-rh/conta-corrente/save-modal?matricula="+matricula;
        $('#ContaCorrenteModal .modal-body').html('carregando...');
        $('#ContaCorrenteModal .modal-body').attr('url',url);
        $('#ContaCorrenteModal .modal-body').load(url);
        $('#ContaCorrenteModal').modal('show');
    }
    
    function editarContaCorrente(id){
        var matricula = $("input#matricula").val();
        url = "/sig-rh/conta-corrente/save-modal/"+id+"?matricula="+matricula;
        $('#ContaCorrenteModal .modal-body').html('carregando...');
        $('#ContaCorrenteModal .modal-body').attr('url',url);
        $('#ContaCorrenteModal .modal-body').load(url);
        $('#ContaCorrenteModal').modal('show');
    }

    function excluirContaCorrente(id){
        var matricula = $("input#matricula").val();
        url = "/sig-rh/conta-corrente/delete-modal/"+id+"?matricula="+matricula;
        $('#ExclusaoCCModal .modal-body').html('carregando...');
        $('#ExclusaoCCModal .modal-body').attr('url',url);
        $('#ExclusaoCCModal .modal-body').load(url);
        $('#ExclusaoCCModal').modal('show');
    }
    
    function refreshGridContaCorrente(matricula){
        url = "/sig-rh/conta-corrente/grid-modal?matricula="+matricula;
        $('#gridContaCorrente').html('carregando...');
        $('#gridContaCorrente').load(url);
    }
    
    function fncExcluirContaCorrente(obj) {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoCCModal").modal('hide');
                refreshGridContaCorrente($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function fncSalvarContaCorrente(obj){
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                
                //$("<option></option>").val(data.id).html(data.descricao).appendTo($("select[name=ca_id]"));
                //$("select[name=ca_id]").val(data.id);
                $("#ContaCorrenteModal").modal('hide');
                refreshGridContaCorrente($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    
    function novoVinculo(matricula){
        url = "/sig-rh/vinculo/save-modal?matricula="+matricula;
        $('#VinculoModal .modal-body').html('carregando...');
        $('#VinculoModal .modal-body').attr('url',url);
        $('#VinculoModal .modal-body').load(url);
        $('#VinculoModal').modal('show');
    }
    
    function editarVinculo(id){
        url = "/sig-rh/vinculo/save-modal/"+id;
        $('#VinculoModal .modal-body').html('carregando...');
        $('#VinculoModal .modal-body').attr('url',url);
        $('#VinculoModal .modal-body').load(url);
        $('#VinculoModal').modal('show');
    }
    
    function clonarVinculo(id,matricula){
        url = "/sig-rh/vinculo/save-modal?clonar="+id+"&matricula="+matricula;
        $('#VinculoModal .modal-body').html('carregando...');
        $('#VinculoModal .modal-body').attr('url',url);
        $('#VinculoModal .modal-body').load(url);
        $('#VinculoModal').modal('show');
    }

    function fncSalvarVinculo(obj){
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                
                $("#VinculoModal").modal('hide');
                refreshGridVinculo($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    
    function refreshGridVinculo(matricula){
        url = "/sig-rh/vinculo/grid-modal?matricula="+matricula;
        $('#gridVinculo').html('carregando...');
        $('#gridVinculo').load(url);
    }
    
    function excluirVinculo(id){
        var matricula = $("input#matricula").val();
        url = "/sig-rh/vinculo/delete-modal/"+id+"?matricula="+matricula;;
        $('#ExclusaoVinculoModal .modal-body').html('carregando...');
        $('#ExclusaoVinculoModal .modal-body').attr('url',url);
        $('#ExclusaoVinculoModal .modal-body').load(url);
        $('#ExclusaoVinculoModal').modal('show');

    }
    
    function fncExcluirVinculo(obj) {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoVinculoModal").modal('hide');
                refreshGridVinculo($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function fncSalvarHorario(obj, vinculoId){
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        
        $.post(urlPost,dados,function(data){
            if ( data.success == 1 ){
                
                $("#HorarioModal").modal('hide');
                refreshGridHorario(vinculoId);
                 
                
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 

    function novoDependente(matricula){
        url = "/sig-rh/dependente/save-modal?matricula="+matricula;
        $('#DependenteModal .modal-body').html('carregando...');
        $('#DependenteModal .modal-body').attr('url',url);
        $('#DependenteModal .modal-body').load(url);
        $('#DependenteModal').modal('show');
    }
    
    function editarDependente(id){
        var matricula = $("input#matricula").val();
        url = "/sig-rh/dependente/save-modal/"+id+"?matricula="+matricula;
        $('#DependenteModal .modal-body').html('carregando...');
        $('#DependenteModal .modal-body').attr('url',url);
        $('#DependenteModal .modal-body').load(url);
        $('#DependenteModal').modal('show');
    }

    function excluirDependente(id){
        var matricula = $("input#matricula").val();
        url = "/sig-rh/dependente/delete-modal/"+id+"?matricula="+matricula;
        $('#ExclusaoDependenteModal .modal-body').html('carregando...');
        $('#ExclusaoDependenteModal .modal-body').attr('url',url);
        $('#ExclusaoDependenteModal .modal-body').load(url);
        $('#ExclusaoDependenteModal').modal('show');
    }

    function fncExcluirDependente(obj) {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoDependenteModal").modal('hide');
                refreshGridDependente($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }

    function refreshGridDependente(matricula){
        url = "/sig-rh/dependente/grid-modal?matricula="+matricula;
        $('#gridDependentes').html('carregando...');
        $('#gridDependentes').load(url);
    }

    function fncSalvarDependente(obj){
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost,dados,function(data){
            if ( data.success == 1 ) {
                $("#DependenteModal").modal('hide');
                refreshGridDependente($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    } 
    
    function refreshGridHorario(id){
        url = "/sig-rh/horario/grid-modal?vinculoId="+id;
        $('#gridHorarios').html('carregando...');
        $('#gridHorarios').load(url);
    }
    
    function editarEscala(id){
        url = "/sig-rh/horario/save-modal?id="+id;
        $('#HorarioModal .modal-body').html('carregando...');
        $('#HorarioModal .modal-body').attr('url',url);
        $('#HorarioModal .modal-body').load(url);
        $('#HorarioModal').modal('show');
    }
    
    function novoCracha(matricula) {
        url = "/sig-rh/cracha/save-modal?matricula="+matricula;
        $('#CrachaModal .modal-body').html('carregando...');
        $('#CrachaModal .modal-body').attr('url',url);
        $('#CrachaModal .modal-body').load(url);
        $('#CrachaModal').modal('show');    
    }

    function refreshGridCracha(matricula){
        url = "/sig-rh/cracha/grid-modal?matricula="+matricula;
        $('#gridCracha').html('carregando...');
        $('#gridCracha').load(url);
    }
   
    function editarCracha(id){
        var matricula = $("input#matricula").val();
        url = "/sig-rh/cracha/save-modal/"+id+"?matricula="+matricula;
        $('#CrachaModal .modal-body').html('carregando...');
        $('#CrachaModal .modal-body').attr('url',url);
        $('#CrachaModal .modal-body').load(url);
        $('#CrachaModal').modal('show');
    }
    
    function fncSalvarCracha(obj){
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#CrachaModal").modal('hide');
                refreshGridCracha($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    }
    
    function excluirCracha(id){
        var matricula = $("input#matricula").val();
        url = "/sig-rh/cracha/delete-modal/"+id+"?matricula="+matricula;
        $('#ExclusaoCrachaModal .modal-body').html('carregando...');
        $('#ExclusaoCrachaModal .modal-body').attr('url',url);
        $('#ExclusaoCrachaModal .modal-body').load(url);
        $('#ExclusaoCrachaModal').modal('show');
    }
    
    function fncExcluirCracha(obj) {
        $(this).html("aguarde ...").attr("disabled",true);
        form =  $("form",$(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#ExclusaoCrachaModal").modal('hide');
                refreshGridCracha($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
        });
    }
    
    function editarRecessoObrigatorio(id){
        url = "/sig-rh/recesso-obrigatorio/save-modal?id="+id;
        $('#RecessoModal .modal-body').html('carregando...');
        $('#RecessoModal .modal-body').attr('url',url);
        $('#RecessoModal .modal-body').load(url);
        $('#RecessoModal').modal('show');
    }
    
    function fncSalvarRecessoObrigatorio(obj){
        $(this).html("aguarde ...").attr("disabled", true);
        form =  $("form", $(obj).closest(".modal-content"));
        dados = $(form).serializeObject();
        urlPost = $(".modal-body",$(obj).closest(".modal-content")).attr('url');
        $.post(urlPost, dados, function(data){
            if ( data.success == 1 ){
                $("#RecessoModal").modal('hide');
//                refreshGridCracha($("input#matricula").val());
            } else {
                $(".modal-body",$(obj).closest(".modal-content")).html(data);
            }
            $(this).html("Salvar").removeAttr("disabled");
        });
    }
    
    function mascarasEntrada()
    {
        $("#cpf").inputmask("999.999.999-99");
        $("#cep").inputmask("99999-999");
    }
    
    function uploadFoto()
    {
//        var extensoesPermitidas = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        var extensoesPermitidas = ['jpg'];
        var extensao = $("#arquivoFoto").val().split('.').pop().toLowerCase();
        if ($.inArray(extensao, extensoesPermitidas) === -1) {
            $("#validacaoFoto").val("");
            alert("Formato de arquivo inválido, verifique!");
        } else {
            $("#validacaoFoto").val("1");
            $("#foto").val(extensao);
        }
    }
    
    function excluirRecesso(recessoId, vinculoId) 
    {
        if (confirm("Clique em 'OK' para confirmar a exclusão do registro.")) {
            $.ajax({
                method: 'get',
                url: '/sig-rh/recesso-obrigatorio/delete/'+recessoId,
                async: false,
            });
        }
        url = "/sig-rh/recesso-obrigatorio/save-modal?id="+vinculoId;
        $('#RecessoModal .modal-body').load(url);
    }
    
$(document).ready(function () {
    mascarasEntrada();
    //var matricula = $("#matricula").val();
    //$("#imgFoto").attr("src", "/img/fotos/jpg/"+matricula+"."+$("#foto").val());
    
// Carregar as cidades do banco de dados e salvar na variavel vCidades em JSON
//    var vCidades = [
//        {id: 'SP', estado: 'Sao Paulo', cidades: [{id: 1, cidade: 'Sao Paulo'}, {id: 2, cidade: 'Santos'}, {id: 3, cidade: 'Praia Grande'}]},
//        {id: 'PR', estado: 'Parana', cidades: [{id: 7, cidade: 'Londrina'}, {id: 8, cidade: 'Cambé'}]}
//        
//    ];
    var vCidades = [];

    function carregaComboCidades(uf, opcao) {
        //opcao = 1 => combo cidade (endereco)
        //opcao = 2 => combo cidade (natual)
        if (opcao === "1") $("select[name=cidade]").html('<option>Selecione</option>');
        if (opcao === "2") $("select[name=natural]").html('<option>Selecione</option>');

        $.ajax({
            type: "POST",
            url: "/sig-rh/cidade/busca-cidades",
            async: false,
            data: {uf: uf},
            success: function (d) {
                vCidades = $.parseJSON(d.cidades);
            },
            dataType: "JSON"
        });

        $.each(vCidades, function (i, item) {
            if (opcao === "1") {
                $("<option></option>").val(item.id).html(item.cidade).appendTo($("select[name=cidade]"));
            } else if (opcao === "2") {
               $("<option></option>").val(item.id).html(item.cidade).appendTo($("select[name=natural]"));
            }
        });

//        $(vCidades).each(function (i, item) {
//            achou = false;
//            $(item.cidades).each(function (i2, item2) {
//                $("<option></option>").val(item2.id).html(item2.cidade).appendTo($("select[name=cidade]"));
//            });
//        });
    }
    
    function selecionaEstado(uf) {
        var idEstado = 0;
        $("select[name=estado] option").each(function() {
            if ($(this).text() === uf) {
                $(this).attr("selected", "selected");
                idEstado = $(this).val();
            }
        });
        return idEstado;
    }
    
    function selecionaCidade(cidade) {
        $("select[name=cidade] option").each(function() {
           if ($(this).text() === cidade) {
               $(this).attr("selected", "selected");
           }
        });
    }
    
//    function addCidade(uf, nome) {
//        $(vCidades).each(function (i, item) {
//            if (item.id === uf) {
//                achou = false;
//                $(item.cidades).each(function (i2, item2) {
//                    if (item2.cidade === nome) {
//                        achou = true;
//                        $("select[name=cidade]").val(item2.id);
//                    }
//                });
//                if (!achou) {
//                    // fazer uma chamada POST para um action e cadastrar essa cidade retornando o id via json
//                    item.cidades.push({id: 999, cidade: nome});
//                    carregaComboCidades(uf);
//                    $("select[name=cidade]").val(999);
//                }
//            }
//        });
//        console.log(achou);
//    }

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("input[name=endereco]").val("");
        $("input[name=bairro]").val("");
        $("select[name=cidade]").val("");
        $("input[name=estado]").val("");
//        $("#ibge").val("");
    }
    $("select[name=estado]").change(function () {
        carregaComboCidades($(this).val(), '1');
    });
    
    $("select[name=natural_estado]").change(function () {
        carregaComboCidades($(this).val(), '2');
    });


    //Quando o campo cep perde o foco.
    $("input[name=cep]").change(function () {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep !== "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
//                        $("input[name=endereco]").val("...");
//                        $("input[name=bairro]").val("...");
//                        $("#cidade").val("...");
//                        $("#uf").val("...");
//                        $("#ibge").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("input[name=endereco]").val(dados.logradouro);
                        $("input[name=bairro]").val(dados.bairro);
                        var idEstado = selecionaEstado(dados.uf);
                        carregaComboCidades(idEstado);
 //                       addCidade(dados.uf, dados.localidade);
                        selecionaCidade(dados.localidade);

                        
                        //$("select[name=cidade]").val(dados.localidade);
//                        $("input[name=estado]").val(dados.uf);
                        //$("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
    
});

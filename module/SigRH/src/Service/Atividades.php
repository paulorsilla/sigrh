<?php
namespace SigRH\Service;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Atividades {
    
    private $_adapter;
    
    public function __construct($adapter){//$serviceInst
        $this->_adapter = $adapter;
    }
    
    public function getDescricao($cod){ 
        if     ( empty($cod))
            return "Não informado";
        
        $select = "select * from prj_tb_atividades where cod_atividade = $cod";
        //die( $select );
        $query = $this->_adapter->query($select);
        $registros = $query->execute();
        if ( $registros->count() == 0 )
            return "Atividade não encontrada";
        $row = $registros->current();
        return $row["num_atividade"];
        
    }
    
    public function getParceiro($id){
    
        $query = $this->_adapter->query("select * from sis_parceiros where idparceiros = '$id'");
        $registros = $query->execute();

        return $registros->current();
        
    }
    public function getListAtividades($limit = 0){
    
        $select = "select * from prj_tb_atividades";
        if ( $limit > 0 ) 
            $select .= " limit $limit ";
        $query = $this->_adapter->query($select);
        $registros = $query->execute();

        $retorno = array();
        foreach($registros as $ativ){
            $retorno[] = array('id'=> $ativ['cod_atividade'], 'atividade'=>$ativ['num_atividade']);
        }
        return $retorno;
    }
    public function getListAtividadesParaCombo($limit = 0,$func = null,$idsPermitidos=null){
    
        $select = "select a.* from prj_tb_atividades a";
        if ( $func != null )
                $select .= " join prj_tb_equipe e on (a.cod_atividade = e.prj_tb_atividades_cod_atividade) where  e.rh_tb_funcionario_cod_func = '$func' ";
        $select .=" order by num_atividade";
        
        if ( $limit > 0 ) 
            $select .= " limit $limit ";
        $query = $this->_adapter->query($select);
        $registros = $query->execute();

        $retorno = array();
        if ( is_array($idsPermitidos) ) {
            //var_dump($idsPermitidos); die();
            foreach($registros as $ativ){
                 if ( in_array($ativ['cod_atividade'],$idsPermitidos) )
                    $retorno[ $ativ['cod_atividade'] ] = $ativ['num_atividade'];
            }
        } else {
            foreach($registros as $ativ){
                $retorno[ $ativ['cod_atividade'] ] = $ativ['num_atividade'];
            }
        }
        return $retorno;
    }
    public function getAtividade($id){
    
        $query = $this->_adapter->query("select * from prj_tb_atividades where cod_atividade = '$id'");
        $registros = $query->execute();

        if ( $registros->count() == 0 ) 
            return null;
        return $registros->current();
        
    }
    public function getPlanoAcao($id){
    
        $query = $this->_adapter->query("select * from prj_tb_plano_acao where cod_pa = '$id'");
        $registros = $query->execute();

        if ( $registros->count() == 0 ) 
            return null;
        return $registros->current();
        
    }
    public function getProjeto($id){
    
        $query = $this->_adapter->query("select * from prj_tb_projetos where cod_projeto = '$id'");
        $registros = $query->execute();

        if ( $registros->count() == 0 ) 
            return null;
        return $registros->current();
        
    }
    
    public function getAtividadePorNumero($id){
    
        $query = $this->_adapter->query("select * from prj_tb_atividades where num_atividade = '$id'");
        $registros = $query->execute();

        if ( $registros->count() == 0 ) 
            return null;
        return $registros->current();
        
    }
    public function getListAtividadePorNumero($id){
     $query = $this->_adapter->query("select * from prj_tb_atividades where num_atividade like '$id%'");
        $registros = $query->execute();

        return $registros;
        
    }
    
    public function getProjetoPorAtividade($idAtividade){
        $query = $this->_adapter->query("select p.*
                from prj_tb_projetos p
                join prj_tb_plano_acao a on (p.cod_projeto = a.prj_tb_projetos_cod_projeto)
                join  prj_tb_atividades atv on (atv.prj_tb_plano_acao_cod_pa = a.cod_pa)
            where atv.cod_atividade =  $idAtividade ");
        $registros = $query->execute();
        if ( $registros->count() == 0 ) 
            return null;
        $row = $registros->current();
        
        return $row;
        
    }
//    public function getResponsavelProjeto($idAtividade){
//        if ( empty($idAtividade)) $idAtividade=0;
//        $query = $this->_adapter->query("select rh_tb_funcionario_cod_func,sis_parceiros_idparceiros
//                from prj_tb_equipe e
//                join prj_tb_plano_acao a on (e.prj_tb_projetos_cod_projeto = a.prj_tb_projetos_cod_projeto)
//                join  prj_tb_atividades atv on (atv.prj_tb_plano_acao_cod_pa = a.cod_pa)
//            where atv.cod_atividade =  $idAtividade and
//                (e.data_ini_vigencia is null or e.data_ini_vigencia <= current_date()) and
//                (e.data_fim_vigencia is null or e.data_fim_vigencia >= current_date())");
//        $registros = $query->execute();
//        if ( $registros->count() == 0 ) 
//            return null;
//        $row = $registros->current();
//        
//        // Pegar o nome do funcionario ou parceiro
//        if ( !empty($row['rh_tb_funcionario_cod_func'])){
//            $func = $this->getServiceFuncionario()->getFuncionario($row['rh_tb_funcionario_cod_func']);
//            return $row['rh_tb_funcionario_cod_func'].' - '.(empty($func["nome_func"])?"Não encontrado":$func["nome_func"]);
//        }
//        
//        if ( !empty($row['sis_parceiro_idparceiros']))
//            return $row['sis_parceiro_idparceiros'];
//        
//        return null;
//    }
    
//    public function getResponsavelPlano($idAtividade){
//        if ( empty($idAtividade)) $idAtividade=0;
//        $query = $this->_adapter->query("select rh_tb_funcionario_cod_func,sis_parceiros_idparceiros
//                                        from prj_tb_equipe e 
//                                        join  prj_tb_atividades atv on (atv.prj_tb_plano_acao_cod_pa = e.prj_tb_plano_acao_cod_pa)
//                                        where
//                                        atv.cod_atividade =  $idAtividade 
//                                        and
//                                        (e.data_ini_vigencia is null or e.data_ini_vigencia <= current_date()) and
//                                        (e.data_fim_vigencia is null or e.data_fim_vigencia >= current_date())");
//
//        $registros = $query->execute();
//        if ( $registros->count() == 0 ) 
//            return null;
//        $row = $registros->current();
//        
//        // Pegar o nome do funcionario ou parceiro
//        if ( !empty($row['rh_tb_funcionario_cod_func'])) {
//            $func = $this->getServiceFuncionario()->getFuncionario($row['rh_tb_funcionario_cod_func']);
//            return $row['rh_tb_funcionario_cod_func'].' - '.(empty($func["nome_func"])?"Não encontrado":$func["nome_func"]);
//        }
//        
//        if ( !empty($row['sis_parceiro_idparceiros']))
//            return $row['sis_parceiro_idparceiros'];
//        
//        return null;
//    }
//    
//    public function getResponsavelAtividade($idAtividade){
//        if ( empty($idAtividade)) $idAtividade=0;
//        $query = $this->_adapter->query("select rh_tb_funcionario_cod_func,sis_parceiros_idparceiros
//                                        from prj_tb_equipe 
//                                        where  prj_tb_atividades_cod_atividade = $idAtividade
//                                        and
//                                        (data_ini_vigencia is null or data_ini_vigencia <= current_date()) 
//                                        and
//                                        (data_fim_vigencia is null or data_fim_vigencia >= current_date())");
//
//        $registros = $query->execute();
//        if ( $registros->count() == 0 ) 
//            return null;
//        $row = $registros->current();
//        
//        // Pegar o nome do funcionario ou parceiro
//        if ( !empty($row['rh_tb_funcionario_cod_func'])) {
//            $func = $this->getServiceFuncionario()->getFuncionario($row['rh_tb_funcionario_cod_func']);
//            return $row['rh_tb_funcionario_cod_func'].' - '.(empty($func["nome_func"])?"Não encontrado":$func["nome_func"]);
//        }
//        
//        if ( !empty($row['sis_parceiro_idparceiros']))
//            return $row['sis_parceiro_idparceiros'];
//        
//        return null;
//    }
//    public function getResponsavelAtividadeSemMatricula($idAtividade){
//        
//        $data = date('Y-m-d');
//        $projeto = $this->getProjetoPorAtividade($idAtividade);
//        if ( !empty($projeto)) {
//            $dtini = \DateTime::createFromFormat('Y-m-d', $projeto['data_ini_vigencia']);
//            if ( $dtini != null && $dtini->getTimestamp() > time() ){
//                $data = $projeto['data_ini_vigencia'];
//            } else {
//                $dtfim = \DateTime::createFromFormat('Y-m-d', $projeto['data_fim_vigencia']);
//                if ( $dtfim != null && $dtfim->getTimestamp() < time() ){
//                    $data = $projeto['data_fim_vigencia'];
//                }
//            }
//            
//        }
//        if ( empty($idAtividade)) $idAtividade=0;
//        $query = $this->_adapter->query("select rh_tb_funcionario_cod_func,sis_parceiros_idparceiros
//                                        from prj_tb_equipe 
//                                        where  
//                                        prj_tb_atividades_cod_atividade = $idAtividade
//                                        and
//                                        (data_ini_vigencia is null or data_ini_vigencia <= '$data') 
//                                        and
//                                        (data_fim_vigencia is null or data_fim_vigencia >= '$data') and funcao='lider'");
//
//        $registros = $query->execute();
//        $vigente = true;
//        if ( $registros->count() == 0 ) {
//            $vigente = false;
//            $query = $this->_adapter->query("select rh_tb_funcionario_cod_func,sis_parceiros_idparceiros
//                                        from prj_tb_equipe 
//                                        where  prj_tb_atividades_cod_atividade = $idAtividade
//                                        order by data_ini_vigencia ");
//
//            $registros = $query->execute();
//            if ( $registros->count() == 0 ) {
//                 return null;
//            }
//        }
//           
//        $row = $registros->current();
//        
//        // Pegar o nome do funcionario ou parceiro
//        if ( !empty($row['rh_tb_funcionario_cod_func'])) {
//            $func = $this->getServiceFuncionario()->getFuncionario($row['rh_tb_funcionario_cod_func']);
//            if ( $vigente )
//                return (empty($func["nome_func"])?"Não encontrado":$func["nome_func"]);
//            else
//                return (empty($func["nome_func"])?"Não encontrado":$func["nome_func"])." <span style='color:red;font-size:8px'>Não Vigente</span>";
//        }
//        
//        if ( !empty($row['sis_parceiros_idparceiros'])) {
//            $rowInst = $this->getParceiro($row['sis_parceiros_idparceiros']);
//            $nomeParceiro = "Não encontrado ID ".$row['sis_parceiros_idparceiros'];
//            if ( !empty($rowInst) ){
//                $nomeParceiro = $rowInst["nome_parceiro"];
//            }
//            // vindo do servico de instituicao getInstituicao()
//            if ( $vigente ) //echo do codigo do parceiro
//                return 'Parceiro Externo: '.$nomeParceiro.' ['.$row['sis_parceiros_idparceiros'].']';
//            else
//                return 'Parceiro Externo: '.$nomeParceiro." <span style='color:red;font-size:8px'>Não Vigente</span>";
//        }
//            //return $row['sis_parceiro_idparceiros'];
//            
//        
//        return null;
//    }
    
    public function getMatriculaPorAtividade($idAtividade){
        if ( empty($idAtividade)) $idAtividade=0;
        $query = $this->_adapter->query("select rh_tb_funcionario_cod_func,sis_parceiros_idparceiros
                                        from prj_tb_equipe 
                                        where  prj_tb_atividades_cod_atividade = $idAtividade
                                        and
                                        (data_ini_vigencia is null or data_ini_vigencia <= current_date()) 
                                        and
                                        (data_fim_vigencia is null or data_fim_vigencia >= current_date()) and funcao='lider'");

        $registros = $query->execute();
        if ( $registros->count() == 0 ) 
            return null;
        $row = $registros->current();
        
        // Pegar o nome do funcionario ou parceiro
        if ( !empty($row['rh_tb_funcionario_cod_func'])) {
            return $row['rh_tb_funcionario_cod_func'];
        }
        if ( !empty($row['sis_parceiros_idparceiros'])) {
            return $row['sis_parceiros_idparceiros'];
        }
        
        
        return null;
    }
    
    public function getAtivMatricula($matricula,$parceiro=false){
        // retornar todos os IDs de tarefa na qual o usuario é responsavel
        if ( !$parceiro ) {
            $query = $this->_adapter->query("select prj_tb_atividades_cod_atividade
            from prj_tb_equipe
            where
            rh_tb_funcionario_cod_func = '$matricula' and 
            prj_tb_atividades_cod_atividade is not null");
        } else {
                $query = $this->_adapter->query("select prj_tb_atividades_cod_atividade
             from prj_tb_equipe
             where
             sis_parceiros_idparceiros = '$matricula' and 
             prj_tb_atividades_cod_atividade is not null"); 
        }
        $registros = $query->execute();
        $array = array();
        foreach($registros as $row){
            $array[] = $row['prj_tb_atividades_cod_atividade'];
        }
        return $array;
    }
}

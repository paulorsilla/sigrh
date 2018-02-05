<?php
namespace SigRH\Service;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Embraorc {
    
    private $_adapter;
    public function __construct($adapter){
        $this->_adapter = $adapter;
    }
    
    public function getIdsAtividadesComMovimentos(){
        //die('passou aqui 2');
        $select = "select distinct prj_tb_projetos_codigo from movimentacao";
        //die( $select );
        $query = $this->_adapter->query($select);
        $registros = $query->execute();
        $array_retorno = array();
        foreach($registros as $row){
            $array_retorno[]=$row['prj_tb_projetos_codigo'];
        }

        return $array_retorno;
    }
    public function getIdsAtividadesComMovimentosPorPeriodo($ano = null ){
        if ( empty($ano) ){
            $ano = date('Y');
        }
        //var_dump($ano); 
        $data_ini = "$ano-01-01";
        $data_fim = "$ano-12-31";
        
        //die('passou aqui 2');
        $select = "select distinct prj_tb_projetos_codigo from movimentacao where lancamento between '$data_ini' and '$data_fim'";
        //die( $select );
        $query = $this->_adapter->query($select);
        $registros = $query->execute();
        $array_retorno = array();
        foreach($registros as $row){
            $array_retorno[]=$row['prj_tb_projetos_codigo'];
        }
        //var_dump($array_retorno); die();
        return $array_retorno;
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
    
//    public function getListAtividadesParaCombo($limit = 0,$func = null){
    public function getListAtividadesParaCombo($limit = 0){
    
        $select = "select m.* from movimentacao m";
//        if ( $func != null )
  //              $select .= " join prj_tb_equipe e on (a.cod_atividade = e.prj_tb_atividades_cod_atividade) where  e.rh_tb_funcionario_cod_func = '$func' ";
    //    $select .=" order by num_atividade";
        
        if ( $limit > 0 ) 
            $select .= " limit $limit ";
        $query = $this->_adapter->query($select);
        $registros = $query->execute();

//        $retorno = array();
//        foreach($registros as $ativ){
//            $retorno[ $ativ['cod_atividade'] ] = $ativ['num_atividade'];
  //      }
//        return $retorno;
        return $registros;
    }
    
    public function getAtividade($id){
    
        $query = $this->_adapter->query("select * from prj_tb_atividades where cod_atividade = '$id'");
        $registros = $query->execute();

        return $registros[0];
        
    }
    
    
}

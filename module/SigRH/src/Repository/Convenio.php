<?php

namespace SigRH\Repository;

use SigRH\Entity\Convenio as ConvenioEntity;

class Convenio extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(ConvenioEntity::class, 'c')
                ->orderby('c.convenioNumero','ASC');

        
        if ( !empty($search['search'])){
            $qb->andWhere('(c.convenioNumero like :busca or c.responsavelNome like :busca or c.responsavelCargo like :busca)'); 
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
        
        if ( !empty($search['tipo'])){
            $qb->andWhere('c.tipo = :tipo ');
            $qb->setParameter("tipo",$search['tipo']);
        }
        
        if ( !empty($search["data_ini"]) ){
             $data_ini = \Datetime::createFromFormat("d/m/Y", $search["data_ini"]); 
             if ( $data_ini != null ){
                $data_ini_str = $data_ini->format('Y-m-d');
                $qb->andWhere('c.convenioTermino >= :data_ini');
                $qb->setParameter(":data_ini",$data_ini_str);
             }
        }
        
        if ( !empty($search["data_fim"]) ){
            $data_fim = \Datetime::createFromFormat("d/m/Y", $search["data_fim"]);
            if ( $data_fim != null ){
                $data_fim_str = $data_fim->format('Y-m-d');
                $qb->andwhere('c.convenioInicio <= :data_fim');
                $qb->setParameter(":data_fim", $data_fim_str); 
            }
            
        }
        
        

//        echo "DQL: ".$qb->getDQL();
//        echo "<hr>";
//        echo "SQL: ".$qb->getQuery()->getSQL();
//        print_r(array("data_ini"=>$data_ini_str,"data_fim"=>$data_fim_str));
//        die();
        
       return $qb;
    }
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->convenioNumero);
        }
        return $array;
    }
    
    public function delete($id){
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados,$id = null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do convenio para poder alterar
        }    
        if ( empty($row)) {
            $row = new ConvenioEntity();
        }
        
        //instituicao...
        if ( !empty($dados['instituicao'] )) {
            $instituicao = $this->getEntityManager()->find('SigRH\Entity\Instituicao', $dados['instituicao']); //busca as informações
            $row->setInstituicao($instituicao);
        }
        unset($dados['instituicao']);
        
        $row->setConvenioInicio(null);
        if ($dados ['convenioInicio'] != "") {					
            $convenioInicio = \DateTime::createFromFormat ( "d/m/Y", $dados ['convenioInicio'] );
            if ( !empty($convenioInicio)  )
               $row->setConvenioInicio($convenioInicio);
        }
        unset($dados['convenioInicio']);
        
        $row->setConvenioTermino(null);
        if ($dados ['convenioTermino'] != "") {					
            $convenioTermino = \DateTime::createFromFormat ( "d/m/Y", $dados ['convenioTermino'] );
            if ( !empty($convenioTermino)  )
               $row->setConvenioTermino($convenioTermino);
        }
        unset($dados['convenioTermino']);
        
        
        $row->setResponsavelRgDataEmissao(null);
        if ($dados ['responsavelRgDataEmissao'] != "") {					
            $responsavelRgDataEmissao = \DateTime::createFromFormat ( "d/m/Y", $dados ['responsavelRgDataEmissao'] );
            if ( !empty($responsavelRgDataEmissao)  )
               $row->setResponsavelRgDataEmissao($responsavelRgDataEmissao);
        }
        unset($dados['responsavelRgDataEmissao']);
        
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
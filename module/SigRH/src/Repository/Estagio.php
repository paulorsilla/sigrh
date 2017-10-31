<?php

namespace SigRH\Repository;

use SigRH\Entity\Estagio as EstagioEntity;

class Estagio extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
                ->from(EstagioEntity::class, 'e')
                ->orderby('e.anoInicio','ASC');
        
        if ( !empty($search['search'])){
            $qb->where(' c.anoInicio like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->dataInicioEfetivo);
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
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new EstagioEntity();
        }
        //nivel...
        if ( !empty($dados['nivel'] )) {
            $nivel = $this->getEntityManager()->find('SigRH\Entity\Nivel', $dados['nivel']); //busca as informações
            $row->setNivel($nivel);
        }
        unset($dados['nivel']);
        
        //curso...
        if ( !empty($dados['curso'] )) {
            $curso = $this->getEntityManager()->find('SigRH\Entity\Curso', $dados['curso']); //busca as informações
            $row->setCurso($curso);
        }
        unset($dados['curso']);
        
        //fonte seguro...
        if ( !empty($dados['fonteSeguro'] )) {
            $fonteSeguro = $this->getEntityManager()->find('SigRH\Entity\FonteSeguro', $dados['fonteSeguro']); //busca as informações
            $row->setFonteSeguro($fonteSeguro);
        }
        unset($dados['fonteSeguro']);
        
        $row->setDataInicioEfetivo(null);
        if ($dados ['dataInicioEfetivo'] != "") {					
            $dataInicioEfetivo = \DateTime::createFromFormat ( "d/m/Y", $dados ['dataInicioEfetivo'] );
            if ( !empty($dataInicioEfetivo)  )
               $row->setDataInicioEfetivo($dataInicioEfetivo);
        }
        unset($dados['dataInicioEfetivo']);
        
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        print_r($row);
//        die;
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
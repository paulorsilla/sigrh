<?php

namespace SigRH\Repository;

use SigRH\Entity\Termo as TermoEntity;

class Termo extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
                ->from(TermoEntity::class, 't')
                ->orderby('t.aditivo','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('t.aditivo like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->aditivo);
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
    public function incluir_ou_editar($dados,$id = null,$estagio=null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new TermoEntity();
        }
        if ( !empty($estagio)) {
            $estagioObj = $this->getEntityManager()->find('SigRH\Entity\Estagio', $estagio);
            if ( empty($estagioObj) )
                throw new Exception('Estagio nao encontrado');
            $row->setEstagio($estagioObj);
        }
        
//        //modalidade bolsa...
        if ( !empty($dados['modalidadeBolsa'] )) {
            $modalidade = $this->getEntityManager()->find('SigRH\Entity\ModalidadeBolsa', $dados['modalidadeBolsa']); //busca as informações
            $row->setModalidadeBolsa($modalidade);
        }
        unset($dados['modalidadeBolsa']);
        
        //instituicao...
        if ( isset($dados['instituicao']) ) {
            if ( !empty($dados['instituicao'] )) {
                $instituicao = $this->getEntityManager()->find('SigRH\Entity\Instituicao', $dados['instituicao']); //busca as informações
                $row->setInstituicao($instituicao);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setInstituicao(null);
            }
        }    
        unset($dados['instituicao']);
        
        //fundacao...
        if ( !empty($dados['fundacao'] )) {
            $fundacao = $this->getEntityManager()->find('SigRH\Entity\Instituicao', $dados['fundacao']); //busca as informações
            $row->setFundacao($fundacao);
        }
        unset($dados['fundacao']);
        
        //orientador...
        if ( !empty($dados['orientador'] )) {
            $orientador = $this->getEntityManager()->find('SigRH\Entity\Colaborador', $dados['orientador']); //busca as informações
            $row->setOrientador($orientador);
        }
        unset($dados['orientador']);
        
        $row->setdataInicio(null);
        if ($dados ['dataInicio'] != "") {					
            $inicio = \DateTime::createFromFormat ("Y-m-d", $dados ['dataInicio']);
            if ( !empty($inicio)  )
               $row->setdataInicio($inicio);
        }
        unset($dados['dataInicio']);
        
        $row->setDataTermino(null);
        if ($dados ['dataTermino'] != "") {					
            $fim = \DateTime::createFromFormat ("Y-m-d", $dados ['dataTermino']);
            if ( !empty($fim)  )
               $row->setDataTermino($fim);
        }
        unset($dados['dataTermino']);
        
        $row->setDataDesligamento(null);
        if ($dados ['dataDesligamento'] != "") {					
            $desligamento = \DateTime::createFromFormat ("Y-m-d", $dados ['dataDesligamento']);
            if ( !empty($desligamento)  )
               $row->setDataDesligamento($desligamento);
        }
        unset($dados['dataDesligamento']);
        
        //atividade...
        if ( isset($dados['atividade']) ) {
            if ( empty($dados['atividade'] )) {
                $row->setAtividade(null);
            }
        }    
        unset($dados['atividade']);
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
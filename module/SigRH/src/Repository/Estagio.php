<?php

namespace SigRH\Repository;

use SigRH\Entity\Estagio as EstagioEntity;

class Estagio extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
                ->from(EstagioEntity::class, 'e')
                ->orderby('e.inicio','ASC');
        
        if ( !empty($search['search'])){
            $qb->where(' e.inicio like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
        //inclui a pesquisa por matricula por meio de um join
        if ( !empty($search['matricula'])){
            $qb->join("e.colaboradorMatricula",'c');
            $qb->where('c.matricula = :matricula');
            $qb->setParameter("matricula",$search['matricula']);
        }
        
/*      echo "DQL: ".$qb->getDQL();
        echo "<hr>";
        echo "SQL: ".$qb->getQuery()->getSQL();
        die();*/
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
    public function incluir_ou_editar($dados,$id = null,$matricula=null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new EstagioEntity();
        }
        if ( !empty($matricula)) {
            $colaborador = $this->getEntityManager()->find('SigRH\Entity\Colaborador', $matricula);
            if ( empty($colaborador) )
                throw new Exception('Colaborador nao encontrado');
            $row->setColaboradorMatricula($colaborador);
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
        
        //instituicao...
        if ( !empty($dados['instituicao'] )) {
            $instituicao = $this->getEntityManager()->find('SigRH\Entity\Instituicao', $dados['instituicao']); //busca as informações
            $row->setInstituicao($instituicao);
        }
        unset($dados['instituicao']);
        
        //instituicao...
        if ( !empty($dados['sublotacao'] )) {
            $sublotacao = $this->getEntityManager()->find('SigRH\Entity\Sublotacao', $dados['sublotacao']); //busca as informações
            $row->setSublotacao($sublotacao);
        }
        unset($dados['sublotacao']);
        
        $row->setDataInicioEfetivo(null);
        if ($dados ['dataInicioEfetivo'] != "") {					
            $dataInicioEfetivo = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataInicioEfetivo'] );
            if ( !empty($dataInicioEfetivo)  )
               $row->setDataInicioEfetivo($dataInicioEfetivo);
        }
        unset($dados['dataInicioEfetivo']);
        
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        // \Doctrine\Common\Util\Debug::dump($row); nunca usar print_r para elemento doctrine
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
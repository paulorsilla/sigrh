<?php

namespace SigRH\Repository;

use SigRH\Entity\Colaborador as ColaboradorEntity;

class Colaborador extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(ColaboradorEntity::class, 'c')
                ->orderby('c.nome','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('b.nome like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->nome);
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
            $row = new ColaboradorEntity();
        }
        
        //endereco...
        if ( !empty($dados['endereco'] )) {
            $endereco = $this->getEntityManager()->find('SigRH\Entity\Endereco', $dados['endereco']); //busca as informações
            $row->setEndereco($endereco);
        }
        unset($dados['endereco']);
        
        //cidade...
        if ( !empty($dados['cidade'] )) {
            $cidade = $this->getEntityManager()->find('SigRH\Entity\Cidade', $dados['cidade']); //busca as informações
            $row->setCidade($cidade);
        }
        unset($dados['cidade']);

        //Grupo sanguineo...
        if ( !empty($dados['grupoSanguineo'] )) {
            $grupoSanguineo = $this->getEntityManager()->find('SigRH\Entity\GrupoSanguineo', $dados['grupoSanguineo']); //busca as informações
            $row->setGrupoSanguineo($grupoSanguineo);
        }
        unset($dados['grupoSanguineo']);
        
        //grauInstrucao
        if ( !empty($dados['grauInstrucao'] )) {
            $grauInstrucao = $this->getEntityManager()->find('SigRH\Entity\GrauInstrucao', $dados['grauInstrucao']); //busca as informações
            $row->setGrauInstrucao($grauInstrucao);
        }
        unset($dados['grauInstrucao']);
        
        //corPele
        if ( !empty($dados['corPele'] )) {
            $corPele = $this->getEntityManager()->find('SigRH\Entity\CorPele', $dados['corPele']); //busca as informações
            $row->setCorPele($corPele);
        }
        unset($dados['corPele']);
        
        //estadoCivil
        if ( !empty($dados['estadoCivil'] )) {
            $estadoCivil = $this->getEntityManager()->find('SigRH\Entity\EstadoCivil', $dados['estadoCivil']); //busca as informações
            $row->setEstadoCivil($estadoCivil);
        }
        unset($dados['estadoCivil']);
        
        //natural
        if ( !empty($dados['natural'] )) {
            $natural = $this->getEntityManager()->find('SigRH\Entity\Cidade', $dados['natural']); //busca as informações
            $row->setNatural($natural);
        }
        unset($dados['natural']);
        
        //ctpsUf
        if ( !empty($dados['ctpsUf'] )) {
            $ctpsUf = $this->getEntityManager()->find('SigRH\Entity\Estado', $dados['ctpsUf']); //busca as informações
            $row->setCtpsUf($ctpsUf);
        }
        unset($dados['ctpsUf']);
        
//        $row = null;
//        if ($dados ['dataNascimento'] != "") {					
//            $row = \DateTime::createFromFormat ( "d/m/Y", $dados ['dataNascimento'] );
//        }
        
//        $dados['dataNascimento'] = \Admin\Model\Util::converteDataSql($dados['dataNascimento']);
        
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
<?php

namespace SigRH\Repository;
use SigRH\Entity\Instituicao as InstituicaoEntity;

class Instituicao extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
                ->from(InstituicaoEntity::class, 'i')
                ->orderBy('i.desRazaoSocial', 'ASC')
                ->where('i.desPfPj = :tipo')
                ->andWhere('i.desRazaoSocial != :empty')
                ->setParameter('tipo', "Pessoa Jurídica")
                ->setParameter('empty', " ");
        if (!empty($search['combo'])) {
            if ($search['combo'] == 1) {
                $array = [];
                $list =  $qb->getQuery()->getResult();
                foreach($list  as $row){
                    $array[] = ["id" => $row->codInstituicao, "desRazaoSocial" => $row->desRazaoSocial];
                }
                return $array;
            } else {
                return $qb->getQuery()->getResult();
            }
        } else {
            return $qb->getQuery();
        }
    }
    
    public function getListParaCombo()
    {
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id" => $row->id, "nome" => $row->desRazaoSocial);
        }
        return $array;
    }
    
    public function incluir_ou_editar($dados, $dataAtual, $usuario, $id = null)
    {
        $row = null;
        if(!empty($id)) {
            $row = $this->find($id);
            if ($row) {
                $row->setDataAlteracao($dataAtual);
                $row->setAlteracao($usuario);
            }
        }
        if (empty($row)) {
            $row = new InstituicaoEntity();
            $row->setDataInclusao($dataAtual);
            $row->setInclusao($usuario);
        }
        $row->setDesPfPj("Pessoa Jurídica");
        if (!empty($dados['cnpj'])) {    
            $cnpj = preg_replace('/\D/', '', $dados['cnpj']);
            $row->setCnpj($cnpj);
            unset($dados['cnpj']);
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model  ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }
    
}




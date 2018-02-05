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
}




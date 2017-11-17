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
        if (null != $search['combo'] && $search['combo'] == 1) {
            return $qb->getQuery()->getResult();
        } else {
            return $qb->getQuery();
        }
    }
     
}




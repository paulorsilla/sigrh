<?php

namespace SigRH\Repository;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;

class AbstractRepository extends EntityRepository {

    public function getQuery($search = array()) {
        return null;
    }

    public function getPaginator($page = 1,$search = array()) {
        $doctrinePaginator = new DoctrinePaginator($this->getQuery($search), false);
        $paginatorAdapter = new PaginatorAdapter($doctrinePaginator);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setDefaultItemCountPerPage(11);
        return $paginator;
    }

}
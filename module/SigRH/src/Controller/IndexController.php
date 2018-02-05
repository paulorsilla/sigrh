<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\User;


class IndexController extends AbstractActionController
{
    /**
     * Entity Manager
     * @var Doctrine\ORM\EntityManager
     */

    private $entityManager;

    public function __construct($entityManager) 
    {
            $this->entityManager = $entityManager;
    }
    
    public function indexAction()
    {
    	$user = null;
    	if ($this->identity() != null) {
    		$user = $this->entityManager->getRepository(User::class)->findOneByLogin($this->identity());
    	}
        return new ViewModel([
        		'user' => $user
        ]);
    }
}

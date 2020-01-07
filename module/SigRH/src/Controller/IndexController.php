<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;
use SigRH\Entity\Vinculo;

//use User\Entity\User;
//use Zend\Barcode\Barcode;

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
            $user = $this->entityManager->getRepository(Colaborador::class)->findOneByLoginLocal($this->identity()['login']);
    	}
        if ($user) {
            $dataAcesso = \DateTime::createFromFormat("Ymd", date("Ymd"));
            $repoVinculo = $this->entityManager->getRepository(Vinculo::class);
            $vinculo = $repoVinculo->buscar_vinculo_por_referencia($user->getMatricula(), date("Ym"), $dataAcesso);
            if ( ( !$vinculo ) || ( !$vinculo->getTipoVinculo()->getAcessoSistema() ) ) {
                return $this->redirect()->toRoute('logout');
            }
        }
        return new ViewModel([
            'user' => $user
        ]);
    }

//    public function barcodeAction()
//    {
//       // Get parameters from route.
//        $type = $this->params()->fromRoute('type', 'code39');
//        $label = $this->params()->fromRoute('label', 'HELLO-WORLD');
//
//        // Set barcode options.
//        $barcodeOptions = ['text' => $label, 'drawText' => false];        
//        $rendererOptions = [];
//
//        // Create barcode object
//        $barcode = Barcode::factory($type, 'image', 
//                     $barcodeOptions, $rendererOptions);
//
//        
//        // The line below will output barcode image to standard 
//        // output stream.
//        $barcode->render();
//
//        // Return Response object to disable default view rendering. 
//        return $this->getResponse();   
//    }
}


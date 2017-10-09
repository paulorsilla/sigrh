<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CidadeController extends AbstractActionController {

    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências no controller
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }
    
    public function indexAction() {
        //TODO
    }

    public function buscaCidadesAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
        
        if ($request->isPost()) {
            $uf = $this->params()->fromPost('uf');
            $estado = $this->entityManager->find(\SigRH\Entity\Estado::class, $uf);
            if ($estado) {
                $cidades = $this->entityManager->getRepository(\SigRH\Entity\Cidade::class)->findBy(['estado' => $estado], ['cidade' => 'ASC']);
                $cidadesJson = '[';
                
                foreach($cidades as $k => $cidade) {
                    $cidadesJson .= '{"id":'.$cidade->getId().', "cidade":"'.$cidade->getCidade().'"}';
                    if (null != $cidades[$k+1]) {
                        $cidadesJson.= ', ';
                    }
                }
                $cidadesJson .= ']';
                error_log($cidadesJson);

                $response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json',
                            'cidades' => $cidadesJson,
                            'response' => true)));
            }
        }
        return $response;
    }

}

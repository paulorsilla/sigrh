<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Entity\RecessoObrigatorio;
use SigRH\Form\RecessoObrigatorioForm;


class RecessoObrigatorioController extends AbstractActionController
{
        /**
         * Object Manager
         */
         private $objectManager;
         
	/**
	 * Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;
	
	/**
	 * Construtor da classe, utilizado para injetar as dependências no controller
	 */
	public function __construct($entityManager, $objectManager)
	{
		$this->entityManager = $entityManager;
                $this->objectManager = $objectManager;
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $id = (int) $this->params()->fromQuery('id', null);
                if ( empty($id)) {
                    die('Vínculo em branco');
                }
                
                $repoVinculo = $this->entityManager->getRepository(\SigRH\Entity\Vinculo::class);
                $vinculo = $repoVinculo->find($id);
                
                if ( empty($vinculo) ) {
                    die('Vínculo não encontrado');
                }
                
		//Cria o formulário
		$form = new RecessoObrigatorioForm($this->objectManager);

                error_log("Aqui1");

                
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
                        
                        error_log("Aqui2");
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
                            $data = $form->getData();
                            $repo = $this->entityManager->getRepository(RecessoObrigatorio::class);
                            $repo->incluir_ou_editar($data, $vinculo);

                            // alterar para json
                            $modelJson = new \Zend\View\Model\JsonModel();
                            return $modelJson->setVariable('success', 1);
			} 
		}
                $view = new ViewModel([
				'form' => $form,
                                'vinculo' => $vinculo
		]);
		return $view->setTerminal(true);
	}
        
        public function deleteModalAction()
        {
//		$id = (int) $this->params()->fromRoute('id', null);
//                $matricula = $this->params()->fromQuery('matricula');
//                
//		if ($this->getRequest()->isPost()) {
//                    $repo = $this->entityManager->getRepository(Horario::class);
//                    $repo->delete($id, $matricula);
//                    $modelJson = new \Zend\View\Model\JsonModel();
//                    return $modelJson->setVariable('success', 1);
//		}
//                
//                $repo = $this->entityManager->getRepository(Horario::class);
//                $horario= $repo->find($id);
//
//                $view = new ViewModel([
//				'horario' => $horario,
//		]);
//                return $view->setTerminal(true);
        }
        
}

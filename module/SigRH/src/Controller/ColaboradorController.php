<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\ColaboradorForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;

class ColaboradorController extends AbstractActionController
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
	
	public function indexAction()
	{
                $repo = $this->entityManager->getRepository(Colaborador::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $search['tipoColaborador'] = 2;
                $search['ativo'] = 'S';
                $paginator = $repo->getPaginator($page, $search);
		return new ViewModel([
				'colaboradores' => $paginator,
                                'page' => $page
		]);
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
                $page = $this->params()->fromRoute('page', null);
		
                //Cria o formulário
		$form = new ColaboradorForm($this->objectManager);
                $colaborador = new Colaborador();
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Colaborador::class);
                    $colaborador = $repo->find($id);
                }
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {

                    //Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Colaborador::class);
                                $repo->incluir_ou_editar($data, $id);
				return $this->redirect()->toRoute('sig-rh/colaborador', ['action' => 'save']);
			}
		} else {
                    if ( !empty($id)){
                        
                        if ( !empty($colaborador)){
                            $form->setData($colaborador->toArray());

                            $form->get("supervisor")->setValue((null != $colaborador->getSupervisor()) ? $colaborador->getSupervisor() : null);
                            $form->get("tipoColaborador")->setValue((null != $colaborador->getTipoColaborador()) ? $colaborador->getTipoColaborador() : null);
                            $form->get("dataAdmissao")->setValue((null != $colaborador->getDataAdmissao()) ? $colaborador->getDataAdmissao()->format('Y-m-d') : null);

                            $form->get("dataDesligamento")->setValue((null != $colaborador->getDataDesligamento()) ? $colaborador->getDataDesligamento()->format('Y-m-d') : null);
                            $form->get("dataNascimento")->setValue((null != $colaborador->getDataNascimento()) ? $colaborador->getDataNascimento()->format('Y-m-d') : null);
                            $form->get("rgDataEmissao")->setValue((null != $colaborador->getRgDataEmissao()) ? $colaborador->getRgDataEmissao()->format('Y-m-d') : null);

                            $form->get("ctpsDataExpedicao")->setValue((null != $colaborador->getCtpsDataExpedicao()) ? $colaborador->getCtpsDataExpedicao()->format('Y-m-d') : null);
                            $form->get("natural_estado")->setValue((null != $colaborador->getNatural()->getEstado()) ? $colaborador->getNatural()->getEstado() : null);
                            $form->get("natural")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural() : null);
                            $form->get("endereco")->setValue((null != $colaborador->getEndereco()) ? $colaborador->getEndereco() : null);
                            $form->get("grupoSanguineo")->setValue((null != $colaborador->getGrupoSanguineo()) ? $colaborador->getGrupoSanguineo() : null);
                            $form->get("grauInstrucao")->setValue((null != $colaborador->getGrauInstrucao()) ? $colaborador->getGrauInstrucao() : null);
                            $form->get("corPele")->setValue((null != $colaborador->getCorPele()) ? $colaborador->getCorPele() : null);
                            $form->get("estadoCivil")->setValue((null != $colaborador->getEstadoCivil()) ? $colaborador->getEstadoCivil() : null);
                            $form->get("natural")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural() : null);
                            $form->get("ctpsUf")->setValue((null != $colaborador->getCtpsUf()) ? $colaborador->getCtpsUf() : null);

                            $endereco = $colaborador->getEndereco();
//                            \Doctrine\Common\Util\Debug::dump($endereco); die();
                            if ( !empty($endereco) ) { // COLOCAR TODOS OS CAMPOS
                                $form->get("cep")->setValue($endereco->getCep());
                                $form->get("endereco")->setValue($endereco->getEndereco());
                                $form->get("numero")->setValue($endereco->getNumero());
                                $form->get("complemento")->setValue($endereco->getComplemento());
                                $form->get("bairro")->setValue($endereco->getBairro());
                                if (null != $endereco->getCidade()) {
                                    $form->get("cidade")->setValue($endereco->getCidade()->getId());
                                    $form->get("estado")->setValue($endereco->getCidade()->getEstado()->getId());
                                }
                            }
                        }
                    }
                }
		return new ViewModel([
				'form' => $form,
                                'page' => $page,
                                'colaborador' => $colaborador
		]);
	}
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/colaborador');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(Colaborador::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/colaborador');
		}
                
                $repo = $this->entityManager->getRepository(Colaborador::class);
                $colaborador = $repo->find($id);

                return new ViewModel([
				'colaborador' => $colaborador,
		]);
		
	}
}

<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\FeriadoForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Feriado;

class FeriadoController extends AbstractActionController
{
	/**
	 * Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;
	
	/**
	 * Construtor da classe, utilizado para injetar as dependências no controller
	 */
	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}
	
	public function indexAction()
	{
                $repo = $this->entityManager->getRepository(Feriado::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromQuery();
                $ano = isset($search['search']) ? $search['search'] : null;
                $paginator = $repo->getPaginator($page, $search);
            
		return new ViewModel([
                    'feriados' => $paginator,
                    'search' => $ano,
                    'diasSemana' => ['1' => 'Segunda-feira', '2' => 'Terça-feira', '3' => 'Quarta-feira',
                        '4' => 'Quinta-feira', '5' => 'Sexta-feira', '6' => 'Sábado', '7' => 'Domingo']
		]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);
		//Cria o formulário
		$form = new FeriadoForm($this->entityManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
			
			//Recebe os dados via POST
			$data = $this->params()->fromPost();
			
			//Preenche o form com os dados recebidos e o valida
			$form->setData($data);
			if ($form->isValid()) {
				$data = $form->getData();
                                $repo = $this->entityManager->getRepository(Feriado::class);
                                $repo->incluir_ou_editar($data, $id);
				return $this->redirect()->toRoute('sig-rh/feriado', ['action' => 'index']);
			}
		} else {
                    if ( !empty($id)){
                        $repo = $this->entityManager->getRepository(Feriado::class);
                        $row = $repo->find($id);
                        if ( !empty($row)){
                            $form->setData($row->toArray());
                        }
                    }
                }
		return new ViewModel([
				'form' => $form
		]);
	}
        
        public function importAction()
	{
		$request = $this->getRequest();
		if ($request->isPost()) {
                    $ano = $this->params()->fromPost("ano");
                    $headers = ['Accept' => 'application/json'];
                    $query = ['ano' => $ano, 'estado' => 'PR', 'cidade' => 'LONDRINA', 'token' => 'cGF1bG8uc2lsbGFAZ21haWwuY29tJmhhc2g9MTAwNDAyNTg5', 'json' => 'true' ];
                    $response = \Unirest\Request::get('https://api.calendario.com.br/', $headers, $query);
                    $feriados = json_decode($response->raw_body, true);
                    foreach($feriados as $feriado) {
                        $tipoFeriado = (int) $feriado['type_code'];
                        $expediente = ($tipoFeriado <= 3) ? false : true;
                        $dataFeriadoAux = explode("/", $feriado['date']);
                        $dataFeriado = $dataFeriadoAux['2']."-".$dataFeriadoAux['1']."-".$dataFeriadoAux['0'];
                        $data = ['dataFeriado' => $dataFeriado, 'nome' => $feriado['name'], 'descricao' => $feriado['description'], 'tipoFeriado' => $tipoFeriado, 'expediente' => $expediente];
                        $repo = $this->entityManager->getRepository(Feriado::class);
                        $repo->incluir_ou_editar($data);
                    }
                    return $this->redirect()->toRoute('sig-rh/feriado', ['action' => 'index']);
                    
                }
		return new ViewModel([
		]);	
	}
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/feriado');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(Feriado::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/feriado');
		}
                
                $repo = $this->entityManager->getRepository(Feriado::class);
                $feriado = $repo->find($id);

                return new ViewModel([
				'feriado' => $feriado,
		]);
	}
}

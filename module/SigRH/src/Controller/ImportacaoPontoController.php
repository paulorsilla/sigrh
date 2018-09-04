<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Form\ImportacaoPontoForm;
use SigRH\Entity\ImportacaoPonto;
use SigRH\Entity\FolhaPonto;
use SigRH\Entity\Feriado;
use SigRH\Entity\ConstantesMes;

class ImportacaoPontoController extends AbstractActionController
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
                $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
                $page = $this->params()->fromQuery('page', 1);
                $search = $this->params()->fromPost();
                $paginator = $repo->getPaginator($page, $search);
            
		return new ViewModel([
                    'importacoesPonto' => $paginator,
		]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
                $id = $this->params()->fromRoute('id', null);

                //Cria o formulário
		$form = new ImportacaoPontoForm($this->entityManager);

                $user = $this->entityManager->getRepository(\User\Entity\User::class)->findOneByLogin($this->identity());
                $dataAtual = new \DateTime();
                
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
		
                    $post = array_merge($this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray());
                    $form->setData($post);

                    //Recebe os dados via POST
		    //$data = $this->params()->fromPost();
			
		    //Preenche o form com os dados recebidos e o valida
		    //$form->setData($data);
			if ($form->isValid()) {
                            $data = $form->getData();

                            $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
                            $folha_repo = $this->entityManager->getRepository(FolhaPonto::class);
                            $feriado_repo = $this->entityManager->getRepository(Feriado::class);
                            $constantes_mes_repo = $this->entityManager->getRepository(ConstantesMes::class);

                            $importacaoPonto = $repo->incluir_ou_editar($data, $user, null, $id);

                            $file = $this->params()->fromFiles('arquivo');
                            $serviceImportacao = $this->getEvent()->getApplication()->getServiceManager()->get(\SigRH\Service\FileUpload::class);
                            $log = $serviceImportacao->uploadPonto($file, $importacaoPonto);

                            $repo->incluir_ou_editar($data, $user, $log, $importacaoPonto->getId());
                            $this->entityManager->flush();

                            $referencia = $importacaoPonto->getReferencia();
                            $mes = substr($referencia, 4, 2);
                            $ano = substr($referencia, 0, 4);
                            $folha_repo->complete($referencia);
                            $numeroDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
                            $numeroDiasUteis = $numeroDiasMes;
                            $feriados = $feriado_repo->getFeriadoReferencia($referencia);
                            foreach($feriados as $feriado) {
                                if ($feriado->getExpediente() == 0) {
                                    $numeroDiasUteis -= 1;
                                } else if ($feriado->getExpediente() >= 2) {
                                    $numeroDiasUteis -= 0.5;
                                }
                            }
                            
                            //busca o número de dias úteis no mês
                            for($dia = 1; $dia <= $numeroDiasMes; $dia++) {
                                $dataConsulta = \DateTime::createFromFormat("Ymd", $referencia.$dia);
                                $dataConsulta->setTime(0, 0);
                                if ( ($dataConsulta->format("w") == 6) || ($dataConsulta->format("w") == 0) ){
                                    $numeroDiasUteis -= 1;
                                }
                            }
                            
                            $dados['referencia'] = $referencia;
                            $dados['ultimoDiaImportado'] = $data['ultimoDia'];
                            $dados['numeroDiasUteis'] = $numeroDiasUteis;
                            
                            $constantes_mes_repo->incluir_ou_editar($dados);

                            return $this->redirect()->toRoute('sig-rh/importacao-ponto', ['action' => 'index']);
			} else {
                            print_r($form->getMessages());
                            die();
                        }
		} else {
                    $form->get("usuario")->setValue($user);
//                    $form->get("dataImportacao")->setValue($dataAtual->format("Y-m-d"));
                    $form->get("dataServidor")->setValue($dataAtual->format("Y-m-d"));

                    if ( !empty($id)) {
                        $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
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
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('sig-rh/importacao-ponto');
		}
		$request = $this->getRequest();
			
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Não');
			if ($del == 'Sim') {
				$id = (int) $request->getPost('id');
				$repo = $this->entityManager->getRepository(ImportacaoPonto::class);
				$repo->delete($id);
			}
			// Redireciona para a lista de registros cadastrados
			return $this->redirect()->toRoute('sig-rh/importacao-ponto');
		}
                
                $repo = $this->entityManager->getRepository(ImportacaoPonto::class);
                $importacaoPonto = $repo->find($id);

                return new ViewModel([
				'importacaoPonto' => $importacaoPonto,
		]);
	}
}

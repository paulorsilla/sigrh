<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SigRH\Form\RegistroHorarioForm;
use SigRH\Entity\RegistroHorario;

//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;

class RegistroHorarioController extends AbstractActionController {

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

    public function saveModalAction()
    {
        $movimentacaoPontoId = $this->params()->fromRoute('id', null);
        if ( empty($movimentacaoPontoId)) { 
            die('Id em branco');
        }
        $movimentacaoPonto = $this->entityManager->getRepository(\SigRH\Entity\MovimentacaoPonto::class)->find($movimentacaoPontoId);
        $colaborador = null;
        $dataPonto = null;
        $escala = null;
        
        //Cria o formulário
        $form = new RegistroHorarioForm();
        
        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $repo = $this->entityManager->getRepository(RegistroHorario::class);
                
                if ( (isset($data['entrada'])) && ($data['entrada'] != "") ) {
                    $repo->incluir_ou_editar($movimentacaoPonto, $data['entrada']);
                }
                if (isset($data['saida']) && ($data['saida']) != "") {
                    $repo->incluir_ou_editar($movimentacaoPonto, $data['saida']);
                }
                // alterar para json
                $modelJson = new \Zend\View\Model\JsonModel();
                return $modelJson->setVariable('success', 1);
            } else {
                foreach($form->getMessages() as $messages) {
                    foreach($messages as $k => $m) {
                        error_log($k. " => ".$m);
                    }
                }
            } 
        } else {
            $colaborador = $movimentacaoPonto->getFolhaPonto()->getColaboradorMatricula();
            $dataPonto = \DateTime::createFromFormat("Ymd", $movimentacaoPonto->getFolhaPonto()->getReferencia().$movimentacaoPonto->getDiaPonto());
            $diaSemana = $dataPonto->format("w");

            //busca a escala de horarios do colaborador
            $escala = null;
            foreach ($movimentacaoPonto->getFolhaPonto()->getColaboradorMatricula()->getHorarios() as $horarioEscala) {
                if ($horarioEscala->getDiaSemana() == $diaSemana + 1) {
                    $escala = $horarioEscala->getEscala();
                    break;
                }
            }
        }
        $view = new ViewModel([
                'form' => $form,
                'movimentacaoPonto' => $movimentacaoPonto,
                'dataPonto' => $dataPonto,
                'escala' => $escala,
                'colaborador' => $colaborador,
        ]);
        return $view->setTerminal(true);
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id) {
          $repo = $this->entityManager->getRepository(RegistroHorario::class);
          $repo->delete($id);
        }
    }
    
}

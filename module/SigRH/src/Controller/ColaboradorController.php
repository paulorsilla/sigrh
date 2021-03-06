<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Form\ColaboradorForm;
use Zend\View\Model\ViewModel;
use SigRH\Entity\Colaborador;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class ColaboradorController extends AbstractActionController {

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
    public function __construct($entityManager, $objectManager) {
        $this->entityManager = $entityManager;
        $this->objectManager = $objectManager;
    }

    public function indexAction() {
        $repo = $this->entityManager->getRepository(Colaborador::class);
        $page = $this->params()->fromQuery('page', 1);

        $search = $this->params()->fromQuery();
        $search['tipoColaborador'] = $this->params()->fromQuery('tipoColaborador');

        $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
        $paginator = new Paginator($adapter);
//            $paginator = $repo->getPaginator($page, $search);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel([
            'colaboradores' => $paginator,
            'page' => $page,
            'nome' => $search['nome'],
            'ativo' => $search['ativo'],
            'tipoColaborador' => $search['tipoColaborador']
        ]);
    }

    /**
     * Action para salvar um novo registro
     */
    public function saveAction() {
        $id = $this->params()->fromRoute('id', null);
        $page = $this->params()->fromRoute('page', null);
        $ativo = $this->params()->fromRoute('ativo');
        $tipoColaborador = $this->params()->fromRoute('tipoColaborador', null);
        $mensagens = [];

        //Cria o formulário
        $form = new ColaboradorForm($this->objectManager);
        if (!empty($id) || $this->params()->fromPost('tipoColaborador') == 1) {
            $form->getInputFilter()->get("matricula")->setRequired(true);
        }
        $colaborador = new Colaborador();
        if (!empty($id)) {
            $repo = $this->entityManager->getRepository(Colaborador::class);
            $colaborador = $repo->find($id);
        }
        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
//			$data = $this->params()->fromPost();

            $post = array_merge($this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray());
            $form->setData($post);

            //Preenche o form com os dados recebidos e o valida
//			$form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $validacaoFoto = $data['validacaoFoto'];
                $repo = $this->entityManager->getRepository(Colaborador::class);
                $repo->incluir_ou_editar($data, $id);
                $file = $this->params()->fromFiles('arquivoFoto');
                if (null != $file && isset($file['tmp_name']) && $file['tmp_name'] != "" && $validacaoFoto == '1') {
                    $serviceImportacao = $this->getEvent()->getApplication()->getServiceManager()->get(\SigRH\Service\FileUpload::class);
                    $serviceImportacao->uploadFoto($file, $colaborador->getMatricula());
                    return $this->redirect()->toRoute('sig-rh/colaborador', ['action' => 'save', 'id' => $colaborador->getMatricula(), 'ativo' => $ativo, 'tipoColaborador' => $tipoColaborador, 'page' => $page]);
                } else {
                    return $this->redirect()->toRoute('sig-rh/colaborador', ['action' => 'index']);
                }
            } else {
                $mensagens = $form->getMessages();
            }
        } else {
            if (!empty($id)) {

                if (!empty($colaborador)) {
                    $form->setData($colaborador->toArray());
                    $vinculoAtual = $colaborador->getVinculos()->first();
                    $form->get("tipoVinculo")->setValue((null != $vinculoAtual) ? $vinculoAtual->getTipoVinculo()->getDescricao() : null );
                    $form->get("supervisor")->setValue((null != $colaborador->getSupervisor()) ? $colaborador->getSupervisor() : null);
//                            $form->get("tipoColaborador")->setValue((null != $colaborador->getTipoColaborador()) ? $colaborador->getTipoColaborador() : null);
                    $form->get("natural_estado")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural()->getEstado() : null);
                    $form->get("natural")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural() : null);
                    $form->get("endereco")->setValue((null != $colaborador->getEndereco()) ? $colaborador->getEndereco() : null);
                    $form->get("grupoSanguineo")->setValue((null != $colaborador->getGrupoSanguineo()) ? $colaborador->getGrupoSanguineo() : null);
                    $form->get("grauInstrucao")->setValue((null != $colaborador->getGrauInstrucao()) ? $colaborador->getGrauInstrucao() : null);
                    $form->get("corPele")->setValue((null != $colaborador->getCorPele()) ? $colaborador->getCorPele() : null);
                    $form->get("estadoCivil")->setValue((null != $colaborador->getEstadoCivil()) ? $colaborador->getEstadoCivil() : null);
                    $form->get("natural")->setValue((null != $colaborador->getNatural()) ? $colaborador->getNatural() : null);
                    $form->get("ctpsUf")->setValue((null != $colaborador->getCtpsUf()) ? $colaborador->getCtpsUf() : null);
                    $form->get("linhaOnibus")->setValue((null != $colaborador->getLinhaOnibus()) ? $colaborador->getLinhaOnibus() : null);

                    $endereco = $colaborador->getEndereco();
                    if (!empty($endereco)) { // COLOCAR TODOS OS CAMPOS
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
            'ativo' => $ativo,
            'mensagens' => $mensagens,
            'colaborador' => $colaborador,
            'tipoColaborador' => $tipoColaborador,
        ]);
    }

    public function deleteAction() {
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

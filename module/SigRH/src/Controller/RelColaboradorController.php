<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Controlador que gerencia o relatorio 
 *
 * @category Application
 * @package Controller
 * @author Ronaldo Campilongo
 */
class RelColaboradorController extends AbstractActionController {

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

        // Exibir o formulario

        $search = [
            "nome" => $this->params()->fromQuery("nome"),
            "matricula" => $this->params()->fromQuery("matricula"),
            "combo_sexo" => $this->params()->fromQuery("combo_sexo"),
            "combo_grupoSanguineo" => $this->params()->fromQuery("combo_grupoSanguineo"),
            "combo_estadoCivil" => $this->params()->fromQuery("combo_estadoCivil"),
            "combo_grauInstrucao" => $this->params()->fromQuery("combo_grauInstrucao"),
            "necessidadeEspecial" => $this->params()->fromQuery("necessidadeEspecial"),
            "obrigatorio" => $this->params()->fromQuery("obrigatorio"),
            "nivel" => $this->params()->fromQuery("nivel"),
            "instituicaoFomento" => $this->params()->fromQuery("instituicaoFomento"),
            "modalidadeBolsa" => $this->params()->fromQuery("modalidadeBolsa"),
            "ativo" => $this->params()->fromQuery("ativo"),
            "aniversariantesMes" => $this->params()->fromQuery("aniversariantesMes"),
            "tipoVinculo" => $this->params()->fromQuery("tipoVinculo"),
            "orientador" => $this->params()->fromQuery("orientador"),
            "inicioVigenciaIni" => $this->params()->fromQuery("inicioVigenciaIni"),
            "inicioVigenciaFim" => $this->params()->fromQuery("inicioVigenciaFim"),
            "terminoVigenciaIni" => $this->params()->fromQuery("terminoVigenciaIni"),
            "terminoVigenciaFim" => $this->params()->fromQuery("terminoVigenciaFim"),
            "subLotacao" => $this->params()->fromQuery("subLotacao"),
        ];

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        /////montando as selectbox...  
        
        //orientador
        $array_orientador = $repo->getQuery(['tipoVinculo' => '1', 'ativo' => 'S', 'combo' => '1']);

        //grupo sanguineo...
        $repo_grupoSanguineo = $this->entityManager->getRepository(\SigRH\Entity\GrupoSanguineo::class);
        $array_grupoSanguineo = $repo_grupoSanguineo->getListParaCombo();

        //estado civil...
        $repo_estadoCivil = $this->entityManager->getRepository(\SigRH\Entity\EstadoCivil::class);
        $array_estadoCivil = $repo_estadoCivil->getListParaCombo();

        //grau de instrucao...
        $repo_grauInstrucao = $this->entityManager->getRepository(\SigRH\Entity\GrauInstrucao::class);
        $array_grauInstrucao = $repo_grauInstrucao->getListParaCombo();

        //nivel de escolaridade...
        $repo_nivelEscolaridade = $this->entityManager->getRepository(\SigRH\Entity\Nivel::class);
        $array_nivelEscolaridade = $repo_nivelEscolaridade->getListParaCombo();

        //instituicao fomento...
        $repo_fomento = $this->entityManager->getRepository(\SigRH\Entity\Instituicao::class);
        $array_fomento = $repo_fomento->getQuery(["combo" => "1"]);

        //modalidade bolsa...
        $repo_bolsa = $this->entityManager->getRepository(\SigRH\Entity\ModalidadeBolsa::class);
        $array_bolsa = $repo_bolsa->getListParaCombo();
        
        //tipo de vinculo
        $repo_tipo_vinculo = $this->entityManager->getRepository(\SigRH\Entity\TipoVinculo::class);
        $array_tipo_vinculo = $repo_tipo_vinculo->getListaParaCombo();
        
        //meses do ano
        $array_meses = ["01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho",
                        "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"];
        
        //sublotacao...
        $repo_subLotacao = $this->entityManager->getRepository(\SigRH\Entity\Sublotacao::class);
        $array_subLotacao = $repo_subLotacao->getListParaCombo();
        
        $view = new \Zend\View\Model\ViewModel();
        $view->setVariable("colaboradores", $repo->getPaginator());
        $view->setVariable("array_grupoSanguineo", $array_grupoSanguineo);
        $view->setVariable("array_estadoCivil", $array_estadoCivil);
        $view->setVariable("array_grauInstrucao", $array_grauInstrucao);
        $view->setVariable("array_nivelEscolaridade", $array_nivelEscolaridade);
        $view->setVariable("array_fomento", $array_fomento);
        $view->setVariable("array_bolsa", $array_bolsa);
        $view->setVariable("array_meses", $array_meses);
        $view->setVariable("array_tipo_vinculo", $array_tipo_vinculo);
        $view->setVariable("array_orientador", $array_orientador);
        $view->setVariable("array_subLotacao", $array_subLotacao);

        return $view;
    }

    public function gerarHtmlAction() {

        $search = [
            "nome" => $this->params()->fromQuery("nome"),
            "matricula" => $this->params()->fromQuery("matricula"),
            "sexo" => $this->params()->fromQuery("sexo"),
            "combo_grupoSanguineo" => $this->params()->fromQuery("combo_grupoSanguineo"),
            "combo_estadoCivil" => $this->params()->fromQuery("combo_estadoCivil"),
            "combo_grauInstrucao" => $this->params()->fromQuery("combo_grauInstrucao"),
            "necessidadeEspecial" => $this->params()->fromQuery("necessidadeEspecial"),
            "obrigatorio" => $this->params()->fromQuery("obrigatorio"),
            "nivel" => $this->params()->fromQuery("nivel"),
            "instituicaoFomento" => $this->params()->fromQuery("instituicaoFomento"),
            "modalidadeBolsa" => $this->params()->fromQuery("modalidadeBolsa"),
            "ativo" => $this->params()->fromQuery("ativo"),
            "aniversariantesMes" => $this->params()->fromQuery("aniversariantesMes"),
            "tipoVinculo" => $this->params()->fromQuery("tipoVinculo"),
            "orientador" => $this->params()->fromQuery("orientador"),
            "inicioVigenciaIni" => $this->params()->fromQuery("inicioVigenciaIni"),
            "inicioVigenciaFim" => $this->params()->fromQuery("inicioVigenciaFim"),
            "terminoVigenciaIni" => $this->params()->fromQuery("terminoVigenciaIni"),
            "terminoVigenciaFim" => $this->params()->fromQuery("terminoVigenciaFim"),
            "subLotacao" => $this->params()->fromQuery("subLotacao"),

        ];
        //\Zend\Debug\Debug::dump($search );
        //meses do ano
        $array_meses = ["01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho",
                        "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"];
        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($search)->getResult();
        //\Doctrine\Common\Util\Debug::dump($colaboradores);
        $orientador = NULL;
        if (!empty($search['orientador'])) {
            $orientador = $repo->findOneByMatricula($search['orientador']);
        }
        
        $instituicaoFomento = NULL;
        if (!empty($search['instituicaoFomento'])) {
            $instituicaoFomento = $this->entityManager->find(\SigRH\Entity\Instituicao::class, $search['instituicaoFomento']);
        }
        $aniversariantesMes = NULL;
        if (!empty($search['aniversariantesMes'])) {
            $aniversariantesMes = $array_meses[$search['aniversariantesMes']];
        }
        
        $tipoVinculo = NULL;
        if (!empty($search['tipoVinculo'])) {
            $tipoVinculo = $this->entityManager->find(\SigRH\Entity\TipoVinculo::class, $search['tipoVinculo']);
        }
        
        $inicioVigenciaIni = NULL;
        if (!empty($search['inicioVigenciaIni'])) {
            $inicioVigenciaIni = \DateTime::createFromFormat("Y-m-d", $search['inicioVigenciaIni']);
        }
        
        $inicioVigenciaFim = NULL;
        if (!empty($search['inicioVigenciaFim'])) {
            $inicioVigenciaFim = \DateTime::createFromFormat("Y-m-d", $search['inicioVigenciaFim']);
        }        
        
        $terminoVigenciaIni = NULL;
        if (!empty($search['terminoVigenciaIni'])) {
            $terminoVigenciaIni = \DateTime::createFromFormat("Y-m-d", $search['terminoVigenciaIni']);
        }
        
        $terminoVigenciaFim = NULL;
        if (!empty($search['terminoVigenciaFim'])) {
            $terminoVigenciaFim = \DateTime::createFromFormat("Y-m-d", $search['terminoVigenciaFim']);
        }

        $subLotacao = NULL;
        if (!empty($search['subLotacao'])) {
            $subLotacao = $this->entityManager->find(\SigRH\Entity\SubLotacao::class, $search['subLotacao']);
        }

        $this->layout()
                ->setTemplate("layout/impressao")
                ->setVariable("titulo_impressao", "Colaboradores");
        $view = new \Zend\View\Model\ViewModel();
        $view->setVariables(["colaboradores"        => $colaboradores,
                             "instituicaoFomento"   => $instituicaoFomento,
                             "aniversariantesMes"   => $aniversariantesMes,
                             "tipoVinculo"          => $tipoVinculo,
                             "orientador"           => $orientador,
                             "inicioVigenciaIni"    => $inicioVigenciaIni,
                             "inicioVigenciaFim"    => $inicioVigenciaFim,
                             "terminoVigenciaIni"   => $terminoVigenciaIni,
                             "terminoVigenciaFim"   => $terminoVigenciaFim,
                             "subLotacao"   => $subLotacao,
                ]);
        return $view;
//}
    }

}

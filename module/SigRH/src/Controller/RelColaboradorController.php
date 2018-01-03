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
            "inicioVigencia" => $this->params()->fromQuery("inicioVigencia"),
            "terminoVigencia" => $this->params()->fromQuery("terminoVigencia"),
            "obrigatorio" => $this->params()->fromQuery("obrigatorio"),
            "nivel" => $this->params()->fromQuery("nivel"),
            "instituicaoFomento" => $this->params()->fromQuery("instituicaoFomento"),
            "modalidadeBolsa" => $this->params()->fromQuery("modalidadeBolsa"),
            "ativo" => $this->params()->fromQuery("ativo"),
            "aniversariantesMes" => $this->params()->fromQuery("aniversariantesMes"),
            "tipoVinculo" => $this->params()->fromQuery("tipoVinculo"),
        ];

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        /////montando as selectbox...  

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
            "inicioVigencia" => $this->params()->fromQuery("inicioVigencia"),
            "terminoVigencia" => $this->params()->fromQuery("terminoVigencia"),
            "obrigatorio" => $this->params()->fromQuery("obrigatorio"),
            "nivel" => $this->params()->fromQuery("nivel"),
            "instituicaoFomento" => $this->params()->fromQuery("instituicaoFomento"),
            "modalidadeBolsa" => $this->params()->fromQuery("modalidadeBolsa"),
            "ativo" => $this->params()->fromQuery("ativo"),
            "aniversariantesMes" => $this->params()->fromQuery("aniversariantesMes"),
            "tipoVinculo" => $this->params()->fromQuery("tipoVinculo"),
        ];

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($search)->getResult();

        /*
          // Selecionar os movimentos dessa data
          $repo = $this->getEntityManager()->getRepository('Rastrea\Model\Movimentacao');

          //                $array_restringe = null;

          //                $cli = $this->params()->fromPost("combo_clientes");
          //                $func = $this->params()->fromPost("combo_func");

          //               $movimentos = $repo->getMovimentosPorData($data_ini,$data_fim, $ativ,$array_restringe,$cli,$func,$outros,$historico);
          //                $movimentos = $repo->getMovimentosPorData($data_ini,$data_fim); //incluir no repositorio se busca por atividade inclui ak a var

          $movimentos = $repo->getQuery($search)->getQuery()->getResult();
          //\Doctrine\Common\Util\Debug::dump($movimentos);
         */

        $this->layout()
                ->setTemplate("layout/impressao")
                ->setVariable("titulo_impressao", "Colaboradores");
        $view = new \Zend\View\Model\ViewModel();
        $view->setVariables(["colaboradores" => $colaboradores]);
        return $view;
//}
    }

}

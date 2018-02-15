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
    
        public function csvAction()
        {
                $em = $this->getEntityManager();
                $titulo = "Relatório de eventos do NCO";

                //altera o formato da data de DD/MM/AAAA para AAAA/MM/DD
                $data_ini = \Admin\Model\Util::converteData($_GET['data_ini']);
                $data_fim = \Admin\Model\Util::converteData($_GET['data_fim']);
                
                if (!isset($data_ini)) {
                    $data_ini = "0000-00-00";
                }
                
                if (!isset($data_fim)) {
                    $data_fim = "9999-99-99";
                }
//                error_log($data_ini);
//                error_log($data_fim);

                $qb =  $em->createQueryBuilder();
                $qb->select('e')
                    ->from('Eventos\Model\Eventosnco', 'e')
                    ->where('e.dat_ini_vig >= :data_ini')
                    ->andWhere('e.dat_fim_vig <= :data_fim')
                    ->setParameter("data_ini", $data_ini)
                    ->setParameter("data_fim", $data_fim);
                
                $query = $qb->getQuery();
                $eventosint = $query->getResult();

                //cabecalho
                $csvData = $titulo."\n";
                $csvData .= "ideventosint;sigif_tipocomprov_idsigif_tipocomprov;pal_tb_tip_partic_cod_tip_partic;eventointerno;des_objetivo_evento;des_obs;dat_ini_vig;dat_fim_vig;des_local;";
                $csvData .= "des_cidade;num_qtd_partic;hor_ini;hor_fim;sieve;ideventoprincipal;sigif_abrangencia_idabrangencia;tip_evento_cod_tip_evento;funcionario;estado;cargahoraria;mes;\n";

                foreach ($eventosint as $evento) {
                    ///comprovantes ...
                    $comprovantes = '';
                    foreach ($evento->getComprovante() as $comprov) {
                      $comprovantes .= $comprov->gettipocomprovante()." ";  
                    }

                    ///publico alvo ...
                    $participantes = '';
                    foreach ($evento->getPublicoalvo() as $partic) {
                      $participantes .= $partic->getDes_tip_partic()." ";  
                    }

                    ///funcionarios ...
                    $funcionarios = '';
                    foreach ($evento->getFuncparticipantes() as $funcPartic) {
                        $objFunc = $funcPartic->getRh_tb_funcionario_cod_func();
                        if ( !empty($objFunc))
                            $funcionarios .= $objFunc->getnome_func()." ";  
                    }
                    
                    $csvData .= $evento->ideventosint.";".$comprovantes.";".
                            $participantes.";".$evento->eventointerno.
                            ";".$evento->des_objetivo_evento.";".$evento->des_obs.
                            ";".$evento->dat_ini_vig.";".$evento->dat_fim_vig.
                            ";".$evento->des_local.";".$evento->des_cidade.
                            ";".$evento->num_qtd_partic.";".$evento->hor_ini.
                            ";".$evento->hor_fim.";".$evento->sieve.
                            ";".$evento->getEventoPrincipal()->eventointerno.
                            ";".$evento->getAbrangencia()->getDescricao().
                            ";".$evento->getCodTipoEvento()->getDes_tip_evento().
                            ";".$funcionarios.
                            ";".$evento->estado.";".$evento->cargahoraria.";".
                            $evento->mes."\n";

 
                }

                header("Content-Encoding: UTF-8");
//                header("Content-type: plain/text"); 
                header("Content-type: application/vnd.ms-excel; charset=UTF-8"); 
                header("Content-Disposition: attachment; filename='eventosnco.csv'"); 
                header("Pragma: no-cache");
                header("Expires: 0");
                header("Content-length: ".strlen($csvData)."\r\n");
                echo "\xEF\xBB\xBF";


                
              ///logica pra tirar o codigo html na hora q exporta...
                $ViewModel = new ViewModel(array(
			'csvData' => $csvData
		));
                $ViewModel->setTerminal(true);
                return $ViewModel;
        }
    

}

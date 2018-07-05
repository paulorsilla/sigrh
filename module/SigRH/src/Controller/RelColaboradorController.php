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
     * @var \TCPDF
     */
    private $tcpdf;
    
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * Construtor da classe, utilizado para injetar as dependências no controller
     */
    public function __construct($entityManager, $tcpdf, $renderer) {
        $this->entityManager = $entityManager;
        $this->tcpdf = $tcpdf;
        $this->renderer = $renderer;
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
            "instituicaoEnsino" => $this->params()->fromQuery("instituicaoEnsino"),
            "escala" => $this->params()->fromQuery("escala"),
            "numeroChip" => $this->params()->fromQuery("numeroChip")
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
        $repo_instituicao = $this->entityManager->getRepository(\SigRH\Entity\Instituicao::class);
        $array_instituicao = $repo_instituicao->getQuery(["combo" => "1"]);

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
        
        //escala
        $repo_escala = $this->entityManager->getRepository(\SigRH\Entity\Escala::class);
        $array_escala = $repo_escala->getListParaCombo();
        
        $view = new \Zend\View\Model\ViewModel();
        $view->setVariable("colaboradores", $repo->getPaginator());
        $view->setVariable("array_grupoSanguineo", $array_grupoSanguineo);
        $view->setVariable("array_estadoCivil", $array_estadoCivil);
        $view->setVariable("array_grauInstrucao", $array_grauInstrucao);
        $view->setVariable("array_nivelEscolaridade", $array_nivelEscolaridade);
        $view->setVariable("array_instituicao", $array_instituicao);
        $view->setVariable("array_bolsa", $array_bolsa);
        $view->setVariable("array_meses", $array_meses);
        $view->setVariable("array_tipo_vinculo", $array_tipo_vinculo);
        $view->setVariable("array_orientador", $array_orientador);
        $view->setVariable("array_subLotacao", $array_subLotacao);
        $view->setVariable("array_escala", $array_escala);

        return $view;
    }

    public function gerarHtmlAction() {

        $search = $this->params()->fromQuery();  
        
        $user = $this->identity();
        $search['perfilUsuario'] = $user['papel'];
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
        
        $instituicaoEnsino = NULL;
        if(!empty($search['instituicaoEnsino'])) {
            $instituicaoEnsino = $this->entityManager->find(\SigRH\Entity\Instituicao::class, $search['instituicaoEnsino']);
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
        
        $escala = NULL;
        if (!empty($search['escala'])) {
            $escala = $this->entityManager->find(\SigRH\Entity\Escala::class, $search['escala']);
        }
        
        $numeroChip = NULL;
        if (!empty($search['numeroChip'])) {
            $numeroChip = $search['numeroChip'];
        }

        $this->layout()
                ->setTemplate("layout/impressao")
                ->setVariable("titulo_impressao", "Colaboradores");
        $view = new \Zend\View\Model\ViewModel();
        $view->setVariables(["colaboradores"        => $colaboradores,
                             "instituicaoFomento"   => $instituicaoFomento,
                             "instituicaoEnsino"    => $instituicaoEnsino,
                             "aniversariantesMes"   => $aniversariantesMes,
                             "tipoVinculo"          => $tipoVinculo,
                             "orientador"           => $orientador,
                             "inicioVigenciaIni"    => $inicioVigenciaIni,
                             "inicioVigenciaFim"    => $inicioVigenciaFim,
                             "terminoVigenciaIni"   => $terminoVigenciaIni,
                             "terminoVigenciaFim"   => $terminoVigenciaFim,
                             "subLotacao"           => $subLotacao,
                             "escala"               => $escala,
                             "numeroChip"           => $numeroChip,
                ]);
        return $view;
//}
    }
    
        public function csvAction()
        {
                $titulo = "Relatório geral";
               
                  $params = $this->params()->fromQuery();   
                  $user = $this->identity();
                  $params['perfilUsuario'] = $user['papel'];
                  
                  $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
                  $colaboradores = $repo->getQuery($params)->getResult();                  
                  

                //cabecalho
                $csvData = $titulo."\n";
                $csvData .= "matricula;nome;Fomento;Sub lotação;Grau de instrução;Obrigatório;Data inicio;Data término;Data nascimento;";
                $csvData .= "Tipo colaborador;Linha ônibus;Endereço;Cidade;UF;Grupo sanguíneo;Cor pele;Estado civil;Supervisor;Apelido;Sexo;Nacionalidade;Telefone residencial;";
                $csvData .= "Celular;Ramal; Email;Necessidade especial;Login sede;Email corporativo;RG;Data emissão RG;Órgão expedidor; CPF; Número CTPS; Data expedição CTPS; Série CTPS; PIS;Crachás;Dependentes; "."\n";
//                $csvData .= "Natural;"."\n";

//                $lista_obrigatorio = array(0=>'Não',1=>'Sim');
                $lista_grauParentesco = [1 => "Cônjuge", 2 => "Filho(a)", 3 => "Irmã(o)", 4 => "Pai", 5 => "Mãe", 99 => "Outros"];
                foreach ($colaboradores as $colaborador) {
                    $lista_crachas = array();
                    foreach($colaborador->crachas as $cracha){
                        $lista_crachas[] = $cracha->numeroChip;
                    }
                    $lista_dependentes = array();
                    foreach($colaborador->dependentes as $dependente){
                        $lista_dependentes[] = $dependente->nome." (".$lista_grauParentesco[$dependente->grauParentesco].")";
                    }                    
                    foreach( $colaborador->vinculos as $vinculo ) {
                        $csvData .= $colaborador->matricula.";".
                                    $colaborador->nome.";".
                                    ($vinculo->instituicaoFomento!= null?$vinculo->instituicaoFomento->nomFantasia:"").";".
                                    $vinculo->getSublotacao()->descricao.";".
                                    $colaborador->getGrauInstrucao()->descricao.";".
                                   // $lista_obrigatorio[$vinculo->obrigatorio].";". // uma forma de fazer
                                    ($vinculo->obrigatorio==1?'Sim':'Não').";". // segunda forma de fazer
                                    ($vinculo->dataInicio!=null?$vinculo->dataInicio->format('d/m/Y'):"").";".
                                    ($vinculo->dataTermino!=null?$vinculo->dataTermino->format('d/m/Y'):"").";".
                                    ($colaborador->dataNascimento!=null?$colaborador->dataNascimento->format('d/m/Y'):"").";".
                                    $colaborador->getTipoColaborador()->descricao.";".
                                    $colaborador->getLinhaOnibus()->descricao.";".
                                    $colaborador->getEndereco()->endereco.";".
                                    ($colaborador->getEndereco()->getCidade()!=null?$colaborador->getEndereco()->getCidade()->cidade:"").";".
                                    ($colaborador->getEndereco()->getCidade()!=null?$colaborador->getEndereco()->getCidade()->estado->sigla:"").";".
                                    $colaborador->getGrupoSanguineo()->descricao.";".
                                    $colaborador->getCorPele()->descricao.";".
                                    $colaborador->getEstadoCivil()->descricao.";".
//                                    ($colaborador->getNatural()->getCidade()!=null?$colaborador->getNatural()->getCidade()->cidade:"").";".
//                                    $colaborador->getNatural()->getCidade()->cidade.";".
                                    $vinculo->getOrientador()->nome.";".
                                    $colaborador->apelido.";".
                                    $colaborador->sexo.";".
                                    $colaborador->nacionalidade.";".
                                    $colaborador->telefoneResidencial.";".
                                    $colaborador->telefoneCelular.";".
                                    $colaborador->ramal.";".
                                    $colaborador->email.";".
                                    ($colaborador->necessidadeEspecial==1?'Sim':'Não').";". 
                                    $colaborador->loginSede.";".
                                    $colaborador->emailCorporativo.";".
                                    $colaborador->rgNumero.";".
                                    ($colaborador->rgDataEmissao!=null?$colaborador->rgDataEmissao->format('d/m/Y'):"").";".
                                    $colaborador->rgOrgaoExpedidor.";".
                                    $colaborador->cpf.";".
                                    $colaborador->ctpsNumero.";".
                                    ($colaborador->ctpsDataExpedicao!=null?$colaborador->ctpsDataExpedicao->format('d/m/Y'):"").";".
                                    $colaborador->ctpsSerie.";".
                                    $colaborador->pis.";".
                                    implode(',',$lista_crachas).";".  // adiciona o separador virgula para um array
                                    implode(',',$lista_dependentes).";".  
                                    "\n";
                    }
                }

                header("Content-Encoding: UTF-8");
//                header("Content-type: plain/text"); 
                header("Content-type: application/vnd.ms-excel; charset=UTF-8"); 
                header("Content-Disposition: attachment; filename='colab.csv'"); 
                header("Pragma: no-cache");
                header("Expires: 0");
                header("Content-length: ".strlen($csvData)."\r\n");
                echo $csvData;
                die();
        }
        
        public function estatisticasAction()
        {
            $periodoIni = $this->params()->fromQuery("periodoIni");
            $periodoFim = $this->params()->fromQuery("periodoFim");
            $tipoVinculoId = $this->params()->fromQuery("tipoVinculo");
            $tipoVinculo = $this->entityManager->find(\SigRH\Entity\TipoVinculo::class, $tipoVinculoId);
            
            $view = new \Zend\View\Model\ViewModel();
            
            if ( ($tipoVinculo) && ($periodoIni != "") && ($periodoFim != "") ) {

                $anoIni = substr($periodoIni, 3, 4);
                $mesIni = substr($periodoIni, 0, 2);
                $anoFim = substr($periodoFim, 3, 4);
                $mesFim = substr($periodoFim, 0, 2);

                $referencia = $anoIni.$mesIni;
                $refFim = $anoFim.$mesFim;

                $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);

                $estatisticas = [];
                $totalGeral = 0;
                while($referencia <= $refFim) {
                    $search = ["referenciaEstatistica" => $referencia, "tipoVinculo" => $tipoVinculo];
                    $colaboradores = $repo->getQuery($search)->getResult();
                    $total = count($colaboradores);
                    $estatisticas[$referencia] = $total;
                    $totalGeral += $total;
                    $mesReferencia = substr($referencia, 4, 2);
                    if ($mesReferencia == 12) {
                        $anoReferencia = substr($referencia, 0, 4);
                        $anoReferencia += 1;
                        $referencia = $anoReferencia."01";
                    } else {
                        $referencia += 1;
                    }
                }

                //meses do ano
                $array_meses = ["01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho",
                            "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"];
                $view->setVariables(["array_meses" => $array_meses,
                                     "estatisticas" => $estatisticas,
                                     "tipoVinculo" => $tipoVinculo,
                                     "anoIni" => $anoIni,
                                     "mesIni" => $mesIni,
                                     "anoFim" => $anoFim,
                                     "mesFim" => $mesFim,
                                     "total" => $totalGeral
                    ]);
            }
            return $view;
        }
        
        public function gerarCrachaAction()
        {
            $search = $this->params()->fromQuery();  
        
            $user = $this->identity();
            $search['perfilUsuario'] = $user['papel'];
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

            $instituicaoEnsino = NULL;
            if(!empty($search['instituicaoEnsino'])) {
                $instituicaoEnsino = $this->entityManager->find(\SigRH\Entity\Instituicao::class, $search['instituicaoEnsino']);
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

            $escala = NULL;
            if (!empty($search['escala'])) {
                $escala = $this->entityManager->find(\SigRH\Entity\Escala::class, $search['escala']);
            }
//            $this->layout()
//                ->setTemplate("layout/layout-cracha");
//                ->setVariable("titulo_impressao", "Colaboradores");
            
//            $view = new \Zend\View\Model\ViewModel();
//            
//            $view->setVariables(["colaboradores"        => $colaboradores,
//                                 "instituicaoFomento"   => $instituicaoFomento,
//                                 "instituicaoEnsino"    => $instituicaoEnsino,
//                                 "aniversariantesMes"   => $aniversariantesMes,
//                                 "tipoVinculo"          => $tipoVinculo,
//                                 "orientador"           => $orientador,
//                                 "inicioVigenciaIni"    => $inicioVigenciaIni,
//                                 "inicioVigenciaFim"    => $inicioVigenciaFim,
//                                 "terminoVigenciaIni"   => $terminoVigenciaIni,
//                                 "terminoVigenciaFim"   => $terminoVigenciaFim,
//                                 "subLotacao"           => $subLotacao,
//                                 "escala"               => $escala,
//                    ]);
            
//            $view->setTemplate("sig-rh/rel-colaborador/gerar-cracha");
            
//            $renderer = $this->renderer;
//            $html = $renderer->render($view);
//            
            $pdf = $this->tcpdf;
            $pdf->AddPage("L");
            
            //Coordenadas
            $x= ['0' => 17, '1' => 153];
            $y = ['0' => 12, '1' => 102];

            //coluna
            $c = 0;

            //linha
            $l = 0;
            
            foreach($colaboradores as $colaborador) {
                $vinculo = $colaborador->getVinculos()->first();
                if ( (null != $vinculo ) && (null != $vinculo->getTipoVinculo()) && (null != $vinculo->getLocalizacao())) {
                    $cargo = "";
                    if ( in_array($vinculo->getTipoVinculo()->getId(), [1, 7]) ) {
                        $cor = ['r' => 0, 'g' => 0, 'b' => 128];
                        $cargo = (null != $vinculo->getCargo()) ? $vinculo->getCargo()->getDescricao() : '--';
                    } else {
                        $cor = ['r' => 0, 'g' => 128, 'b' => 0];
                        $cargo = $vinculo->getTipoVinculo()->getDescricao();
                    }

                    $cpf = $colaborador->getCpf();
                    $cpfFormatado = substr($cpf, 0, 3).".".substr($cpf, 3, 3).".". substr($cpf, 6, 3)."-".substr($cpf, 9, 2);
                    $pdf->SetFont('arialnarrow', 'IB', 14, '', false);
                    $pdf->Rect($x[$c]+8, $y[$l], 56, 86);
                    $pdf->Rect($x[$c]+65, $y[$l], 56, 86);

                    $pdf->Image("/img/embrapa-soja-cor.png", $x[$c]+79, $y[$l]+5, 30);
                    if(file_exists(__DIR__."/../../../../public/img/fotos/jpg/".$colaborador->getMatricula().".jpg")) {
                        $pdf->Image("/img/fotos/jpg/".$colaborador->getMatricula().".jpg", $x[$c]+79, $y[$l]+23, 30, 0);
                    }
                    $pdf->ln(66);
                    $pdf->SetFillColor($cor['r'], $cor['g'], $cor['b']);
                    $pdf->SetAbsXY($x[$c]+65, $y[$l]+62);
                    $pdf->SetTextColor(255, 255, 255);
                    $pdf->Cell(56, 10, strtoupper($colaborador->getApelido()), 0, 0, 'C', 1);
                    $pdf->ln(15);
                    $pdf->SetFont('arialnarrow', 'IB', 12, '', false);
                    $pdf->SetTextColor(0, 0, 128);
                    $pdf->SetAbsX($x[$c]+65);
                    $pdf->Cell(56, 0, $vinculo->getLocalizacao()->getDescricao(), 0, 0, 'C');

                    $pdf->SetFont('arialnarrow', 'IB', 10, '', false);
                    $pdf->SetAbsXY($x[$c]+8, $y[$l]+2);
                    $pdf->Cell(54, 0, "Nome", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+8, $y[$l]+13);
                    $pdf->Cell(54, 0, "CPF", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+8, $y[$l]+22);
                    $pdf->Cell(54, 0, "Identidade/Órgão", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+8, $y[$l]+31);
                    $pdf->Cell(54, 0, "Nascimento", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+45, $y[$l]+31);
                    $pdf->Cell(54, 0, "Admissão", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+8, $y[$l]+40);
                    $pdf->Cell(54, 0, "Cargo", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+45, $y[$l]+40);
                    $pdf->Cell(54, 0, "Matrícula", 0, 0, 'L');

                    $pdf->SetFont('arialnarrow', 'I', 7, '', false);

                    $pdf->SetAbsXY($x[$c]+13, $y[$l]+63);
                    $pdf->Cell(45, 0, "Empresa Brasileira de Pesquisa Agropecuária", 0, 0, 'C');
                    $pdf->SetAbsXY($x[$c]+13, $y[$l]+66);
                    $pdf->Cell(45, 0, "Ministério da Agricultura, Pecuária e Abastecimento", 0, 0, 'C');
                    $pdf->SetAbsXY($x[$c]+13, $y[$l]+69);
                    $pdf->Cell(45, 0, "Fone: (43) 3371-6000", 0, 0, 'C');

                    $pdf->SetFont('arialnarrow', 'IB', 10, '', false);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetAbsXY($x[$c]+10, $y[$l]+6);
                    $pdf->Cell(54, 0, $colaborador->getNome(), 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+10, $y[$l]+17);
                    $pdf->Cell(54, 0, $cpfFormatado, 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c]+10, $y[$l]+26);
                    $pdf->Cell(54, 0, $colaborador->getRgNumero()." ".$colaborador->getRgOrgaoExpedidor(), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c]+10, $y[$l]+35);
                    $pdf->Cell(54, 0, $colaborador->getDataNascimento()->format("d/m/Y"), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c]+46, $y[$l]+35);
                    $pdf->Cell(54, 0, $vinculo->getDataInicio()->format("d/m/Y"), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c]+10, $y[$l]+44);
                    $pdf->Cell(54, 0, $cargo, 0, 0, "L");
                    $pdf->SetAbsXY($x[$c]+46, $y[$l]+44);
                    $pdf->Cell(54, 0, $colaborador->getMatricula(), 0, 0, "L");

                    $pdf->SetFont('arialnarrow', 'IB', 8, '', false);
                    $pdf->SetAbsXY($x[$c]+13, $y[$l]+55);
                    $pdf->Cell(45, 0, "José Renato Bouças Farias", 0, 0, 'C');
                    $pdf->SetAbsXY($x[$c]+13, $y[$l]+58);
                    $pdf->SetFont('arialnarrow', 'IB', 7, '', false);
                    $pdf->Cell(45, 0, "Chefe-geral da Embrapa Soja", 0, 0, 'C');

                    $pdf->SetAbsXY($x[$c]+16, $y[$l]+74);
                    $pdf->write1DBarcode($colaborador->getMatricula(), "I25", "", "", 40, 12, 40);
                    
                    $c+= 1;
                    if ($c > 1) {
                        $l+= 1;
                        if ($l > 1 ) {
                            $l = 0;
                            $pdf->AddPage("L");
                        }
                        $c = 0;
                    }
                }
            }
            $pdf->Output();
       }
}

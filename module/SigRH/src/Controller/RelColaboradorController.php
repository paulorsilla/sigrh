<?php

namespace SigRH\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SigRH\Entity\Vinculo;

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
            
            "desligamentoIni" => $this->params()->fromQuery("desligamentoIni"),
            "desligamentoFim" => $this->params()->fromQuery("desligamentoFim"),
            
            "subLotacao" => $this->params()->fromQuery("subLotacao"),
            "instituicaoEnsino" => $this->params()->fromQuery("instituicaoEnsino"),
            "escala" => $this->params()->fromQuery("escala"),
            "numeroChip" => $this->params()->fromQuery("numeroChip"),
        ];

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        /////montando as selectbox...  
        //orientador
        $array_orientador = $repo->getQuery(['tipoColaborador' => '1', 'ativo' => 'S', 'combo' => '1']);

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

        if ((isset($search['ativoEmInicio']) && ($search['ativoEmInicio']) != "")) {
            $search['ativo'] = "";
        }

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
        if (!empty($search['instituicaoEnsino'])) {
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
        
        $desligamentoIni = NULL;
        if (!empty($search['desligamentoIni'])) {
            $desligamentoIni = \DateTime::createFromFormat("Y-m-d", $search['desligamentoIni']);
        }

        $desligamentoFim = NULL;
        if (!empty($search['desligamentoFim'])) {
            $desligamentoFim = \DateTime::createFromFormat("Y-m-d", $search['desligamentoFim']);
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
        $view->setVariables(["colaboradores" => $colaboradores,
            "instituicaoFomento" => $instituicaoFomento,
            "instituicaoEnsino" => $instituicaoEnsino,
            "aniversariantesMes" => $aniversariantesMes,
            "tipoVinculo" => $tipoVinculo,
            "orientador" => $orientador,
            "inicioVigenciaIni" => $inicioVigenciaIni,
            "inicioVigenciaFim" => $inicioVigenciaFim,
            "terminoVigenciaIni" => $terminoVigenciaIni,
            "terminoVigenciaFim" => $terminoVigenciaFim,
            "desligamentoIni" => $desligamentoIni,
            "desligamentoFim" => $desligamentoFim,
            "subLotacao" => $subLotacao,
            "escala" => $escala,
            "numeroChip" => $numeroChip,
        ]);
        return $view;
//}
    }
    
    public function captiveportalsqlAction()
    {
        $params = $this->params()->fromQuery();
        $user = $this->identity();
        $params['perfilUsuario'] = $user['papel'];
        if ((isset($params['ativoEmInicio']) && ($params['ativoEmInicio']) != "")) {
            $params['ativo'] = "";
        }
        $sqlData = 'DELETE FROM "main"."cp_captiveportalcpf" WHERE 1;'."\n";
        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($params)->getResult();
        
        foreach($colaboradores as $k => $colaborador) {
            $sqlData .= 'INSERT INTO "main"."cp_captiveportalcpf" (id, cpf, status, numDevices, period, time_id) VALUES ('.$k.',"'.$colaborador->getCpf().'", 0, 1, NULL, 0);'."\n";
        }
        
//        header("Content-Encoding: UTF-8");
        header("Content-Type: application/csv"); 
        //header("Content-type: application/vnd.ms-excel;");

        header("Content-Disposition: attachment; filename=captiveportal.sql");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-length: " . strlen($sqlData) . "\r\n");
        echo $sqlData;
        die();
    }

    public function csvAction() 
    {
        $titulo = "Relatório geral";

        $params = $this->params()->fromQuery();
        $user = $this->identity();
        $params['perfilUsuario'] = $user['papel'];
        if ((isset($params['ativoEmInicio']) && ($params['ativoEmInicio']) != "")) {
            $params['ativo'] = "";
        }

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($params)->getResult();

        //cabecalho
        $csvData = $titulo . "\n";
        $csvData .= "Matricula;Nome;Cargo;Fomento;Valor da bolsa;Ensino;Sub lotação;Grau de instrução;Obrigatório;Data inicio;Data término;Data nascimento;";
        $csvData .= "Tipo colaborador;Linha ônibus;Endereço;Cidade;UF;Grupo sanguíneo;Cor pele;Estado civil;Supervisor;Apelido;Sexo;Nacionalidade;Telefone residencial;";
        $csvData .= "Celular;Ramal; Email;Necessidade especial;Login sede;Email corporativo;RG;Data emissão RG;Órgão expedidor; CPF; Número CTPS; Data expedição CTPS; Série CTPS; PIS;Crachás;Dependentes; " . "\n";
//                $csvData .= "Natural;"."\n";
//                $lista_obrigatorio = array(0=>'Não',1=>'Sim');
        $lista_grauParentesco = [1 => "Cônjuge", 2 => "Filho(a)", 3 => "Irmã(o)", 4 => "Pai", 5 => "Mãe", 99 => "Outros"];
        foreach ($colaboradores as $colaborador) {
            $lista_crachas = array();
            foreach ($colaborador->crachas as $cracha) {
                $lista_crachas[] = $cracha->numeroChip;
            }
            $lista_dependentes = array();
            foreach ($colaborador->dependentes as $dependente) {
                $lista_dependentes[] = $dependente->nome . " (" . $lista_grauParentesco[$dependente->grauParentesco] . ")";
            }
            $vinculo = ($colaborador->getVinculos()->count() > 0) ? $colaborador->getVinculos()->first() : NULL;
            $cargo = "";
            if($vinculo) {
                $dataTermino = "";
                if (null != $vinculo->dataDesligamento) {
                    $dataTermino = $vinculo->dataDesligamento->format("d/m/Y")."*";
                } else if (null != $vinculo->dataTermino) {
                    $dataTermino = $vinculo->dataTermino->format("d/m/Y");
                }
                $cargo = (null != $vinculo->getCargo()) ? $vinculo->getCargo()->getDescricao() : "";
//            foreach ($colaborador->vinculos as $vinculo) {
                $csvData .= $colaborador->matricula . ";" .
                        $colaborador->nome . ";" .
                        $cargo. ";" .
                        ($vinculo->instituicaoFomento != null ? $vinculo->instituicaoFomento->nomFantasia : "") . ";" .
                        $vinculo->valorBolsa . ";" .
                        ($vinculo->instituicaoEnsino != null ? $vinculo->instituicaoEnsino->nomFantasia : "") . ";" .
                        $vinculo->getSublotacao()->descricao . ";" .
                        $colaborador->getGrauInstrucao()->descricao . ";" .
                        // $lista_obrigatorio[$vinculo->obrigatorio].";". // uma forma de fazer
                        ($vinculo->obrigatorio == 1 ? 'Sim' : 'Não') . ";" . // segunda forma de fazer
                        ($vinculo->dataInicio != null ? $vinculo->dataInicio->format('d/m/Y') : "") . ";" . $dataTermino . ";".
                        ($colaborador->dataNascimento != null ? $colaborador->dataNascimento->format('d/m/Y') : "") . ";" .
                        $vinculo->getTipoVinculo()->getDescricao() . ";" .
                        $colaborador->getLinhaOnibus()->descricao . ";" .
                        $colaborador->getEndereco()->endereco . ";" .
                        ($colaborador->getEndereco()->getCidade() != null ? $colaborador->getEndereco()->getCidade()->cidade : "") . ";" .
                        ($colaborador->getEndereco()->getCidade() != null ? $colaborador->getEndereco()->getCidade()->estado->sigla : "") . ";" .
                        $colaborador->getGrupoSanguineo()->descricao . ";" .
                        $colaborador->getCorPele()->descricao . ";" .
                        $colaborador->getEstadoCivil()->descricao . ";" .
//                                    ($colaborador->getNatural()->getCidade()!=null?$colaborador->getNatural()->getCidade()->cidade:"").";".
//                                    $colaborador->getNatural()->getCidade()->cidade.";".
                        $vinculo->getOrientador()->nome . ";" .
                        $colaborador->apelido . ";" .
                        $colaborador->sexo . ";" .
                        $colaborador->nacionalidade . ";" .
                        $colaborador->telefoneResidencial . ";" .
                        $colaborador->telefoneCelular . ";" .
                        $colaborador->ramal . ";" .
                        $colaborador->email . ";" .
                        ($colaborador->necessidadeEspecial == 1 ? 'Sim' : 'Não') . ";" .
                        $colaborador->loginSede . ";" .
                        $colaborador->emailCorporativo . ";" .
                        $colaborador->rgNumero . ";" .
                        ($colaborador->rgDataEmissao != null ? $colaborador->rgDataEmissao->format('d/m/Y') : "") . ";" .
                        $colaborador->rgOrgaoExpedidor . ";" .
                        $colaborador->cpf . ";" .
                        $colaborador->ctpsNumero . ";" .
                        ($colaborador->ctpsDataExpedicao != null ? $colaborador->ctpsDataExpedicao->format('d/m/Y') : "") . ";" .
                        $colaborador->ctpsSerie . ";" .
                        $colaborador->pis . ";" .
                        implode(', ', $lista_crachas) . ";" . // adiciona o separador virgula para um array
                        implode(', ', $lista_dependentes) . ";" .
                        "\n";
            }
        }
        $csvData .= ";;;;;;;;;* - Data de desligamento.";
        header("Content-Encoding: UTF-8");
//                header("Content-type: plain/text"); 
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=colab.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-length: " . strlen($csvData) . "\r\n");
        echo utf8_decode($csvData);
        die();
    }
    
    public function feriascsvAction()
    {
        $titulo = "Relatório de férias";

        $periodoIni = $this->params()->fromQuery('periodoFeriasIni');
        $periodoFim = $this->params()->fromQuery('periodoFeriasFim');
        $dataIni = substr($periodoIni, 3, 4).substr($periodoIni, 0, 2)."01";
        $dataFim = substr($periodoFim, 3, 4).substr($periodoFim, 0, 2)."31";
        
        $buscaVinculoIni = substr($periodoIni, 3, 4).substr($periodoIni, 0, 2);

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $repoVinculo = $this->entityManager->getRepository(\SigRH\Entity\Vinculo::class);
        
        $colaboradores = $repo->getColaboradoresRecesso($dataIni, $dataFim)->getResult();

        //cabecalho
        $csvData = $titulo . "\n";
        $csvData .= "CPF;Nome;Início;Término;Instituição de fomento;Estágio obrigatório\n";
        foreach ($colaboradores as $colaborador) {
            $vinculo = $repoVinculo->buscar_vinculo_por_referencia($colaborador['matricula'], $buscaVinculoIni, $colaborador['dataInicio']);
            $instituicaoFomento = (null != $vinculo->getInstituicaoFomento()) ? $vinculo->getInstituicaoFomento()->getDesRazaoSocial() : "-";
            //$instituicaoFomento = $colaborador['desRazaoSocial'];
            
            if ($colaborador['obrigatorio']) {
                $obrigatorio = "Sim";
            } else {
                $obrigatorio = "Não";
            }
            $csvData .= $colaborador['cpf'] . ";" . $colaborador['nome'] . ";".$colaborador['dataInicio']->format("d/m/Y").";".$colaborador['dataTermino']->format("d/m/Y").';'.$instituicaoFomento.';'.$obrigatorio."\n";
        }
        header("Content-Encoding: UTF-8");
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=ferias.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-length: " . strlen($csvData) . "\r\n");
        echo utf8_decode($csvData);
        die();
    }

    public function estatisticasAction() {
        $periodoIni = $this->params()->fromQuery("periodoIni");
        $periodoFim = $this->params()->fromQuery("periodoFim");
        $tipoVinculoId = $this->params()->fromQuery("tipoVinculo");
        $tipoVinculo = $this->entityManager->find(\SigRH\Entity\TipoVinculo::class, $tipoVinculoId);

        $view = new \Zend\View\Model\ViewModel();

        if (($tipoVinculo) && ($periodoIni != "") && ($periodoFim != "")) {

            $anoIni = substr($periodoIni, 3, 4);
            $mesIni = substr($periodoIni, 0, 2);
            $anoFim = substr($periodoFim, 3, 4);
            $mesFim = substr($periodoFim, 0, 2);

            $referencia = $anoIni . $mesIni;
            $refFim = $anoFim . $mesFim;

            $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);

            $estatisticas = [];
            $totalGeral = 0;
            while ($referencia <= $refFim) {
                $search = ["referenciaEstatistica" => $referencia, "tipoVinculo" => $tipoVinculo];
                $colaboradores = $repo->getQuery($search)->getResult();
                foreach ($colaboradores as $k => $colaborador) {
                    error_log(($k + 1) . " => " . $colaborador->getNome());
                }
                $total = count($colaboradores);
                $estatisticas[$referencia] = $total;
                $totalGeral += $total;
                $mesReferencia = substr($referencia, 4, 2);
                if ($mesReferencia == 12) {
                    $anoReferencia = substr($referencia, 0, 4);
                    $anoReferencia += 1;
                    $referencia = $anoReferencia . "01";
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

    public function gerarCrachaAction() {
        $search = $this->params()->fromQuery();

        $user = $this->identity();
        $search['perfilUsuario'] = $user['papel'];
        //\Zend\Debug\Debug::dump($search );
        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($search)->getResult();

        $pdf = $this->tcpdf;
        $pdf->AddPage("L");

        //Coordenadas
        $x = ['0' => 17, '1' => 153];
        $y = ['0' => 12, '1' => 102];

        //coluna
        $c = 0;

        //linha
        $l = 0;

        foreach ($colaboradores as $colaborador) {
            $vinculo = $colaborador->getVinculos()->first();
            $prataCasa = false;
            if ((null != $vinculo ) && (null != $vinculo->getTipoVinculo()) && (null != $vinculo->getLocalizacao())) {
                if (in_array($vinculo->getTipoVinculo()->getId(), [1, 7])) {
                    $cor = ['r' => 0, 'g' => 0, 'b' => 128];
                    $cargo = (null != $vinculo->getCargo()) ? $vinculo->getCargo()->getDescricao() : '--';
                } else if (in_array($vinculo->getTipoVinculo()->getId(), [11])) {
                    $cor = ['r' => 128, 'g' => 128, 'b' => 128];
                    $prataCasa = true;
                    $repoVinculo = $this->entityManager->getRepository(Vinculo::class);
                    $search['matricula'] = $colaborador->getMatricula();
                    $vinculos = $repoVinculo->getQuery($search)->getQuery()->getResult();
                    $vinculoAnterior = $vinculos[1];
                    $cargo = (null != $vinculoAnterior->getCargo()) ? $vinculoAnterior->getCargo()->getDescricao() : '--';
                } else {
                    $cor = ['r' => 0, 'g' => 128, 'b' => 0];
                    $cargo = $vinculo->getTipoVinculo()->getDescricao();
                }

                $cpf = $colaborador->getCpf();
                $cpfFormatado = substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9, 2);
                $pdf->SetFont('arialnarrow', 'IB', 16, '', false);
                $pdf->Rect($x[$c] + 8, $y[$l], 56, 86);
                $pdf->Rect($x[$c] + 65, $y[$l], 56, 86);

                if (!in_array($vinculo->getTipoVinculo()->getId(), [9, 10]) ) {
                    $pdf->Image("/img/embrapa-soja-cor.png", $x[$c] + 79, $y[$l] + 5, 30);
                } elseif (null != $vinculo->getInstituicaoFomento()) {
                    $empresa = explode(" ", $vinculo->getInstituicaoFomento()->getDesRazaoSocial());
                    $pdf->SetTextColor(0, 0, 128);
                    $pdf->SetAbsXY($x[$c] + 65, $y[$l] + 10);
                    $pdf->Cell(56, 0, $empresa[0], 0, 100, 'C');
                }
                if (file_exists(__DIR__ . "/../../../../public/img/fotos/jpg/" . $colaborador->getMatricula() . ".jpg")) {
                    $pdf->Image("/img/fotos/jpg/" . $colaborador->getMatricula() . ".jpg", $x[$c] + 79, $y[$l] + 23, 30, 0);
                }
                $pdf->SetFont('arialnarrow', 'IB', 14, '', false);

                $pdf->ln(66);
                $pdf->SetFillColor($cor['r'], $cor['g'], $cor['b']);
                $pdf->SetAbsXY($x[$c] + 65, $y[$l] + 62);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->Cell(56, 10, $colaborador->getApelido(), 0, 0, 'C', 1);
                $pdf->ln(15);
                $pdf->SetFont('arialnarrow', 'IB', 12, '', false);
                $pdf->SetAbsX($x[$c] + 65);
                if ($prataCasa) {
                    $pdf->SetTextColor(128, 128, 128);
                    $pdf->Cell(56, 0, "Prata da Casa", 0, 0, 'C');
                } else {
                    $pdf->SetTextColor(0, 0, 128);
                    $pdf->Cell(56, 0, $vinculo->getLocalizacao()->getDescricao(), 0, 0, 'C');
                }
                $pdf->SetFont('arialnarrow', 'IB', 9, '', false);
                if ($prataCasa) {
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 2);
                    $pdf->Cell(54, 0, "Nome", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 13);
                    $pdf->Cell(54, 0, "CPF", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 44, $y[$l] + 13);
                    $pdf->Cell(54, 0, "Matrícula", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 22);
                    $pdf->Cell(54, 0, "Identidade/Órgão", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 44, $y[$l] + 22);
                    $pdf->Cell(54, 0, "Admissão", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 31);
                    $pdf->Cell(54, 0, "Nascimento", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 44, $y[$l] + 31);
                    $pdf->Cell(54, 0, "Desligamento", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 40);
                    $pdf->Cell(54, 0, "Última Lotação", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 44, $y[$l] + 40);
                    $pdf->Cell(54, 0, "Último Cargo", 0, 0, 'L');

//                        $pdf->SetFont('arialnarrow', 'IB', 9, '', false);
//                        $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 6);
                    $pdf->Cell(54, 0, $colaborador->getNome(), 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 17);
                    $pdf->Cell(54, 0, $cpfFormatado, 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 46, $y[$l] + 17);
                    $pdf->Cell(54, 0, $colaborador->getMatricula(), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 26);
                    $pdf->Cell(54, 0, $colaborador->getRgNumero() . " " . $colaborador->getRgOrgaoExpedidor(), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 46, $y[$l] + 26);
                    $pdf->Cell(54, 0, $vinculoAnterior->getDataInicio()->format("d/m/Y"), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 35);
                    $pdf->Cell(54, 0, $colaborador->getDataNascimento()->format("d/m/Y"), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 46, $y[$l] + 35);
                    $pdf->Cell(54, 0, $vinculoAnterior->getDataDesligamento()->format("d/m/Y"), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 44);
                    $pdf->Cell(54, 0, $vinculo->getLocalizacao()->getDescricao(), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 46, $y[$l] + 44);
                    $pdf->Cell(54, 0, $cargo, 0, 0, "L");

                    $pdf->Line($x[$c] + 8, $y[$l] + 50, $x[$c] + 64, $y[$l] + 50);
                    $pdf->Line($x[$c] + 8, $y[$l] + 61, $x[$c] + 64, $y[$l] + 61);
                    $pdf->SetFont('arialnarrow', 'IB', 8, '', false);
                    $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 51);
                    $pdf->Cell(45, 0, "Ex-empregado", 0, 0, 'C');
                    $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 54);
                    $pdf->Cell(45, 0, "Válido somente para acesso à", 0, 0, 'C');
                    $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 57);
                    $pdf->Cell(45, 0, "Embrapa", 0, 0, 'C');
                } else {
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 2);
                    $pdf->Cell(54, 0, "Nome", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 13);
                    $pdf->Cell(54, 0, "CPF", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 22);
                    $pdf->Cell(54, 0, "Identidade/Órgão", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 31);
                    $pdf->Cell(54, 0, "Nascimento", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 45, $y[$l] + 31);
                    $pdf->Cell(54, 0, "Admissão", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 8, $y[$l] + 40);
                    $pdf->Cell(54, 0, "Cargo", 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 45, $y[$l] + 40);
                    $pdf->Cell(54, 0, "Matrícula", 0, 0, 'L');

                    $pdf->SetFont('arialnarrow', 'IB', 10, '', false);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 6);
                    $pdf->Cell(54, 0, $colaborador->getNome(), 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 17);
                    $pdf->Cell(54, 0, $cpfFormatado, 0, 0, 'L');
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 26);
                    $pdf->Cell(54, 0, $colaborador->getRgNumero() . " " . $colaborador->getRgOrgaoExpedidor(), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 35);
                    $pdf->Cell(54, 0, $colaborador->getDataNascimento()->format("d/m/Y"), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 46, $y[$l] + 35);
                    $pdf->Cell(54, 0, $vinculo->getDataInicio()->format("d/m/Y"), 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 10, $y[$l] + 44);
                    $pdf->Cell(54, 0, $cargo, 0, 0, "L");
                    $pdf->SetAbsXY($x[$c] + 46, $y[$l] + 44);
                    $pdf->Cell(54, 0, $colaborador->getMatricula(), 0, 0, "L");

                    $pdf->SetFont('arialnarrow', 'IB', 8, '', false);
                    $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 55);
                    $pdf->Cell(45, 0, "José Renato Bouças Farias", 0, 0, 'C');
                    $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 58);
                    $pdf->SetFont('arialnarrow', 'IB', 7, '', false);
                    $pdf->Cell(45, 0, "Chefe-geral da Embrapa Soja", 0, 0, 'C');
                }
                $pdf->SetFont('arialnarrow', 'I', 7, '', false);

                $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 63);
                $pdf->Cell(45, 0, "Empresa Brasileira de Pesquisa Agropecuária", 0, 0, 'C');
                $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 66);
                $pdf->Cell(45, 0, "Ministério da Agricultura, Pecuária e Abastecimento", 0, 0, 'C');
                $pdf->SetAbsXY($x[$c] + 13, $y[$l] + 69);
                $pdf->Cell(45, 0, "Fone: (43) 3371-6000", 0, 0, 'C');

                $pdf->SetAbsXY($x[$c] + 16, $y[$l] + 74);
                $pdf->write1DBarcode($colaborador->getMatricula(), "I25", "", "", 40, 12, 40);

                $c += 1;
                if ($c > 1) {
                    $l += 1;
                    if ($l > 1) {
                        $l = 0;
                        $pdf->AddPage("L");
                    }
                    $c = 0;
                }
            }
        }
        $pdf->Output();
    }
    
    public function gerarDocumentoInicialAction() {
        $search = $this->params()->fromQuery();

        $user = $this->identity();
        $search['perfilUsuario'] = $user['papel'];

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($search)->getResult();

        $pdf = $this->tcpdf;

        $pdf->SetTitle("Termo de compromisso");
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);  
        
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);
        $pdf->SetAutoPageBreak(TRUE, 1);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        $pdf->SetPrintHeader(false);

        $rodape = "<i><b>Empresa Brasileira de Pesquisa Agropecuária<br>"
                . "Ministério da Agricultura, Pecuária e Abastecimento</b><br>"
                . "Rod. Carlos J. Strass, km 04 – Distrito de Warta<br>"
                . "Fone: (43) 3371-6000 – cnpso.estagios@embrapa.br<br>"
                . "Caixa Postal 231 CEP: 86001-970 Londrina PR<br>"
                . "<a href='http://www.embrapa.br/soja'>http://www.embrapa.br/soja</a></i>";
        
        foreach ($colaboradores as $colaborador) {
            $vinculo = $colaborador->getVinculos()->first();
            $cpf = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $colaborador->getCpf());
            $nome = trim($colaborador->getNome());
            $orientador = trim($vinculo->getOrientador()->getNome());
            $tratamentoOrientador = "";
            $cargoOrientador = "";
            
            switch ($vinculo->getOrientador()->getSexo()) {
                case "M": $tratamentoOrientador = "Dr."; $cargoOrientador = "Pesquisador"; break;
                case "F": $tratamentoOrientador = "Dra."; $cargoOrientador = "Pesquisadora"; break;
                default: $tratamentoOrientador = "Dr(a)"; $cargoOrientador = "Pesquisador(a)";
            }
            
            $matriculaOrientador = trim($vinculo->getOrientador()->getMatricula());
            $instituicaoEnsino = "<strike>INSTITUIÇÃO DE ENSINO NÃO INFORMADA</strike>"; 
            $rgNumero = trim($colaborador->getRgNumero());
            $dataInicio = "<strike>DATA NÃO INFORMADA</strike>";
            $dataTermino = "<strike>DATA NÃO INFORMADA</strike>";
            $nacionalidade = "<strike>NACIONALIDADE NÃO INFORMADA</strike>";
            $estadoCivil = "<strike>ESTADO CIVIL NÃO INFORMADO</strike>";
            $rgOrgaoExpedidor = "<strike>ÓRGÃO EXPEDIDOR NÃO INFORMADO</strike>";
            $endereco = "<strike>ENDEREÇO NÃO INFORMADO</strike>";
            $numero = "";
            $complemento = "";
            $bairro = "";
            $cep = "";
            $cidade = "<strike>CIDADE NÃO INFORMADA</strike>";
            $estado = "";
            $sublotacao = "<strike>ÁREA NÃO INFORMADA</strike>";
            $nivelEstagio = "<strike>NÍVEL NÃO INFORMADO</strike>";

            if ( null != $vinculo->getInstituicaoEnsino() ) {
                $instituicaoEnsino = trim($vinculo->getInstituicaoEnsino()->getDesRazaoSocial());
            }
            
            if ( null != $vinculo->getNivel()) {
                $nivelEstagio = $vinculo->getNivel()->getDescricao();
            }
            if ( null != $vinculo->getDataInicio() ) {
                $dataInicio = $vinculo->getDataInicio()->format("d/m/Y");
            }
            if ( null != $vinculo->getDataTermino() ) {
                $dataTermino = $vinculo->getDataTermino()->format("d/m/Y");
            }
            if ( null != $colaborador->getNacionalidade() ) {
                $nacionalidade = $colaborador->getNacionalidade();
            }
            if ( null != $colaborador->getEstadoCivil() ) {
                $estadoCivil = $colaborador->getEstadoCivil()->getDescricao();
            }
            if ( $colaborador->getRgOrgaoExpedidor() != '' ) {
                $rgOrgaoExpedidor = trim($colaborador->getRgOrgaoExpedidor());
            }
            
            if ( null != $colaborador->getEndereco() ) {
                $endereco = $colaborador->getEndereco()->getEndereco();
                $numero = $colaborador->getEndereco()->getNumero();
                $complemento = $colaborador->getEndereco()->getComplemento();
                $bairro = $colaborador->getEndereco()->getBairro();
                $cep = $colaborador->getEndereco()->getCep();
            }
            
            if ( null != $colaborador->getEndereco()->getCidade() ) {
                $cidade = $colaborador->getEndereco()->getCidade()->getCidade();
                if ( null != $colaborador->getEndereco()->getCidade()->getEstado() ) {
                    $estado = $colaborador->getEndereco()->getCidade()->getEstado()->getSigla();
                }
            }

            if ( null != $vinculo->getSublotacao() ) {
                $sublotacao = $vinculo->getSublotacao()->getDescricao();
            }
            
            $pdf->AddPage("P");
            $pdf->Image("/img/embrapa-soja-cor.png", 80, 7, 33);
            
            $html1 = "<p>TERMO DE COMPROMISSO DE TREINAMENTO &quot;NÃO REMUNERADO&quot;, "
                  . "QUE ENTRE SI CELEBRAM A EMPRESA BRASILEIRA DE PESQUISA "
                  . "AGROPECUÁRIA – EMBRAPA E (O)A TREINANDO(A) "
                  .strtoupper($nome).", NA FORMA ABAIXO:</p>";
            
            $html2 = "<p>A <b>EMPRESA BRASILEIRA DE PESQUISA AGROPECUÁRIA</b>, "
                   . "doravante designada simplesmente <b>EMBRAPA</b>, empresa pública"
                   . " federal vinculada ao Ministério da Agricultura, Pecuária e "
                   . "Abastecimento (MAPA) da República Federativa do Brasil, criada "
                   . "pela Lei nº 5.851, de 12 de fevereiro de 1972, Estatuto aprovado "
                   . "pelo Decreto nº 7.766, de 25 de junho de 2012, e alterado pela "
                   . "2ª Assembleia Geral Extraordinária, realizada em 12 de dezembro de 2017 "
                   . "e publicada no Diário Oficial da União nº 33, de 19 de fevereiro "
                   . "de 2018, Seção 1, páginas 2/7, consoante parágrafo único do artigo 72 "
                   . "do Decreto nº 8.945, de 27 de dezembro de 2016, por intermédio de sua "
                   . "Unidade: <b>Centro Nacional de Pesquisa de Soja</b>, inscrita no "
                   . "CNPJ/MF sob o nº. 00.348.003/0042-99, sediada em Londrina, Estado do "
                   . "Paraná, na Rodovia Carlos João Strass, km 04, Acesso Orlando Amaral, "
                   . "Distrito de Warta, neste ato representado por seu Chefe Geral, Dr. "
                   ."José Renato Bouças Farias, e do outro lado <b>".$nome."</b>, "
                   ."de nacionalidade <b>".$nacionalidade."</b>, ".$estadoCivil
                   .", portador (a) do CPF/MF nº. ".$cpf
                   ." e da Carteira de Identidade, RG nº ".$rgNumero.", "
                   .$rgOrgaoExpedidor.", residente e domiciliado em ".$cidade."-".$estado
                   .", ".$endereco.", nº ".$numero." ".$complemento." – ".$bairro." – CEP ".$cep
                   .", doravante designado simplesmente TREINANDO, "
                   ."resolveram celebrar o presente <b>“TERMO DE COMPROMISSO DE "
                   ."TREINAMENTO “NÃO REMUNERADO”</b>, que será regido pela Lei nº. "
                   ."11.788, de 25/09/2008, bem como pelas seguintes cláusulas"
                   ." e condições: </p>"
                   ."<p><b>CLÁUSULA PRIMEIRA – DO OBJETO</b><br>"	
                   ."A <b>Embrapa</b>, por este instrumento, concede treinamento "
                   ."e prática profissional ao <b>Treinando</b>, com sua efetiva atuação "
                   ."nas atividades pertinentes à área de <b>".$sublotacao
                    ."</b>, no <b>Centro Nacional de Pesquisa de Soja</b>, situado no endereço discriminado "
                   ."no preâmbulo deste instrumento, ficando sob orientação "
                   ."do(a) <b>empregado(a) ".$tratamentoOrientador." ".$orientador."</b>.</p>"
                   ."<p><b>CLÁUSULA SEGUNDA – DAS OBRIGAÇÕES ESPECIAIS</b><br>"
                   ."Sem prejuízo do disposto nas demais cláusulas deste instrumento, "
                   ."o (a) <b>Treinando (a)</b> obriga-se especialmente ao seguinte:<br>" 
                   ."a) atuar com zelo e dedicação na execução de suas atribuições, "
                   ."de forma a evidenciar desempenho satisfatório nas avaliações a "
                   ."serem realizadas pelo Supervisor do Treinamento; <br>"
                   ."b) cumprir fielmente todas as instruções, recomendações de "
                   ."normas emanadas da <b>Embrapa</b>;<br>"
                   ."c) manter total reserva em relação a quaisquer dados ou informações "
                   ."a que venha ter acesso em razão de sua atuação no cumprimento do treinamento, "
                   ."não repassando-as a terceiros sob qualquer forma ou pretexto, sem prévia "
                   ."autorização formal da <b>Embrapa</b>,  independentemente de se tratar ou não de "
                   ."informação reservada, confidencial  ou sigilosa;<br>"
                   ."d) responsabilizar-se  por qualquer dano ou  prejuízo que venha a causar ao "
                   ."patrimônio da <b>Embrapa</b> por dolo ou culpa;<br>"
                   ."e) manter conduta compatível com a ética, os bons costumes e a probidade administrativa"
                   ." no desenvolvimento do treinamento, evitando a prática de atos que caracterizem falta grave.</p>"
                   ."<p><b>CLÁUSULA TERCEIRA – DA INEXISTÊNCIA DE VÍNCULO EMPREGATÍCIO</b><br>"
                   ."A atuação do (a) <b>Treinando (a)</b> nas instalações da <b>Embrapa</b> não "
                   ."caracteriza vínculo empregatício de qualquer natureza, visando apenas treinamento "
                   ."na área citada na cláusula primeira do presente Termo e conforme atividades "
                   ."definidas no <b>Plano de Treinamento</b> elaborado pelo (a) <b>Treinando (a)</b> "
                   ."em conjunto com o <b>empregado(a) ".$tratamentoOrientador." ".$orientador."</b>.</p>"
                   ."<p><b>CLÁUSULA QUARTA – DO ACESSO ÀS INSTALAÇÕES</b><br>"
                   ."O acesso à infraestrutura e instalações da <b>Embrapa</b>, pelo (a) <b>Treinando (a)</b>, será "
                   ."o estritamente necessário à execução das atividades objeto do treinamento e de acordo com "
                   ."a regulamentação interna da <b>Embrapa</b>.</p>"
                   ."<p><b>CLÁUSULA QUINTA – DOS RESULTADOS</b><br>"
                   ."A exploração, a qualquer título, dos resultados dos trabalhos realizados pelo (a) "
                   ."<b>Treinando (a)</b>, privilegiáveis ou não, pertencerá automática e exclusivamente "
                   ."à <b>Embrapa</b>, especialmente Direitos da Propriedade Industrial, Direito sobre "
                   ."Cultivares e Direitos Autorais.</p>"
                   ."<p><b>CLÁUSULA SEXTA – DO SEGURO</b><br>"
                   ."O(a) <b>Treinando(a)</b> estará segurado(a) contra acidentes pessoais no período "
                   ."de treinamento, apólice está contratada pelo estudante.</p>"
                   ."<p><b>CLÁUSULA SÉTIMA – Da Vigência</b><br>"
                   ."O treinamento será realizado no período de <b> ".$dataInicio." a "
                   .$dataTermino."</b>.</p>"
                   ."<p><b>CLÁUSULA OITAVA – DA RESCISÃO</b><br>"
                   ."A <b>Embrapa</b> poderá rescindir o presente Termo de Compromisso, independente "
                   ."de prévia interpelação judicial ou extrajudicial, por descumprimento de qualquer "
                   ."de suas cláusulas ou condições pelo(a) <b>Treinando(a)</b>, respondendo esta pelos "
                   ."prejuízos ocasionados, salvo hipótese de caso fortuito ou de força maior.</p>"; 
            
            $html3 = "<p><b>Subcláusula Única:</b> Além do acima exposto, o presente Termo de Compromisso"
                   ." extingue-se automaticamente ou de pleno direito nas seguintes hipóteses:<br><br>"
                   ."a) iniciativa do(a) <b>Treinando(a)</b>;<br>b) conveniência técnica ou "
                   ."administrativa da <b>Embrapa</b>;<br>c) conduta reprovável do(a) <b>Treinando(a)</b>"
                   ." no ambiente de trabalho.</p>"
                   ."<p><b>CLÁUSULA NONA – DA DENÚNCIA</b><br>Qualquer das partes, independentemente "
                   ."de justo motivo e quando bem lhe convier, poderá denunciar o presente Termo de Compromisso, "
                   ."desde que o faça mediante aviso prévio, por escrito, de pelo menos  05 (cinco) dias úteis.</p>"
                   ."<p><b>CLÁUSULA DÉCIMA – DO FORO</b><br>Para solução de quaisquer controvérsias porventura "
                   ."oriundas da execução deste Termo de Compromisso, as partes elegem o Foro da Justiça Federal, "
                   ."Seção Judiciária de Londrina, PR.</p>"
                   ."<p>Estando assim justos e acordes, firmam o presente em 03 (três) vias de igual teor e forma, "
                   ."na presença das testemunhas instrumentárias abaixo nomeadas e subscritas.</p><br>"
                   ."<table border='0' cellpadding='2' cellspacing='2' nobr='true'>"
                   ."<tr><th></th><th></th></tr>"
                   .'<tr><th colspan="2" align="right">Londrina, PR, ____ de ___________________ de ______.</th>'
                   .'</tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td align="center">Dr. José Renato Bouças Farias</td>
                    <td align="center">'.$nome.'</td>
                    </tr><tr><td align="center">Chefe geral da Embrapa Soja</td>
                    <td align="center">Treinando(a)</td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr><tr><td></td><td></td></tr>
                    <tr><td></td><td align="center">'.$instituicaoEnsino.'</td></tr>
                    </table><br>
                    <b>Testemunhas:</b><br><br><br><br><br><br><br><br><br><br>'
                   ."<table border='0' cellpadding='2' cellspacing='2' nobr='true'>"
                   .'<tr><td></td><td></td></tr>
                    <tr>
                      <td align="center">SGP</td>
                      <td align="center"><b>'.$tratamentoOrientador.' '.$orientador.'</b></td>
                     </tr>
                     <tr>
                      <td align="center">Matrícula Embrapa:</td>
                      <td align="center">'.$cargoOrientador.'</td></tr>
                     <tr><td></td><td align="center">Matrícula Embrapa: '.$matriculaOrientador.'</td></tr>
                    </table>';
            
            $html4 = '<h3 align="center">TERMO DE RECEBIMENTO</h3>'
                   . '<p>Eu, '.$nome.', na qualidade de Estudante de '.$nivelEstagio
                   . ', portador(a) do R.G. nº '.$rgNumero.' e C.P.F. nº '.$cpf
                   . ', declaro ter recebido: </p>'
                   . '<p><b>- GUIA DO ESTAGIÁRIO<br>- CÓDIGO DE CONDUTA DA EMBRAPA<br>'
                   . '- CRACHÁ (ESTOU CIENTE DE QUE SEU USO É OBRIGATÓRIO, PESSOAL E INTRANSFERÍVEL, '
                   . 'SENDO PROIBIDA A UTILIZAÇÃO DESTE PARA A AUTORIZAÇÃO DA ENTRADA/SAÍDA DE '
                   . 'OUTRA PESSOA)</b></p>'
                   . '<table border="0" cellpadding="2" cellspacing="2" nobr="true">'
                   . '<tr><td></td></tr>'
                   . '<tr><td align="center">_____________________________________</td></tr>'
                   . '<tr><td align="center">'.$nome.'</td></tr></table><br><hr><br>'
                   . '<h3 align="center">AUTO DECLARAÇÃO DE COR/ETNIA</h3>'
                   . 'Eu, '.$nome.' portador(a) do R.G. nº '.$rgNumero.' e C.P.F. nº '.$cpf
                   . ', declaro, em conformidade com a classificação do IBGE, que sou de cor: <br>'
                   . '<table border="0" cellpadding="2" cellspacing="2" nobr="true">'
                   . '<tr><td></td></tr>'
                   . '<tr><td align="center">(    ) Preta (    ) Branca  (    ) Amarela (    ) Parda (    ) Indígena</td></tr>'
                   . '<tr><td></td></tr>'
                   . '<tr><td></td></tr>'
                   . '<tr><td></td></tr></table>'
                   . '<hr>'
                   . '<table border="0" cellpadding="2" cellspacing="2" nobr="true">'
                   . '<tr><td></td></tr></table>'
                   . '<b><i>I) Tipo sanguíneo e fator RH: Obrigatório se estágio não-obrigatório:</i><br><br>'
                   . 'Grupo sanguíneo</b><br>(    ) A     (    ) B     (    ) AB     (    ) O<br><br>'
                   . '<b>FATOR RH</b> <br>(    ) POSITIVO     (    ) NEGATIVO<br><br>'
                   . '<i><b>II) Autodeclaração de PNE - Portador(a) de Necessidaes Especiais</b></i><br><br>'
                   . 'Possuo necessidades especiais?  (    ) Não     (    ) Sim<br><br>'
                   . 'Tipo de necessidades especiais: <br><br>'
                   . '__________________________________________________________________________________________________<br><br>'
                   . '__________________________________________________________________________________________________<br><br>'
                   . '__________________________________________________________________________________________________<br><br>'
                   . 'Declaro que as informações acima são verdadeiras.<br>'
                   . '<table border="0" cellpadding="2" cellspacing="2" nobr="true">'
                   . '<tr><td></td></tr>'
                   . '<tr><td align="right">__________________,______/______/______.</td></tr>'
                   . '<tr><td></td></tr>'
                   . '<tr><td align="center">_____________________________________</td></tr>'
                   . '<tr><td align="center">'.$nome.'</td></tr></table>';

            $pdf->SetFont('helvetica', 'B', 8.6);
            $pdf->writeHTMLCell(0, 0, 75, 30, $html1, 0, 1, 0, true, 'J');
            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 15, 48, $html2, 0, 1, 0, true, 'J');
            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 0, 265, $rodape, 0, 1, 0, true, 'C');

            $pdf->AddPage("P");
            $pdf->Image("/img/embrapa-soja-cor.png", 80, 7, 33);
            $pdf->SetFont('helvetica', '', 8.6);
            
            $pdf->writeHTMLCell(0, 0, 15, 30, $html3, 0, 1, 0, true, 'J');
          //  $pdf->writeHTMLCell(0, 0, 15, 140, $tbl, 0, 1, 0, true, 'C');
            
            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 0, 265, $rodape, 0, 1, 0, true, 'C');

            $pdf->AddPage("P");
            $pdf->Image("/img/embrapa-soja-cor.png", 80, 7, 33);
            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 15, 30, $html4, 0, 1, 0, true, 'J');

            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 0, 265, $rodape, 0, 1, 0, true, 'C');
        }
        $pdf->Output();
    }
    
    public function gerarDocumentoDesligamentoAction() {
        $search = $this->params()->fromQuery();

        $user = $this->identity();
        $search['perfilUsuario'] = $user['papel'];

        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($search)->getResult();

        $pdf = $this->tcpdf;

        $pdf->SetTitle("Desligamento");
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);  
        
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);
        $pdf->SetAutoPageBreak(TRUE, 1);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        $pdf->SetPrintHeader(false);

        $rodape = "<i><b>Empresa Brasileira de Pesquisa Agropecuária<br>"
                . "Ministério da Agricultura, Pecuária e Abastecimento</b><br>"
                . "Rod. Carlos J. Strass, km 04 – Distrito de Warta<br>"
                . "Fone: (43) 3371-6000 – cnpso.estagios@embrapa.br<br>"
                . "Caixa Postal 231 CEP: 86001-970 Londrina PR<br>"
                . "<a href='http://www.embrapa.br/soja'>http://www.embrapa.br/soja</a></i>";
        
        foreach ($colaboradores as $colaborador) {
            $vinculo = $colaborador->getVinculos()->first();
            $nome = trim($colaborador->getNome());
            $matricula = trim($colaborador->getMatricula());
            $orientador = trim($vinculo->getOrientador()->getNome());
            
            switch ($vinculo->getOrientador()->getSexo()) {
                case "M": $tratamentoOrientador = "Dr."; $cargoOrientador = "Pesquisador"; break;
                case "F": $tratamentoOrientador = "Dra."; $cargoOrientador = "Pesquisadora"; break;
                default: $tratamentoOrientador = "Dr(a)"; $cargoOrientador = "Pesquisador(a)";
            }
            $instituicaoEnsino = "<strike>INSTITUIÇÃO DE ENSINO NÃO INFORMADA</strike>"; 
            $dataInicio = "<strike>DATA NÃO INFORMADA</strike>";
            $dataTermino = "<strike>DATA NÃO INFORMADA</strike>";
            $nacionalidade = "<strike>NACIONALIDADE NÃO INFORMADA</strike>";
            $estadoCivil = "<strike>ESTADO CIVIL NÃO INFORMADO</strike>";
            $rgOrgaoExpedidor = "<strike>ÓRGÃO EXPEDIDOR NÃO INFORMADO</strike>";
            $endereco = "<strike>ENDEREÇO NÃO INFORMADO</strike>";
            $numero = "";
            $complemento = "";
            $bairro = "";
            $cep = "";
            $cidade = "<strike>CIDADE NÃO INFORMADA</strike>";
            $estado = "";
            $sublotacao = "<strike>ÁREA NÃO INFORMADA</strike>";
            $nivelEstagio = "<strike>NÍVEL NÃO INFORMADO</strike>";

            if ( null != $vinculo->getInstituicaoEnsino() ) {
                $instituicaoEnsino = trim($vinculo->getInstituicaoEnsino()->getDesRazaoSocial());
            }
            
            if ( null != $vinculo->getNivel()) {
                $nivelEstagio = $vinculo->getNivel()->getDescricao();
            }
            if ( null != $vinculo->getDataInicio() ) {
                $dataInicio = $vinculo->getDataInicio()->format("d/m/Y");
            }
            if ( null != $vinculo->getDataTermino() ) {
                $dataTermino = $vinculo->getDataTermino()->format("d/m/Y");
            }
            if ( null != $vinculo->getTipoVinculo() ) {
                $tipoVinculoAux = $vinculo->getTipoVinculo()->getDescricao();
            }

            $artigo = ($colaborador->getSexo() == "F") ? $artigo = "a " : $artigo = "o ";
            
            $tipoVinculo = "";
            $tituloVinculo = "";
            switch($tipoVinculoAux) {
                case "Treinando": 
                    $tipoVinculo = "Treinand".$artigo; 
                    $tituloVinculo = "TREINAMENTO";
                    break;
                case "Estagiário": 
                    $tipoVinculo = "Estagiári".$artigo;
                    $tituloVinculo = "ESTÁGIO";
                    break;
                case "Bolsista": $tipoVinculo = "Bolsista";
            }
            
            if ( null != $colaborador->getNacionalidade() ) {
                $nacionalidade = $colaborador->getNacionalidade();
            }
            if ( null != $colaborador->getEstadoCivil() ) {
                $estadoCivil = $colaborador->getEstadoCivil()->getDescricao();
            }
            if ( $colaborador->getRgOrgaoExpedidor() != '' ) {
                $rgOrgaoExpedidor = trim($colaborador->getRgOrgaoExpedidor());
            }
            
            if ( null != $colaborador->getEndereco() ) {
                $endereco = $colaborador->getEndereco()->getEndereco();
                $numero = $colaborador->getEndereco()->getNumero();
                $complemento = $colaborador->getEndereco()->getComplemento();
                $bairro = $colaborador->getEndereco()->getBairro();
                $cep = $colaborador->getEndereco()->getCep();
            }
            
            if ( null != $colaborador->getEndereco()->getCidade() ) {
                $cidade = $colaborador->getEndereco()->getCidade()->getCidade();
                if ( null != $colaborador->getEndereco()->getCidade()->getEstado() ) {
                    $estado = $colaborador->getEndereco()->getCidade()->getEstado()->getSigla();
                }
            }

            if ( null != $vinculo->getSublotacao() ) {
                $sublotacao = $vinculo->getSublotacao()->getDescricao();
            }
            
            $pdf->AddPage("P");
            $pdf->Image("/img/embrapa-soja-cor.png", 80, 7, 33);
            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 0, 265, $rodape, 0, 1, 0, true, 'C');
            
            $titulo1 = '<i>AVALIAÇÃO D'.mb_strtoupper($artigo, 'UTF8').' '.mb_strtoupper($tipoVinculo, 'UTF8').' PELO ORIENTADOR</i><br>';
            $titulo2 = '<i>AVALIAÇÃO DO '.$tituloVinculo.' PEL'.mb_strtoupper($artigo, 'UTF8').' '.mb_strtoupper($tipoVinculo, 'UTF8').'</i><br>';
            $titulo3 = 'SGP/COORDENADORIA DE ESTÁGIOS/TREINAMENTOS<br>';
            
            $tblId = 
                '<table cellspacing="0" cellpadding="1" border="0.5">
                    <tr>
                        <td><i>Nome d'.$artigo.' '.$tipoVinculo.'</i><br>'.$nome.'</td>
                        <td><i>Matrícula</i><br>'.$matricula.'</td>
                        <td>Instituição de Ensino/Empresa<br>'.$instituicaoEnsino.'</td>
                    </tr>
                    <tr>
                        <td><i>Nome do Orientador/Supervisor</i><br>'.$orientador.'</td>
                        <td>Área ou Setor de Lotação<br>'.$sublotacao.'</td>
                        <td>Período de avaliação<br>'.$dataInicio.' a '.$dataTermino.'</td>
                    </tr>
                </table>';
            
            $atividades1 = '<i>Atividades desenvolvidas:</i> ______________________________________________________________________________<br><br>'
                        . '_____________________________________________________________________________________________________<br><br>'
                        . '_____________________________________________________________________________________________________<br><br>'
                        . '<i>As atividades desenvolvidas obedeceram à programação pré-estabelecida: (    ) SIM   (    ) NÃO</i> <br><br>'
                        . '<i>Em caso negativo, explique os motivos impeditivos:</i> ________________________________________________________<br><br>'
                        . '_____________________________________________________________________________________________________<br>';
            
            $atividades2 = '<i>Faça uma correlação das atividades desenvolvidas no '. mb_strtolower($tituloVinculo, "UTF8").' com os conhecimentos teóricos recebidos na Instituição de Ensino:</i><br>'
                        . '_____________________________________________________________________________________________________<br><br>'
                        . '_____________________________________________________________________________________________________<br><br>'
                        . '_____________________________________________________________________________________________________<br><br>';
            
            $tblLegenda = '<i>Avalie os itens abaixo conforme a tabela a seguir:</i><br>'
                . '<table cellspacing="0" cellpadding="1" border="0.5">
                    <tr>
                        <td align="center"><i>1</i></td>
                        <td align="center"><i>2</i></td>
                        <td align="center"><i>3</i></td>
                        <td align="center"><i>4</i></td>
                        <td align="center"><i>5</i></td>
                    </tr>
                    <tr>
                        <td align="center"><i>Insuficiente</i></td>
                        <td align="center"><i>Regular</i></td>
                        <td align="center"><i>Bom</i></td>
                        <td align="center"><i>Muito bom</i></td>
                        <td align="center"><i>Excelente</i></td>
                    </tr>
                </table>';
            
            $tblAvaliacao1 = 
                '<table cellspacing="0" cellpadding="1" border="0.5">
                    <tr>
                        <td align="center" width="80%"><i><b>Itens para avaliação</b></i></td>
                        <td align="center" width="4%"><i><b>1</b></i></td>
                        <td align="center" width="4%"><i><b>2</b></i></td>
                        <td align="center" width="4%"><i><b>3</b></i></td>
                        <td align="center" width="4%"><i><b>4</b></i></td>
                        <td align="center" width="4%"><i><b>5</b></i></td>
                    </tr>
                    <tr>
                        <td><i>01. Habilidades - considerar as habilidades demonstradas no desenvolvimento das atividades propostas, tendo em vista as condições oferecidas. </i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>02. Criatividade - capacidade para identificar, equacionar e resolver situações, bem como sugerir inovações.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>03. Cumprimento das tarefas programadas - considerar o volume do trabalho realizado, dentro de padrões aceitáveis para um '.mb_strtolower($tituloVinculo, "UTF8").'.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>04. Disposição para aprender - esforço revelado para aprender, a partir de indagações e de dúvidas apresentadas.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>05. Espírito de iniciativa.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>06. Conhecimentos - nível de conhecimento técnico-científico apresentado e que tenha revelado compatível com as tarefas propostas.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>07. Disciplina e responsabilidade - observância das normas internas da empresa ou instituição oficial, sigilo e cuidado com o patrimônio.</i></td>
                        <td></td><td></td><td></td><td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><i>08. Assiduidade e pontualidade.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>09. Disposição para atender prontamente as solicitações (cooperação).</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>10. Sociabilidade e integração no ambiente de trabalho.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>11. Atividade profissional - avaliação em perspectiva, de atitudes que possam revelar boas qualidades de um profissional.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                </table>';
            
            $tblAvaliacao2 = 
                '<table cellspacing="0" cellpadding="1" border="0.5">
                    <tr>
                        <td align="center" width="80%"><i><b>Itens para avaliação</b></i></td>
                        <td align="center" width="4%"><i><b>1</b></i></td>
                        <td align="center" width="4%"><i><b>2</b></i></td>
                        <td align="center" width="4%"><i><b>3</b></i></td>
                        <td align="center" width="4%"><i><b>4</b></i></td>
                        <td align="center" width="4%"><i><b>5</b></i></td>
                    </tr>
                    <tr>
                        <td><i>01. Supervisão do '. mb_strtolower($tituloVinculo, "UTF8").' na Embrapa - considerar as orientações recebidas, bem como disponibilização de materiais para consulta.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>02. Tempo dedicado pelo orientador do '.mb_strtolower($tituloVinculo, "UTF8").' - considerar o tempo dispendido pelo orientador conforme necessidades apresentadas.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>03. Condições oferecidas pela Embrapa para a realização do '. mb_strtolower($tituloVinculo, "UTF8").' - considerar os insumos e equipamentos disponibilizados.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>04. Cumprimento da programação pré-estabelecida no plano de '. mb_strtolower($tituloVinculo, "UTF8").' - atividades desenvolvidas x programação inicial.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>05. Qualidade do relacionamento com o orientador do '.mb_strtolower($tituloVinculo, "UTF8").'.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>06. Qualidade do relacionamento com empregados da Embrapa.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>07. Qualidade do relacionamento com outros treinandos/estagiários.</i></td>
                        <td></td><td></td><td></td><td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><i>08. Grau de profissionalismo percebido nas relações dentro da Embrapa.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>09. Aplicação de conhecimentos - nível de conhecimento técnico-científico exigido pelas atividades desenvolvidas.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>10. Expectativas - considerar o atingimento dos seus objetivos pessoais propostos quando do início do '. mb_strtolower($tituloVinculo, "UTF8").'.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                        <td><i>11. Desempenho - considerar seu desempenho geral no desenvolvimento do '.mb_strtolower($tituloVinculo, "UTF8").' nas perspectivas didático-pedagógica e profissional.</i></td>
                        <td></td><td></td><td></td><td></td><td></td>
                    </tr>
                </table>';
            
            
            $observacoes1 = '<br><i>Outras observações, considerações e/ou sugestões:</i>________________________________________________________<br><br>'
                        . '_____________________________________________________________________________________________________<br>';

            $observacoes2 = '<br><i>Outras observações, considerações e/ou sugestões para o aprimoramento do processo de '.mb_strtolower($tituloVinculo, "UTF8").':</i><br><br>'
                        . '_____________________________________________________________________________________________________<br><br>'
                        . '_____________________________________________________________________________________________________<br>';
            $tblAssinaturas = '<br><br><table cellspacing="0" cellpadding="1" border="0.5">
                    <tr>
                        <td align="center"><i>Supervisor/Orientador</i></td>
                        <td align="center"><i>'.$tipoVinculo.'</i></td>
                        <td align="center"><i>SGP</i></td>
                    </tr>
                    <tr>
                        <td align="right"><br><br><br>_____/_____/_____<br></td>
                        <td align="right"><br><br><br>_____/_____/_____<br></td>
                        <td align="right"><br><br><br>_____/_____/_____<br></td>
                    </tr>
                </table>';
            
            $tblNadaConsta =  
                    '<table cellspacing="0" cellpadding="5" border="0.5">
                    <tr>
                        <td width="33.5%"><b>ÁREA</b><br></td>
                        <td align="center" width="7%"><b>Bloco</b></td>
                        <td align="center" width="15%"><b>VALOR DEVIDO<BR>(ESPECIFICAR)</b></td>
                        <td align="center" width="11%"><b>DATA</b></td>
                        <td align="center" width="33.5%"><b>ASSINATURA</b></td>
                    </tr>
                    <tr>
                        <td>Avaliação do Supervisor<br></td>
                        <td align="center"><br>--</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>Avaliação d'.$artigo.' '.$tipoVinculo.'</td>
                        <td align="center">--</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>SESMT</td>
                        <td align="center">02</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>SOF</td>
                        <td align="center">02</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>Entrega de crachá (SGP)</td>
                        <td align="center">02</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>Mapa de Horas (SGP)</td>
                        <td align="center">02</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>ENTREGA DO RELATÓRIO IMPRESSO NO SGP</td>
                        <td align="center">02</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>';
            if ($vinculo->getObrigatorio()) {
                $tblNadaConsta .= 
                    '<tr>
                        <td>Em caso de rescisão: 03 vias da<br>Rescisão do contrato</td>
                        <td align="center">02</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>';
            }
            $tblNadaConsta .= 
                    '<tr>
                        <td>BIBLIOTECA</td>
                        <td align="center">04</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>INFORMÁTICA</td>
                        <td align="center">07</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>LABORATÓRIO</td>
                        <td align="center">11</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td>RESTAURANTE</td>
                        <td align="center">15</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <td colspan="5"><br><p><i><b>ORIENTADOR:</b> Declaro para os devidos'
                        .' fins que estou ciente de que '.$artigo.mb_strtolower($tipoVinculo, "UTF8")
                        .' acima, sob minha orientação, está se desligando desta empresa.</i></p><br></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left"><br><br><br><br>Londrina, _____/_____/_____</td>
                        <td colspan="2"><br><br><br><br>Assinatura: _________________________________</td>
                    </tr>
                    
                </table>';
            
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->writeHTMLCell(0, 0, 10, 32, $titulo1, 0, 1, 0, true, 'C');
            
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->writeHTML($tblId, true, false, false, false, '');
            $pdf->writeHTML($atividades1, true, false, false, false, '');
            $pdf->writeHTML($tblLegenda, true, false, false, false, '');
            $pdf->SetFont('helvetica', '', 9);
            $pdf->writeHTML($tblAvaliacao1, true, false, false, false, '');
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->writeHTML($observacoes1, true, false, false, false, '');
            
            $pdf->writeHTML($tblAssinaturas, true, false, false, false, '');
            $pdf->SetFont('helvetica', '', 8.6);
            
            $pdf->AddPage("P");
            $pdf->Image("/img/embrapa-soja-cor.png", 80, 7, 33);
            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 0, 265, $rodape, 0, 1, 0, true, 'C');

            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->writeHTMLCell(0, 0, 10, 32, $titulo2, 0, 1, 0, true, 'C');
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->writeHTML($tblId, true, false, false, false, '');
            $pdf->writeHTML($atividades2, true, false, false, false, '');
            $pdf->writeHTML($tblLegenda, true, false, false, false, '');
            $pdf->SetFont('helvetica', '', 9);
            $pdf->writeHTML($tblAvaliacao2, true, false, false, false, '');
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->writeHTML($observacoes2, true, false, false, false, '');
            $pdf->writeHTML($tblAssinaturas, true, false, false, false, '');
            
            $pdf->AddPage("P");
            $pdf->Image("/img/embrapa-soja-cor.png", 80, 7, 33);
            $pdf->SetFont('helvetica', '', 8.6);
            $pdf->writeHTMLCell(0, 0, 0, 265, $rodape, 0, 1, 0, true, 'C');
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->writeHTMLCell(0, 0, 10, 32, $titulo3, 0, 1, 0, true, 'C');
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->writeHTML($tblId, true, false, false, false, '');
            $pdf->SetFont('helvetica', '', 9);
            $pdf->writeHTML($tblNadaConsta, true, false, false, false, '');
        }
        $pdf->Output();
    }
}

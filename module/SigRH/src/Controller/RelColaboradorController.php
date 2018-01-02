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

class RelColaboradorController extends AbstractActionController
{
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

    public function indexAction(){
            
            // Exibir o formulario
                
            $search = [
                "nome"                  => $this->params()->fromQuery("nome"),
                "matricula"             => $this->params()->fromQuery("matricula"),
                "combo_sexo"            => $this->params()->fromQuery("combo_sexo"),
                "combo_grupoSanguineo"  => $this->params()->fromQuery("combo_grupoSanguineo"),
                "combo_estadoCivil"     => $this->params()->fromQuery("combo_estadoCivil"),
                "combo_grauInstrucao"   => $this->params()->fromQuery("combo_grauInstrucao"),
                "necessidadeEspecial"   => $this->params()->fromQuery("necessidadeEspecial"),
                "inicioVigencia"        => $this->params()->fromQuery("inicioVigencia"),
                "terminoVigencia"       => $this->params()->fromQuery("terminoVigencia"),
                
/*              "combo_lote" => $this->params()->fromQuery("combo_lote"),
                "combo_material" => $this->params()->fromQuery("combo_material"),
                "combo_tipo" => $this->params()->fromQuery("combo_tipo"),
                "combo_cultivar" => $this->params()->fromQuery("combo_cultivar"),
                "combo_geracao" => $this->params()->fromQuery("combo_geracao"), //fase
                "combo_unidade" => $this->params()->fromQuery("combo_unidade"), //fase
                "destino" => $this->params()->fromQuery("destino"),
                "procedencia" => $this->params()->fromQuery("procedencia"),
                "responsavel" => $this->params()->fromQuery("responsavel"),
                "responsavel_destino" => $this->params()->fromQuery("responsavel_destino"),
                "data_ini" => $this->params()->fromQuery("data_ini"),
                "data_fim" => $this->params()->fromQuery("data_fim"),*/
                
                
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
                $repo_grauInstrucao = $this->entityManager->getRepository(\SigRH\Entity\grauInstrucao::class);
                $array_grauInstrucao = $repo_grauInstrucao->getListParaCombo();
                
/*                 
                //lotes
                $repo_lote = $this->getEntityManager()->getRepository('Rastrea\Model\Lote');
                $array_lote = $repo_lote->getListParaCombo();
                
                //material
                $repo_material = $this->getEntityManager()->getRepository('Rastrea\Model\Material');
                $array_material = $repo_material->getListParaCombo();

                //fase
                $repo_fase = $this->getEntityManager()->getRepository('Rastrea\Model\Fase');
                $array_geracao = $repo_fase->getListParaCombo();
                
                //unidade
                $repo_unidade = $this->getEntityManager()->getRepository('Rastrea\Model\Fase');
                $array_unidade = $repo_unidade->getListUnidadesParaCombo();*/
                
                
//////////////////////////////////////////////
                
            $view = new \Zend\View\Model\ViewModel();
//            $view->setVariable("array_lote", $array_lote);
//            $view->setVariable("array_tipoc", $array_tipoc);
//            $view->setVariable("array_material", $array_material);
//            $view->setVariable("array_geracao", $array_geracao);
//
//            $view->setVariable("array_unidade", $array_unidade);
             $view->setVariable("colaboradores", $repo->getPaginator);
             $view->setVariable("array_grupoSanguineo", $array_grupoSanguineo);
             $view->setVariable("array_estadoCivil", $array_estadoCivil);
             $view->setVariable("array_grauInstrucao", $array_grauInstrucao);
                    
            return $view;
            
        }
        
        public function gerarHtmlAction(){
            
        $search = [
                "nome"                 => $this->params()->fromQuery("nome"),
                "matricula"            => $this->params()->fromQuery("matricula"),
                "sexo"                 => $this->params()->fromQuery("sexo"),
                "combo_grupoSanguineo" => $this->params()->fromQuery("combo_grupoSanguineo"),
                "combo_estadoCivil"    => $this->params()->fromQuery("combo_estadoCivil"),
                "combo_grauInstrucao"  => $this->params()->fromQuery("combo_grauInstrucao"),
                "necessidadeEspecial"  => $this->params()->fromQuery("necessidadeEspecial"),
                "inicioVigencia"        => $this->params()->fromQuery("inicioVigencia"),
                "terminoVigencia"       => $this->params()->fromQuery("terminoVigencia"),
            ];
        
        $repo = $this->entityManager->getRepository(\SigRH\Entity\Colaborador::class);
        $colaboradores = $repo->getQuery($search)->getResult();
        foreach($colaboradores as $colaborador) {
            error_log("matricula: ".$colaborador->getMatricula());
        }
        /*        
                "combo_lote" => $this->params()->fromQuery("combo_lote"),
                "material_id" => $this->params()->fromQuery("material_id"),
                "combo_material" => $this->params()->fromQuery("combo_material"),
                "combo_tipo" => $this->params()->fromQuery("combo_tipo"),
                "combo_cultivar" => $this->params()->fromQuery("combo_cultivar"),
                "combo_geracao" => $this->params()->fromQuery("combo_geracao"), //fase
                "combo_unidade" => $this->params()->fromQuery("combo_unidade"), //fase
                "destino" => $this->params()->fromQuery("destino"),
                "procedencia" => $this->params()->fromQuery("procedencia"),
                "responsavel" => $this->params()->fromQuery("responsavel"),
                "responsavel_destino" => $this->params()->fromQuery("responsavel_destino"),
                "data_ini" => $this->params()->fromQuery("data_ini"),
                "data_fim" => $this->params()->fromQuery("data_fim"),
                
                
            );
                
//                $data_ini = $this->params()->fromPost("data_ini");
//                if ( empty($data_ini)) {
//                    $data_ini=date('Y').'-01-01';
//                } else {
//                    $data_ini = \Admin\Model\Util::converteDataSql($data_ini);
//                }
//                $data_fim = $this->params()->fromPost("data_fim");
//                if ( empty($data_fim)) {
//                    $data_fim=date('Y').'-12-31';
//                } else {
//                    $data_fim = \Admin\Model\Util::converteDataSql($data_fim);
//                }
                
                    

                
                // Selecionar os movimentos dessa data
                $repo = $this->getEntityManager()->getRepository('Rastrea\Model\Movimentacao');
                
//                $array_restringe = null;
                
//                $cli = $this->params()->fromPost("combo_clientes");
//                $func = $this->params()->fromPost("combo_func");
                
//               $movimentos = $repo->getMovimentosPorData($data_ini,$data_fim, $ativ,$array_restringe,$cli,$func,$outros,$historico);
//                $movimentos = $repo->getMovimentosPorData($data_ini,$data_fim); //incluir no repositorio se busca por atividade inclui ak a var
                
                $movimentos = $repo->getQuery($search)->getQuery()->getResult(); 
                //\Doctrine\Common\Util\Debug::dump($movimentos);*/
        
            $this->layout()
                    ->setTemplate("layout/impressao")
                    ->setVariable("titulo_impressao", "Colaboradores");
            $view = new \Zend\View\Model\ViewModel();
            $view->setVariables(["colaboradores" => $colaboradores]);
            return $view;
//}
            
        }
}

<?php
namespace SigRH\Service;

class FileUpload {
    
    protected $entityManager;
    
    public function getEntityManager() {
        return $this->entityManager;
    }
    
    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function __construct($entityManager){ //$serviceInst
        $this->entityManager = $entityManager;
    }
    
    public function uploadPonto($file, $importacaoPonto) {

        $fileName = $file['tmp_name'];
        $log = "Crachás não encontrados: ";
        $registrosPonto = [];
        
        $ponteiro = fopen ( $fileName, 'r' );
	while ( ! feof ( $ponteiro ) ) {
            $linha = fgets($ponteiro);
            $hora = substr($linha, 3, 2);
            $minuto = substr($linha, 5, 2);
            $dia = substr($linha, 7, 2);
            $mes = substr($linha, 9, 2);
            $ano = 2000 + (int) substr($linha, 11, 2);
            $numeroChip = substr($linha, 15, 12);
            if($numeroChip != '') {
                $cracha = $this->getEntityManager()->getRepository(\SigRH\Entity\Cracha::class)->findOneBy(['numeroChip' => $numeroChip], ['dataInclusao' => 'DESC']);
                $dataPonto = \DateTime::createFromFormat("Ymd", $ano.$mes.$dia);
                if ( (!$cracha) || ($dataPonto < $cracha->getDataInclusao()) ) {
                    $log .= $numeroChip.";";
                } else {
                    $matricula = $cracha->getColaboradorMatricula()->getMatricula();
                    if(empty($registrosPonto[$matricula.$ano.$mes.$dia])) {
                        $registrosPonto[$matricula.$ano.$mes.$dia] = $hora."-".$minuto;
                    } else {
                        $registrosPonto[$matricula.$ano.$mes.$dia] .= ";".$hora."-".$minuto;
                    }
                }
            }
        }
        fclose($ponteiro);
        $repo = $this->getEntityManager()->getRepository(\SigRH\Entity\MovimentacaoPonto::class);
        $repo->incluir_ou_editar($registrosPonto, $importacaoPonto->getReferencia());
        return $log;
    }
}

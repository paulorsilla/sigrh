<?php

namespace SigRH\Repository;

use SigRH\Entity\MovimentacaoPonto as MovimentacaoPontoEntity;
use SigRH\Entity\RegistroHorario as RegistroHorarioEntity;

class MovimentacaoPonto extends AbstractRepository {

//    public function getQuery($search = []) {
//
//    }
    
    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($registrosPonto, $referencia) {
        
        //cria a folha ponto para o mês referência, caso não exista
        $ano = substr($referencia, 0, 4);
        $mes = substr($referencia, 4, 2);
        
        $terminoVigenciaIni = $ano."-".$mes."-01";
        $terminoVigenciaFim = $ano."-".$mes."-31";
        $colaboradores1 = $this->getEntityManager()->getRepository(\SigRH\Entity\Colaborador::class)->getQuery(['tipoVinculo' => 'FP', 'ativo' => "S"])->getResult();
        $colaboradores2 = $this->getEntityManager()->getRepository(\SigRH\Entity\Colaborador::class)
                               ->getQuery(['tipoVinculo' => 'FP', 'ativo' => "T", 'terminoVigenciaIni' => $terminoVigenciaIni, 'terminoVigenciaFim' => $terminoVigenciaFim])->getResult();
        $colaboradores = new \Doctrine\Common\Collections\ArrayCollection(array_merge($colaboradores1, $colaboradores2));
        $folhas = [];
        foreach($colaboradores as $colaborador) {
            $vinculoAtual = $colaborador->getVinculos()->first();
            $folhaPonto = $this->getEntityManager()->getRepository(\SigRH\Entity\FolhaPonto::class)->findOneBy(['colaboradorMatricula' => $colaborador, 'referencia' => $referencia]);
            if (!$folhaPonto) {
                $status = 0;
                if ($vinculoAtual->getTipoVinculo()->getId() == 4) {
                    $status = 10;
                }
                $folhaPonto = $this->getEntityManager()->getRepository(\SigRH\Entity\FolhaPonto::class)->create($colaborador, $referencia, $status);
            }
            $folhas[$colaborador->getMatricula()] = $folhaPonto;
        }
        
        foreach($registrosPonto as $k => $value) {
            $matricula = substr($k, 0, 6);
            if (!empty($folhas[$matricula])) {
                $ano = substr($k, 6, 4);
                $mes = substr($k, 10, 2);
                $dia = substr($k, 12, 2);

                $dataRegistro = \DateTime::createFromFormat( "Y-m-d", $ano."-".$mes."-".$dia);
                $colaborador = $this->getEntityManager()->find(\SigRH\Entity\Colaborador::class, $matricula);
                $folhaPonto = $folhas[$matricula];
                
                //verifica se o ano/mês do registro é compatível com a referência da folha
                if ($folhaPonto->getReferencia() == $ano.$mes ) {

                    //verifica a existencia de movimentacao para o colaborador no dia
                    //caso nao exista, inicia a movimentacao
                    $movimentacaoPonto = $this->getEntityManager()->getRepository(\SigRH\Entity\MovimentacaoPonto::class)->findOneBy(['folhaPonto' => $folhaPonto, 'diaPonto' => $dataRegistro->format('d')]);
                    if (null == $movimentacaoPonto ) {
                        $movimentacaoPonto = new MovimentacaoPontoEntity();
                        $movimentacaoPonto->setDiaPonto($dataRegistro->format("d"));
                        $movimentacaoPonto->setFolhaPonto($folhaPonto);
                        $this->getEntityManager()->persist($movimentacaoPonto);
                    }

                    $horarios = explode(";", $value);
                    foreach($horarios as $hora) {
                        $horaRegistro = \DateTime::createFromFormat( "H-i", $hora);
                        $registroHorario = $this->getEntityManager()->getRepository(\SigRH\Entity\RegistroHorario::class)->findOneBy(["horaRegistro" => $horaRegistro, "tipo" => "C", "movimentacaoPonto" => $movimentacaoPonto]);
                        if (null == $registroHorario) {
                            $registroHorario = new RegistroHorarioEntity();
                            $registroHorario->setHoraRegistro($horaRegistro);
                            $registroHorario->setMovimentacaoPonto($movimentacaoPonto);
                            $registroHorario->setTipo('C');
                            $this->getEntityManager()->persist($registroHorario);
                        }
                    }
                }
            }
        }
    }
    
//    
//    public function marcacao_intervalo($batidaPonto, $escala) {
//        $horaBatidaPontoS1 = new HoraBatidaPontoEntity();
//        $horaBatidaPontoS1->setBatidaPonto($batidaPonto);
//        $horaBatidaPontoS1->setHoraBatida($escala->getSaida1());
//        $horaBatidaPontoS1->setTipo("A");
//        $this->getEntityManager()->persist($horaBatidaPontoS1);
//
//        $horaBatidaPontoE2 = new HoraBatidaPontoEntity();
//        $horaBatidaPontoE2->setBatidaPonto($batidaPonto);
//        $horaBatidaPontoE2->setHoraBatida($escala->getEntrada2());
//        $horaBatidaPontoE2->setTipo("A");
//        $this->getEntityManager()->persist($horaBatidaPontoE2);
//        $this->getEntityManager()->flush();
//
//    }

}

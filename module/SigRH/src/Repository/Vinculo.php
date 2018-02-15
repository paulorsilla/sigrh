<?php

namespace SigRH\Repository;

use SigRH\Entity\Vinculo as VinculoEntity;

class Vinculo extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('v')
                ->from(VinculoEntity::class, 'v')
                ->orderby('v.inicio','ASC');
        
        //inclui a pesquisa por matricula por meio de um join
        if ( !empty($search['matricula'])){
            $qb->join("v.colaboradorMatricula",'c');
            $qb->where('c.matricula = :matricula');
            $qb->setParameter("matricula",$search['matricula']);
        }
        
/*      echo "DQL: ".$qb->getDQL();
        echo "<hr>";
        echo "SQL: ".$qb->getQuery()->getSQL();
        die();*/
       return $qb;
    }
    
//    public function delete($id){
//        $row = $this->find($id);
//        if ($row) {
//                $this->getEntityManager()->remove($row);
//                $this->getEntityManager()->flush();
//        }
//    }
    
    public function delete($id, $matricula){
        $row = $this->find($id);
        error_log("excluindo id = ".$id);
        if ($row) {
            $colaborador = $this->getEntityManager()->find(\SigRH\Entity\Colaborador::class, $matricula);
            if ( empty($colaborador) )
                throw new Exception('Colaborador nao encontrado');
            $colaborador->getVinculos()->removeElement($row);
            $this->getEntityManager()->flush();
//            $this->getEntityManager()->persist($colaborador);
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
        
    public function incluir_ou_editar($dados,$id = null,$matricula=null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new VinculoEntity();
        }
        if ( !empty($matricula)) {
            $colaborador = $this->getEntityManager()->find('SigRH\Entity\Colaborador', $matricula);
            if ( empty($colaborador) )
                throw new Exception('Colaborador nao encontrado');
            $row->setColaboradorMatricula($colaborador);
        }
        
        //nivel...
        if ( !empty($dados['nivel'] )) {
            $nivel = $this->getEntityManager()->find('SigRH\Entity\Nivel', $dados['nivel']); //busca as informações
            $row->setNivel($nivel);
        }
        unset($dados['nivel']);
        
        //curso...
        if ( isset($dados['curso']) ) {
            if ( !empty($dados['curso'] )) {
                $curso = $this->getEntityManager()->find('SigRH\Entity\Curso', $dados['curso']); //busca as informações
                $row->setCurso($curso);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setCurso(null);
            }
        }
        unset($dados['curso']);
        
        //fonte seguro...
        if ( isset($dados['fonteSeguro']) ) {
            if ( !empty($dados['fonteSeguro'] )) {
                $fonteSeguro = $this->getEntityManager()->find('SigRH\Entity\FonteSeguro', $dados['fonteSeguro']); //busca as informações
                $row->setFonteSeguro($fonteSeguro);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setFonteSeguro(null);
            }
        }    
        unset($dados['fonteSeguro']);
        
        //instituicaoEnsino...
        if ( isset($dados['instituicaoEnsino']) ) {
            if ( !empty($dados['instituicaoEnsino'] )) {
                $instituicaoEnsino = $this->getEntityManager()->find('SigRH\Entity\Instituicao', $dados['instituicaoEnsino']); //busca as informações
                $row->setInstituicaoEnsino($instituicaoEnsino);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setInstituicaoEnsino(null);
            }
        }    
        unset($dados['instituicaoEnsino']);
        
        //instituicaoFomento...
        if ( isset($dados['instituicaoFomento']) ) {
            if ( !empty($dados['instituicaoFomento'] )) {
                $instituicaoFomento = $this->getEntityManager()->find('SigRH\Entity\Instituicao', $dados['instituicaoFomento']); //busca as informações
                $row->setInstituicaoFomento($instituicaoFomento);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setInstituicaoFomento(null);
            }
        }    
        unset($dados['instituicaoFomento']);

        //sublotacao...
        if ( !empty($dados['sublotacao'] )) {
            $sublotacao = $this->getEntityManager()->find('SigRH\Entity\Sublotacao', $dados['sublotacao']); //busca as informações
            $row->setSublotacao($sublotacao);
        }
        unset($dados['sublotacao']);
        
        $row->setDataInicioEfetivo(null);
        if ($dados ['dataInicioEfetivo'] != "") {					
            $dataInicioEfetivo = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataInicioEfetivo'] );
            if ( !empty($dataInicioEfetivo)  ) {
               $row->setDataInicioEfetivo($dataInicioEfetivo);
            }
        }
        unset($dados['dataInicioEfetivo']);
        
        if ( isset($dados['tipoContrato']) && $dados['tipoContrato'] === '' ){
            $dados['tipoContrato'] = null;
        }
        
        //localizacao
        if ( isset($dados['localizacao']) ) {
            if ( !empty($dados['localizacao'] )) {
                $localizacao = $this->getEntityManager()->find('SigRH\Entity\Localizacao', $dados['localizacao']); //busca as informações
                $row->setLocalizacao($localizacao);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setLocalizacao(null);
            }
        }    
        unset($dados['localizacao']);
        
        //modalidade bolsa...
        if ( isset($dados['modalidadeBolsa']) ) {
            if ( !empty($dados['modalidadeBolsa'] )) {
                $modalidade = $this->getEntityManager()->find('SigRH\Entity\ModalidadeBolsa', $dados['modalidadeBolsa']); //busca as informações
                $row->setModalidadeBolsa($modalidade);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setModalidadeBolsa(null);
            }
        }    
        unset($dados['modalidadeBolsa']);
        
        //orientador...
        if ( isset($dados['orientador']) ) {
            if ( !empty($dados['orientador'] )) {
                $orientador = $this->getEntityManager()->find('SigRH\Entity\Colaborador', $dados['orientador']); //busca as informações
                $row->setOrientador($orientador);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->setOrientador(null);
            }
        }    
        unset($dados['orientador']);
        
        
        
        $row->setdataInicio(null);
        if ($dados ['dataInicio'] != "") {					
            $inicio = \DateTime::createFromFormat ("Y-m-d", $dados ['dataInicio']);
            if ( !empty($inicio)  ) {
               $row->setdataInicio($inicio);
            }
        }
        unset($dados['dataInicio']);
        
        $row->setDataTermino(null);
        if ($dados ['dataTermino'] != "") {					
            $fim = \DateTime::createFromFormat ("Y-m-d", $dados ['dataTermino']);
            if ( !empty($fim)  ) {
               $row->setDataTermino($fim);
            }
        }
        unset($dados['dataTermino']);
        
        $row->setDataDesligamento(null);
        if ($dados ['dataDesligamento'] != "") {					
            $desligamento = \DateTime::createFromFormat ("Y-m-d", $dados ['dataDesligamento']);
            if ( !empty($desligamento)  ) {
               $row->setDataDesligamento($desligamento);
            }
        }
        unset($dados['dataDesligamento']);
        
//        //atividade...
//        if ( isset($dados['atividade']) ) {
//            if ( empty($dados['atividade'] )) {
//                $row->setAtividade(null);
//            }
//        }    
//        unset($dados['atividade']);
        
//        //valor bolsa...
//        if ( isset($dados['valorBolsa']) ) {
//            if ( empty($dados['valorBolsa'] )) {
//                $row->setValorBolsa(null);
//            }
//        }    
//        unset($dados['valorBolsa']);
        
        
        //tipoVinculo...
        if ( isset($dados['tipoVinculo']) ) {
            if ( !empty($dados['tipoVinculo'] )) {
                $tipoVinculo = $this->getEntityManager()->find('SigRH\Entity\TipoVinculo', $dados['tipoVinculo']); //busca as informações
                $row->settipoVinculo($tipoVinculo);
            } else {  // caso ele tenha sido passado em branco, setar como nulo
                $row->settipoVinculo(null);
            }
        }    
        unset($dados['tipoVinculo']);

        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        // \Doctrine\Common\Util\Debug::dump($row); nunca usar print_r para elemento doctrine
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}
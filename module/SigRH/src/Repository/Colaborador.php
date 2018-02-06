<?php

namespace SigRH\Repository;

use SigRH\Entity\Colaborador as ColaboradorEntity;
//use SigRH\Entity\Vinculo as VinculoEntity;

class Colaborador extends AbstractRepository {

    public function getQuery($search = []) {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction("MONTH", \DoctrineExtensions\Query\Mysql\Month::class);
        $emConfig->addCustomDatetimeFunction("DAY", \DoctrineExtensions\Query\Mysql\Day::class);
//        $combo = false;
//        if ( (isset($search['combo'])) && ($search['combo'] == 1)) {
//            $combo = true;
//            unset($search['combo']);
//        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(ColaboradorEntity::class, 'c')
                ->orderby('c.nome','ASC')
                ->where('c.nome is not NULL')
                ->andWhere('c.nome != :empty')
                ->setParameter('empty', ' ');
        if ( (isset($search['tipoColaborador'])) && ($search['tipoColaborador'] == 2) ) {
            unset($search['tipoColaborador']);
            $qb->andWhere('c.tipoColaborador = 2');
            $qb->orWhere('c.tipoColaborador = 3'); //inclusao do parceiro tb a pedido da karen
            $qb->orWhere('c.tipoColaborador = 4');
            $qb->orWhere('c.tipoColaborador = 5');
            $qb->orWhere('c.tipoColaborador = 6');
            $qb->orWhere('c.tipoColaborador = 8');
        }
        if ( (isset($search["aniversariantesMes"])) && (!empty($search["aniversariantesMes"]))) {
                $qb->andWhere("MONTH(c.dataNascimento) = :mes")
                    ->orderby('DAY(c.dataNascimento)','ASC')
                    ->setParameter('mes', $search["aniversariantesMes"]);
        }
        
        if ( !empty($search['nome'])){
            $qb->andWhere('c.nome like :nome' );
             $qb->setParameter('nome', "%".$search['nome']."%");
        }
        
        if ( !empty($search['matricula'])){
            $qb->andWhere('c.matricula = :matricula' );
             $qb->setParameter('matricula', $search['matricula']);
        }
        
        if ( !empty($search["sexo"]) ){
             $qb->andWhere('c.sexo in ( :sexo )');
             $qb->setParameter("sexo", $search["sexo"]);
        }
        
//        if (isset($search['ativo'])) {
//            switch($search['ativo']) {
//                case 'S': $qb->andWhere('c.dataDesligamento is NULL'); break;
//                case 'N': $qb->andWhere('c.dataDesligamento is NOT NULL');
//            }
//        }
        
        if ( !empty($search["combo_grupoSanguineo"]) ){
             $qb->andWhere('c.grupoSanguineo in ( :combo_grupoSanguineo )');
            $qb->setParameter("combo_grupoSanguineo",$search["combo_grupoSanguineo"]);
        }
        
        if ( !empty($search["combo_estadoCivil"]) ){
             $qb->andWhere('c.estadoCivil in ( :combo_estadoCivil )');
            $qb->setParameter("combo_estadoCivil",$search["combo_estadoCivil"]);
        }
        
        if ( !empty($search["combo_grauInstrucao"]) ){
             $qb->andWhere('c.grauInstrucao in ( :grauInstrucao )');
            $qb->setParameter("grauInstrucao", $search["combo_grauInstrucao"]);
        }
        
        if ( !empty($search["necessidadeEspecial"]) ){
             $qb->andWhere('c.necessidadeEspecial in ( :necessidadeEspecial )');
             $qb->setParameter("necessidadeEspecial",$search["necessidadeEspecial"]);
        }
        
        //busca da tabela vinculo...
        $joinVinculo = false;
        
        
        if ( !empty($search["inicioVigencia"]) ) {
            $joinVinculo = true;
            $dataInicio = \DateTime::createFromFormat("Y-m-d", $search["inicioVigencia"]);
            $qb->join('c.vinculos', 'v')
                ->andWhere("v.dataInicio >= :dataInicio")
                ->setParameter("dataInicio", $dataInicio->format("Ymd"));
        }

        if ( !empty($search["inicioVigenciaIni"]) ) {
            $dataInicioIni = \DateTime::createFromFormat("Y-m-d", $search["inicioVigenciaIni"]);
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            $qb->andWhere("v.dataInicio >= :dataInicioIni")
                ->orderBy("v.dataInicio")
                ->setParameter("dataInicioIni", $dataInicioIni->format("Ymd"));
        }
                
        if ( !empty($search["inicioVigenciaFim"]) ) {
            $dataInicioFim = \DateTime::createFromFormat("Y-m-d", $search["inicioVigenciaFim"]);
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            $qb->andWhere("v.dataInicio <= :dataInicioFim")
                ->setParameter("dataInicioFim", $dataInicioFim->format("Ymd"));
        }        
        
        if ( !empty($search["terminoVigenciaIni"]) ) {
            $dataTerminoIni = \DateTime::createFromFormat("Y-m-d", $search["terminoVigenciaIni"]);
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            $qb->andWhere("v.dataTermino >= :dataTerminoIni")
                ->orderBy("v.dataTermino")
                ->setParameter("dataTerminoIni", $dataTerminoIni->format("Ymd"));
        }
                
        if ( !empty($search["terminoVigenciaFim"]) ) {
            $dataTerminoFim = \DateTime::createFromFormat("Y-m-d", $search["terminoVigenciaFim"]);
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            $qb->andWhere("v.dataTermino <= :dataTerminoFim")
                ->setParameter("dataTerminoFim", $dataTerminoFim->format("Ymd"));
        }

        if ( !empty($search["obrigatorio"]) ){
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            
            if ($search['obrigatorio'] == '9') {
                $search['obrigatorio'] = 0;
            }
             $qb->andWhere('v.obrigatorio = :obrigatorio');
             $qb->setParameter("obrigatorio",$search["obrigatorio"]);
        }
        
        if (isset($search['ativo'])) {
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            
            switch($search['ativo']) {
                case 'S': $qb->andWhere('v.dataDesligamento is NULL'); break;
                case 'N': $qb->andWhere('v.dataDesligamento is NOT NULL');
            }
        }
        

        if ( !empty($search["tipoVinculo"]) ){
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
             $qb->andWhere('v.tipoVinculo = :tipoVinculo');
             $qb->setParameter("tipoVinculo",$search["tipoVinculo"]);
        }
        
        if ( !empty($search["nivel"]) ){
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
                
            }
             $qb->andWhere('v.nivel = :nivel');
             $qb->setParameter("nivel",$search["nivel"]);
        }
        
        if ( !empty($search["modalidadeBolsa"]) ){
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
             $qb->andWhere('v.modalidadeBolsa = :modalidadeBolsa');
             $qb->setParameter("modalidadeBolsa",$search["modalidadeBolsa"]);
        }
        
        if ( !empty($search["instituicaoFomento"]) ){
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
//                $qb->join('v.instituicaoFomento', 'i');
                $joinVinculo = true;
                
            }
             $qb->andWhere('v.instituicaoFomento = :instituicaoFomento');
             $qb->setParameter("instituicaoFomento", $search["instituicaoFomento"]);
        }
        
        if ( !empty($search['orientador'])) {
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            $qb->andWhere('v.orientador = :orientador');
            $qb->setParameter("orientador", $search["orientador"]);
        }
        
        if ( !empty($search['subLotacao'])) {
            if (!$joinVinculo) {
                $qb->join('c.vinculos', 'v');
                $joinVinculo = true;
            }
            $qb->andWhere('v.sublotacao = :sublotacao');
            $qb->setParameter("sublotacao", $search["subLotacao"]);
        }
        
        
        //echo "SQL: ".$qb->getQuery()->getSQL();
        
//        die();
          
//        foreach($search as $key => $value) {
//            $qb->andWhere('c.'.$key.' = :'.$key);
//            $qb->setParameter($key, $value);
//        }
        
//        if ($combo) {
//            return $qb->getQuery()->getResult();
//        } else {
//            return $qb->getQuery();
//        }
//        if ( !empty($search)){
//            $qb->where('c.tipoColaborador = :busca');
//            $qb->setParameter("busca", $search['tipoColaborador']);
//        }
//       return $qb;
        
        if (!empty($search['combo'])) {
            if ($search['combo'] == 1) {
                $array = [];
                $list =  $qb->getQuery()->getResult();
                foreach($list  as $row){
                    $array[] = ["matricula" => $row->matricula, "nome" => $row->nome];
                }
                return $array;
            } else {
                return $qb->getQuery()->getResult();
            }
        } else {
            return $qb->getQuery();
        }
        
        }
    
    public function getEstagiarios($graduacao = false, $foraEmbrapaSoja = false)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(ColaboradorEntity::class, 'c')
                ->orderby('c.nome','ASC')
                ->join('c.vinculos', 'v')
                ->where('c.nome is not NULL')
                ->andWhere('c.nome != :empty')
                ->andWhere('c.tipoColaborador = 2')
                ->andWhere('v.dataDesligamento is NULL')
                ->setParameter('empty', ' ');
        if($graduacao) {
            $qb->andWhere('v.nivel = 3'); //graduacao
        }
        if(!$foraEmbrapaSoja) {
            $qb->andWhere('v.localizacao != 122');
        }
       return $qb->getQuery()->getResult();
    }
    
    
    public function getListParaCombo(){
        
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id"=>$row->id,"nome"=>$row->nome);
        }
        return $array;
    }
    
    public function delete($id){
        $row = $this->find($id);
        if ($row) {
                $this->getEntityManager()->remove($row);
                $this->getEntityManager()->flush();
        }
    }
    public function getLastMatriculaEstagio(){
        $query = $this->createQueryBuilder('c');
        $query->select('MAX(c.matricula) AS last_matricula');
        $query->where("c.matricula like '5_____' ");
        $row = $query->getQuery()->getOneOrNullResult();
        if ( empty($row) || $row['last_matricula'] < 500000)
            return 500000;
        else
            return $row['last_matricula'];        
    }
    public function incluir_ou_editar($dados,$id = null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new ColaboradorEntity();
            if ( $dados['tipoColaborador'] != 1 ){
                $dados['matricula'] = $this->getLastMatriculaEstagio()+1;
            }
        }
        
        //tipoColaborador...
        if ( !empty($dados['tipoColaborador'] )) {
            $tipoColaborador = $this->getEntityManager()->find('SigRH\Entity\TipoColaborador', $dados['tipoColaborador']); //busca as informações
            $row->setTipoColaborador($tipoColaborador);
        }
        unset($dados['tipoColaborador']);
        
        //////////////endereco////////////////////////////////////
        $endereco = $row->getEndereco();
        if ( empty($endereco )){
            $endereco = new \SigRH\Entity\Endereco();
            $row->setEndereco($endereco);
        }
        
        $endereco->setCep($dados['cep']);
        unset($dados['cep']);
        
        $endereco->setEndereco($dados['endereco']);
        unset($dados['endereco']);
        
        $endereco->setComplemento($dados['complemento']);
        unset($dados['complemento']);
        
        if ( !empty($dados['numero']))
            $endereco->setNumero($dados['numero']);
        
        unset($dados['numero']);
        
        $endereco->setBairro($dados['bairro']);
        unset($dados['bairro']);
        
        //cidade...
        if ( !empty($dados['cidade'] )) {
            $cidade = $this->getEntityManager()->find('SigRH\Entity\Cidade', $dados['cidade']); //busca as informações
            $endereco->setCidade($cidade);
        }
        unset($dados['cidade']);
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //supervisor...
        if ( !empty($dados['supervisor'] )) {
            $supervisor = $this->getEntityManager()->find('SigRH\Entity\Colaborador', $dados['supervisor']); //busca as informações
            $row->setSupervisor($supervisor);
        }
        unset($dados['supervisor']);
        
        //Grupo sanguineo...
        if ( !empty($dados['grupoSanguineo'] )) {
            $grupoSanguineo = $this->getEntityManager()->find('SigRH\Entity\GrupoSanguineo', $dados['grupoSanguineo']); //busca as informações
            $row->setGrupoSanguineo($grupoSanguineo);
        }
        unset($dados['grupoSanguineo']);
        
        //grauInstrucao
        if ( !empty($dados['grauInstrucao'] )) {
            $grauInstrucao = $this->getEntityManager()->find('SigRH\Entity\GrauInstrucao', $dados['grauInstrucao']); //busca as informações
            $row->setGrauInstrucao($grauInstrucao);
        }
        unset($dados['grauInstrucao']);
        
        //corPele
        if ( !empty($dados['corPele'] )) {
            $corPele = $this->getEntityManager()->find('SigRH\Entity\CorPele', $dados['corPele']); //busca as informações
            $row->setCorPele($corPele);
        }
        unset($dados['corPele']);
        
        //estadoCivil
        if ( !empty($dados['estadoCivil'] )) {
            $estadoCivil = $this->getEntityManager()->find('SigRH\Entity\EstadoCivil', $dados['estadoCivil']); //busca as informações
            $row->setEstadoCivil($estadoCivil);
        }
        unset($dados['estadoCivil']);
        
        //natural
        if ( !empty($dados['natural'] )) {
            $natural = $this->getEntityManager()->find('SigRH\Entity\Cidade', $dados['natural']); //busca as informações
            $row->setNatural($natural);
        }
        unset($dados['natural']);
        
        //ctpsUf
        if ( !empty($dados['ctpsUf'] )) {
            $ctpsUf = $this->getEntityManager()->find('SigRH\Entity\Estado', $dados['ctpsUf']); //busca as informações
            $row->setCtpsUf($ctpsUf);
        }
        unset($dados['ctpsUf']);
        
        $row->setDataNascimento(null);
        if ($dados ['dataNascimento'] != "") {					
            $dataNascimento = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataNascimento'] );
            if ( !empty($dataNascimento)  )
               $row->setDataNascimento($dataNascimento);
        }
        unset($dados['dataNascimento']);
        
        $row->setDataAdmissao(null);
        if ($dados ['dataAdmissao'] != "") {					
            $dataAdmissao = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataAdmissao'] );
            if ( !empty($dataAdmissao)  )
                $row->setDataAdmissao($dataAdmissao);
        }
        unset($dados['dataAdmissao']);
        
        $row->setDataDesligamento(null);
        if ($dados ['dataDesligamento'] != "") {					
            $dataDesligamento = \DateTime::createFromFormat ( "Y-m-d", $dados ['dataDesligamento'] );
            if ( !empty($dataDesligamento)  )
                $row->setDataDesligamento($dataDesligamento);
        }
        unset($dados['dataDesligamento']);
        
        $row->setRgDataEmissao(null);
        if ($dados ['rgDataEmissao'] != "") {					
            $rgDataEmissao = \DateTime::createFromFormat ( "Y-m-d", $dados ['rgDataEmissao'] );
            if ( !empty($rgDataEmissao)  )
                $row->setRgDataEmissao($rgDataEmissao);
        }
        unset($dados['rgDataEmissao']);
        
        $row->setCtpsDataExpedicao(null);
        if ($dados ['ctpsDataExpedicao'] != "") {					
            $ctpsDataExpedicao = \DateTime::createFromFormat ( "Y-m-d", $dados ['ctpsDataExpedicao'] );
            if ( !empty($ctpsDataExpedicao)  )
                $row->setCtpsDataExpedicao($ctpsDataExpedicao);
        }
        unset($dados['ctpsDataExpedicao']);
        
        if ( !empty($dados['linhaOnibus'] )) {
            $estadoCivil = $this->getEntityManager()->find('SigRH\Entity\LinhaOnibus', $dados['linhaOnibus']); //busca as informações
            $row->setLinhaOnibus($linhaOnibus);
        }
        unset($dados['linhaOnibus']);
        
        if (!empty($dados['cpf'])) {
            $cpf = str_replace(['.','-'], '', $dados['cpf']);
            $row->setCpf($cpf);
        }
        unset($dados['cpf']);
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($endereco);
        $this->getEntityManager()->persist($row); // persiste o model  ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}

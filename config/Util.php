<?php

/*
 * Author: Paulo Roberto Silla - paulo.silla@embrapa.br
 */
namespace Admin\Model;

class Util 
{
    /*
     * @return Array contendo os nomes dos Estados brasileiros identificados 
     * por suas siglas (UF)
     */
    public function getEstadosBr() 
    {
        return array(
            '' => '--- Escolha um Estado ---',
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AM'=>'Amazonas',
            'AP'=>'Amapá',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RO'=>'Rondônia',
            'RS'=>'Rio Grande do Sul',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SE'=>'Sergipe',
            'SP'=>'São Paulo',
            'TO'=>'Tocantins'
        );
    }
    
    /*
     * Converte a data para os formatos AAAA/MM/DD e DD/MM/AAAA
     * @param string $data - data no formato AAAA/MM/DD ou DD/MM/AAAA
     * @return string (data convertida)
     */
    
    public function converteData($data) //desabilitado!
    {
        return self::converteDataPhp($data);
        
//        $data = str_replace("-","/",$data);
//        $data_aux = explode("/", $data);
//        return $data_aux[2]."/".$data_aux[1]."/".$data_aux[0];
    }
    public function converteDataSql($data) 
    {
        if ( empty($data))
            return null;
        $obj = \Datetime::createFromFormat("d/m/Y",$data);
        if ( $obj == null)
            return null;
        return $obj->format('Y-m-d');
    }
    public function converteDataPhp($data) 
    {
        if ( empty($data))
            return null;
        $obj = \Datetime::createFromFormat('Y-m-d',$data);
        if ( $obj == null)
            return null;
        return $obj->format("d/m/Y");
    }
    
    public function converteNumero($valor){
        $valor = str_replace(",", ".", $valor);
        return floatval($valor);
    }
}
?>

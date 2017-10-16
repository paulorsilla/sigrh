<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Estagio.
 * @ORM\Entity(repositoryClass="SigRH\Repository\Termo")
 * @ORM\Table(name="termo")
 */
class Termo extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\ModalidadeBolsa")
     * @ORM\JoinColumn(name="modalidade_bolsa_id", referencedColumnName="id")
     **/        
    protected $modalidadeBolsa; //modalidade_bolsa_id 
    
    /**
     * @ORM\ManyToOne(targetEntity="\SigRH\Entity\Colaborador")
     * @ORM\JoinColumn(name="orientador", referencedColumnName="id")
     **/        
    protected $orientador; //orientador 
    

     /**
     * @ORM\Column(name="seguro_capital", type="string")
     */
    protected $seguroCapital; //seguro_capital
    
    /**
     * @ORM\Column(name="instituicao", type="integer") 
     */
    protected $instituicao; //instituicao -> buscar via serviço
    
    /**
     * @ORM\Column(name="plano_acao", type="integer") 
     */
    protected $planoAcao; //plano_acao -> buscar via serviço
    
    /**
     * Returns user ID.
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Sets user ID.
     * 
     * @param int $id        	
     */
    public function setId($id) {
        $this->id = $id;
    }


    
}

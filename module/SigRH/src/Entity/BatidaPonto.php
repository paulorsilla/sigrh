<?php

namespace SigRH\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe banco.
 * @ORM\Entity(repositoryClass="SigRH\Repository\BatidaPonto")
 * @ORM\Table(name="batida_ponto")
 */
class BatidaPonto extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

}

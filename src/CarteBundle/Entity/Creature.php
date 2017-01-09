<?php

namespace CarteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Creature
 *
 * @ORM\Table(name="creature")
 * @ORM\Entity(repositoryClass="CarteBundle\Repository\CreatureRepository")
 */
class Creature
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="pdv", type="integer")
     */
    private $pdv;

    /**
     * @var int
     *
     * @ORM\Column(name="atk", type="integer")
     */
    private $atk;

    /**
     * @var int
     *
     * @ORM\Column(name="pm", type="integer")
     */
    private $pm;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=255)
     */
    private $classe;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pdv
     *
     * @param integer $pdv
     * @return Creature
     */
    public function setPdv($pdv)
    {
        $this->pdv = $pdv;

        return $this;
    }

    /**
     * Get pdv
     *
     * @return integer 
     */
    public function getPdv()
    {
        return $this->pdv;
    }

    /**
     * Set atk
     *
     * @param integer $atk
     * @return Creature
     */
    public function setAtk($atk)
    {
        $this->atk = $atk;

        return $this;
    }

    /**
     * Get atk
     *
     * @return integer 
     */
    public function getAtk()
    {
        return $this->atk;
    }

    /**
     * Set pm
     *
     * @param integer $pm
     * @return Creature
     */
    public function setPm($pm)
    {
        $this->pm = $pm;

        return $this;
    }

    /**
     * Get pm
     *
     * @return integer 
     */
    public function getPm()
    {
        return $this->pm;
    }

    /**
     * Set classe
     *
     * @param string $classe
     * @return Creature
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return string 
     */
    public function getClasse()
    {
        return $this->classe;
    }
}

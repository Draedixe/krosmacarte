<?php

namespace CarteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carte
 *
 * @ORM\Table(name="carte")
 * @ORM\Entity(repositoryClass="CarteBundle\Repository\CarteRepository")
 */
class Carte
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="cout", type="integer")
     */
    private $cout;

    /**
     * @var string
     *
     * @ORM\Column(name="pouvoir", type="string", length=255)
     */
    private $pouvoir;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="CarteBundle\Entity\Extension")
     * @ORM\JoinColumn(nullable=false)
     */
    private $extension;

    /**
     * @ORM\OneToOne(targetEntity="CarteBundle\Entity\Creature")
     * @ORM\JoinColumn(nullable=true)
     */
    private $creature;

    /**
     * @ORM\ManyToOne(targetEntity="CarteBundle\Entity\Dieu")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dieu;

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
     * Set nom
     *
     * @param string $nom
     * @return Carte
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set cout
     *
     * @param integer $cout
     * @return Carte
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return integer 
     */
    public function getCout()
    {
        return $this->cout;
    }

    /**
     * Set pouvoir
     *
     * @param string $pouvoir
     * @return Carte
     */
    public function setPouvoir($pouvoir)
    {
        $this->pouvoir = $pouvoir;

        return $this;
    }

    /**
     * Get pouvoir
     *
     * @return string 
     */
    public function getPouvoir()
    {
        return $this->pouvoir;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Extension $ext
     */
    public function setExtension(Extension $ext)
    {
        $this->extension = $ext;

        return $this;
    }
    /**
     * @return Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param Dieu $dieu
     */
    public function setDieu(Dieu $dieu)
    {
        $this->dieu = $dieu;

        return $this;
    }
    /**
     * @return Dieu
     */
    public function getDieu()
    {
        return $this->dieu;
    }

    /**
     * @return Creature
     */
    public function getCreature()
    {
        return $this->creature;
    }

    /**
     * @param Creature $creature
     */
    public function setCreature(Creature $creature)
    {
        $this->creature = $creature;
    }


}

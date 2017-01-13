<?php

namespace CarteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Extension
 *
 * @ORM\Table(name="extension")
 * @ORM\Entity(repositoryClass="CarteBundle\Repository\ExtensionRepository")
 */
class Extension
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="CarteBundle\Entity\Carte", mappedBy="extension", cascade={"remove"})
     */
    private $cartes;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;

    /**
     * @ORM\OneToOne(targetEntity="CarteBundle\Entity\Note")
     * @ORM\JoinColumn(nullable=true)
     */
    private $note;

    public function __construct()
    {
        $this->cartes = new ArrayCollection();
    }

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
     * @return Extension
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
     * @return User
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * @param User $createur
     */
    public function setCreateur($createur)
    {
        $this->createur = $createur;
    }

    public function getCartes()
    {
        return $this->cartes;
    }

    public function addCarte(Carte $carte)
    {
        $this->cartes[] = $carte;

        return $this;
    }

    public function removeApplication(Carte $carte)
    {
        $this->cartes->removeElement($carte);
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return Note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param Note $note
     */
    public function setNote(Note $note)
    {
        $this->note = $note;
    }
}

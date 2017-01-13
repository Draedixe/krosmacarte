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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="CarteBundle\Entity\Note")
     * @ORM\JoinColumn(nullable=true)
     */
    private $note;

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

    public function resizePng($im, $dst_width, $dst_height) {
        $width = imagesx($im);
        $height = imagesy($im);

        $newImg = imagecreatetruecolor($dst_width, $dst_height);

        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
        imagecopyresampled($newImg, $im, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);

        return $newImg;
    }

    public function genererCartePNG($urlImg, $urlCreations,$urlFont)
    {

        $imageTot = imagecreatetruecolor(250,317);
        $transparent = imagecolorallocatealpha($imageTot, 255, 255, 255, 127);
        imagefill($imageTot, 0, 0, $transparent);
        imagealphablending($imageTot, true);

        $imageCarte = imagecreatefrompng($this->getImage());
        $imageCarte = $this->resizePng($imageCarte,184,135);

        imagecopy($imageTot, $imageCarte, 37, 36, 0, 0, 184, 135);

        $imageFond = imagecreatefrompng($urlImg.strtolower($this->getDieu()->getNom())."_".(($this->getCreature() == null) ? 'sort' : 'crea').".png");
        $imageFond = $this->resizePng($imageFond,250,317);
        imagecopy($imageTot, $imageFond, 0, 0, 0, 0, 250, 317);


        imagealphablending($imageTot, false);
        imagesavealpha($imageTot, true);
        $blanc = imagecolorallocate($imageCarte, 255, 255, 255);
        $noir = imagecolorallocate($imageCarte, 0, 0, 0);
        imagestring($imageTot, 5, 42, 180, $this->getNom(), $blanc);
        imagestring($imageTot, 5, 33, 30, $this->getCout(), $blanc);
        //imagettftext ( $imageTot, 50 , 0 , 33 , 30, $blanc , $urlFont."/Prototype.ttf" , $this->getCout() );
        imagestring($imageTot, 5, 42, 214, $this->getPouvoir(), $noir);
        $creatureCarte = $this->getCreature();
        if($creatureCarte != null){
            imagestring($imageTot, 5, 177, 38, $creatureCarte->getAtk(), $blanc);
            imagestring($imageTot, 5, 211, 38, $creatureCarte->getPdv(), $blanc);
            imagestring($imageTot, 5, 196, 65, $creatureCarte->getPm(), $blanc);
            imagestring($imageTot, 5, 60, 297,  $creatureCarte->getClasse(), $blanc);

        }

        imagepng($imageTot, $urlCreations."carte_".$this->getId().".png");
    }

}

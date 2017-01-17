<?php

namespace CarteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SplFileInfo;
use UserBundle\Entity\User;

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
     * @ORM\ManyToOne(targetEntity="CarteBundle\Entity\Extension", inversedBy="cartes")
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
     * @ORM\ManyToOne(targetEntity="CarteBundle\Entity\Rarete")
     * @ORM\JoinColumn(nullable=true)
     */
    private $rarete;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinTable(name="votes_cartes")
     */
    private $votes;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
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
     * @param Rarete $rarete
     */
    public function setRarete(Rarete $rarete)
    {
        $this->rarete = $rarete;
    }

    /**
     * @return Rarete
     */
    public function getRarete()
    {
        return $this->rarete;
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
     * @param User $user
     */
    public function addVote(User $user)
    {
        $this->votes[] = $user;
    }

    /**
     * @param User $user
     */
    public function removeVote(User $user)
    {
        $this->votes->removeElement($user);
    }

    public function getExisteVote(User $user)
    {
        return $this->votes->contains($user);
    }

    /**
     * Get votes
     *
     * @return ArrayCollection
     */
    public function getVotes()
    {
        return $this->votes;
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

    function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
        return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }

    public function genererCartePNG($urlImg, $urlCreations,$urlFont,$type)
    {

        $imageTot = imagecreatetruecolor(250,317);
        $transparent = imagecolorallocatealpha($imageTot, 255, 255, 255, 127);
        imagefill($imageTot, 0, 0, $transparent);
        imagealphablending($imageTot, true);

        $info = new SplFileInfo($this->getImage());
        if(strcmp ($info->getExtension(),"png") == 0){
            $imageCarte = imagecreatefrompng($this->getImage());
        }
        else if(strcmp ($info->getExtension(),"jpeg") == 0 || strcmp ($info->getExtension(),"jpg") == 0){
            $imageCarte = imagecreatefromjpeg($this->getImage());
        }

        $imageCarte = $this->resizePng($imageCarte,184,135);
        imagecopy($imageTot, $imageCarte, 37, 36, 0, 0, 184, 135);
        $imageFond = imagecreatefrompng($urlImg.strtolower($this->getDieu()->getNom())."_".$type.".png");
        $imageFond = $this->resizePng($imageFond,250,317);
        imagecopy($imageTot, $imageFond, 0, 0, 0, 0, 250, 317);

        if($this->getRarete() != null){
            if(! strcmp($this->getRarete()->getNom(),"Commune") == 0){
                $imageRareteUrl = $urlImg.str_replace(" ","_",strtolower($this->getRarete()->getNom())).".png";
                $imageRarete = imagecreatefrompng($imageRareteUrl);
                list($width, $height, $type, $attr) = getimagesize($imageRareteUrl);
                if(! strcmp($this->getRarete()->getNom(),"Krosmique") == 0) {
                    imagecopy($imageTot, $imageRarete, 107, 43 - $height, 0, 0, $width, $height);
                }else{
                    imagecopy($imageTot, $imageRarete, 111, 43 - $height, 0, 0, $width, $height);
                }
            }
        }

        imagealphablending($imageTot, false);
        imagesavealpha($imageTot, true);
        $blanc = imagecolorallocate($imageCarte, 255, 255, 255);
        $noir = imagecolorallocate($imageCarte, 0, 0, 0);
        $jaune = imagecolorallocate($imageCarte, 132, 87, 13);
        $rouge = imagecolorallocate($imageCarte, 139, 0, 13);
        $vert = imagecolorallocate($imageCarte, 43, 81, 11);
        $bleu = imagecolorallocate($imageCarte, 3, 133, 155);
        imagealphablending($imageTot, true);
        imagettftext ( $imageTot, 15 , 0 ,(((175-(strlen($this->getNom())*9.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ))/2)+39)  , 195, $blanc , $urlFont."/BERNHC.ttf" , $this->getNom() );
        if($this->getCout() < 10){
            $this->imagettfstroketext($imageTot, 30 , 0 , 33 , 60, $blanc,$bleu,$urlFont."/BERNHC.ttf" , $this->getCout(),2);
        }else{
            $this->imagettfstroketext($imageTot, 30 , 0 , 23 , 60, $blanc,$bleu,$urlFont."/BERNHC.ttf" , $this->getCout(),2);
        }
        imagettftext ( $imageTot, 10 , 0 , 38 , 225, $noir , $urlFont."/arialbd.ttf" , $this->getPouvoir() );
        $creatureCarte = $this->getCreature();
        if($creatureCarte != null){
            if($creatureCarte->getAtk() < 10){
                $this->imagettfstroketext($imageTot, 20 , 0 , 177 , 48, $blanc,$jaune,$urlFont."/BERNHC.ttf" , $creatureCarte->getAtk(),1);
            }else{
                $this->imagettfstroketext($imageTot, 20 , 0 , 171 , 48, $blanc,$jaune,$urlFont."/BERNHC.ttf" , $creatureCarte->getAtk(),1);
            }
            if($creatureCarte->getPdv() < 10){
                $this->imagettfstroketext($imageTot, 20 , 0 , 211 , 48, $blanc,$rouge,$urlFont."/BERNHC.ttf" , $creatureCarte->getPdv(),1);
            }else{
                $this->imagettfstroketext($imageTot, 20 , 0 , 205 , 48, $blanc,$rouge,$urlFont."/BERNHC.ttf" , $creatureCarte->getPdv(),1);
            }
            if($creatureCarte->getPm() < 10){
                $this->imagettfstroketext($imageTot, 20 , 0 , 196 , 75, $blanc,$vert,$urlFont."/BERNHC.ttf" , $creatureCarte->getPm(),1);
            }else{
                $this->imagettfstroketext($imageTot, 20 , 0 , 190 , 75, $blanc,$vert,$urlFont."/BERNHC.ttf" , $creatureCarte->getPm(),1);
            }
            imagettftext ( $imageTot, 10 , 0 , (((144-(strlen($creatureCarte->getClasse())*6))/2)+60) , 307, $blanc , $urlFont."/BERNHC.ttf" , $creatureCarte->getClasse() );

        }
        imagealphablending($imageTot, false);

        imagepng($imageTot, $urlCreations."carte_".$this->getId().".png");
    }

}

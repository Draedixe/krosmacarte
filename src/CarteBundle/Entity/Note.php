<?php

namespace CarteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity(repositoryClass="CarteBundle\Repository\NoteRepository")
 */
class Note
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
     * @ORM\Column(name="upvote", type="integer")
     */
    private $upvote = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="downvote", type="integer")
     */
    private $downvote = 0;


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
     * Set upvote
     *
     * @param integer $upvote
     * @return Note
     */
    public function setUpvote($upvote)
    {
        $this->upvote = $upvote;

        return $this;
    }

    /**
     * Get upvote
     *
     * @return integer 
     */
    public function getUpvote()
    {
        return $this->upvote;
    }

    /**
     * Set downvote
     *
     * @param integer $downvote
     * @return Note
     */
    public function setDownvote($downvote)
    {
        $this->downvote = $downvote;

        return $this;
    }

    /**
     * Get downvote
     *
     * @return integer 
     */
    public function getDownvote()
    {
        return $this->downvote;
    }

    public function addUpvote(){
        $this->upvote++;
    }

    public function addDownvote(){
        $this->downvote++;
    }



}

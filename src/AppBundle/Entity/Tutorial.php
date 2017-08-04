<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tutorial
 *
 * @ORM\Table(name="tutorial")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TutorialRepository")
 */
class Tutorial
{

    /**
     * One Tutorial has Many ClientOrder.
     * @ORM\OneToMany(targetEntity="ClientOrder", mappedBy="tutorial")
     */
    private $clientOrders;

    /**
     * One Tutorial has Many Videos.
     * @ORM\OneToMany(targetEntity="Video", mappedBy="tutorial")
     */
    private $videos;

    public function __construct() {
        $this->videos = new ArrayCollection();
        $this->clientOrders = new ArrayCollection();
    }


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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=600)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="coins", type="integer", nullable=true)
     */
    protected $coins;

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
     * Set title
     *
     * @param string $title
     * @return Tutorial
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Tutorial
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * @param int $coins
     */
    public function setCoins($coins)
    {
        $this->coins = $coins;
    }

    /**
     * @return mixed
     */
    public function getClientOrders()
    {
        return $this->clientOrders;
    }

    /**
     * @param mixed $clientOrders
     * @return Tutorial
     */
    public function setClientOrders($clientOrders)
    {
        $this->clientOrders = $clientOrders;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     * @return Tutorial
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
        return $this;
    }



}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoRepository")
 */
class Video
{

    /**
     * One Video has Many ClientOrder.
     * @ORM\OneToMany(targetEntity="ClientOrder", mappedBy="video")
     */
    private $clientOrders;


    /**
     * Many Videos have One Tutorial.
     * @ORM\ManyToOne(targetEntity="Tutorial", inversedBy="videos")
     * @ORM\JoinColumn(name="tutorial_id", referencedColumnName="id")
     */
    private $tutorial;

    /**
     * One Video has Many Ratings.
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="user")
     */
    private $ratings;


    /**
     * One Video has Many Comments.
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="video")
     */
    private $comments;

    public function __construct() {
        $this->ratings= new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time")
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="part", type="integer")
     */
    private $part;


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
     * @return Video
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
     * Set source
     *
     * @param string $source
     * @return Video
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Video
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set part
     *
     * @param integer $part
     * @return Video
     */
    public function setPart($part)
    {
        $this->part = $part;

        return $this;
    }

    /**
     * Get part
     *
     * @return integer 
     */
    public function getPart()
    {
        return $this->part;
    }
}

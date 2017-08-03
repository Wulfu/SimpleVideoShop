<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * One User has Many ClientOrder.
     * @ORM\OneToMany(targetEntity="ClientOrder", mappedBy="user")
     */
    private $clientOrders;

    /**
     * One User has Many Comments.
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;

    /**
     * One User has Many Ratings.
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="user")
     */
    private $ratings;


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank(message="You must specify user name.")
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100)
     */
    protected $surname;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_coins", type="integer", nullable=true)
     */
    protected $user_coins;

    public function __construct()
    {
        parent::__construct();

        $this->comments = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->clientOrders= new ArrayCollection();
        // your own logic
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserCoins()
    {
        return $this->user_coins;
    }

    /**
     * @param int $user_coins
     */
    public function setUserCoins($user_coins)
    {
        $this->user_coins = $user_coins;
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
     * @return User
     */
    public function setClientOrders($clientOrders)
    {
        $this->clientOrders = $clientOrders;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     * @return User
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * @param mixed $ratings
     * @return User
     */
    public function setRatings($ratings)
    {
        $this->ratings = $ratings;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }



}
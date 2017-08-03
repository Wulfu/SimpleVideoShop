<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientOrder
 *
 * @ORM\Table(name="client_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientOrderRepository")
 */
class ClientOrder
{
    /**
     * Many ClientOrders have One User.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="clientOrders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Many ClientOrders have One Tutorial.
     * @ORM\ManyToOne(targetEntity="Tutorial", inversedBy="clientOrders")
     * @ORM\JoinColumn(name="tutorial_id", referencedColumnName="id")
     */
    private $tutorial;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;


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
     * Set date
     *
     * @param \DateTime $date
     * @return ClientOrder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getTutorial()
    {
        return $this->tutorial;
    }

    /**
     * @param mixed $tutorial
     */
    public function setTutorial($tutorial)
    {
        $this->tutorial = $tutorial;
    }


}

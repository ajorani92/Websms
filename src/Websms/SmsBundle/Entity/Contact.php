<?php

namespace Websms\SmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Websms\SmsBundle\Entity\Group;

/**
 * @ORM\Entity(repositoryClass="Websms\SmsBundle\Repository\ContactRepository")
 * @ORM\Table(name="contact")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $number;

    /**
     * @var \Websms\SmsBundle\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="\Websms\SmsBundle\Entity\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $group;

    /**
     * @ORM\Column(name="user_id", type="integer", length=40)
     */
    protected $userId;

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
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Contact
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get group
     *
     * @return \Websms\SmsBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set group
     *
     * @param \Websms\SmsBundle\Entity\Group $group
     * @return Contact
     */
    public function setGroup(Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Set user id
     *
     * @param integer $userId
     * @return Group
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get user id
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
}

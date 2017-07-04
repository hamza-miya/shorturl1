<?php

/**
 * @author  Even-Mind
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="User")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @Groups({"GetUser"})
     * @ORM\Column(name="dateInscription", type="datetime")
     *
     */
    protected $dateInscription;

    public function __construct() {
        parent::__construct();

        // Date d'inscription
        $this->dateInscription = new \DateTime("now");
    }

    /**
     * @return mixed
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        parent::setEmail(strtolower(trim($email)));
        $this->setUsername($email);
    }

    /**
     * @return \DateTime
     */
    public function getDateInscription() : \DateTime
    {
        return $this->dateInscription;
    }

    /**
     * @param \DateTime $dateInscription
     */
    public function setDateInscription(\DateTime $dateInscription)
    {
        $this->dateInscription = $dateInscription;
    }
}
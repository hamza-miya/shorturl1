<?php

/**
 * @author  Even-Mind
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity()
 * @ORM\Table(name="StatsUrl")
 */
class StatsUrl
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=20)
     *
     */
    protected $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *
     */
    protected $date;


    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\ShorterUrl", inversedBy="stats", cascade={"persist"})
     * @JoinColumn(name="id_shorterUrl", referencedColumnName="id", onDelete="cascade", nullable=false)
     */
    protected $shorterUrl;

    /**
     * StatsUrl constructor.
     */
    public function __construct(ShorterUrl $shorterUrl, $ip) {
        $this->date = new \DateTime('now');
        $this->ip = $ip;
        $this->shorterUrl = $shorterUrl;
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
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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
}
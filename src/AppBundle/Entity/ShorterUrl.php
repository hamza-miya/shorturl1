<?php

/**
 * @author  Even-Mind
 */


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShorterUrlRepository")
 * @ORM\Table(name="ShorterUrl")
 */
class ShorterUrl
{
    /**
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
     * @ORM\Column(name="url", type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message = "ChampsObligatoire.Url.Url",
     *     groups={"Guest"},
     * )
     *
     * @Assert\Url(
     *    message = "Invalide.Url.Url",
     *    groups={"Guest"}
     * )
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Min.Url.Url",
     *      maxMessage = "Max.Url.Url",
     *      groups={"Guest"},
     * )
     *
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=6)
     *
     */
    protected $code;

    /**
     * @OneToMany(targetEntity="AppBundle\Entity\StatsUrl", mappedBy="shorterUrl", cascade={"persist"})
     */
    protected $stats;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Min.PassW.PassW",
     *      maxMessage = "Max.PassW.PassW",
     *      groups={"Guest"},
     * )
     *
     */
    protected $password;

    /**
     * ShorterUrl constructor.
     */
    public function __construct() {
        $this->code = $this->clef = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        $this->stats = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return ArrayCollection
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param ArrayCollection $stats
     */
    public function setStats($stats)
    {
        $this->stats = $stats;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Miya
 * Date: 09/06/2017
 * Time: 14:33
 */

namespace AppBundle\Entity;


class LinkAccessPswdProtected
{
    /**
     * @var string
     *
     *
     *
     */
    protected $password;

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
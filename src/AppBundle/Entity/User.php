<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __construct()
    {
        parent::__construct();
        // may not be needed, see section on salt below
         //$this->apiKey = md5(uniqid(null, true));
    }
    /**
     * @var string $firstName
     *
     * @ORM\Column(name="firstName", type="string")
      */
    protected $firstName;
    /**
     * @var string $lastName
     *
     * @ORM\Column(name="lastName", type="string")
     */
    protected $lastName;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


}

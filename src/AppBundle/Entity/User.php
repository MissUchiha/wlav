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

//    /**
//     * @ORM\Column(type="string", length=25, unique=true)
//     */
//    protected $username;
//
//    /**
//     * @ORM\Column(type="string", length=64)
//     */
//    protected $password;
//
//
//    /**
//     * @ORM\Column(type="string", length=60, unique=true)
//     */
//    protected $email;
//
//    /**
//     * @ORM\Column(name="apiKey", type="string")
//     */
//    protected $apiKey;
//
//    /**
//     * @ORM\Column(type="json_array")
//     */
//    protected $roles = array();
//

    public function __construct()
    {
        parent::__construct();
        // may not be needed, see section on salt below
         //$this->apiKey = md5(uniqid(null, true));
    }

//
//    public function getUsername()
//    {
//        return $this->username;
//    }
//
//
//    public function getPassword()
//    {
//        return $this->password;
//    }
//
//
//    /**
//     * Get id
//     *
//     * @return int
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * Get email
//     *
//     * @return string
//     */
//    public function getEmail()
//    {
//        return $this->email;
//    }
//
//
//    /**
//     * Get apiKey
//     *
//     * @return string
//     */
//    public function getApiKey()
//    {
//        return $this->apiKey;
//    }
//    /**
//     * Set username
//     *
//     * @param string $username
//     *
//     * @return User
//     */
//    public function setUsername($username)
//    {
//        $this->username = $username;
//
//        return $this;
//    }
//
//    /**
//     * Set password
//     *
//     * @param string $password
//     *
//     * @return User
//     */
//    public function setPassword($password)
//    {
//        $this->password = $password;
//
//        return $this;
//    }
//
//    /**
//     * Set email
//     *
//     * @param string $email
//     *
//     * @return User
//     */
//    public function setEmail($email)
//    {
//        $this->email = $email;
//
//        return $this;
//    }
//
//    /**
//     * Set apiKey
//     *
//     * @param string $apiKey
//     *
//     * @return User
//     */
//    public function setApiKey($apiKey)
//    {
//        $this->apiKey = $apiKey;
//
//        return $this;
//    }
//
//
//    /**
//     * Set roles
//     *
//     * @param array $roles
//     *
//     * @return User
//     */
//    public function setRoles(array $roles)
//    {
//        $this->roles = $roles || ['ROLE_USER'];
//
//        return $this;
//    }
//
//    /**
//     * Returns the salt that was originally used to encode the password.
//     *
//     * This can return null if the password was not encoded using a salt.
//     *
//     * @return string|null The salt
//     */
//
//    /**
//     * Removes sensitive data from the user.
//     *
//     * This is important if, at any given point, sensitive information like
//     * the plain-text password is stored on this object.
//     */
//    public function eraseCredentials()
//    {
//        // TODO: Implement eraseCredentials() method.
//    }
}

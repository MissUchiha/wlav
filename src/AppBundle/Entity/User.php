<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\FOSUserBundle;
use FOS\UserBundle\Model\User as BaseUser;
use \AppBundle\Entity\ProgramSource;
use Symfony\Component\Intl\Data\Util\ArrayAccessibleResourceBundle;

/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser implements \JsonSerializable
{    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __construct($user = null)
    {
        parent::__construct();
//        $this->programSources = new ArrayCollection();
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
     * @var string $programSources
     * @ORM\OneToMany(targetEntity="ProgramSource", mappedBy="user")
     */
    protected $programSources;

    /**
     * @return string
     */
    public function getProgramSources()
    {
        return $this->programSources;
    }

    /**
     * @param string $programSources
     */
    public function setProgramSources($programSources)
    {
        $this->programSources = $programSources;
    }

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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $progs = array();
        foreach ($this->getProgramSources() as $prog) {
            array_push($progs,$prog);
        }
        return array(
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'roles' =>$this->getRoles(),
            'programsources' => $progs
        );
    }

}

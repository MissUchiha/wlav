<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgramSource
 *
 * @ORM\Table(name="program_source")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgramSourceRepository")
 */
class ProgramSource implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="programSources")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
      */
    private $user;

    /**
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    public $name;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string $verificationCalls
     * @ORM\OneToMany(targetEntity="VerificationCall", mappedBy="programSource")
     */
    protected $verificationCalls;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getVerificationCalls()
    {
        return $this->verificationCalls;
    }

    /**
     * @param string $verificationCalls
     */
    public function setVerificationCalls($verificationCalls)
    {
        $this->verificationCalls = $verificationCalls;
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
        $calls = array();
        if($this->getVerificationCalls()  != null)
        {
            foreach ($this->getVerificationCalls() as $call)
                array_push($calls,$call);
        }

        return array(
            'id' => $this->id,
            'name' => $this->name,
            'createdAt' => $this->createdAt->format("d.M.Y. H:m:s"),
            'userId' => $this->user->getId(),
            'verificationCalls' => $calls
        );
    }
}


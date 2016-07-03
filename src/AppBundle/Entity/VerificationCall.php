<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerificationCall
 *
 * @ORM\Table(name="verification_call")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VerificationCallRepository")
 */
class VerificationCall implements \JsonSerializable
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
     * @var json_array
     * @ORM\Column(name="flags", type="string", nullable=true)
     */
    private $flags;


    /**
     * @var string
     * @ORM\Column(name="stdoutMsg", type="string", nullable=true)
     */
    private $stdoutMsg;

    /**
     * @var string
     * @ORM\Column(name="stderrMsg", type="string", nullable=true)
     */
    private $stderrMsg;

    /**
     * @var string
     * @ORM\Column(name="errorMsg", type="string", nullable=true)
     */
    private $errorMsg;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var text
     * @ORM\Column(name="output", type="text",nullable=true)
     */
    private $output;


    /**
     * @ORM\ManyToOne(targetEntity="ProgramSource", inversedBy="verificationCalls")
     * @ORM\JoinColumn(name="programSource_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $programSource;

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param mixed $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @param mixed $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
    }


    /**
     * @return mixed
     */
    public function getStdoutMsg()
    {
        return $this->stdoutMsg;
    }

    /**
     * @param mixed $stdoutMsg
     */
    public function setStdoutMsg($stdoutMsg)
    {
        $this->stdoutMsg = $stdoutMsg;
    }

    /**
     * @return mixed
     */
    public function getStderrMsg()
    {
        return $this->stderrMsg;
    }

    /**
     * @param mixed $stderrMsg
     */
    public function setStderrMsg($stderrMsg)
    {
        $this->stderrMsg = $stderrMsg;
    }

    /**
     * @return mixed
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * @param mixed $errorMsg
     */
    public function setErrorMsg($errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getProgramSource()
    {
        return $this->programSource;
    }

    /**
     * @param mixed $programSource
     */
    public function setProgramSource($programSource)
    {
        $this->programSource = $programSource;
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
     * Specify data which should be serialized to JSON
     * @link http://php$verificationCall.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return array(
            'id' => $this->id,
            'programSourceId' => $this->programSource->getId(),
            'flags' => $this->flags,
            'stdoutMsg' => $this->stdoutMsg,
            'stderrMsg' => $this->stderrMsg,
            'errorMsg' => $this->errorMsg,
            'createdAt' => $this->createdAt->format("d.M.Y. H:m:s"),
            'status' => $this->status,
            'output' => $this->output
        );
    }
}


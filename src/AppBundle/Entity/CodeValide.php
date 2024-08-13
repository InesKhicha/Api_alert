<?php
// src/AppBundle/Entity/CodeValide.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="codevalide")
 */
class CodeValide
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $code;

    /**
     * @ORM\Column(type="boolean")
     */
    private $expired;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="FileContent")
     * @ORM\JoinColumn(name="id_filecontent", referencedColumnName="id")
     */
    private $filecontent;

    // Getters et Setters
    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function isExpired()
    {
        return $this->expired;
    }

    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getFilecontent()
    {
        return $this->filecontent;
    }

    public function setFilecontent($filecontent)
    {
        $this->filecontent = $filecontent;
    }
}
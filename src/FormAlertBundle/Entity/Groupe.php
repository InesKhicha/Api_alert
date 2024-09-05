<?php
namespace FormAlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Groupe")
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActivated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $verifiedAt;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $isProcessed;

    /**
     * @ORM\Column(type="float")
     */
    private $pourcentLoad;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $rapport;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $appkey;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSpecialFile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLocationFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbContact;

    /**
     * @ORM\ManyToOne(targetEntity="SmsUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $columnsSelected;

    // Ajoutez ici les getters et setters pour chaque propriété.

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getIsActivated()
    {
        return $this->isActivated;
    }

    public function setIsActivated($isActivated)
    {
        $this->isActivated = $isActivated;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getVerifiedAt()
    {
        return $this->verifiedAt;
    }

    public function setVerifiedAt($verifiedAt)
    {
        $this->verifiedAt = $verifiedAt;
    }

    public function getIsProcessed()
    {
        return $this->isProcessed;
    }

    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = $isProcessed;
    }

    public function getPourcentLoad()
    {
        return $this->pourcentLoad;
    }

    public function setPourcentLoad($pourcentLoad)
    {
        $this->pourcentLoad = $pourcentLoad;
    }

    public function getRapport()
    {
        return $this->rapport;
    }

    public function setRapport($rapport)
    {
        $this->rapport = $rapport;
    }

    public function getAppkey()
    {
        return $this->appkey;
    }

    public function setAppkey($appkey)
    {
        $this->appkey = $appkey;
    }

    public function getIsSpecialFile()
    {
        return $this->isSpecialFile;
    }

    public function setIsSpecialFile($isSpecialFile)
    {
        $this->isSpecialFile = $isSpecialFile;
    }

    public function getIsLocationFile()
    {
        return $this->isLocationFile;
    }

    public function setIsLocationFile($isLocationFile)
    {
        $this->isLocationFile = $isLocationFile;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getNbContact()
    {
        return $this->nbContact;
    }

    public function setNbContact($nbContact)
    {
        $this->nbContact = $nbContact;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getColumnsSelected()
    {
        return $this->columnsSelected;
    }

    public function setColumnsSelected($columnsSelected)
    {
        $this->columnsSelected = $columnsSelected;
    }
    
}

<?php
// src/AppBundle/Entity/FileContent.php
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity
 * @ORM\Table(name="FileContent")
 */
class FileContent
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $phone;

    /**
     * @ORM\Column(type="integer")
     */
    private $invalidePhone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActivated;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $region;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stopSms;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $numberPrefix;

    /**
     * @ORM\Column(type="integer")
     */
    private $isVerified;

    /**
     * @ORM\Column(type="integer")
     */
    private $toVerified;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rgpdPolicy;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $dateEvent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbEventSent;


    /**
     * @ORM\ManyToOne(targetEntity="Groupe", inversedBy="fileContents")
     * @ORM\JoinColumn(name="grp", referencedColumnName="id")
     */
    private $grp;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $shortUrlPartnr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $custom1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $custom2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $custom3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $custom4;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetimeEvent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dateInvalid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $urlInvalid;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $network;

  /**
     * @ORM\Column(type="integer")
     */
    private $formImport;

 


 // Constructeur
 public function __construct(

) {
    $this->content = " ";
    $this->phone = NULL;
    $this->invalidePhone = 0;
    $this->createdAt =  new \DateTime();
    $this->updatedAt =  new \DateTime();
    $this->isActivated = 1;
    $this->region = 'FR';
    $this->stopSms = 0;
    $this->isVerified = 1;
    $this->toVerified = 0;
    $this->rgpdPolicy = 1;
    $this->nbEventSent = 0;
    $this->formImport = " ";


    // Initialisation des valeurs par défaut
    $this->datetimeEvent = null; // ou une valeur par défaut si nécessaire
    $this->dateInvalid = false; // valeur par défaut
    $this->urlInvalid = false; // valeur par défaut
    $this->grp = null; // ou une valeur par défaut si nécessaire
    $this->lastname = null; // ou une valeur par défaut si nécessaire
    $this->firstname = null; // ou une valeur par défaut si nécessaire
    $this->url = null; // ou une valeur par défaut si nécessaire
    $this->shortUrlPartnr = null; // ou une valeur par défaut si nécessaire
    $this->custom1 = null; // ou une valeur par défaut si nécessaire
    $this->custom2 = null; // ou une valeur par défaut si nécessaire
    $this->custom3 = null; // ou une valeur par défaut si nécessaire
    $this->custom4 = null; // ou une valeur par défaut si nécessaire
    $this->token = null; // ou une valeur par défaut si nécessaire
    $this->network = null; // ou une valeur par défaut si nécessaire
}
    // Getters et Setters
    public function getId()
    {
        return $this->id;
    }

    public function getCustom1()
    {
        return $this->custom1;
    }

    public function setCustom1($custom1)
    {
        $this->custom1 = $custom1;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setphone($phone)
    {
        $this->phone = $phone;
    }

    public function getCustom2()
    {
        return $this->custom2;
    }

    public function setCustom2($custom2)
    {
        $this->custom2 = $custom2;
    }

    public function getCustom3()
    {
        return $this->custom3;
    }

    public function setCustom3($custom3)
    {
        $this->custom3 = $custom3;
    }

    public function getCustom4()
    {
        return $this->custom4;
    }

    public function setCustom4($custom4)
    {
        $this->custom4 = $custom4;
    }



    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }


    public function getFirstname()
    {
        return $this->firstname;
    }

   
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of grp
     */ 
    public function getGrp()
    {
        return $this->grp;
    }

    /**
     * Set the value of grp
     *
     * @return  self
     */ 
    public function setGrp($grp)
    {
        $this->grp = $grp;

        return $this;
    }
}


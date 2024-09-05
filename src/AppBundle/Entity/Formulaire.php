<?php
// src/AppBundle/Entity/Formulaire.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="formulaire")
 */
class Formulaire
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $phone="Télephone";

    

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $custom1;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $lastname;

        /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $custom2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $custom3;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $custom4;

    /**
     * @ORM\Column(type="string")
     */
    private $nom_formulaire;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $codeFormulaire;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumn(name="id_groupe", referencedColumnName="id", nullable=false)
     */
    private $groupe;

    public function getId()
    {
        return $this->id;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = "Télephone";
        return $this;
    }

    public function getCustom1()
    {
        return $this->custom1;
    }

    public function setCustom1($custom1)
    {
        $this->custom1 = $this->capitalizeFirstLetter($custom1);
        return $this;
    }

    public function getCustom2()
    {
        return $this->custom2;
    }

    public function setCustom2($custom2)
    {
        $this->custom2 = $this->capitalizeFirstLetter($custom2);
        return $this;
    }

    public function getCustom3()
    {
        return $this->custom3;
    }

    public function setCustom3($custom3)
    {
        $this->custom3 = $this->capitalizeFirstLetter($custom3);
        return $this;
    }

    public function getCustom4()
    {
        return $this->custom4;
    }

    public function setCustom4($custom4)
    {
        $this->custom4 = $this->capitalizeFirstLetter($custom4);
        return $this;
    }

    public function getNomFormulaire()
    {
        return $this->nom_formulaire;
    }

    public function setNomFormulaire($nom_formulaire)
    {
        $this->nom_formulaire = $this->capitalizeFirstLetter($nom_formulaire);
        return $this;
    }

    public function getCodeFormulaire()
    {
        return $this->codeFormulaire;
    }

    public function setCodeFormulaire($codeFormulaire)
    {
        $this->codeFormulaire = $codeFormulaire;
        return $this;
    }

    public function getGroupe()
    {
        return $this->groupe;
    }

    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;
        return $this;
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

    public function capitalizeFirstLetter($string)
    {
        return mb_convert_case(mb_strtolower($string), MB_CASE_TITLE, "UTF-8");
    }
}

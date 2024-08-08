<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formulaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formulaire;

    // Getters et setters pour chaque champ...


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

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
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

    public function getFormulaire()
    {
        return $this->formulaire;
    }

    public function setFormulaire($formulaire)
    {
        $this->formulaire = $formulaire;
    }
}
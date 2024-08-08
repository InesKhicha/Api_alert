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
     * @ORM\Column(type="string")
     */
    private $tel="Télephone";

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $custom1;

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
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     */
    private $client;

    public function getId()
    {
        return $this->id;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel)
    {
        $this->tel = "Télephone";
        return $this;
    }

    public function getCustom1()
    {
        return $this->custom1;
    }

    public function setCustom1($custom1)
    {
        $this->custom1 = $custom1;
        return $this;
    }

    public function getCustom2()
    {
        return $this->custom2;
    }

    public function setCustom2($custom2)
    {
        $this->custom2 = $custom2;
        return $this;
    }

    public function getCustom3()
    {
        return $this->custom3;
    }

    public function setCustom3($custom3)
    {
        $this->custom3 = $custom3;
        return $this;
    }

    public function getCustom4()
    {
        return $this->custom4;
    }

    public function setCustom4($custom4)
    {
        $this->custom4 = $custom4;
        return $this;
    }

    public function getNomFormulaire()
    {
        return $this->nom_formulaire;
    }

    public function setNomFormulaire($nom_formulaire)
    {
        $this->nom_formulaire = $nom_formulaire;
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

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }
}

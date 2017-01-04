<?php

namespace VetoPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Animal
 *
 * @ORM\Table(name="animal")
 * @ORM\Entity(repositoryClass="VetoPlatformBundle\Repository\AnimalRepository")
 */
class Animal {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\Length(min=4, minMessage="Le nom doit faire au moins {{ limit }} caractères.")
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_maj", type="datetime")
     */
    private $dateMaj;

    /**
     * @ORM\ManyToOne(targetEntity="VetoPlatformBundle\Entity\ClasseAnimal")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classeAnimal;

    public function __construct() {
        // Par défaut, la date de l'annonce est la date d'aujourd'hui
        $this->dateMaj = new \Datetime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Animal
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Animal
     */
    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Animal
     */
    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire() {
        return $this->commentaire;
    }

    /**
     * Set dateMaj
     *
     * @param \DateTime $dateMaj
     *
     * @return Animal
     */
    public function setDateMaj($dateMaj) {
        $this->dateMaj = $dateMaj;

        return $this;
    }

    /**
     * Get dateMaj
     *
     * @return \DateTime
     */
    public function getDateMaj() {
        return $this->dateMaj;
    }


    /**
     * Set classeAnimal
     *
     * @param \VetoPlatformBundle\Entity\ClasseAnimal $classeAnimal
     *
     * @return Animal
     */
    public function setClasseAnimal(\VetoPlatformBundle\Entity\ClasseAnimal $classeAnimal = null)
    {
        $this->classeAnimal = $classeAnimal;

        return $this;
    }

    /**
     * Get classeAnimal
     *
     * @return \VetoPlatformBundle\Entity\ClasseAnimal
     */
    public function getClasseAnimal()
    {
        return $this->classeAnimal;
    }
}

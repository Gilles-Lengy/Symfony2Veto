<?php

namespace VetoPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClasseAnimal
 *
 * @ORM\Table(name="classe_animal")
 * @ORM\Entity(repositoryClass="VetoPlatformBundle\Repository\ClasseAnimalRepository")
 */
class ClasseAnimal {

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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

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
     * @return ClasseAnimal
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
     * @return string String representation of this class
     */
    public function __toString() {
        return (string) $this->getId();
    }

}

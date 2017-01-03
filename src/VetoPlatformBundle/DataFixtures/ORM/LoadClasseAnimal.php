<?php

// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace VetoPlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use VetoPlatformBundle\Entity\ClasseAnimal;

class LoadClasseAnimal implements FixtureInterface, OrderedFixtureInterface {

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

    public function load(ObjectManager $manager) {


        // Liste des noms de Classe animal à ajouter
        $names = array(
            "Mammifère",
            "Oiseau",
            "Poisson",
            "Reptile"
        );

        foreach ($names as $name) {
            
            // On crée la classe animal
            $classe_animal = new ClasseAnimal();
            $classe_animal->setNom($name);

            // On la persiste
            $manager->persist($classe_animal);
        }


        // On déclenche l'enregistrement de toutes les classes

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}

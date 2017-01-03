<?php

// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace VetoPlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VetoPlatformBundle\Entity\ClasseAnimal;

class LoadClasseAnimal implements FixtureInterface {

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

    public function load(ObjectManager $manager) {
        // Animaux

        $classe_animal_1 = array("Mammifère");
        $classe_animal_2 = array("Oiseau");
        $classe_animal_3 = array("Poisson");
        $classe_animal_4 = array("Reptile");

        // Liste des animaux à ajouter

        $classes_animal = array(
            $classe_animal_1,
            $classe_animal_2,
            $classe_animal_3,
            $classe_animal_4
        );


        foreach ($classes_animal as $tab_classe_animal) {

            // On crée l'animal

            $classe_animal = new ClasseAnimal();

            $classe_animal->setNom($tab_classe_animal[0]);


            // On le persiste

            $manager->persist($classe_animal);
        }


        // On déclenche l'enregistrement de tous les animaux

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}

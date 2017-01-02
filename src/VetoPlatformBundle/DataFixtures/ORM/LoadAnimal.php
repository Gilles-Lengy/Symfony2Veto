<?php

// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace VetoPlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VetoPlatformBundle\Entity\Animal;

class LoadAnimal implements FixtureInterface {

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

    public function load(ObjectManager $manager) {
        // Animaux

        $animal_1 = array("Minou", NULL, "Chat recueilli fin Novembre par Gilles Lengy");
        $animal_2 = array("Minette", new \Datetime("2015-12-13 00:00:00"), "A stériliser");
        $animal_3 = array("Belle", new \Datetime("1974-12-13 00:00:00"), "Chienne décédée");
        $animal_4 = array("Boule de poil", NULL, "Hamster achetée dans une animalerie tout bébé");

        // Liste des animaux à ajouter

        $animaux = array(
            $animal_1,
            $animal_2,
            $animal_3,
            $animal_4
        );


        foreach ($animaux as $tab_animal) {

            // On crée l'animal

            $animal = new Animal();

            $animal->setNom($tab_animal[0]);
            $animal->setDateNaissance($tab_animal[1]);
            $animal->setCommentaire($tab_animal[2]);


            // On le persiste

            $manager->persist($animal);
        }


        // On déclenche l'enregistrement de tous les animaux

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}

<?php

// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace VetoPlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use VetoPlatformBundle\Entity\Animal;

class LoadAnimal implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

    public function load(ObjectManager $manager) {

        // Classe Animal
        $em = $this->container->get('doctrine')->getEntityManager('default');

        $repository = $em->getRepository('VetoPlatformBundle:ClasseAnimal');

        $classe_animal_mammifere = $repository->findOneByNom('Mammifère');
        $classe_animal_oiseau = $repository->findOneByNom('Oiseau');

        // Animaux

        $animal_1 = array("Minou", NULL, "Chat recueilli fin Novembre par Gilles Lengy", $classe_animal_mammifere);
        $animal_2 = array("Minette", new \Datetime("2015-12-13 00:00:00"), "A stériliser", $classe_animal_mammifere);
        $animal_3 = array("Belle", new \Datetime("1974-12-13 00:00:00"), "Chienne décédée", $classe_animal_mammifere);
        $animal_4 = array("Boule de poil", NULL, "Hamster achetée dans une animalerie tout bébé", $classe_animal_mammifere);
        $animal_5 = array("Titi", NULL, "Gros minet le chasse", $classe_animal_oiseau);

        // Liste des animaux à ajouter

        $animaux = array(
            $animal_1,
            $animal_2,
            $animal_3,
            $animal_4,
            $animal_5
        );


        foreach ($animaux as $tab_animal) {

            // On crée l'animal

            $animal = new Animal();

            $animal->setNom($tab_animal[0]);
            $animal->setDateNaissance($tab_animal[1]);
            $animal->setCommentaire($tab_animal[2]);
            $animal->setClasseAnimal($tab_animal[3]);





            // On le persiste

            $manager->persist($animal);
        }


        // On déclenche l'enregistrement de tous les animaux

        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}

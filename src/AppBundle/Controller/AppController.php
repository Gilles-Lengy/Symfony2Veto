<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VetoPlatformBundle\Entity\Animal;
use VetoPlatformBundle\Form\AnimalType;

class AppController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $listeAnimaux = $em->getRepository('VetoPlatformBundle:Animal')->findBy(
                array(), // Pas de critère
                array('dateMaj' => 'desc')
        );
        return $this->render('AppBundle:App:index.html.twig', array(
                    'listeAnimaux' => $listeAnimaux
        ));
    }

    public function viewAnimalAction($id) {
        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $animal = $em->getRepository('VetoPlatformBundle:Animal')->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id n'existe pas, d'où ce if :
        if (null === $animal) {
            throw new NotFoundHttpException("L'animal d'id " . $id . " n'existe pas.");
        }

        // On récupère la Classe Animal

        $classAnimal = $em->getRepository('VetoPlatformBundle:ClasseAnimal')->find($animal->getClasseAnimal());

        return $this->render('AppBundle:App:viewAnimal.html.twig', array(
                    'animal' => $animal,
                    'class_animal' => $classAnimal
        ));
    }

    public function addAnimalAction(Request $request) {
        // On crée un objet Animal
        $animal = new Animal();

        // On crée le FormBuilder grâce au service form factory
        //$form = $this->get('form.factory')->create(new AnimalType(), $animal);
        $form = $this->createForm(new AnimalType(), $animal);

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
        // (Nous verrons la validation des objets en détail dans le prochain chapitre)
        if ($form->isValid()) {
            // On l'enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Animal bien enregistré.');

            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirect($this->generateUrl('app_viewAnimal', array('id' => $animal->getId())));
        }

        // À ce stade, le formulaire n'est pas valide car :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
        return $this->render('AppBundle:App:addAnimal.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAnimalAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $animal = $em->getRepository('VetoPlatformBundle:Animal')->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id n'existe pas, d'où ce if :
        if (null === $animal) {
            throw new NotFoundHttpException("L'animal d'id " . $id . " n'existe pas.");
        }

        // On crée le FormBuilder grâce au service form factory
        //$form = $this->get('form.factory')->create(new AnimalType(), $animal);
        $form = $this->createForm(new AnimalType(), $animal);

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
        // (Nous verrons la validation des objets en détail dans le prochain chapitre)
        if ($form->isValid()) {
            // On l'enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Animal bien modifié.');

            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirect($this->generateUrl('app_viewAnimal', array('id' => $animal->getId())));
        }


        return $this->render('AppBundle:App:editAnimal.html.twig', array(
                    'animal' => $animal,
                    'form' => $form->createView()
        ));
    }

    public function deleteAnimalAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $animal = $em->getRepository('VetoPlatformBundle:Animal')->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id n'existe pas, d'où ce if :
        if (null === $animal) {
            throw new NotFoundHttpException("L'animal d'id " . $id . " n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($animal);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', "L'animal a bien été supprimé.");

            return $this->redirect($this->generateUrl('app_index'));
        }

        // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
        return $this->render('AppBundle:App:deleteAnimal.html.twig', array(
                    'animal' => $animal,
                    'form' => $form->createView()
        ));
    }

    public function menuAction($limit) {
        $em = $this->getDoctrine()->getManager();

        $listeAnimaux = $em->getRepository('VetoPlatformBundle:Animal')->findBy(
                array(), // Pas de critère
                array('dateMaj' => 'desc'), // On trie par date décroissante
                $limit, // On sélectionne $limit annonces
                0                        // À partir du premier
        );

        return $this->render('AppBundle:App:menu.html.twig', array(
                    'listeAnimaux' => $listeAnimaux
        ));
    }

}

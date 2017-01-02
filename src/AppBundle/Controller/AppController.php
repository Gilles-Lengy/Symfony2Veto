<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller {

    public function indexAction() {
        return $this->render('AppBundle:App:index.html.twig');
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

        return $this->render('AppBundle:App:viewAnimal.html.twig', array(
                    'animal' => $animal,
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

        // Ici il faudra mettre la gestion du formulaire

        if ($request->isMethod('GET')) {// Attention, il faudra mettre POST lorsque ça sera un formulaire
            $em = $this->getDoctrine()->getManager();
            // On récupère l'animal

            $animal = $em->getRepository('VetoPlatformBundle:Animal')->find($id);

            $animal->setDateMaj(new \Datetime()); // ATTENTION Pensez à utiliser prepersite pour la date de maj
            // On le persiste

            $em->persist($animal);

            // On déclenche l'enregistrement de tous les animaux

            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Animal bien modifiée.');
            return $this->redirectToRoute('app_viewAnimal', array('id' => $animal->getId()));
        }


        return $this->render('AppBundle:App:editAnimal.html.twig', array(
                    'animal' => $animal,
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

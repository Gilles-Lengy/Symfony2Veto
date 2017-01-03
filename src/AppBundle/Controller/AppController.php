<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VetoPlatformBundle\Entity\Animal;

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

    public function addAnimalAction(Request $request) {
        // On crée un objet Animal
        $animal = new Animal();

        // On crée le FormBuilder grâce au service form factory
        $form = $this->get('form.factory')->createBuilder('form', $animal)
                ->add('nom', 'text')
                ->add('commentaire', 'textarea', array('required' => false))
                ->add('save', 'submit')
                ->getForm();

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

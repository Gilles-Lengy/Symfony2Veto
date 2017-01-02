<?php

namespace VetoPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VetoPlatformBundle:Default:index.html.twig');
    }
}

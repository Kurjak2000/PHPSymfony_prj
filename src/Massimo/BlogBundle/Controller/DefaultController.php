<?php

namespace Massimo\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($page)
    {
        return $this->render('MassimoBlogBundle:Default:index.html.twig', array('page' => $page));
    }
}

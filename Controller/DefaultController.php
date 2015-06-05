<?php

namespace Cogitoweb\ParametersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CogitowebParametersBundle:Default:index.html.twig', array('name' => $name));
    }
}

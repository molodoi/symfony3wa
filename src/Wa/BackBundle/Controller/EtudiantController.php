<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EtudiantController extends Controller
{

    public function indexAction($firstname, $lastname)
    {
        return $this->render('WaBackBundle:Etudiant:index.html.twig',
            array(
                'firstname' => $firstname,
                'lastname' => $lastname
            )
        );

    }

}

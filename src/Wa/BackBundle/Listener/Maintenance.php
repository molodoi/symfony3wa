<?php

namespace Wa\BackBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;

class Maintenance{

    private $twig;
    private $maintenance;
    private $environnement;

    public function __construct($twig, $maintenance, $environnement){
        $this->twig = $twig;
        $this->maintenance = $maintenance;
        $this->environnement = $environnement;
    }

    public function miseEnMaintenance(GetResponseEvent $event){
        //die(dump($this->maintenance, $this->environnement));
        if ($this->maintenance && $this->environnement === 'prod'){
            $contenuHTML = $this->twig->render('WaBackBundle:Others:maintenance.html.twig');
            $event->setResponse(new Response($contenuHTML, 503)); // contenu et code maintenance
            $event->stopPropagation();
        }
    }

}
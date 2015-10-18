<?php

namespace Wa\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wa\BackBundle\Entity\Chat;
use Wa\BackBundle\Form\ChatType;

/**
 * Marque controller.
 *
 */
class ChatController extends Controller {

    
    public function recentsMessagesChatAction() {
        
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('WaBackBundle:Chat')->findBy(
                array(), // Critere
                array('dateCreated' => 'desc'), // Tri
                5, //* Limite                           
                0
        );
        
        /*
        $formMessage = $this->createForm(
                new ChatType(), 
                    $messages, 
                    array(
                        'action' => $this->generateUrl('wa_back_homepage'),
                        'method' => 'POST'
                    )
                );
         * 
         */

        return $this->render('WaBackBundle:Chat:Partials/recents-messages-chat.html.twig', array(
            'messages' => $messages,
            //'formMessage' => $formMessage->createView()
        ));
        
        
    }

}

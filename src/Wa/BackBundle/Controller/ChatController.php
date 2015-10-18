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

    /**
     * Lists all Brand entities.
     *
     */
    public function recentsMessagesChatAction() {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('WaBackBundle:Chat')->findBy(
                array(), // Critere
                array('dateCreated' => 'desc'), // Tri
                5, //* Limite                           
                0
        );

        return $this->render('WaBackBundle:Chat:Partials/recents-messages-chat.html.twig', array(
                    'messages' => $messages,
                ));
    }

}

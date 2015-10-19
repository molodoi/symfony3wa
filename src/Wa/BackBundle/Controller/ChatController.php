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

    
    public function recentsMessagesChatAction(Request $request) {

        
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('WaBackBundle:Chat')->findBy(
                array(), // Critere
                array('dateCreated' => 'asc'), // Tri
                5, //* Limite                           
                0
        );

        $chat = new Chat();

        $formMessage = $this->createForm(
                new ChatType(),
                    $chat,
                    array(
                        'action' => $this->generateUrl('wa_back_chat_admin_form'),
                        'method' => 'POST'
                    )
                );

        $formMessage->handleRequest($request);

        if($formMessage->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($chat);

            $em->flush();

            return $this->redirectToRoute('wa_back_homepage');

        }


        return $this->render('WaBackBundle:Chat:Partials/recents-messages-chat.html.twig', array(
            'messages' => $messages,
            'formMessage' => $formMessage->createView()
        ));
        
    }

}

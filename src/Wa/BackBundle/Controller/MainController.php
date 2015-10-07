<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{

    public function adminAction()
    {
        $categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum \n suite du contenu",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "<strong>lorem</strong> ipsum",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];
        $products = [
            [
                "id" => 1,
                "title" => "Mon premier produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 10
            ],
            [
                "id" => 2,
                "title" => "Mon deuxième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 20
            ],
            [
                "id" => 3,
                "title" => "Mon troisième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 30
            ],
            [
                "id" => 4,
                "title" => "",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 410
            ],
        ];
        return $this->render('WaBackBundle:Main:admin.html.twig',
            array('categories' => $categories, 'products' => $products)
        );

    }

    public function contactAction(Request $request)
    {

        $formContact = $this->createFormBuilder()
            ->add('firstname', 'text',
                array(
                     'constraints' => array(
                         new Assert\NotBlank(array('message' => 'Champ obligatoire')),
                         new Assert\Length(['min' =>2,'minMessage'=>'attention'])
                     ),
                    'required' => true
                )
            )
            ->add('lastname', 'text',
                array(
                    'constraints' => array(
                        new Assert\NotBlank(array('message' => 'Champ obligatoire'))
                    ),
                    //active/désactive la validation html5 du navigateur sur 1 champ
                    'required' => true
                )
            )
            ->add('email', 'email',
                array(
                    'constraints' => array(
                        new Assert\NotBlank(array('message' => 'Champ obligatoire')),
                        new Assert\Email(array(
                            'message' => 'La valeur "{{ value }}" n\'est un email pas valide.',
                            'checkMX' => true,
                        ))
                    ),
                    //active/désactive la validation html5 du navigateur sur 1 champ
                    'required' => true
                )
            )
            ->add('content', 'textarea',
                array(
                    'constraints' => array(
                        new Assert\NotBlank(array('message' => 'Champ obligatoire')),
                        new Assert\Length(['min' => 10, 'max' => 100])
                    ),
                    //active/désactive la validation html5 du navigateur sur 1 champ
                    'required' => true
                )
            )
            ->add('envoyer', 'submit')
            ->getForm();

        $formContact->handleRequest($request);

        if($formContact->isValid()){

            $data = $formContact->getData();
            $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('lamerant.matthieu@gmail.com')
                ->setTo('lamerant.matthieu@gmail.com')
                ->setBody(
                    $this->renderView(
                        'WaBackBundle:Emails:registration.html.twig',
                        array('data' => $data)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            $session = $request->getSession();
            $session->getFlashBag()->add('info', 'Votre email a bien été envoyé!');

            return $this->redirectToRoute('wa_back_contact');
        }

        return $this->render('WaBackBundle:Main:contact.html.twig', array('formContact' => $formContact->createView()));

    }

    public function feedbackAction(Request $request)
    {
        $formFeedBack = $this->createFormBuilder()
            ->add('url', 'url')
            ->add('statut', 'choice', array(
                'choices'  => array('urgent' => 'Urgent', 'important' => 'Important', 'normal' => 'Normal'),
                'preferred_choices' => array('normal'),
                'constraints' => array(
                    new Assert\Choice(array(
                        'choices' => array('urgent', 'important', 'normal' ),
                        'message' => 'Choisir un statut valide.',
                    ))
                )
            ))
            ->add('firstname', 'text')
            ->add('email', 'email')
            ->add('date', 'date', array(
                'years' => range(date('Y') -1, date('Y')),
                'format' => 'dd MM yyyy',
                'constraints' => array(
                    new Assert\Date(
                        array('message' => 'Date invalide')
                    )
                ),
            ))
            ->add('envoyer', 'submit')
            ->getForm();

            $formFeedBack->handleRequest($request);
            if($formFeedBack->isValid()){
                $data = $formFeedBack->getData();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Thanks Feedback')
                    ->setFrom('lamerant.matthieu@gmail.com')
                    ->setTo('lamerant.matthieu@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'WaBackBundle:Emails:thanks-feedback.html.twig',
                            array('data' => $data)
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);
                $session = $request->getSession();
                $session->getFlashBag()->add('info', 'Merci pour votre feedback. Un email vous a été envoyé!');

                return $this->redirectToRoute('wa_back_tanks_feedback');
            }

        return $this->render('WaBackBundle:Main:feedback.html.twig', array('formFeedBack' => $formFeedBack->createView()));

    }

    public function thanksFeedbackAction(){
        return $this->render('WaBackBundle:Main:thanks-feedback.html.twig');
    }


    public function aboutAction()
    {
        return $this->render('WaBackBundle:Main:about.html.twig');

    }

}

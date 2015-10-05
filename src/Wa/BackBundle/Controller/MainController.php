<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

    public function contactAction()
    {
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

        $matt = "Matthieu";
        $lame = "Lamerant";


        return $this->render('WaBackBundle:Main:contact.html.twig', array('products' => $products, 'matt'=> $matt, 'lame' => $lame));

    }

    public function aboutAction()
    {
        return $this->render('WaBackBundle:Main:about.html.twig');

    }

}

<?php

namespace Wa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Wa\BackBundle\Entity\Product;
use Wa\BackBundle\Entity\Comment;
use Wa\BackBundle\Form\ProductType;
use Wa\BackBundle\Form\CommentType;

//use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function createAction(Request $request){

        $product = new Product();

        $form = $this->createForm(new ProductType(), $product);

        $form->handleRequest($request);

        if($form->isValid()){

            //$em = $this->get("doctrine");

            $em = $this->getDoctrine()->getManager();

            $em->persist($product);

            $em->flush();

            $session = $request->getSession();

            $session->getFlashBag()->add('info', 'Produit ajouté');

            return $this->redirectToRoute('wa_back_product_list');

        }

        return $this->render('WaBackBundle:Product:create.html.twig',
            array(
                'formProduct' => $form->createView()
            ));
    }
    

    public function editAction($id, Request $request){

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Product')
        ;

        $product = $repository->find($id);

        if (!$product) {
            throw new NotFoundHttpException("Le produit id ".$id." n'existe pas.");
        }

        $formProduct = $form = $this->createForm(new ProductType(), $product);

        $formProduct->handleRequest($request);

        if($formProduct->isValid()){
            //$em = $this->get("doctrine");
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $session = $request->getSession();

            $session->getFlashBag()->add('info', $product->getTitle(). ' modifié');

            return $this->redirect($this->generateUrl('wa_back_product_edit',
                array('produit' => $product, 'id' => $id)
            ));

        }

        return $this->render('WaBackBundle:Product:create.html.twig',
            array(
                'formProduct' => $formProduct->createView(),
                'produit' => $product
            )
        );
    }
    

    public function listAction(){
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('WaBackBundle:Product');

        //$products = $repository->findAll();
        $products = $repository->findAllProductsWithCategories();

        if (null === $products) {
            throw new NotFoundHttpException("Aucuns produits.");
        }

        return $this->render('WaBackBundle:Product:list.html.twig', array('products' => $products));
    }
    

    public function showAction(Product $product, Request $request){
        //$em = $this->getDoctrine()->getManager();

        //$product = $em->getRepository('WaBackBundle:Product')->find($id); 

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }
        
        $repository = $this->getDoctrine()->getManager()->getRepository('WaBackBundle:Comment');
        $comments = $repository->findBy(
                        array('product' => $product),       // Critere
                        array('dateCreated' => 'DESC'),   // Tri
                        5,   // Limite                               
                        0
                    );
        
        $formComment = $form = $this->createForm(new \Wa\BackBundle\Form\CommentType());
        
        $formComment->handleRequest($request);

        if($formComment->isValid() && $request->isMethod('POST')){
            //$em = $this->get("doctrine");
            $em = $this->getDoctrine()->getManager();
            
            $mycomment = $formComment->getData();
            
            $comment = new Comment();
            $comment->setContent($mycomment->getContent());
            $comment->setProduct($product);
            
            $em->persist($comment); 
            $em->flush();

            $session = $request->getSession();

            $session->getFlashBag()->add('info', $product->getTitle(). ' modifié');

            
            return $this->redirect($this->generateUrl('wa_back_product_show',
                array(
                    'id' => $product->getId()
                )
            ));

        }

        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('WaBackBundle:Product:show.html.twig', array(
            'produit' => $product,
            'comments' => $comments,
            'formComment' => $formComment->createView()
        ));
    }
    

    public function deleteAction(Request $request, $id)
    {
        //$form = $this->createDeleteForm($id);

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('WaBackBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $em->remove($product);
        $em->flush();

        if($request->isXmlHttpRequest()){
            return new JsonResponse(array('success' => true));
        }

        $session = $request->getSession();
        $session->getFlashBag()->add('info', $product->getTitle(). ' supprimé');

        return $this->redirectToRoute('wa_back_product_list');
    }


    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('WaBackBundle:Product')->findAllPerso();
        //$products = $em->getRepository('WaBackBundle:Product')->getProductsWhereCategorieIsAccueil();
        //$products = $em->getRepository('WaBackBundle:Product')->getProductsDontHaveCategorie();
        //$products = $em->getRepository('WaBackBundle:Product')->getProductsDontCatButBrand();
        //$products = $em->getRepository('WaBackBundle:Product')->getCountProductsByCategorie();
        //$products = $em->getRepository('WaBackBundle:Product')->getProductPriceMaxByActiveCategorie();
        //$catges = $em->getRepository('WaBackBundle:Category')->getCategoriesWithoutImage();
        //$products = $em->getRepository('WaBackBundle:Category')->getImageCaptionWherePositionIsMax();
        //$products = $em->getRepository('WaBackBundle:Category')->getCategorieWhereMaxlenghtCaption();



        return $this->render('WaBackBundle:Product:index.html.twig', array(
            'products' => $products
        ));
    }

    /*
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wa_back_product_delete', array('id' => $id)))
            ->getForm()
            ;
    }
    */
    
    
    public function recentlyAddedProductsAction(){
        $em = $this->getDoctrine()->getManager();
        
        $products = $em->getRepository('WaBackBundle:Product')->findBy(
                        array(),       // Critere
                        array('dateCreated' => 'desc'),    // Tri
                        5,      //* Limite                           
                        0 
                    );
        
        return $this->render('WaBackBundle:Product:Partials/recents-products.html.twig', array(
            'products' => $products
        ));
    }

}

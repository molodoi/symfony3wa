<?php
namespace Wa\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Wa\BackBundle\Entity\User;
use Wa\BackBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends BaseController{

    public function createAction(Request $request){

        $user = new User();

        $formUser = $this->createForm(new UserType(), $user);

        $formUser->handleRequest($request);

        $formUser->get('password')->getData();

        if($formUser->isValid()){

            //die(dump($formUser->get('password')->getData()));
            $em = $this->getDoctrine()->getManager();

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);

            $password = $formUser->get('password')->getData();

            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

            $em->persist($user);

            $em->flush();

            return $this->redirectToRoute('wa_back_user_create');

        }

        return $this->render('WaBackBundle:User:create.html.twig',
            array(
                'formUser' => $formUser->createView()
            )
        );
    }

    public function editAction(User $user, Request $request){

        if (!$user) {
            throw new NotFoundHttpException("Le user id n'existe pas.");
        }

        $formUser = $this->createForm(new UserType(), $user);

        $formUser->handleRequest($request);

        $formUser->get('password')->getData();

        if($formUser->isValid()){

            $em = $this->getDoctrine()->getManager();

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);

            $password = $formUser->get('password')->getData();

            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

            $em->persist($user);

            $em->flush();

            return $this->redirectToRoute('wa_back_user_edit');

        }

        return $this->render('WaBackBundle:User:edit.html.twig',
            array(
                'formUser' => $formUser->createView()
            )
        );
    }


}
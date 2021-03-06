<?php
namespace Wa\BackBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Wa\BackBundle\Entity\Brand;
use Wa\BackBundle\Entity\Tag;
use Wa\BackBundle\Form\BrandType;
/**
 * Marque controller.
 *
 */
class BrandController extends BaseController
{
    /**
     * Lists all Brand entities.
     *
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $allEntities = $em->getRepository('WaBackBundle:Brand')->allBrandsTags();

        if (null === $allEntities) {
            throw new NotFoundHttpException("Aucuns marques.");
        }

        if(empty($page)){
            $page = $request->query->getInt('page', 1);
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $allEntities,
            $page,
            5
        );
        return $this->render('WaBackBundle:Brand:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Brand entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Brand();
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('wa_back_brand_show', array('id' => $entity->getId())));
        }
        return $this->render('WaBackBundle:Brand:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Creates a form to create a Brand entity.
     *
     * @param Brand $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Brand $entity)
    {
        $form = $this->createForm(new BrandType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('wa_back_brand_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }
    /**
     * Displays a form to create a new Brand entity.
     *
     */
    public function newAction()
    {
        $entity = new Brand();
        $form   = $this->createCreateForm($entity);
        return $this->render('WaBackBundle:Brand:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Finds and displays a Brand entity.
     * @ParamConverter("brand", class="WaBackBundle:Brand", options={"mapping": {"id" = "id"}})
     *
     */
    public function showAction(Brand $brand)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WaBackBundle:Brand')->findOneById($brand->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());

        return $this->render('WaBackBundle:Brand:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing Brand entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('WaBackBundle:Brand')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('WaBackBundle:Brand:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Creates a form to edit a Brand entity.
     *
     * @param Brand $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Brand $entity)
    {
        $form = $this->createForm(new BrandType(), $entity, array(
            'action' => $this->generateUrl('wa_back_brand_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Update'));
        return $form;
    }
    /**
     * Edits an existing Brand entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('WaBackBundle:Brand')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('wa_back_brand_edit', array('id' => $id)));
        }
        return $this->render('WaBackBundle:Brand:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Brand entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('WaBackBundle:Brand')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('wa_back_brand'));
    }
    /**
     * Creates a form to delete a Brand entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wa_back_brand_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }



}
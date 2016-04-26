<?php

namespace NoticeBoardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NoticeBoardBundle\Entity\Category;
use NoticeBoardBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/admin/category")
 */
class CategoryController extends Controller {

    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_category")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('NoticeBoardBundle:Category')->findAll();

        if (!($this->getUser()->hasRole('ROLE_ADMIN'))) {
            throw $this->createAccessDeniedException('Access denied');
        }

        return array(
            'categories' => $category,
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/", name="admin_category_create")
     * @Method("POST")
     * @Template("NoticeBoardBundle:Category:new.html.twig")
     */
    public function createAction(Request $request) {
        $category = new Category();
        $form = $this->createCreateForm($category);
        $form->handleRequest($request);

        if (!($this->getUser()->hasRole('ROLE_ADMIN'))) {
            throw $this->createAccessDeniedException('Access denied');
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);

            $em->flush();

            return $this->redirect($this->generateUrl('admin_category_show', array('id' => $category->getId())));
        }

        return array(
            'category' => $category,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity) {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit',  array(
            'label' => 'Dodaj',
            'attr' => array(
                'class' => 'btn btn-success btn-xs',
            )));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="admin_category_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $category = new Category();
        $form = $this->createCreateForm($category);

        if (!($this->getUser()->hasRole('ROLE_ADMIN'))) {
            throw $this->createAccessDeniedException('Access denied');
        }

        return array(
            'category' => $category,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_category_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('NoticeBoardBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        if (!($this->getUser()->hasRole('ROLE_ADMIN'))) {
            throw $this->createAccessDeniedException('Access denied');
        }

        $editForm = $this->createEditForm($category);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Category $entity) {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit',  array(
            'label' => 'Aktualizuj',
            'attr' => array(
                'class' => 'btn btn-success btn-xs',
            )));

        return $form;
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}", name="admin_category_update")
     * @Method("PUT")
     * @Template("NoticeBoardBundle:Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('NoticeBoardBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        if (!($this->getUser()->hasRole('ROLE_ADMIN'))) {
            throw $this->createAccessDeniedException('Access denied');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($category);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_category_edit', array('id' => $id)));
        }

        return array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="admin_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('NoticeBoardBundle:Category')->find($id);

            if (!$category) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            if (!($this->getUser()->hasRole('ROLE_ADMIN'))) {
                throw $this->createAccessDeniedException('Access denied');
            }

            $em->remove($category);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_category'));
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit',  array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'btn btn-success btn-xs confirm',
                )))
            ->getForm();
    }
}

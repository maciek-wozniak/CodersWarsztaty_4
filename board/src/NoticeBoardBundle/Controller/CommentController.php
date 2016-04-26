<?php

namespace NoticeBoardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NoticeBoardBundle\Entity\Comment;
use NoticeBoardBundle\Form\CommentType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Comment controller.
 *
 * @Route("/comment")
 */
class CommentController extends Controller {

    /**
     * Creates a new Comment entity.
     *
     * @Route("/new/{noticeId}", name="comment_create")
     * @Method("POST")
     * @Template("NoticeBoardBundle:Comment:new.html.twig")
     *
     */
    public function createAction(Request $request, $noticeId) {
        $repo = $this->getDoctrine()->getRepository('NoticeBoardBundle:Notice');
        $notice = $repo->find($noticeId);

        if (!$notice) {
            throw $this->createNotFoundException('No such notice');
        }

        $user = $this->getUser();

        $comment = new Comment();
        $comment->setNotice($notice);

        $form = $this->createCreateForm($comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $notice->addComment($comment);

            $date = new \DateTime();
            $comment->setCreationDate($date);
            $comment->setNotice($notice);
            if ($user) {
                $comment->setUser($user);
            }

            $em->persist($notice);
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('notice_show', array('id' => $notice->getId())));
        }

        return array(
            'notice' => $notice,
            'comment' => $comment,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Comment entity.
     *
     * @param Comment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Comment $comment) {

        $form = $this->createForm(new CommentType(), $comment, array(
            'action' => $this->generateUrl('comment_create', ['noticeId' => $comment->getNotice()->getId()]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
                'label' => 'Dodaj',
                'attr' => array(
                    'class' => 'btn btn-default btn-xs',
                )));

        return $form;
    }

    /**
     * Displays a form to create a new Comment entity.
     *
     * @Route("/new/{noticeId}", name="comment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($noticeId) {
        $repo = $this->getDoctrine()->getRepository('NoticeBoardBundle:Notice');
        $notice = $repo->find($noticeId);

        if (!$notice) {
            throw $this->createNotFoundException('No such notice');
        }

        $comment = new Comment();
        $comment->setNotice($notice);
        $form = $this->createCreateForm($comment);

        return array(
            'notice' => $notice,
            'comment' => $comment,
            'form' => $form->createView(),
        );
    }

    /**
     * Deletes a Comment entity.
     *
     * @Route("/{id}/notice/{noticeId}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id, $noticeId) {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('NoticeBoardBundle:Comment')->find($id);
        $notice = $em->getRepository('NoticeBoardBundle:Notice')->find($noticeId);

        if (!$comment) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }

        if (!($notice->getUser() === $this->getUser() || $this->getUser()->hasRole('ROLE_ADMIN'))) {
            throw $this->createAccessDeniedException('Access denied');
        }

        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('notice_show', ['id' => $noticeId]);
    }

}

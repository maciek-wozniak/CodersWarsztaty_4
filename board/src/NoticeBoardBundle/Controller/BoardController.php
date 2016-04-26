<?php

namespace NoticeBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class BoardController extends Controller {

    /**
     * @Route("/")
     * @Template("NoticeBoardBundle:Notice:index.html.twig")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:Notice');
        $notices = $repository->findNotExpiredNotices();

        return ['notices' => $notices ];
    }

    public function showCategoriesMenuAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('NoticeBoardBundle:Category')->findAll();

        $html = '';
        if (!$categories) {
            $html .='<li><a href="/">Brak</a></li>';
        }

        foreach ($categories as $category) {
            $html .= '<li><a href="/category/'.$category->getId().'">'.$category->getName().'</a></li>';
        }

        return new Response($html);
    }

    /**
     * @Route("/category/{categoryId}")
     * @Template("NoticeBoardBundle:Notice:index.html.twig")
     */
    public function showNoticesByCategory($categoryId) {
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:Category');
        $category = $repository->find($categoryId);
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:Notice');
        $notices = $repository->findNotExpiredNoticesById($categoryId);

        return ['notices' => $notices, 'category' => strtolower($category->getName())];
    }

    /**
     * @Route("/notice/user/{userId}")
     * @Template("NoticeBoardBundle:Notice:index.html.twig")
     */
    public function showUserNotices($userId) {
        if ($userId != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException('Cant display not yours notices');
        }
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:Notice');
        $notices = $repository->findNotExpiredNoticesByUser($userId);

        return ['notices' => $notices];
    }

    /**
     * @Route("/notice/user/{userId}/expired")
     * @Template("NoticeBoardBundle:Notice:index.html.twig")
     */
    public function showExpiredUserNotices($userId) {
        if ($userId != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException('Cant display not yours notices');
        }
        $repository = $this->getDoctrine()->getRepository('NoticeBoardBundle:Notice');
        $notices = $repository->findExpiredNoticesByUser($userId);

        return ['notices' => $notices];
    }

}

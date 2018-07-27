<?php

namespace SnowTricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use SnowTricksBundle\Entity\Trick;
use SnowTricksBundle\Form\Type\TrickType;
use SnowTricksBundle\Entity\Comment;
use SnowTricksBundle\Form\Type\CommentType;

class TrickController extends Controller
{
    /**
     * @Route("/{page}", name="trick_list", requirements={"page"="\d+"})
     * @Method({"GET"})
     */
    public function listAction($page = 1)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('The page '.$page.' does not exist.');
        }

        $nbPerPage = 12;

        $em = $this->getDoctrine()->getManager();
        $listTricks = $em->getRepository(Trick::class)->getTricks($page, $nbPerPage);

        $nbPages = ceil(count($listTricks) / $nbPerPage);

        if ($page > $nbPages) {
            throw new NotFoundHttpException('The page '.$page.' does not exist.');
        }

        return $this->render('Trick/home.html.twig', array(
            'listTricks' => $listTricks,
            'nbPages'    => $nbPages,
            'page'       => $page,
        ));
    }  

    /**
     * @Route("/trick/{slug}", name="trick_show", requirements={"slug"="[a-z0-9-]{2,}"})
     * @Method({"GET", "POST"})
     */
    public function trickAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository(Trick::class)->findOneBySlug($slug);

        if (null === $trick) {
            throw new NotFoundHttpException("The trick ". $slug ." does not exist.");
        }

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            if ( ! $this->isGranted('ROLE_AUTHOR')) {
                $this->denyAccessUnlessGranted('ROLE_AUTHOR', null, 'Limited access to authors.');
            }
            $user = $this->getUser();
            $comment->setUser($user);
            $comment->setTrick($trick);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('notice', "Your comment has been successfully added.");
            return $this->redirectToRoute('trick_show', array('slug' => $trick->getSlug()));
        }

        return $this->render('Trick/trick.html.twig', array(
            'trick' => $trick,
            'form'  => $form->createView(),
        ));
    } 

    /**
     * @Route("/add", name="trick_add")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            $this->addFlash('notice', "Your trick has been successfully added.");
            return $this->redirectToRoute('trick_show', array('slug' => $trick->getSlug()));
        }

        return $this->render('Trick/add.html.twig', array(
        	'form' => $form->createView(),
        ));
    } 

    /**
     * @Route("/edit/{slug}", name="trick_edit", requirements={"slug"="[a-z0-9-]{2,}"})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository(Trick::class)->findOneBySlug($slug);

        if (null === $trick) {
            throw new NotFoundHttpException("This trick ". $slug ." doesn't exist !");
        }

        $form = $this->createForm(TrickType::class, $trick);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $trick->setUpdated(new \Datetime("now", new \DateTimeZone('Europe/Paris')));
            $em->flush();

            $this->addFlash('notice', "Your trick has been successfully updated.");
            return $this->redirectToRoute('trick_show', array('slug' => $trick->getSlug()));
        }

        return $this->render('Trick/edit.html.twig', array(
            'trick' => $trick,
            'form'  => $form->createView(),
        ));
    } 

    /**
     * @Route("/delete/{slug}", name="trick_delete", requirements={"slug"="[a-z0-9-]{2,}"})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function deleteAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository(Trick::class)->findOneBySlug($slug);

        if (null === $trick) {
            throw new NotFoundHttpException("This trick ". $slug ." doesn't exist !");
        }

        $submittedToken = $request->request->get('token');
        if ( ! $this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $this->addFlash('notice', "The CSRF token is invalid. Please try to repeat the action");
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        } 

        $em->remove($trick);
        $em->flush();
        $this->addFlash('notice', "Your trick has been successfully deleted.");

        return $this->redirectToRoute('trick_list');
    }   
}

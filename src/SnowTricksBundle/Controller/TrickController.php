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

use SnowTricksBundle\Entity\Picture;
use SnowTricksBundle\Form\Type\PictureType;

use SnowTricksBundle\Entity\Video;
use SnowTricksBundle\Form\Type\VideoType;

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
     * @Method({"GET"})
     */
    public function trickAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository(Trick::class)->findOneBySlug($slug);

        if (null === $trick) {
            throw new NotFoundHttpException("The trick ". $slug ." does not exist.");
        }

        return $this->render('Trick/trick.html.twig', array(
            'trick' => $trick
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

            $this->addFlash('notice', "Your Trick has been successfully added.");
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

            $this->addFlash('notice', "Your Trick has been successfully updated.");
            return $this->redirectToRoute('trick_show', array('slug' => $trick->getSlug()));
        }

        return $this->render('Trick/edit.html.twig', array(
            'trick' => $trick,
            'form'  => $form->createView(),
        ));
    } 

    /**
     * @Route("/delete/{slug}", name="trick_delete", requirements={"slug"="[a-z0-9-]{2,}"})
     * @Method({"GET"})
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function deleteAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository(Trick::class)->findOneBySlug($slug);

        if (null === $trick) {
            throw new NotFoundHttpException("This trick ". $slug ." doesn't exist !");
        }

        $em->remove($trick);
        $em->flush();

        $this->addFlash('notice'," Your Trick has been successfully deleted.");

        return $this->redirectToRoute('trick_list');
    }   
}

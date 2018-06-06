<?php

namespace SnowTricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use SnowTricksBundle\Entity\Trick;
use SnowTricksBundle\Form\TrickType;

class TrickController extends Controller
{
    /**
     * @Route("/{page}", name="trick_list", requirements={"page"="\d+"})
     */
    public function listAction($page = 1)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page '.$page.' does not exist.');
        }

        $em = $this->getDoctrine()->getManager();
        $listTricks = $em->getRepository(Trick::class)->findAll();

        return $this->render('@SnowTricks/Trick/home.html.twig', array(
            'listTricks' => $listTricks,
            'page'       => $page
        ));
    }  

    /**
     * @Route("/trick/{slug}", name="trick_show")
     */
    public function trickAction(Trick $trick)
    {
        return $this->render('@SnowTricks/Trick/trick.html.twig', array(
            'trick' => $trick
        ));
    } 

    /**
     * @Route("/add", name="trick_add")
     */
    public function addAction(Request $request)
    {
    	$trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Trick saved.');
            return $this->redirectToRoute('snow_tricks_homepage');
        }

        return $this->render('@SnowTricks/Trick/add.html.twig', array(
        	'form' => $form->createView(),
        ));
    } 

    /**
     * @Route("/edit/{slug}", name="trick_edit")
     */
    public function editAction(Request $request, Trick $trick)
    {
        $form = $this->createForm(TrickType::class, $trick);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', $trick->getName().' modified.');
            return $this->redirectToRoute('snow_tricks_homepage');
        }

        return $this->render('@SnowTricks/Trick/edit.html.twig', array(
            'form' => $form->createView()
        ));
    } 

    /**
     * @Route("/delete/{slug", name="trick_delete")
     */
    public function deleteAction(Request $request, Trick $trick)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($trick);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Trick deleted.');

        return $this->redirectToRoute('snow_tricks_homepage');
    }   
}

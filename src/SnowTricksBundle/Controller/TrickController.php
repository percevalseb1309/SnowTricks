<?php

namespace SnowTricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use SnowTricksBundle\Entity\Trick;
use SnowTricksBundle\Form\TrickType;

class TrickController extends Controller
{
    public function indexAction()
    {
        return $this->render('@SnowTricks/Trick/home.html.twig');
    }  

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
}

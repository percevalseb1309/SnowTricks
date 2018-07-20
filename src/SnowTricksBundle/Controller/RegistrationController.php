<?php

namespace SnowTricksBundle\Controller;

use SnowTricksBundle\Form\Type\UserType;
use SnowTricksBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $passwordEncoder = $this->get('security.password_encoder');
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $token = new UsernamePasswordToken($user, $password, 'main', $user->getRoles());

            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            $this->addFlash('notice', 'You are now successfully registered !');

            return $this->redirectToRoute('trick_list');
        }

        return $this->render('User/register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

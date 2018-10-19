<?php

namespace SnowTricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use SnowTricksBundle\Entity\User;
use SnowTricksBundle\Form\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('User/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    private function randomPassword($max = 8) 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < $max; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); 
    }

    /**
     * @Route("/reset_password", name="resetPassword")
     * @Method({"GET", "POST"})
     */
    public function resetPasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $form = $this->createFormBuilder()
            ->add('login', TextType::class, array(
               'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 2, 'max' => 64)),
                )
            ))
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ( ! array_key_exists("login", $data)) {
                throw new NotFoundHttpException("No login given");
            }
            $login = $data["login"];

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->loadUserByUsername($login);

            if (null === $user) {
                $this->addFlash('error', "Invalid login.");
                return $this->redirectToRoute('resetPassword');
            }

            // $password = random_bytes(10);
            $password = $this->randomPassword();
            $passwordEncoded = $passwordEncoder->encodePassword($user, $password);
            $user->setPassword($passwordEncoded);
            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('Snowtricks website : Your new password !'))
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($user->getEmail())
                // ->setTo('percevalseb@gmail.com')
                ->setBody(
                    $this->renderView(
                        'Email/newpassword.html.twig',
                        array(
                            'username' => $user->getUsername(),
                            'password' => $password
                        )
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', "an email with a new password has been sent to you");
            // $this->addFlash('success', "Here is your new password : ".$password);
            return $this->redirectToRoute('login');
        }

        return $this->render('User/resetpassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }
}

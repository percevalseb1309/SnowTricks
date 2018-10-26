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
use SnowTricksBundle\Service\Mailer;
use SnowTricksBundle\Form\Type\ForgotPasswordType;
use SnowTricksBundle\Form\Type\ResetPasswordType;


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

    /**
     * @Route("/forgot_password", name="forgot_password")
     * @Method({"GET", "POST"})
     */
    public function forgotPasswordAction(Request $request, Mailer $mailer)
    {
        $form = $this->createForm(ForgotPasswordType::class);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $login = $data["login"];

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->loadUserByUsername($login);

            if (null !== $user) {
                $token = uniqid();
                $user->setToken($token);
                $em->persist($user);
                $em->flush();

                $mailer->sendMessage($user, $token);

                $this->addFlash('success', "A password reset email has been sent to you.");
                return $this->redirectToRoute('forgot_password');
            }

            $this->addFlash('error', "Invalid login.");
        }

        return $this->render('User/forgot-password.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/reset_password", name="reset_password")
     * @Method({"GET", "POST"})
     */
    public function resetPasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $token = $request->query->get('token');
        if (null !== $token) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByToken($token);
            if (null !== $user) {
                $form = $this->createForm(ResetPasswordType::class);

                if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                    $data = $form->getData();
                    $plainPassword = $data["plainPassword"];
                    $user->setPlainPassword($plainPassword);
                    $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                    $user->setPassword($password);
                    $user->setToken(NULL);
                    $em->flush();

                    $this->addFlash('success', 'Your password has been reset successfully');
                    return $this->redirectToRoute('login');
                }

                return $this->render('User/reset-password.html.twig', array(
                    'form' => $form->createView(),
                ));
            }
        }

        $this->addFlash('warning', "The URL is invalid. Please try to repeat the action");
        return $this->redirectToRoute('forgot_password');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }
}

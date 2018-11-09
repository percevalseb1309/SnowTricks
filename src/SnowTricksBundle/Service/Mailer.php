<?php

namespace SnowTricksBundle\Service;

class Mailer
{
    private $templating;
    private $mailer;
    private $mailer_user;

    public function __construct(\Twig_Environment $templating, \Swift_Mailer $mailer, $mailer_user)
    {
        $this->templating  = $templating;
        $this->mailer      = $mailer;
        $this->mailer_user = $mailer_user;
    }

    public function sendMessage(\SnowTricksBundle\Entity\User $user, $token)
    {
        $message = (new \Swift_Message('Snowtricks website : Reset your password !'))
            ->setFrom([$this->mailer_user => 'SnowTricks'])
            ->setTo([$user->getEmail() => $user->getUsername()])
            ->setBody(
                $this->templating->render(
                    'Email/reset-password.html.twig',
                    array(
                        'username' => $user->getUsername(),
                        'token'    => $token
                    )
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}

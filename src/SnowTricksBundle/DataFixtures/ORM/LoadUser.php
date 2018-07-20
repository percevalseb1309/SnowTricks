<?php

namespace SnowTricksBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SnowTricksBundle\Entity\User;

class LoadUser implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');

        $listNames = array('Vanessa', 'Sebastien', 'Maelys', 'Antoine');

        foreach ($listNames as $name) {
            $user = new User;
            $user->setUsername($name);

            $name = strtolower($name);
            $user->setEmail($name.'@gmail.com');
            
            $encoded = $encoder->encodePassword($user, $name.'_pass');
            $user->setPassword($encoded);

            $user->setRoles(array('ROLE_USER'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
<?php

namespace SnowTricksBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SnowTricksBundle\Entity\User;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $listNames = array('Sebastien', 'Vanessa');

        foreach ($listNames as $name) {
            $user = new User;
            $user->setUsername($name);
            $user->setEmail(strtolower($name).'@gmail.com');
            $user->setPassword($name);
            $user->setSalt('');
            $user->setRoles(array('ROLE_USER'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
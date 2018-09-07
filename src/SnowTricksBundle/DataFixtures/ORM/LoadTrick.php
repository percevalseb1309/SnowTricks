<?php

namespace SnowTricksBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SnowTricksBundle\Entity\TricksGroup;
use SnowTricksBundle\Entity\Trick;

class LoadTrick implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = array(
            'Grabs' => array(
                'mute'         => "Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.",
                'sad'          => "Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.",
                'indy'         => "Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.",
                'stalefish'    => "Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.",
                'tail grab'    => "Saisie de la partie arrière de la planche, avec la main arrière.",
                'nose grab'    => "Saisie de la partie avant de la planche, avec la main avant.",
                'japan'        => "Saisie de l'avant de la planche, avec la main avant, du côté de la carre frontside.",
                'seat belt'    => "Saisie du carre frontside à l'arrière avec la main avant.",
                'truck driver' => "Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).",
            ),
            'Rotations' => array(
                '180'  => "Un 180 désigne un demi-tour, soit 180 degrés d'angle.",
                '360'  => "360, trois six pour un tour complet.",
                '540'  => "540, cinq quatre pour un tour et demi.",
                '720'  => "720, sept deux pour deux tours complets.",
                '900'  => "900 pour deux tours et demi.",
                '1080' => "1080 ou big foot pour trois tours.",
                '90'   => "Pour un quart de tour simple.",
                '270'  => "Pour trois quarts de tours.",
                '450'  => "Pour un tour un quart.",
                '630'  => "Pour un tour trois quarts.",
                '810'  => "Pour deux tours un quart.",
            ),
            'Flips' => array(
                // '' => "",
            ), 
            'Rotations désaxées' => array(
                // '' => "",
            ), 
            'Slides' => array(
                // '' => "",
            ), 
            'One foot tricks' => array(
                // '' => "",
            ), 
            'Old school' => array(
                // '' => "",
            ),
        );

        foreach ($data as $group => $tricks) {
            $tricksGroup = new TricksGroup();
            $tricksGroup->setName($group);
            $manager->persist($tricksGroup);
            foreach ($tricks as $trickName => $trickDescription) {
                $trick = new Trick();
                $trick->setName($trickName);
                $trick->setDescription($trickDescription);
                $trick->setTricksGroup($tricksGroup);
                $manager->persist($trick);
            }
        }
        $manager->flush();
    }
}

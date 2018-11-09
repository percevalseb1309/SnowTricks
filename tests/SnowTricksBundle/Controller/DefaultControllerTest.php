<?php

namespace Tests\SnowTricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function provideUrls()
    {
        return array(
            array('/1'),
            array('/trick/mute'),
            array('/login'),
            array('/forgot_password'),
            array('/register'),
        );
    }

    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/register');

        $form = $crawler->selectButton('snowtricksbundle_user_submit')->form();
        $form['snowtricksbundle_user[username]'] = 'John-Doe';
        $form['snowtricksbundle_user[email]'] = 'john.doe@gmail.com';
        $form['snowtricksbundle_user[plainPassword][first]'] = 'P3ssword';
        $form['snowtricksbundle_user[plainPassword][second]'] = 'P3ssword';
        $form['snowtricksbundle_user[termsAccepted]']->tick();

        $crawler = $client->submit($form);
    }
}

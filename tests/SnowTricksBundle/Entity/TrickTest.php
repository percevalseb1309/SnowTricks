<?php

namespace Tests\SnowTricksBundle\Entity;

use SnowTricksBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickTest extends WebTestCase
{
    private $trick;

    protected function setUp()
    {
        $this->trick = new Trick();
    }

    public function testName()
    {
        $name = 'SNOWBOARD FIGURE';
        $this->trick->setName($name);
        $this->assertGreaterThanOrEqual(2, strlen($this->trick->getName()));
        $this->assertLessThanOrEqual(64, strlen($this->trick->getName()));
        $this->assertEquals($name, $this->trick->getName());
    }

    public function testSlugify()
    {
        $this->trick->setName('SNOWBOARD FIGURE');
        $this->assertEquals('snowboard-figure', $this->trick->getSlug());
    }

    public function testDescription()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis quo, dolorum obcaecati, maxime rem ratione, doloremque, eaque sint praesentium illum omnis cum cumque alias distinctio! Aspernatur nobis, vel labore iste.';
        $this->trick->setDescription($description);
        $this->assertNotEmpty($description, $this->trick->getDescription());
        $this->assertEquals($description, $this->trick->getDescription());
    }

    protected function tearDown()
    {
        $this->trick = null;
    }
}

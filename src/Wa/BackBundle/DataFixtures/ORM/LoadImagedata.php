<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Wa\BackBundle\Entity\Image;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $image01 = new Image();
        $image01->setTitle($faker->text(10));
        $image01->setPath('561f8d29113a3.jpeg');
        $image01->setCaption($faker->text(10));
        $image01->setAlt($faker->text(10));

        $image02 = new Image();
        $image02->setTitle($faker->text(10));
        $image02->setPath('561f8d29113a3.jpeg');
        $image02->setCaption($faker->text(50));
        $image02->setAlt($faker->text(10));

        $manager->persist($image01);
        $manager->persist($image02);

        $manager->flush();

        $this->addReference('image', $image01 );

    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

}
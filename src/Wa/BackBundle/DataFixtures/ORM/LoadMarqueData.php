<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Wa\BackBundle\Entity\Marque;

class LoadMarqueData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $marque01 = new Marque();
        $marque01->setTitle($faker->text(10));

        $manager->persist($marque01);

        $manager->flush();

        $this->addReference('marque', $marque01 );

    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }

}
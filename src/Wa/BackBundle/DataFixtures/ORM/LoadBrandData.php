<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Wa\BackBundle\Entity\Brand;

class LoadBrandData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $marque01 = new Brand();
        $marque01->setTitle($faker->text(10));

        $manager->persist($marque01);

        $manager->flush();

        $this->addReference('brand', $marque01 );

    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }

}
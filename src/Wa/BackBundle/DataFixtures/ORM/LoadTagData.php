<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Wa\BackBundle\Entity\Tag;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');


        for ($i = 1; $i <= 25; $i++){
            $tag = new Tag();
            $tag->setTitle($faker->text(10));
            $manager->persist($tag);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

}
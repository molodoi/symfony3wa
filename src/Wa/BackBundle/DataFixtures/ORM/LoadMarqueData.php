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

                $marque01 = new Marque();
                $marque01->setTitle('Marque 01');

                $manager->persist($marque01);

                $manager->flush();

                $this>$this->addReference('marque', $marque01 );

    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

}
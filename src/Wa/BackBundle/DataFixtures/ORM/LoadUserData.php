<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Wa\BackBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $me = new User();
        $me->setFirstname('matt');
        $me->setLastname('matt');
        $me->setEmail('contact@ticme.fr');
        $me->setLogin('matt');
        $me->setPassword('matt');
        $me->setGender(1);
        $me->setAddress('36 rue réné clair');
        $me->setPhone('0000000000');

        $manager->persist($me);

        $manager->flush();

    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

}
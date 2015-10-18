<?php

namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Wa\BackBundle\Entity\Chat;

class LoadChatData extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 25; $i++) {
            $message = new Chat();
            $message->setContent($faker->text(120));

            $manager->persist($message);            
        }
        $manager->flush();
    }

    public function getOrder() {
        return 6; // the order in which fixtures will be loaded
    }

}
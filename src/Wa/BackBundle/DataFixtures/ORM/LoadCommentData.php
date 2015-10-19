<?php

namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Wa\BackBundle\Entity\Comment;
use Wa\BackBundle\Entity\Product;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        $faker = \Faker\Factory::create('fr_FR');

        $product = new Product();
        $product->setTitle($faker->text(10));
        $product->setDescription($faker->text(100));
        $product->setPrice($faker->randomFloat);
        $product->setQuantity($faker->randomDigitNotNull);
        $product->setCategory($this->getReference('category'));
        $product->setBrand($this->getReference('brand'));
        $product->setDateCreated(new \DateTime('NOW'));
        $manager->persist($product);

        for ($i = 1; $i <= 25; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->text(120) . ' ' . $i);
            $comment->setProduct($product);
            $comment->setAuthor($faker->firstName($gender = null|'male'|'female'));
            $comment->setNote($faker->numberBetween(0,5));
            $comment->setActive($faker->numberBetween(0,1));
            $comment->setDateCreated(new \DateTime('NOW'));
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getOrder() {
        return 4; // the order in which fixtures will be loaded
    }

}
<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Wa\BackBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 25; $i++){
            $product = new Product();
            $product->setTitle($faker->text(10).' '.$i);
            $product->setDescription($faker->text(100).' '.$i);
            $product->setPrice($faker->randomFloat(2,0,1000));
            $product->setQuantity($faker->randomNumber(2));
            $product->setCategory($this->getReference('category'));
            $product->setBrand($this->getReference('brand'));
            $product->setDateCreated(new \DateTime('NOW'));
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}
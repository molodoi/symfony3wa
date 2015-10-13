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


        for ($i = 1; $i <= 25; $i++){
            $product = new Product();
            $product->setTitle('Produit '.$i);
            $product->setDescription('Desc produit '.$i);
            $product->setPrice($i);
            $product->setQuantity($i);
            $product->setCategory($manager->merge($this->getReference('category')));
            $product->setDateCreated(new \DateTime('NOW'));
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
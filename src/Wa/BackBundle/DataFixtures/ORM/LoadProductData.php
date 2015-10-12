<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wa\BackBundle\Entity\Product;

class LoadProductData implements FixtureInterface
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
            $product->setDateCreated(new \DateTime('NOW'));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
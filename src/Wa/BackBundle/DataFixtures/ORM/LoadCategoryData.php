<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Wa\BackBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        $category01 = new Category();
        $category01->setTitle($faker->text(10));
        $category01->setDescription($faker->text(100));
        $category01->setPosition($faker->randomDigitNotNull);
        $category01->setActive($faker->numberBetween(0,1));
        $category01->setImageFixture($this->getReference('image'));

        $manager->persist($category01);

        $manager->flush();

        $this->addReference('category', $category01 );

        /*
          $product = new Product();
          $product->setTitle($faker->text(10));
          $product->setDescription($faker->text());
          $product->setQuantity($faker->randomDigitNotNull);
          $product->setPrice($faker->randomFloat));
          $product->setReference($faker->randomLetter);
          $product->setActivate($faker->numberBetween(0,1));
          $category=$this->getReference("categ");
          $product->setCategory($category);
        */

        /*
        for ($i = 1; $i <= 10; $i++){
            $category = new Category();
            $category->setTitle('Catégorie '.$i);
            $category->setDescription('Description '.$i);
            $category->setPosition($i);
            $category->setActive(1);
            $category->setDateCreated(new \Datetime('NOW'));
            $manager->persist($category);
        }

        $manager->flush();
         */
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

}
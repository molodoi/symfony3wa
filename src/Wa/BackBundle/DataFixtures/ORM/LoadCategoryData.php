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

                $category01 = new Category();
                $category01->setTitle('Categorie 01');
                $category01->setDescription('Description categorie 01');
                $category01->setPosition(1);
                $category01->setActive(1);

                $manager->persist($category01);

                $manager->flush();

                $this>$this->addReference('category', $category01 );

        /*

                for ($i = 1; $i <= 25; $i++){
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
        return 1; // the order in which fixtures will be loaded
    }

}
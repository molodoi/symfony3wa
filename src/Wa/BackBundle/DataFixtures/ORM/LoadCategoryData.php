<?php
namespace Wa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wa\BackBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
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
    }
}
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\CategorieArticle;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $list_cat = [];
        foreach ($list_cat as $value) {
            $cat = new CategorieArticle();
            $cat->setName($value);
            $manager->persist($cat);
        }
        $manager->flush();
    }
}

<?php


namespace App\DataFixtures;

use App\Entity\Promo;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PromoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $promoLE1 = new Promo();
        $promoLE1->setName("LE1");

        $manager->persist($promoLE1);
        $this->addReference("promo_LE1", $promoLE1);
        $manager->flush();
        $promoLE2 = new Promo();
        $promoLE2->setName("LE2");

        $manager->persist($promoLE2);
        $this->addReference("promo_LE2", $promoLE2);
        $manager->flush();
    }

}
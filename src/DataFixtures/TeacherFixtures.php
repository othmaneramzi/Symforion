<?php


namespace App\DataFixtures;
use App\Entity\Promo;
use App\Entity\Teacher;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class TeacherFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $promoLE1 = $this->getReference("promo_LE1");
        $promoLE2 = $this->getReference("promo_LE2");

        for ($i = 0; $i < 6; $i++) {
            $teacher = new Teacher();
            $teacher->setEmail($faker->email);
            $teacher->setPassword(password_hash("Prof123",PASSWORD_BCRYPT));
            $teacher->setLastname($faker->name());
            $teacher->setFirstname($faker->firstName());
            $teacher->addPromo($promoLE1);
            $teacher->addPromo($promoLE2);
            $teacher->setRoles(["ROLE_USER","ROLE_TEACHER"]);

            $manager->persist($teacher);
            $this->addReference("teacher_$i", $teacher);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PromoFixtures::class,
        ];
    }
}
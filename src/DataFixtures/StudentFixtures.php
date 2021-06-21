<?php


namespace App\DataFixtures;
use App\Entity\Student;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class StudentFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $promoLE1 = $this->getReference("promo_LE1");
        $promoLE2 = $this->getReference("promo_LE2");

        for ($i = 0; $i < 40; $i++) {
            $student = new Student();
            $student->setEmail($faker->email);
            $student->setPassword(password_hash("Eleve123",PASSWORD_BCRYPT));
            $student->setLastname($faker->name());
            $student->setFirstname($faker->firstName());
            $student->setPromo(($i%2 == 0) ? $promoLE1 : $promoLE2);
            $student->setRoles(["ROLE_USER","ROLE_STUDENT"]);
            $manager->persist($student);
            $this->addReference("student_$i",$student);
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

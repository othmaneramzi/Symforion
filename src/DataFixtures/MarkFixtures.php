<?php


namespace App\DataFixtures;


use App\Entity\Mark;
use App\Entity\Student;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MarkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $subjectsName = ['Mathématiques', 'Mécanique', 'Algorithmie', 'SDA', 'Micro-informatique', 'Web'];
        $typeList = ['CT','CC'];
        $coeffList = [0.5,1,1.5,2,2.5,3,3.5,4];
        for ($j =0; $j < 10;$j++){
            $coeff = $coeffList[$faker->numberBetween(0,7)];
            $type = $typeList[$faker->numberBetween(0,1)];
            $subject = $subjectsName[$faker->numberBetween(0,5)];
            for ($i = 0; $i < 40; $i++) {
                $mark = new Mark();
                $mark->setMark($faker->numberBetween(0,20));
                $mark->setCoef($coeff);
                $mark->setType($type);
                $mark->setDescription($faker->sentence($nbWords = 6, $variableNbWords = true));
                $mark->setSubject($this->getReference("subject_$subject"));
                $mark->setStudent($this->getReference("student_$i"));
                $manager->persist($mark);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StudentFixtures::class,
            SubjectFixtures::class,
        ];
    }
}
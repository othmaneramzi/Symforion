<?php


namespace App\DataFixtures;


use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $subjectsName = ['Mathématiques', 'Mécanique', 'Algorithmie', 'SDA', 'Micro-informatique', 'Web'];

        $cnt = 0;
        foreach ($subjectsName as $str){

            $subject = new Subject();
            $subject->setName($str);
            $teacher = $this->getReference("teacher_$cnt");
            $subject->setTeacher($teacher);
            $manager->persist($subject);
            $this->addReference("subject_$str", $subject);
            $cnt ++;
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TeacherFixtures::class,
        ];
    }
}
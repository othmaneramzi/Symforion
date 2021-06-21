<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();


        for ($i = 0; $i < 40; $i++) {
            $admin = new User();
            $admin->setEmail("admin$i@gmail.com");
            $admin->setPassword(password_hash("Admin123",PASSWORD_BCRYPT));
            $admin->setLastname($faker->name());
            $admin->setFirstname($faker->firstName());
            $admin->setRoles(["ROLE_USER","ROLE_ADMIN"]);
            $manager->persist($admin);
            $this->addReference("admin_$i",$admin);
        }
        $manager->flush();
    }

}
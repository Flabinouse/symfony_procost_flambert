<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\Profession;
use App\Entity\Project;
use App\Entity\Production;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const DATA_PROFESSION = [
        ['Web Developer Junior'],
        ['Web Developer Senior'],
        ['Web Developer Front-end'],
        ['Web Developer Back-end'],
        ['SEO Manager'],
        ['Web designer'],
        ['Trainee'],
    ];
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadProfession();
        $this->loadProject();
        $this->loadEmployee();
        $manager->flush();
    }

    private function loadEmployee(): void
    {
        for($i = 1; $i < 16; $i++) {

            $employee = new Employee();
            $employee->setFirstname('John'.$i);
            $employee->setLastname('DOE'.$i);
            $employee->setEmail('johndoe'.$i.'@gmail.com');
            $employee->setProfession($this->getReference(Profession::class . random_int(0, 6)));
            $employee->setDailyCost(rand(200, 500));
            $employee->setHireDate(new \DateTime());
            $this->addReference(Employee::class . $i, $employee);
            $employee = $this->loadProduction($i, $employee);

            $this->manager->persist($employee);
        }
    }

    private function loadProfession(): void
    {
        foreach (self::DATA_PROFESSION as $key => [$title]) {
            $profession = new Profession();
            $profession->setTitle($title);

            $this->manager->persist($profession);
            $this->addReference(Profession::class . $key, $profession);
        }

        $this->manager->persist($profession);
    }

    private function loadProject(): void
    {
        for($i = 1; $i < 16; $i++) {
            $project = new Project();
            $project->setName('Projet'.$i);
            $project->setDescription('description'.$i);
            $project->setCreatedAt(new \DateTime(2019 . '-' . 10 . '-' . $i));
            if($i < 4) {
                $project->setDeliveryDate(new \DateTime(2021 . '-' . 03 . '-' . $i));
            } else {
                $project->setDeliveryDate(NULL);
            }
            $project->setSellPrice(rand(10000, 20000));
            $this->addReference(Project::class . $i, $project);
            $this->manager->persist($project);
            sleep(1);
        }
        
        $this->manager->persist($project);
    }

    private function loadProduction(int $id, Employee $employee): Employee
    {
        for($i = 1; $i < 6; $i++) {
            $production = new Production();
            $production->setProject($this->getReference(Project::class . random_int(1, 15)));
            $production->setNbDays(rand(1, 9));
            $production->setCreatedAt(new \DateTime());
            $this->manager->persist($production);
            $employee->addProduction($production);
            
        }
        
        $this->manager->persist($production);
        return $employee;
    }
}

<?php

namespace App\Command;

use App\Entity\Personne;
use App\Entity\Batiment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Faker\Factory;

#[AsCommand(
    name: 'app:insert-data',
    description: 'Génère des données fictives pour la base de données',
)]
class InsertDataCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            // Créer un bâtiment
            $batiment = new Batiment();
            $batiment->setName($faker->company());
            $batiment->setAdresse($faker->address);
            $this->entityManager->persist($batiment);

            // Créer une personne associée à ce bâtiment
            $person = new Personne();
            $person->setName($faker->name);
            $person->setBatimentId($batiment);
            $this->entityManager->persist($person);
        }

        // Sauvegarder les données dans la base
        $this->entityManager->flush();

        $output->writeln('10 personnes et 10 bâtiments ont été ajoutés.');
        return Command::SUCCESS;
    }
}

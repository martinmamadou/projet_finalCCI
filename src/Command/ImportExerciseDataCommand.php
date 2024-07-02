<?php

namespace App\Command;

use App\Entity\ExTemplate;
use App\Service\ExerciseApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-exercise-data',
    description: 'Importe les exercices depuis l\'API ExerciseDB dans la base de données'
)]
class ImportExerciseDataCommand extends Command
{
    protected static $defaultName = 'app:import-exercise-data';
    private ExerciseApiService $apiService;
    private EntityManagerInterface $entityManager;

    public function __construct(ExerciseApiService $apiService, EntityManagerInterface $entityManager)
    {
        $this->apiService = $apiService;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Importe les exercices depuis l\'API ExerciseDB dans la base de données');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $exercises = $this->apiService->fetchExercises();

        foreach ($exercises as $exercise) {
            $exTemplate = new ExTemplate();
            $exTemplate->setName($exercise['name']);
            $exTemplate->setShortDes($exercise['description'] ?? '');
            $exTemplate->setGifurl($exercise['gifUrl']);

            $this->entityManager->persist($exTemplate);
        }

        $this->entityManager->flush();

        $io->success('Les exercices ont été importés avec succès.');

        return Command::SUCCESS;
    }
}

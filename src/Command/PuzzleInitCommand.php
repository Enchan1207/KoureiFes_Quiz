<?php

namespace App\Command;

use App\Entity\Puzzle;
use App\Repository\PuzzleRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'puzzle:init',
    description: 'remove all Puzzles',
)]
class PuzzleInitCommand extends Command
{
    /**
     * @var PuzzleRepository $puzzleRepository
     */
    private $puzzleRepository;

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->puzzleRepository = $container->get('doctrine')->getRepository(Puzzle::class);
        $this->entityManager = $container->get('doctrine')->getManager();

        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // 保存されているパズルエンティティを取得し
        $puzzles = $this->puzzleRepository->findAll();
        $puzzleCount = count($puzzles);

        if ($puzzleCount == 0){
            $io->warning("No puzzle registered.");
            return Command::FAILURE;
        }

        $result = $io->confirm("Delete All $puzzleCount puzzles?", false);
        if(!$result){
            $io->warning("Canceled.");
            return Command::FAILURE;
        }

        // 削除
        foreach ($puzzles as $puzzle) {
            $this->entityManager->remove($puzzle);
        }
        $this->entityManager->flush();
        
        $io->success("All puzzle has been removed.");

        return Command::SUCCESS;
    }
}

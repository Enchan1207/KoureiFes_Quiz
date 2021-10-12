<?php

namespace App\Command;

use App\Entity\Puzzle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'puzzle:list',
    description: 'list up all Puzzles',
)]
class PuzzleListCommand extends Command
{

    private $puzzleRepository;

    public function __construct(ContainerInterface $container)
    {
        $this->puzzleRepository = $container->get('doctrine')->getRepository(Puzzle::class);

        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title("Puzzle List:");

        $puzzles = $this->puzzleRepository->findAll();
        
        foreach ($puzzles as $puzzle) {
            $answer = implode(",", $puzzle->getAnswer());
            $stringRepresentedPuzzle = "ID:{$puzzle->getId()} {$puzzle->getWidth()}×{$puzzle->getHeight()} ({$answer}) -> {$puzzle->getReward()}";
            $io->text($stringRepresentedPuzzle);
        }

        $io->info("To add new Puzzle, exec `console puzzle:add`.");

        return Command::SUCCESS;
    }
}

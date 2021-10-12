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
    name: 'puzzle:delete',
    description: 'Add a short description for your command',
)]
class PuzzleDeleteCommand extends Command
{
    private $puzzleRepository;
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

        $io->title("Delete puzzle:");

        $puzzles = $this->puzzleRepository->findAll();
        $stringRepresentedPuzzles = array_map(function ($puzzle) {
            $answer = implode(",", $puzzle->getAnswer());
            return "ID:{$puzzle->getId()} {$puzzle->getWidth()}×{$puzzle->getHeight()} ({$answer}) -> {$puzzle->getReward()}";
        }, $puzzles);

        // 選択結果はそのまま選択肢の文字列 (indexで欲しい)
        $puzzle = $io->choice("Which Puzzle do you want to remove?", $stringRepresentedPuzzles);
        $index = array_search($puzzle, $stringRepresentedPuzzles);

        // 削除
        $target = $puzzles[$index];
        
        $this->entityManager->remove($target);

        $io->success("Puzzle (ID: {$target->getId()}) has been deleted successfully.");

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}

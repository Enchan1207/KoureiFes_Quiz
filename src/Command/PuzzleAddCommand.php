<?php

namespace App\Command;

use App\Entity\Puzzle;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PuzzleAddCommand extends Command
{
    protected static $defaultName = 'puzzle:add';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription("add a new puzzle");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $validateInteger = function ($number) {
            if (!is_numeric($number)) {
                throw new \RuntimeException('You must type a number.');
            }
            return (int) $number;
        };

        $io->title("Register new puzzle.");

        $name = $io->ask("Puzzle name", "new puzzle");

        $width = $io->ask("Puzzle width", 3, $validateInteger);
        $height = $io->ask("Puzzle height", 3, $validateInteger);

        $answer = $io->ask("Puzzle answer(comma-separated)", null, function ($answer) {

            if ($answer == null) {
                throw new \RuntimeException('Please type value');
            }

            $separatedAnswer = explode(",", $answer);

            // 数値配列に変換
            foreach ($separatedAnswer as &$ans) {
                if (!is_numeric($ans)) {
                    throw new \RuntimeException('Invalid format');
                }
                $ans = (int) $ans;
            }

            // 重複を削除して返す
            return array_unique($separatedAnswer);
        });

        $colors = $io->ask("Puzzle colors(comma-separated)", null, function ($answer) {

            if ($answer == null) {
                throw new \RuntimeException('Please type value');
            }

            $separatedAnswer = explode(",", $answer);

            foreach ($separatedAnswer as $ans) {
                if (!preg_match('/^#([0-9a-fA-F]{3}){1,2}$/', $ans)) {
                    throw new \RuntimeException('Invalid color format');
                }
            }

            return $separatedAnswer;
        });

        $reward = $io->ask("Puzzle reward (20 characters or less is recommended)", null, function ($ans) {
            if (strlen($ans) > 255) {
                throw new \RuntimeException("string too long");
            }
            return $ans;
        });

        // バリデーション
        $dataCount = $width * $height;
        $answerCount = count($answer);
        if ($answerCount != $dataCount) {
            throw new \RuntimeException("Invalid answer format. width*height is $dataCount, but count(answer) is $answerCount.");
        }

        $colorCount = count($colors);
        if ($colorCount != $dataCount) {
            throw new \RuntimeException("Invalid color format. width*height is $dataCount, but count(colors) is $colorCount.");
        }

        // 値を元にPuzzleエンティティを生成
        $puzzle = new Puzzle();
        $puzzle->setWidth($width);
        $puzzle->setHeight($height);
        $puzzle->setAnswer($answer);
        $puzzle->setColors($colors);
        $puzzle->setReward($reward);
        $puzzle->setName($name);


        try {
            $this->entityManager->persist($puzzle);
            $this->entityManager->flush();

            $io->success("A new puzzle has been created.");

            return Command::SUCCESS;

        } catch (Exception $th) {
            $io->error($th->getMessage());

            return Command::FAILURE;
        }

    }
}

<?php

namespace App\Controller;

use App\Entity\Puzzle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    #[Route('/manager', name: 'manager')]
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Puzzle::class);
        $puzzles = $repository->findAll();

        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
            'puzzles' => $puzzles
        ]);
    }
}

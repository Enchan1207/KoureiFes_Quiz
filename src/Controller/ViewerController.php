<?php

namespace App\Controller;

use App\Entity\Puzzle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ViewerController extends AbstractController
{
    #[Route('/viewer/{id}', name: 'viewer', requirements: ['page'=>'\d+'])]
    public function index(int $id): Response
    {
        // IDに対応するPuzzleを持ってくる
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Puzzle::class);

        $puzzle = $repository->findOneBy(['id' => $id]);

        if ($puzzle == NULL) {
            throw new NotFoundHttpException("Invalid Puzzle ID: $id");
        }

        return $this->render('viewer/index.html.twig', [
            'puzzle' => $puzzle,
            'controller_name' => 'ViewerController',
        ]);
    }
}

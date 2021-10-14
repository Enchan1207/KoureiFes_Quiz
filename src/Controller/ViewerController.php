<?php

namespace App\Controller;

use App\Entity\Puzzle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ViewerController extends AbstractController
{
    #[Route('/viewer/{name}', name: 'viewer')]
    public function index(string $name): Response
    {
        // nameに対応するPuzzleを持ってくる
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Puzzle::class);

        $puzzle = $repository->findOneBy(['name' => $name]);

        if ($puzzle == NULL) {
            throw new NotFoundHttpException("Invalid Puzzle Name: $name");
        }

        return $this->render('viewer/index.html.twig', [
            'puzzle' => $puzzle,
            'controller_name' => 'ViewerController',
        ]);
    }
}

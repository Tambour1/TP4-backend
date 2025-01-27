<?php

namespace App\Controller;

use App\Entity\Batiment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PersonneController extends AbstractController
{
    #[Route('/personnes', name: 'app_personne')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $batimentRepository = $entityManager->getRepository(Batiment::class);

        // Récupérer tous les bâtiments avec les personnes associées
        $batiments = $batimentRepository->findAll();

        return $this->render('personne/index.html.twig', [
            'batiments' => $batiments,
        ]);
    }
}

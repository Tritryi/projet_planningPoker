<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Backlog;
use App\Entity\Fonctionnalite;

final class BacklogController extends AbstractController
{
    #[Route('/backlog', name: 'app_backlog')]
    public function index(): Response
    {
        return $this->render('backlog/index.html.twig', [
            'controller_name' => 'BacklogController',
        ]);
    }

    #[Route('/backlog/load', name: 'app_backlog_load', methods: ['POST'])]
    public function loadBacklog(Request $request, SerializerInterface $serialiser)
    {
        $session = $request->getSession();

        //return dd($request);
        //return dd($serialiser->deserialize(file_get_contents($request->files->get("file")), Backlog::class, "json"));
        $session->set('backlog', $serialiser->deserialize(file_get_contents($request->files->get("file")), Backlog::class, "json"));

        
        return $this->render('backlog/index.html.twig', [
            'controller_name' => 'BacklogController',
        ]);
    }
}

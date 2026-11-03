<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Partie;

final class PartieController extends AbstractController
{
    #[Route('/partie/creer',
        name: 'app_partie_creer',
        methods: ['POST'],)]
    public function partie(Request $request): Response{
        $nomsJoueurs = $request->request->all('joueurs');

        $p = new Partie($nomsJoueurs);
        $request->getSession()->set('partie', $p);

        return $this->redirectToRoute('app_partie_jouer');
    }

    #[Route('/partie/jouer',
        name: 'app_partie_jouer')]
    public function jouer(Request $request): Response{
        $p = $request->getSession()->get('partie');

        if(!$p){
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('default/partie.html.twig', [
            'joueurs' => $p->getJoueurs(),
        ]);
    }
}

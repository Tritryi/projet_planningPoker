<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Partie;
use App\Entity\Backlog;
use App\Entity\Fonctionnalite;

final class PartieController extends AbstractController
{
    #[Route('/partie/creer',
        name: 'app_partie_creer',
        methods: ['POST'],)]
    public function partie(Request $request, SerializerInterface $serialiser): Response{
        $nomsJoueurs = $request->request->all('joueurs');
        $session = $request->getSession();
        $error = false;

        try {
            $backlog = $serialiser->deserialize(file_get_contents($request->files->get("file")), Backlog::class, "json");

            if($this->checkBacklogValidity($backlog)){
                $session->set('backlog', $backlog);
            }
            else{
                $session->set('error', "Backlog incorrect, veuillez vérifier les champs");
                $error = true;
            }
        } catch (\Throwable $th) {
            $session->set('error', "Veuillez entrer un fichier JSON correct");
            $error = true;
        }

        if(!$error){
            $session->set('error', null);

            $p = new Partie($nomsJoueurs);
            $session->set('partie', $p);

            return $this->redirectToRoute('app_partie_jouer');
        }
        else
            return $this->redirectToRoute('app_accueil');
        
    }

    #[Route('/partie/jouer',
        name: 'app_partie_jouer')]
    public function jouer(Request $request): Response{
        $p = $request->getSession()->get('partie');
        $b = $request->getSession()->get('backlog');

        if(!$p || !$b){
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('default/partie.html.twig', [
            'joueurs' => $p->getJoueurs(),
            'backlog' => $b,
        ]);
    }

    #[Route('/partie/checkvote', name: 'app_partie_voter', methods: ['POST'])]
    public function voter(Request $request): Response{
        $votes = json_decode($request->request->get('votes'), true);
        $p = $request->getSession()->get('partie');
        $voteJ1 =  $votes[$p->getJoueurs()[0]];
        
        if(count($votes) == 0){
            return $this->redirectToRoute('app_partie_jouer');
        }

        return $this->redirectToRoute('app_partie_resultatvote',[
            'votes' => $votes,
        ]);
    }

    #[Route('/partie/resultvote', name: 'app_partie_resultatvote')]
    public function resultatvote(Request $request): Response{

        return $this->render('default/voteresult.html.twig',[
            'votes' => $request->query->all('votes'),
        ]);
    }

    private function checkBacklogValidity($backlog){
        if(!$backlog->nomProjet){
            return false;
        }
        foreach ($backlog->fonctionnalites as $fonctionnalite) {
            if($fonctionnalite->id == null)
                return false;
            if($fonctionnalite->titre == null || $fonctionnalite->titre == "")
                return false;
        }
            return true;
    }
}

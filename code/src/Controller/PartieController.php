<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Partie;
use App\Entity\Backlog;
use App\Entity\Fonctionnalite;
use Symfony\Component\HttpFoundation\HeaderUtils;

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
            $session->set('error', "$th");
            $error = true;
        }

        if(!$error){
            $session->set('error', null);

            $p = new Partie($nomsJoueurs);
            $p->setBacklog($backlog);
            $p->setRegle("Stricte");
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

        if($p->getCurrentFuncIndex() >= sizeof($b->getFonctionnalites())){
            return $this->redirectToRoute('app_partie_recap');
        }

        if(!$p || !$b){
            return $this->redirectToRoute('app_accueil');
        }
        $indexFonc = $p->getCurrentFuncIndex();
        $tour = $p->getCurrentTurn();

        return $this->render('default/partie.html.twig', [
            'joueurs' => $p->getJoueurs(),
            'backlog' => $b,
            'indexFonc' => $indexFonc,
            'tour' => $tour,
        ]);
    }

    #[Route('/partie/checkvote', name: 'app_partie_voter', methods: ['POST'])]
    public function voter(Request $request): Response{
        $votes = json_decode($request->request->get('votes'), true);
        $p = $request->getSession()->get('partie');

        if(count($votes) == 0){
            return $this->redirectToRoute('app_partie_jouer');
        }

        if($p->getCurrentTurn() == 1){
            $validite = $p->checkVoteStrict($votes);
        }else if($p->getRegle() == "Stricte"){
            $validite = $p->checkVoteStrict($votes);
        }else{
            $validite = $p->checkVoteAbsolute($votes);
        }


        $request->getSession()->set('validite', $validite);
        return $this->redirectToRoute('app_partie_resultatvote',[
            'votes' => $votes,
        ]);
    }

    #[Route('/partie/resultvote', name: 'app_partie_resultatvote')]
    public function resultatvote(Request $request): Response{
        return $this->render('default/voteresult.html.twig',[
            'votes' => $request->query->all('votes'),
            'validite' => $request->getSession()->get('validite'),
        ]);
    }

    #[Route('/partie/recap', name: 'app_partie_recap')]
    public function recap(Request $request): Response
    {
        $p = $request->getSession()->get('partie');

        return $this->render('default/recap.html.twig', [
            'partie' => $p,
        ]);
    }

    #[Route('/partie/savebacklog', name: 'app_partie_savebacklog', methods: ['GET'])]
    public function saveBacklog(Request $request, SerializerInterface $serializer): Response{
        $p = $request->getSession()->get('partie');

        $backlogJson = $serializer->serialize($p->getBacklog(), 'json', [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE, // pretty print + utf8
        ]);

        $response = JsonResponse::fromJsonString($backlogJson);

        // Force le téléchargement
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'Backlog_Complet.json'
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    private function checkBacklogValidity($backlog){
        return true;
        if(!$backlog->getNomProjet()){
            return false;
        }
        foreach ($backlog->getFonctionnalites() as $fonctionnalite) {
            if($fonctionnalite->getId() == null)
                return false;
            if($fonctionnalite->getTitre() == null || $fonctionnalite->getTitre() == "")
                return false;
        }
            return true;
    }
}

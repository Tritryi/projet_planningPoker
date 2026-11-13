<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{

    private array $joueurs = [];
    public int $currentFuncIndex;
    public int $currentTurn;
    public string $regle;

    public Backlog $backlog;

    public function __construct(array $joueurs)
    {
        $this->joueurs = $joueurs;
        $this->currentFuncIndex = 0;
        $this->regle = "Stricte";
    }

    public function getJoueurs(): array
    {
        return $this->joueurs;
    }

    public function setJoueurs(array $joueurs): void
    {
        $this->joueurs = $joueurs;
    }

    public function setBacklog(Backlog $backlog): void
    {
        $this->backlog = $backlog;
    }
}

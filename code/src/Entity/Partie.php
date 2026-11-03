<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{

    private array $joueurs = [];
    private array $taches;

    public function __construct(array $joueurs)
    {
        $this->joueurs = $joueurs;
        $this->taches = ["Connexion", "Inscription"];
    }

    public function getJoueurs(): array
    {
        return $this->joueurs;
    }

    public function setJoueurs(array $joueurs): void
    {
        $this->joueurs = $joueurs;
    }

}

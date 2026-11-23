<?php

namespace App\Entity;

use App\Repository\BacklogRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Fonctionnalite;

#[ORM\Entity(repositoryClass: BacklogRepository::class)]
class Backlog
{
    public ?string $nomProjet = null;

    public ?array $fonctionnalites = [];

    public function __construct($nomProjet, $fonctionnalites)
    {
        $this->nomProjet = $nomProjet;
        $this->fonctionnalites = $fonctionnalites;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): void
    {
        $this->nomProjet = $nomProjet;
    }
    public function getFonctionnalite(int $index): Fonctionnalite
    {
        return $this->fonctionnalites[$index];
    }

    public function getFonctionnalites(): array
    {
        return $this->fonctionnalites;
    }
    public function setFonctionnalites(array $fonctionnalites): void
    {
        $this->fonctionnalites = $fonctionnalites;
    }
}

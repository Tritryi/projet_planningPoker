<?php

namespace App\Entity;

use App\Repository\BacklogRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Fonctionnalite;

#[ORM\Entity(repositoryClass: BacklogRepository::class)]
class Backlog
{
    public ?string $nomProjet = null;

    /**
     * @var Fonctionnalite[]
     */
    public ?array $fonctionnalites = [];
/*
    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    
    public function getFonctionnalites(): ?array
    {
        return $this->fonctionnalites;
    }*/
}

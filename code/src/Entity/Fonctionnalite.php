<?php

namespace App\Entity;

use App\Repository\FonctionnaliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FonctionnaliteRepository::class)]
class Fonctionnalite
{
    public ?int $id = null;
    public ?string $titre = null;
    public ?int $score = null;

    public function __construct($id, $titre)
    {
        $this->id = $id;
        $this->titre = $titre;
    }
/*
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }*/
}

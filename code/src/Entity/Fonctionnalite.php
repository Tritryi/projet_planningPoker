<?php

namespace App\Entity;

use App\Repository\FonctionnaliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FonctionnaliteRepository::class)]
class Fonctionnalite
{
    private ?int $id = null;
    private ?string $titre = null;
    private ?int $score = null;

    public function __construct($id, $titre)
    {
        $this->id = $id;
        $this->titre = $titre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}

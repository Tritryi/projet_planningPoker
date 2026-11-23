<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{

    private array $joueurs = [];
    private int $currentFuncIndex;
    private int $currentTurn;
    private string $regle;

    private Backlog $backlog;

    public function __construct(array $joueurs)
    {
        $this->joueurs = $joueurs;
        $this->currentFuncIndex = 0;
        $this->currentTurn = 1;
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

    public function getCurrentFuncIndex(): int
    {
        return $this->currentFuncIndex;
    }

    public function setCurrentFuncIndex(int $currentFuncIndex): void
    {
        $this->currentFuncIndex = $currentFuncIndex;
    }

    public function getCurrentTurn(): int
    {
        return $this->currentTurn;
    }

    public function setCurrentTurn(int $currentTurn): void
    {
        $this->currentTurn = $currentTurn;
    }

    public function getRegle(): string
    {
        return $this->regle;
    }

    public function setRegle(string $regle): void
    {
        $this->regle = $regle;
    }

    public function getBacklog(): Backlog
    {
        return $this->backlog;
    }

    public function setBacklog(Backlog $backlog): void
    {
        $this->backlog = $backlog;
    }

    /**
     * Utilisé lors du premier tour et en vote strict pour vérifier qu'une fonctionnalité est validable
     * @param array $scores
     * @return int
     */
    public function checKVoteStrict(array $scores): int
    {
        $value = reset($scores);
        foreach ($scores as $s) {
            if ($s != $value) {
                $this->setCurrentTurn($this->getCurrentTurn()+1);
                return -1;
            }
        }
        $fct = $this->getBacklog()->getFonctionnalite($this->getCurrentFuncIndex());
        $fct->setScore($value);
        $this->setCurrentFuncIndex($this->getCurrentFuncIndex()+1);
        return $value;
    }

    public function checkVoteAbsolute(array $scores): int
    {
        $compta = [];
        $totalVotes = sizeof($scores);
        foreach ($scores as $s) {
            if (!isset($compta[$s])){
                $compta[$s] = 1;
            }else{
                $compta[$s]++;
            }
        }

        foreach ($compta as $k => $v) {
            if($v > $totalVotes/2){
                $fct = $this->getBacklog()->getFonctionnalite($this->getCurrentFuncIndex());
                $fct->setScore($k);
                $this->setCurrentFuncIndex($this->getCurrentFuncIndex()+1);
                return (int)$k;
            }
        }
        $this->setCurrentTurn($this->getCurrentTurn()+1);
        return -1;
    }
}

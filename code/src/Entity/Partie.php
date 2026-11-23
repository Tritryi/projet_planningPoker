<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Représente l'objet central de l'application : une partie.
 * Permet de garder en mémoire les joueurs, les fonctions traitées du backlog, la règle choisie par le joueur et le backlog chargé.
 * Encapsule à la fois les paramètres de la partie mais également le backlog et les fonctionnalités traitées et permet de réaliser des
 * actions comme vérifier la validité des votes ou suivre le cours de la partie.
 */
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
     * Détermine si un tour en règle stricte est valide ou non.
     *      - si -1 alors invalide (Ligne 1)
     *      - autre valeur : valide, la valeur retournée est le score attribué à la fonctionnalité (Ligne 2)
     *
     * Parcours la liste des votes entrés, si une seule valeur diffère des autres, on incrémente les tours et on retourne une invalidité.
     * Sinon, on entre l'estimation de la fonctionnalité et on incrémente l'index de la fonctionnalité traitée.
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


    /**
     * Détermine si un tour en majorité absolue est valide ou non (s'applique si tour != 1 et regle="majoriteAbsolue")
     *      - si -1 alors invalide (Lignes 3, 7 et 8)
     *      - autre valeur : valide, la valeur retournée est le score attribué à la fonctionnalité (Lignes 4, 5 et 6)
     *
     * On parcourt les scores et créé un dictionnaire clé->valeur où la clé est le score attribué et valeur est le nombre de votes en faveur
     * de cette valeur.
     * Ensuite, on parcourt ce dictionnaire et on regarde pour chaque valeur si elle est supérieure à la 50% des votes, auquel cas la fonctionnalité
     * prend cette valeur que l'on retourne. Sinon, on retourne -1 et incrémente les tours.
     * @param array $scores
     * @return int
     */
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

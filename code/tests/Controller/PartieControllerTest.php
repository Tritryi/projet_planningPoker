<?php

namespace App\Tests\Controller;
use App\Entity\Partie;
use App\Entity\Backlog;
use App\Entity\Fonctionnalite;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PartieControllerTest extends WebTestCase
{
    /* Mis en commentaire car route plus utilisée (à voir si on garde ce type de tests)
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/partie');

        self::assertResponseIsSuccessful();
    }*/

    /* Exemple de test passant par les controllers
    public function test_CA_01_1_stricte_echec(): void
    {
        // Arrange
        $client = static::createClient();
        $partie = new Partie(["Antoine", "Baptiste", "Céline"]);
        $partie->currentTurn = 1;
        $partie->regle = "Stricte";
        $backlog = new Backlog("Projet", [new Fonctionnalite(1, "Première tâche"), new Fonctionnalite(1, "Deuxième tâche")]);

        $session = $client->getSession();
        $session->set('partie', $partie);
        $session->set('backlog', $backlog);
        $session->save();

        // Act
        $crawler = $client->request('POST', '/partie/validatevote', [
            'votes' => [3, 5 , 5],
        ]);

        // Assert
        $this->assertResponseStatusCodeSame(201); // 201 pour échec sinon 200 pour les réussites
        $this->assertSame($session->get('partie')->currentFuncIndex, 0);
        $this->assertSame($session->get('partie')->currentTurn, 2);
    }
    */

    public function test_CA_01_1_stricte_echec(): void
    {
        // Arrange
        $partie = new Partie(["Antoine", "Baptiste", "Céline"]); // currentFuncIndex initialisé à 0
        $partie->setCurrentTurn(1);
        $partie->setRegle("Stricte");
        $backlog = new Backlog("Projet", [new Fonctionnalite(1, "Première tâche"), new Fonctionnalite(2, "Deuxième tâche")]);
        $partie->setBacklog($backlog);
        $votes = [3,5,5];

        // Act
        // La fonction serait choisie dans le controlleur selon partie->regle & partie->currentTurn
        $result = $partie->CheckVoteStrict($votes);

        // Assert
        $this->assertSame($result, -1);
        $this->assertSame($partie->getCurrentFuncIndex(), 0);
        $this->assertSame($partie->getCurrentTurn(), 2);
    }

    public function test_CA_02_1_majorite_absolue_reussite_regle(): void
    {
        // Arrange
        $partie = new Partie(["Antoine", "Baptiste", "Céline"]); // currentFuncIndex initialisé à 0
        $partie->setCurrentTurn(2);
        $partie->setRegle("Maj absolue");
        $backlog = new Backlog("Projet", [new Fonctionnalite(1, "Première tâche"), new Fonctionnalite(2, "Deuxième tâche")]);
        $partie->setBacklog($backlog);
        $votes = [3,5,5];

        // Act
        // La fonction serait choisie dans le controlleur selon partie->regle & partie->currentTurn
        $result = $partie->CheckVoteAbsolute($votes);

        // Assert
        $this->assertSame($result, 5);
        $this->assertSame($partie->getCurrentFuncIndex(), 1);
        $this->assertSame($backlog->fonctionnalites[0]->getScore(), 5);
    }

    public function test_CA_03_1_majorite_absolue_echec_premier_tour(): void
    {
        // Arrange
        $partie = new Partie(["Antoine", "Baptiste", "Céline"]); // currentFuncIndex initialisé à 0
        $partie->setCurrentTurn(1);
        $partie->setRegle("Maj absolue");
        $backlog = new Backlog("Projet", [new Fonctionnalite(1, "Première tâche"), new Fonctionnalite(2, "Deuxième tâche")]);
        $partie->setBacklog($backlog);
        $votes = [3,3,5];

        // Act
        // La fonction serait choisie dans le controlleur selon partie->regle & partie->currentTurn
        $result = $partie->CheckVoteStrict($votes);

        // Assert
        $this->assertSame($result, -1);
        $this->assertSame($partie->getCurrentFuncIndex(), 0);
        $this->assertSame($partie->getCurrentTurn(), 2);
    }

    public function test_CA_02_3_majorite_absolue_echec_egalite() : void
    {
        $partie = new Partie(["Antoine", "Baptiste", "Céline", "Richard"]);
        $partie->setCurrentTurn(2);
        $partie->setRegle("Maj absolue");
        $backlog = new Backlog("Projet", [new Fonctionnalite(1, "Première tâche"), new Fonctionnalite(2, "Deuxième tâche")]);
        $partie->setBacklog($backlog);
        $votes = [3,3,5,5];

        $result = $partie->checkVoteAbsolute($votes);

        $this->assertSame($result, -1);
        $this->assertSame($partie->getCurrentFuncIndex(), 0);
        $this->assertSame($partie->getCurrentTurn(), 3);
    }

    public function test_CA_01_2_majorite_absolue_reussite_premier_tour() : void
    {
        $partie = new Partie(["Antoine", "Baptiste", "Céline"]);
        $partie->setCurrentTurn(1);
        $partie->setRegle("Maj absolue");
        $backlog = new Backlog("Projet", [new Fonctionnalite(1, "Première tâche"), new Fonctionnalite(2, "Deuxième tâche")]);
        $partie->setBacklog($backlog);
        $votes = [3,3,3];

        $result = $partie->checKVoteStrict($votes);

        $this->assertSame($result, 3);
        $this->assertSame($partie->getCurrentFuncIndex(), 1);
        $this->assertSame($backlog->fonctionnalites[0]->getScore(), 3);
    }

    public function test_CA_02_2_majorite_absolue_echec_aucune_majorite() : void
    {
        $partie = new Partie(["Antoine", "Baptiste", "Céline"]);
        $partie->setCurrentTurn(1);
        $partie->setRegle("Maj absolue");
        $backlog = new Backlog("Projet", [new Fonctionnalite(1, "Première tâche"), new Fonctionnalite(2, "Deuxième tâche")]);
        $votes = [8,3,5];

        $result = $partie->checkVoteAbsolute($votes);

        $this->assertSame($result, -1);
        $this->assertSame($partie->getCurrentFuncIndex(), 0);
        $this->assertSame($partie->getCurrentTurn(), 2);
    }


}

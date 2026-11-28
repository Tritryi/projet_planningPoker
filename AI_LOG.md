# AI_LOG.md : journal d'usage de l'IA

> À placer à la racine du dépôt. À remplir **au fil de l'eau**, pas en fin de projet. Une entrée par tâche (pas par message), en 5 lignes.
> Rappel : l'IA est autorisée pour le **code de production** et la **configuration d'outils** uniquement. Qui a fait la demande, les fichiers touchés et les commits se retrouvent dans l'historique Git : ne les recopiez pas.

## Outils utilisés (à remplir une fois)

| Outil  | Modèle (si connu) | Mode (autocomplétion, chat, agent) |
|--------|---|------------------------------------|
| Gemini | 4 Hydrogen / 3.5 Flash-lite | Chat                               |

Fichier d'instructions pour agent versionné (`CLAUDE.md`, `AGENTS.md`...) : <oui : chemin / non>

## Entrées

### AAAA-MM-JJ : <tâche en une ligne> (US-xx)

### 2026-11-02 
- **Demande (résumé fidèle)** : US-01 : Génération du code HTML/CSS, contexte fourni : code du controlleur pour qu'il sache le nom des variables à afficher
- **Résultat** : Accepté
- **Ce que nous avons vérifié** : Vérification visuelle et bon fonctionnement des éventuels boutons
- **Ce que nous avons changé ou rejeté, et pourquoi** : Rien, nous préferions nous concentrer sur l'écriture du backend et laisser le front à l'IA n'étant pas très doué pour les beaux visuels.

### 2026-11-09
- **Demande (résumé fidèle)** : Demande d'aide sur le ci.yaml, seule la partie installation de php a été demandé (ligne "uses : shivammathur/setup-php@v2"), le reste du fichier a été fait par nous.
- **Résultat** : Modifié, la mauvaise version de php était proposée
- **Ce que nous avons vérifié** : Vérification que le CI fonctionnait sur une branche de test.
- **Ce que nous avons changé ou rejeté, et pourquoi** : Changement de la version php, les extensions et le coverage était bons.

### 2026-11-14
- **Demande (résumé fidèle)** : US-01-02-03 :  Demande de génération de la page voteresult et d'aide pour l'envoi de l'objet JS votes, contexte fourni : le but de l'application pour qu'il adapte l'affichage de sortie et le nom de la variable en entrée de la page voteresult.
- **Résultat** : Modifié, une partie du code proposée était redondante avec ce que nous avions fait précédemment + pour l'envoi des votes, juste la méthode JSON.stringify a été réutilisée.
- **Ce que nous avons vérifié** : Vérification des visuels et qu'il n'y avait pas de perte de données au niveau de l'envoi / reception des votes.
- **Ce que nous avons changé ou rejeté, et pourquoi** : Rejeté une partie du code qui proposait de refaire le vote des joueurs, car cela ne nous était plus utile. De plus, la partié résultat global sera mené a changer pour intégrer le reste des fonctionnalités. Pour l'envoi de données, rejeté le formulaire proposé. La méthode stringify suffisant pour corriger les problèmes rencontrés. 


### 2026-11-24
- **Demande (résumé fidèle)** : US-01-02-03 :  Troubleshooting sur le formulaire de téléchargement du JSON de la page recap.
- **Résultat** : Le problème venait de l'utilisation d'un add on de Symfony, UX Turbo, qui modifie le fonctionnement des forms html. 
- **Ce que nous avons vérifié** : Vérification dans la doc de Symfony du comportement de l'add on + fonctionnement de la modification.
- **Ce que nous avons changé ou rejeté, et pourquoi** : Accepté. Pour corriger le problème, il fallait ajouter un tag dans le form pour permettre à la requête de s'exécuter.

## Bilan (à compléter en séance 4, 3 lignes)

- Nombre d'entrées et de propositions rejetées ou corrigées :
- Tâches où l'IA a fait gagner du temps :
- Tâches où l'IA a fait perdre du temps :

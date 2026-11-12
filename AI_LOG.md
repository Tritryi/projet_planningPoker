# AI_LOG.md : journal d'usage de l'IA

> À placer à la racine du dépôt. À remplir **au fil de l'eau**, pas en fin de projet. Une entrée par tâche (pas par message), en 5 lignes.
> Rappel : l'IA est autorisée pour le **code de production** et la **configuration d'outils** uniquement. Qui a fait la demande, les fichiers touchés et les commits se retrouvent dans l'historique Git : ne les recopiez pas.

## Outils utilisés (à remplir une fois)

| Outil  | Modèle (si connu) | Mode (autocomplétion, chat, agent) |
|--------|---|------------------------------------|
| Gemini | | Chat                               |

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

## Bilan (à compléter en séance 4, 3 lignes)

- Nombre d'entrées et de propositions rejetées ou corrigées :
- Tâches où l'IA a fait gagner du temps :
- Tâches où l'IA a fait perdre du temps :

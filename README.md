# projet_planningPoker
Repository pour le projet d'application de planning poker du cours de Conception de Projets Agiles

# Procédure Hello World et test
Suivre ces 3 commandes suffit à voir le "Hello world" et lancer un test qui fonctionne (cela ne comprend pas l'installation des package nécessaire comme symfony-cli)
```
git clone git@github.com:Tritryi/projet_planningPoker.git

symfony server:start
```
Après avoir lancé le serveur symfony se rendre sur [127.0.0.1](127.0.0.1:8000) afin de visualiser le "hello world".

Pour lancer les tests : 
```
php bin/phpunit tests/Controller/DefaultControllerTests.php
```
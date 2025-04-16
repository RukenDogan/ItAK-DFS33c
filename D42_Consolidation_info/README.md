# D42 - Consolidation des compétences en développement informatique

Ces exercices ont pour objectif de vous permettre de construire la chaîne de programmes nécessaires à la construction d'une application web simple, accessible depuis un navigateur.

Une partie des instructions suivantes font appel à des notions qui n'ont pas été développées en cours, vous êtes libres de faire appel à la source d'information de votre choix pour vous aider.

## Écoute et distribution des requêtes HTTP avec Apache

Pour appliquer le concept d'automatisation vus en cours, nous allons créer un pont entre une requête HTTP et un exécutable sur votre ordinateur.

Pour ce faire, nous utiliserons Apache via Docker sur votre machine locale.

Commencez par vérifier l'installation de Docker dans votre espace de travail.
Une fois celui-ci installé si nécessaire, ouvrez une ligne de commande puis créez un dossier `~/Workspace/D42` et ouvrez-le.

Dans ce dossier, lancez un container Apache avec la ligne suivante :
```shell
docker run -d --name apache -p 81:80 \
  -v "$(pwd)/vhosts":/etc/apache2/sites-enabled:ro \
  -v "$(pwd)/public":/var/www/html:ro \
  php:apache
```
Sous Windows, utilisez PowerShell :
```shell
docker run -d --name apache -p 81:80 -v "$(PWD)\vhosts:/etc/apache2/sites-enabled:ro" -v "$(PWD)\public:/var/www/html:ro " php:apache
```

Le dossier `public` va contenir les fichiers "servis" par Apache via le protocole HTTP.
Pour que ce dossier soit accessible en lecture à travers le protocole HTTP, il faut créer une configuration qui autorise Apache à servir ce dossier - pour des raisons de sécurité, aucun dossier n'est exposé par défaut.

Créez le fichier `vhosts/localhost.conf` puis intégrez la configuration du ficher de [configuration joint](./vhosts/localhost.conf).

Rendez-vous sur l'url (http://localhost:81).
Le contenu de votre dossier `public` est maintenant accessible avec le protocole HTTP grâce à Apache.
Dans le cas probable où rien ne se passe, redémarrer le container Apache pourra être nécessaire; vous pouvez le faire via la commande `docker restart apache`.

Pour des raisons évidentes de sécurité, laisser lister le contenu de notre dossier sur le web n'est pas une bonne pratique, désactivez l'affichage du dossier, et référencez une page comme page par défaut si un fichier n'est pas explicitement appelé.

Importez maintenant votre TP du module D12 dans votre dossier `public` et visualisez votre travail dans votre navigateur.

Utilisez maintenant la directive `ErrorDocument` pour personnaliser vos pages d'erreur.

## Création de pages web dynamiques avec Php

Afficher des pages avec seulement du HTML a des vertues certaines en terme de performances, mais oblige à dupliquer des affichages comme le menu, les en-têtes...

Les langages serveur comme Php / Python / Node... permettent de créer des modèles de pages web appelés templates qui permettent d'afficher des informations différentes mais qui suivent la même structure d'affichage : une fiche produit, une page de compte utilisateur, une note de blog...
On considère que le balisage HTML **décore** la donnée brute.

Dans un premier temps, nous allons permettre à Apache de lancer le moteur d'interprétation de code Php si le fichier appelé termine par `.php`.

Nous devons maintenant ajouter la directive qui donne à Apache la possibilité d'appeler Php. Dans la configuration, nous allons appeler le module interne de Apache dédié à Php (un handler) via la configuration `SetHandler application/x-httpd-php`. Attention, il ne doit s'activer que si le fichier demandé termine par `.php`; vous devrez utiliser une directive de filtre pour ce faire.

Ajoutez le fichier [main.php](./public/main.php) dans votre navigateur. Si le serveur a bien été paramétré, le code sera interprété et vous verrez le titre "Hello There".

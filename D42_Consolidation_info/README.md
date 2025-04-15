# D42 - Consolidation des compétences en développement informatique

## Écoute et distribution des requêtes HTTP avec Apache

Pour appliquer le concept d'automatisation vus en cours, nous allons créer un pont entre une requête HTTP et un exécutable sur votre ordinateur.

Pour ce faire, nous utiliserons Apache via Docker sur votre machine locale.

Commencez par vérifier l'installation de Docker dans votre espace de travail.
Une fois celui-ci installé si nécessaire, ouvrez une ligne de commande puis créez un dossier `~/Workspace/D42` et ouvrez-le.

Dans ce dossier, lancez un container Apache avec la ligne suivante :
```sh
docker run -d --name apache -p 81:80 \
  -v "./vhosts":/usr/local/apache2/conf/vhosts:ro \
  -v "./public":/usr/local/apache2/htdocs:ro \
  httpd:latest
```

Le dossier `public` va contenir les fichiers "servis" par Apache via le protocole HTTP.
Pour que ce dossier soit accessible en lecture à travers le protocole HTTP, il faut créer une configuration qui autorise Apache à servir ce dossier - pour des raisons de sécurité, aucun dossier n'est exposé par défaut.

Créez le fichier `vhosts/localhost.conf` puis intégrez la configuration du ficher de [configuration joint](./vhosts/localhost.conf).

Rendez-vous sur l'url (http://localhost:81).
Le contenu de votre dossier `public` est maintenant accessible avec le protocole HTTP grâce à Apache.

Pour des raisons évidentes de sécurité, laisser lister le contenu de notre dossier sur le web n'est pas une bonne pratique, désactivez l'affichage du dossier, et référencez une page comme page par défaut si un fichier n'est pas explicitement appelé.

Importez maintenant votre TP du module D12 dans votre dossier `public` et visualisez votre travail dans votre navigateur.

Utilisez maintenant la directive `ErrorDocument` pour personnaliser vos pages d'erreur.

## Création de pages web dynamiques avec Php

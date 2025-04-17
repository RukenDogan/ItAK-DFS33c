# D42 - Consolidation des compétences en développement informatique

Ces exercices ont pour objectif de vous permettre de construire la chaîne de programmes nécessaires à la construction d'une application web simple, accessible depuis un navigateur.

Une partie des instructions suivantes font appel à des notions qui n'ont pas été développées en cours, vous êtes libres de faire appel à la source d'information de votre choix pour vous aider.

## Écoute et distribution des requêtes HTTP avec Apache

Pour appliquer le concept d'automatisation vus en cours, nous allons créer un pont entre une requête HTTP et un exécutable sur votre ordinateur.

Pour ce faire, nous utiliserons Apache via Docker sur votre machine locale.

Commencez par vérifier l'installation de Docker dans votre espace de travail.
Une fois celui-ci installé si nécessaire, ouvrez une ligne de commande puis créez un dossier `Workspace/D42` et ouvrez-le.

Dans ce dossier, lancez un container Apache avec la ligne suivante :
```shell
docker run -d --name apache -p 81:80 \
  -v "$(pwd)/vhosts":/etc/apache2/sites-enabled:ro \
  -v "$(pwd)/public":/var/www/html:ro \
  php:apache
```
Sous Windows, utilisez PowerShell :
```shell
docker run -d --name apache -p 81:80 -v "$(PWD)\vhosts:/etc/apache2/sites-enabled:ro" -v "$(PWD)\public:/var/www/html:ro" php:apache
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

Pour continuer, nous allons utiliser des paramètres d'url pour modifier la page et saluer quelqu'un d'autre.
Accédez à la page [main.php](http://localhost:81/main.php?who=Nyx). Les paramètres passés dans l'url sont disponibles dans la variable superglobale `$_GET`. Utilisez cette variable pour afficher la valeur du paramètre `who` dans le h1.
Intégrez ensuite le code suivant pour contrôler le paramètre du salut grâce aux liens :
```html
<ul>
    <li><a href="https://www.planetegrandesecoles.com/wp-content/uploads/2023/08/anne.jpg.webp">Anne</a></li>
    <li><a href="https://upload.wikimedia.org/wikipedia/commons/3/30/EVA_GREEN_CESAR_2020.jpg">Eva</a></li>
</ul>
```

Utilisez maintenant les paramètres d'url pour afficher les données d'un produit.
Prenez en paramètre le numéro d'un produit, puis affichez les informations produit sur votre page. Vous veillerez à afficher les prix en € et pas en centimes; et à gérer les possibles erreurs.

Tips :
```php
// afficher un sous-éléments d'un objet
<?= $product->title ?>

// accéder à un élément donné d'une collection (un tableau)
$product = $productCollection[1];

// tester si une variable existe et n'est pas vide
if (empty($maVarPeutEtreVide)) {
}

// changer le code de réponse et rediriger vers une autre page
header("HTTP/1.1 XXX .......");
header("Location: url_de_la_page.html");
exit();
```

Reprenez la liste précédente pour afficher des liens vers les informations produits.
Tips :
```php
<li><a href="......"><?= $product->title ?></a>

foreach ($productCollection as $x => $y) {
    var_dump(x, y);
}
```

## Docker multi-container

La bonne pratique avec Docker consiste à créer un container par technologie pour maintenir une isolation des systèmes.
Dans l'exercice précédent, nous avons utilisé Apache et Php mais dans le même container. Nous allons maintenant en utiliser des différents et les faire communiquer.

Afin de créer et gérer facilement plusieurs containers, Docker propose la sous directive `compose` qui permet de définir à l'avance les containers à utiliser via un fichier de configuration.

Pour commencer, créons un dossier `src/` qui va contenir tout le code Php, déplacez-y votre `main.php`.
Créez ensuite votre fichier `docker-compose.yml` à partir du [modèle proposé](./docker-compose.yml) et le fichier `vhost/httpd.conf` à partir de celui proposé [ici](./vhosts/httpd.conf).
Retirez ensuite le handler Php de votre vhost, et détruisez tous vos anciens containers.

Dans le fichier `docker-compose.yml`, créez un service du nom de votre choix basé sur l'image `httpd:latest`.
Référencez lui les mêmes réglages de ports, mais adaptez les volumes pour :
 - ajouter votre fichier `localhost.conf` dans le dossier `/usr/local/apache2/conf/vhosts`
 - ajouter le fichier `httpd.conf` dans le dossier `/usr/local/apache2/conf/`
 - publier le dossier `public` dans le DocumentRoot de votre VHost

Lancez maintenant votre composition avec la commande `docker compose up --build -d`.
Rendez-vous sur votre navigateur pour vérifier si votre installation fonctionne : votre `index.html` doit être accessible à l'adresse http://localhost:81/.

Créons maintenant un container pour exécuter Php dans un environnement isolé.
Basez vous sur l'image `php:8.4-fpm`, et créez un volume avec votre dossier `src` vers `/var/www/html`.
Il va maintenant être nécessaire de dire au container d'Apache d'appeler le container de Php dans le cas où les fichiers requis sont en .php.

Modifiez le fichier `localhost.conf` pour que chaque appel de fichier .php soit soit envoyé au container de Php en utilisant le handler `proxy:fcgi:`. Notez que :
 - Docker publie le nom des containers en tant que nom de domaine à l'intérieur de son réseau interne
 - L'image `php:8.4-fpm` écoute les requêtes sur le port 3000

Exécutez maintenant votre fichier `src/main.php` à travers votre serveur.







# D70 - Git / Github / systèmes de versioning

## Versioning / Problématique du stockage du code / partage

smb:\\DEV\Project\
| config
| \ framework.yaml
| src
|

BitKeeper / SVN / CVS

Gestionnaire de paquets ? Npm / Composer
    Gestion + maj des dépendances : code externe

    npm install got v1.0.*
        dev-master@stable

Semantic Versioning
    v{MAJEURE}.{mineure}.{patch}
                          \ -> correctif de bug :
                                - faille de sécurité
                                - comportement inattendu

                \ -> ajout de fonctionnalités :
                      - fonction supplémentaire
                      - ajouté un titre en rouge
                      - dépréciation

      \ -> refonte, bc-breaks, modification de fonctionnalités
            - retire les fonctions dépréciées
            - changer un sous système

League of Legends

Majeure : changement sur la Map / Objets
Mineure : nouveau champion
Patch : balance / bugfix

```php
<?php

class ...
{
    #[\Deprecated("Will be removed in vX.0, use buildVatPrice instead.")]
    public function calculateVat(float $rating) : float
    {
        return $this
            ->buildVatPrice(new TvaRating($rating))
            ->getPrice()
        ;
    }

    public function buildVatPrice(TvaRating $rating) : TaxedPrice
    {
        return new TaxedPrice(
            $this->price,
            $rating
        );
    }
}

$hash = sha256('mon_mdp'.SALT);

```

"Remote" = dépôts de code
pair-à-pair, distribué

serveur <----   v1.2.1
^
|______   v1.3.0

\- v1.0
\- v2.0

Iteratif

Transactions : +200
               -200 article

## Git / Concepts / Commandes

Programme : ligne de commande

SemVer : v{MAJEURE}.{mineure}.{patch}
Git :    {tag}.{branche}.{commit}
                \v1.0
                        \1.0.5c0496
                        \1.0.5c0496
                        \1.0.5c0496
                        \1.0.5c0496
                        \1.0.5c0496




C1 :
- public function __construct(A $a)
+ public function __construct(B $b)


C1' :
- public function __construct(B $b)
+ public function __construct(A $a)









## Github / Branching model


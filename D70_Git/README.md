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
```





## Git / Concepts / Commandes

## Github / Branching model


# Livrer son travail

1/ Effectuez un fork de ce dépôt en utilisant votre compte @it-students :
- Fork ⏷
- Create a new fork
Vous disposez maintenant de votre propre dépôt dans lequel vous pouvez déposer tout votre code. Veillez à laisser votre dépôt public.

2/ Clonez votre dépôt sur votre machine via HTTPS.
- <> Code ⏷
- HTTPS
- Copiez l'adresse https://github.com/........./ItAK-DFS.....git)

```shell
git clone -b main <url copiée> <nom dossier à créer>
cd <nom dossier à créer>
git remote add prof git@github.com:Nyxis/ItAK-DFS<votre numéro de session>.git
```

Cloner votre dépôt via HTTPS présente un défaut : votre mot de passe est prompt à chaque push, ce qui n'est ni ergonomique ni sécurisant; Github a même déprécié cette authentification.

Pour passer à SSH, nous allons mettre à jour le remote. Retrouvez l'adresse SSH, elle ressemble à `git@github.com:......../ItAK-DFS........git`). Lancez ensuite :
```shell
git remote set-url origin <url copiée>
```

3/ Effectuez les exercices du module dans une branche créée à partir du main du dépôt principal
```shell
# mise à jour du dépot local
git fetch prof

# création de la branche
git branch module_Dxx prof/main
git checkout module_Dxx

# intégration de la version à jour
git pull --rebase prof main
    # résolvez les éventuels conflits
    git add <fichiers de conflits résolus>
    git rebase --continue
git push origin module_Dxx --force
```

4/ Créez un commit avec vos modifications, puis envoyez le à votre dépôt.
```shell
git add <vos fichiers modifiés>
git commit -m "<message de commit>"
git push origin module_Dxx
```

5/ Dans votre dépôt, créez une Pull Request à partir de la branche que vous venez de déposer
- Pull Requests
- New Pull Request
- "compare accross forks"
- Base repository : `Nyxis/ItAK-DFS<votre numéro de session>` / base : `main` / head repository : `<votre fork>` / compare : `main`
- Create pull request
- Title : `Nom Prenom - Code Module`


# FREDI

Projet AP FREDI de 2SIO : 

F.R.E.D.I (Frais de déplacement et remise d'impôt) 
est un logiciel visant à faciliter les démarches admninistratives relatives aux frais de déplacement et aux remises d'impôts.

Ce logiciel s'inscrit dans une continuité du site de la Maison des Ligues Lorraine. 

Suivi de l'organisation et de l'avancement : https://trello.com/b/eRW868V0/organisation

## Table des matieres

1.	Téléchargement et installation
2.	Utilisateur
3.	Log.txt	
4.	Gestion type utilisateur


### 1. Téléchargement et installation 

Téléchargez le projet FREDI via le lien github : [https://github.com/ThomasLandes/FREDI](https://github.com/ThomasLandes/FREDI).
Il faut ensuite unzip le fichier obtenu dans le dossier projets de XAMPP.

Prenez ensuite le fichier ``FREDI/sql/db/fredi.sql`` et importez le dans phpMyAdmin. Le script crée alors la base de données ainsi que les tables associées, les trigger et le 3 utilisateurs. 

### 2. Utilisateur

Il existe 3 types d'utilisateur avec chacun un pseudo, un mail et un mot de passe :

- Adherent, adherent@m2l.com, Adherent31!
- Controleur, controleur@m2l.com, Controleur31!
- Administrateur, administrateur@m2l.com, Administrateur31!

Lors de l'inscription l'utilisateur devient auomatiquement un adherent.
Pour changer le type d'utilisateur il faut le faire manuellement via la table utilisateur, au niveau du champ typeutil dans la bdd : 

1 pour adhérent
2 pour admin
3 pour controleur


### 3. Inscription et connexion 

Lancez l’application en allant dans : ``FREDI/PHP/index.php``
Si vous n’êtes pas connecté (ce qui sera le cas) vous êtes redirigé vers connexion.php. Commencez par créer votre compte en cliquant sur ‘inscrivez-vous’. 
Pour information, le mot de passe doit contenir 8 caractères dont au minimum une majuscule, une minuscule, un chiffre et un caractère spécial.
Retournez ensuite sur la page de connexion et entrez les identifiants saisis lors de l’inscription. ATTENTION!!! Si vous rencontrez un problème, il se peut que votre mot de passe contienne des caractères non supportés, comme "&" .
Vous pouvez maintenant accéder à index.php soit l'accueil de FREDI.

### 4. Log.txt

Une fois connecté chaque fois que vous allez sur une page une trace est enregistrée dans le fichier ``htaccess/log.txt``.



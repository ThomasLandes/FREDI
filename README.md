# FREDI

Projet AP FREDI de 2SIO : 

- F.R.E.D.I (Frais de déplacement et remise d'impôt) 
est un logiciel visant à faciliter les démarches admninistratives relatives aux frais de déplacement et aux remises d'impôts.

Ce logiciel s'inscrit dans une continuité du site de la Maison des Ligues Lorraine. 

Suivi de l'organisation et de l'avancement : https://trello.com/b/eRW868V0/organisation


FREDI
MODE D’EMPLOI



Table des matières
1.	Téléchargement et installation	2
2.	Inscription et connexion	2
3.	Log.txt	2




1.	Téléchargement et installation 

Téléchargez le projet FREDI via le lien github : https://github.com/ThomasLandes/FREDI
Il faut ensuite unzip le fichier obtenu. 

Prenez ensuite le fichier FREDI/sql/db/fredi.sql et importez le dans phpmyadmin. Le script crée alors la base de données ainsi que les tables associées. 

Le projet est prêt à être utilisé. 

2.	Inscription et connexion 

Lancez l’application en allant dans : FREDI/PHP/index.php
Si vous n’êtes pas connecté (ce qui sera le cas) vous êtes redirigé vers connexion.php. Commencez par créer votre compte en cliquant sur ‘inscrivez-vous’. 
Pour information, le mot de passe doit contenir 8 caractères dont au minimum une majuscule, une minuscule, un chiffre et un caractère spécial.
Retournez ensuite sur la page de connexion et entrez les identifiants saisis lors de l’inscription.
Vous pouvez maintenant accéder à index.php

3.	Log.txt

Une fois connecté chaque fois que vous allez sur une page une trace est enregistrée dans le fichier htaccess/log.txt


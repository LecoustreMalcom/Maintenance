# les-devoirs-de-primaire
Site permettant aux enfants en primaire de faire des exercices de maths/français et peut être plus par la suite.

# Installation :
1 - Téléchargez le code

2 - Transférez-le sur un hébergement avec PHP (pas de base de données utilisée)

3 - Après le transfert, dans les répertoires addition, conjugaison_phrase, conjugaison_verbe, dictee, multiplication et soustraction, changez les droits en 777 pour les sous-répertoires logs, resultats et supprime

# Utilisation :
Rendez-vous sur la page d'accueil puis inscrivez vous et connectez vous. Sélectionnez l'exercice à réaliser. 

Pour voir les résultats d'un enfant, rendez-vous sur la page d'accueil, entrez dans l'exercice pour lequel vous voulez les résultats puis, dans la barre d'adresse, modifiez le index.php par affiche_resultat.php

# Rôles des utilisateurs :
- **Enfant** : peut faire des exercices et voir ses propres résultats.
- **Enseignant** : peut voir les résultats de ses élèves.
- **Parent** : peut voir les résultats de ses enfants.


# Changements depuis le début :
1. Création d'un système de connexion avec profil : inclut l'inscription, la connexion et la sauvegarde des différents exercices réalisés avec visualisation de stats sur son profil.
2. Ajout de rôles aux utilisateurs : ajout des rôles enfant, enseignant et parent. Les parents peuvent voir les résultats de leurs enfants. Les enseignants peuvent voir les résultats de leurs élèves. Les enfants peuvent faire des exercices. Les enseignants peuvent configurer les exercices pour les enfants.
3. Utilisation d'une base de données : intégration avec le système de connexion.
4. Amélioration du système d'affichage des résultats : intégration avec les stats sur profil.
5. Prévu : documentation complète du sujet


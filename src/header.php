<?php
// Démarrage de la session
session_start();

// Logique de déconnexion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    // Supprime toutes les variables de session
    session_unset();
    // Détruit la session
    session_destroy();
    // Redirige vers la page d'accueil
    header('Location: /les-devoirs-de-primaire/index.php');
    exit();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <!-- Inclusion des feuilles de style CSS -->
    <link rel="stylesheet" href="/les-devoirs-de-primaire/src/style/style.css">
    <link rel="stylesheet" href="/les-devoirs-de-primaire/src/style/header.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <!-- Lien vers la page d'accueil -->
                <li><a href="/les-devoirs-de-primaire/index.php">Accueil</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-right">
                        <!-- Lien vers la page de profil si l'utilisateur est connecté -->
                        <li><a href="/les-devoirs-de-primaire/src/profil/index.php">Profil</a></li>
                        <li>
                            <!-- Formulaire de déconnexion -->
                            <form action="" method="post" style="display:inline;">
                                <button type="submit" name="logout">Se déconnecter</button>
                            </form>
                        </li>
                    </div>
                <?php else: ?>
                    <!-- Lien vers la page de connexion si l'utilisateur n'est pas connecté -->
                    <li><a href="/les-devoirs-de-primaire/src/login/index.php">Connexion</a></li>
                    <!-- Lien vers la page d'inscription si l'utilisateur n'est pas connecté -->
                    <li><a href="/les-devoirs-de-primaire/src/register/index.php">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
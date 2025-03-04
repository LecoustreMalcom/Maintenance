<?php
session_start();

// Logique de déconnexion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /les-devoirs-de-primaire/index.php');
    exit();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/les-devoirs-de-primaire/src/style/style.css">
    <link rel="stylesheet" href="/les-devoirs-de-primaire/src/style/header.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/les-devoirs-de-primaire/index.php">Accueil</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav-right">
                        <li><a href="/les-devoirs-de-primaire/src/profil/index.php">Profil</a></li>
                        <li>
                            <form action="" method="post" style="display:inline;">
                                <button type="submit" name="logout">Se déconnecter</button>
                            </form>
                        </li>
                    </div>
                <?php else: ?>
                    <li><a href="/les-devoirs-de-primaire/src/login/index.php">Connexion</a></li>
                    <li><a href="/les-devoirs-de-primaire/src/register/index.php">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
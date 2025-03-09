<?php
// Inclut le fichier bdd.php pour la connexion à la base de données
require '../bdd.php';
// Inclut le fichier header.php
require '../header.php';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère le nom d'utilisateur et le mot de passe du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prépare et exécute une requête pour récupérer l'utilisateur correspondant au nom d'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Vérifie si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user->password)) {
        // Stocke les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role;
        // Redirige vers la page d'accueil
        header('Location: ../../index.php');
        exit();
    } else {
        // Affiche un message d'erreur si le nom d'utilisateur ou le mot de passe est incorrect
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('../../public/images/NO.jpg');background-size:cover;background-repeat:no-repeat;">
                    <center>
                        <div class="container">
                            <h1>Connexion</h1>
                            <!-- Affiche un message d'erreur si les informations de connexion sont incorrectes -->
                            <?php if (isset($error)): ?>
                                <p class="error"><?php echo $error; ?></p>
                            <?php endif; ?>
                            <!-- Formulaire de connexion -->
                            <form method="post">
                                <label for="username">Nom d'utilisateur:</label>
                                <input type="text" id="username" name="username" required>
                                <label for="password">Mot de passe:</label>
                                <input type="password" id="password" name="password" required>
                                <button type="submit">Se connecter</button>
                            </form>
                        </div>
                    </center>
                </td>
                <td style="width:280px;height:430px;background-image:url('../../public/images/NE.jpg');background-size:cover;background-repeat:no-repeat;"></td>
            </tr>
            <tr>
                <td style="width:1000px;height:323px;background-image:url('../../public/images/SO.jpg');background-size:cover;background-repeat:no-repeat;"></td>
                <td style="width:280px;height:323px;background-image:url('../../public/images/SE.jpg');background-size:cover;background-repeat:no-repeat;"></td>
            </tr>
        </table>
    </center>
    <br />
    <footer>
        <center>
            Rémi Synave<br />
            Contact : remi . synave @ univ - littoral [.fr]<br />
            Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
            Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
        </center>
    </footer>
</body>
</html>
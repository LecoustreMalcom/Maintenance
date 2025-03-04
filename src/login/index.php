<?php
require '../bdd.php';
require '../header.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user->password)) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role;
        header('Location: ../../index.php');
        exit();
    } else {
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
                            <?php if (isset($error)): ?>
                                <p class="error"><?php echo $error; ?></p>
                            <?php endif; ?>
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
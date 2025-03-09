<?php
    // Démarre la mise en tampon de sortie
    @ob_start();
    
    // Inclut le fichier utils.php pour utiliser ses fonctions
    include 'utils.php';
    
    // Inclut le fichier header.php
    require '../header.php';

    // Enregistre l'adresse IP de l'utilisateur dans un fichier de log
    log_adresse_ip("logs/log.txt", "fin.php - " . $_SESSION['prenom']);

    // Définit l'origine de la session comme "fin"
    $_SESSION['origine'] = "fin";

    // Inclut le fichier bdd.php pour la connexion à la base de données
    require '../bdd.php';

    // Enregistre l'historique des réponses dans un fichier
    $_SESSION['prenom'] = strtolower($_SESSION['prenom']);
    $_SESSION['prenom'] = supprime_caracteres_speciaux($_SESSION['prenom']);
    $today = date('Ymd-His');
    $history_link = '../addition/resultats/' . $_SESSION['prenom'] . '-addition-' . $today . '.txt';
    $fp = fopen($history_link, 'w');
    $_SESSION['historique'] = $_SESSION['historique'] . '' . $_SESSION['nbBonneReponse'];
    fwrite($fp, $_SESSION['historique']);
    fclose($fp);

    // Enregistre les résultats dans la base de données
    $stmt = $pdo->prepare("INSERT INTO results (user_id, exercise, correct, total, history_link) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], 'addition', $_SESSION['nbBonneReponse'], $_SESSION['nbQuestion'], $history_link]);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Fin de la série</title>
</head>
<body style="background-color:grey;">
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                    <center>
                        <?php
                        // Affiche le nombre de bonnes réponses et de questions
                        if ($_SESSION['nbBonneReponse'] > 1)
                            echo '<h2>Fin du test.</h2>Tu as ' . $_SESSION['nbBonneReponse'] . ' bonnes réponses sur ' . $_SESSION['nbQuestion'] . ' questions.';
                        else
                            echo '<h2>Fin du test.</h2>Tu as ' . $_SESSION['nbBonneReponse'] . ' bonne réponse sur ' . $_SESSION['nbQuestion'] . ' questions.';

                        // Affiche une médaille ou un message en fonction du score
                        if ($_SESSION['nbBonneReponse'] >= $_SESSION['nbMaxQuestions'] * 0.8) {
                            echo '<h3>Félicitations !</h3>';
                            echo '<img src="./images/medailleOr.png" width="100px"><br />';
                        } else {
                            if ($_SESSION['nbBonneReponse'] >= $_SESSION['nbMaxQuestions'] * 0.6) {
                                echo '<h3>Très bien !</h3>';
                                echo '<img src="./images/medailleArgent.png" width="100px"><br />';
                            } else {
                                if ($_SESSION['nbBonneReponse'] >= $_SESSION['nbMaxQuestions'] * 0.4) {
                                    echo '<h3>Super !</h3>';
                                    echo '<img src="./images/medailleBronze.png" width="100px"><br />';
                                } else {
                                    echo '<h3>Recommence. Tu peux faire mieux !</h3>';
                                    echo '<img src="./images/smileyTriste.png" width="100px"><br />';
                                }
                            }
                        }
                        ?>
                        <!-- Formulaire pour recommencer le test -->
                        <form action="./index.php" method="post">
                            <input type="submit" value="Recommencer" autofocus>
                        </form>
                    </center>
                </td>
                <td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td>
            </tr>
            <tr>
                <td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td>
                <td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td>
            </tr>
        </table>
    </center>
    <br />
    <footer style="background-color: #45a1ff;">
        <center>
            Rémi Synave<br />
            Contact : remi . synave @ univ - littoral [.fr]<br />
            Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
            et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5213756">Pixabay</a> <br />
        </center>
    </footer>
</body>
</html>
<?php
    @ob_start();
    include 'utils.php';
    log_adresse_ip("logs/log.txt","index.php");

    require '../header.php';
    $_SESSION['nbMaxQuestions']=10;
    $_SESSION['nbQuestion']=0;
    $_SESSION['nbBonneReponse']=0;
    $_SESSION['historique']="";
    $_SESSION['origine']="index";

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login/index.php');
        exit();
    }

    $username = $_SESSION['username'];
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Accueil</title>
    </head>
    <body style="background-color:grey;">
        <center>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                        <center>
                            <h1>Bonjour, <?php echo htmlspecialchars($username); ?> !</h1><br />
                            <h2>Nous allons faire du calcul mental. Tu devras faire <?php echo ''.$_SESSION['nbMaxQuestions'].'' ?> calculs.</h2><br />
                            <form action="./question.php" method="post">
                                <input type="submit" value="Commencer" autofocus>
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
<?php
require 'src/bdd.php';
include 'src/header.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Accueil</title>
	<link rel="stylesheet" href="src/style/header.css">
</head>
<body style="background-color:grey;">
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('public/images/NO.jpg');background-repeat:no-repeat;">
                    <center>
                        <h1>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
                        <h2>Que veux-tu faire ?</h2>
                        <table border="1" cellpadding="15" style="border-collapse:collapse;border: 15px solid #ff7700;background-color:#d6d6d6;">
                            <tr>
                                <td><center><a href="src/addition/index.php" style="color:black;font-weight:bold;text-decoration:none"><img src="public/images/addition.png"><br />Addition</a></center></td>
                                <td><center><a href="src/soustraction/index.php" style="color:black;font-weight:bold;text-decoration:none"><img src="public/images/soustraction.png"><br />Soustraction</a></center></td>
                                <td><center><a href="src/multiplication/index.php" style="color:black;font-weight:bold;text-decoration:none"><img src="public/images/multiplication.png"><br />Multiplication</a></center></td>
                            </tr>
                            <tr>
                                <td><center><a href="src/dictee/index.php" style="color:black;font-weight:bold;text-decoration:none"><img src="public/images/dictee.png"><br />Dictée</a></center></td>
                                <td><center><a href="src/conjugaison_verbe/index.php" style="color:black;font-weight:bold;text-decoration:none"><img src="public/images/conjugaison_verbe.png"><br />Conjugaison<br />de verbes</a></center></td>
                                <td><center><a href="src/conjugaison_phrase/index.php" style="color:black;font-weight:bold;text-decoration:none"><img src="public/images/conjugaison_phrase.png"><br />Conjugaison<br />de phrases</a></center></td>
                            </tr>
                        </table>
                    </center>
                </td>
                <td style="width:280px;height:430px;background-image:url('public/images/NE.jpg');background-repeat:no-repeat;"></td>
            </tr>
            <tr>
                <td style="width:1000px;height:323px;background-image:url('public/images/SO.jpg');background-repeat:no-repeat;"></td>
                <td style="width:280px;height:323px;background-image:url('public/images/SE.jpg');background-repeat:no-repeat;"></td>
            </tr>
        </table>
    </center>
    <br />
    <footer style="background-color: #45a1ff;">
        <center>
            Rémi Synave<br />
            Contact : remi . synave @ univ - littoral [.fr]<br />
            Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
            Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
        </center>
    </footer>
</body>
</html>
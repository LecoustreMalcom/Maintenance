<?php
require '../bdd.php';
require '../header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $children_usernames = isset($_POST['children_usernames']) ? explode(',', $_POST['children_usernames']) : [];

    // Rechercher les IDs des enfants à partir de leurs noms d'utilisateur
    $children_ids = [];
    foreach ($children_usernames as $child_username) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([trim($child_username)]);
        $child = $stmt->fetch();
        if ($child) {
            $children_ids[] = $child->id;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);
    $parent_id = $pdo->lastInsertId();

    // Sauvegarder les relations parent-enfant
    foreach ($children_ids as $child_id) {
        $stmt = $pdo->prepare("INSERT INTO parent_child (parent_id, child_id) VALUES (?, ?)");
        $stmt->execute([$parent_id, $child_id]);
    }

    header('Location: ../login/index.php');
    exit();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style/style.css">
    <script>
        function toggleChildrenUsernames() {
            var role = document.getElementById('role').value;
            var childrenUsernamesContainer = document.getElementById('children_usernames_container');
            if (role === 'parent') {
                childrenUsernamesContainer.style.display = 'block';
            } else {
                childrenUsernamesContainer.style.display = 'none';
            }
        }
    </script>
</head>
<body onload="toggleChildrenUsernames()">
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('../../public/images/NO.jpg');background-size:cover;background-repeat:no-repeat;">
                    <center>
                        <div class="container">
                            <h1>Inscription</h1>
                            <form method="post">
                                <label for="username">Nom d'utilisateur:</label>
                                <input type="text" id="username" name="username" required>
                                <label for="password">Mot de passe:</label>
                                <input type="password" id="password" name="password" required>
                                <label for="role">Rôle:</label>
                                <select id="role" name="role" required onchange="toggleChildrenUsernames()">
                                    <option value="enfant">Enfant</option>
                                    <option value="enseignant">Enseignant</option>
                                    <option value="parent">Parent</option>
                                </select>
                                <div id="children_usernames_container" style="display:none;">
                                    <label for="children_usernames">Noms d'utilisateur des enfants (séparés par des virgules):</label>
                                    <input type="text" id="children_usernames" name="children_usernames">
                                </div>
                                <button type="submit">S'inscrire</button>
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
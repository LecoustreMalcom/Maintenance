<?php
// Inclut le fichier bdd.php pour la connexion à la base de données
require '../bdd.php';
// Inclut le fichier header.php
require '../header.php';

$error_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère les données du formulaire
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $classe = isset($_POST['classe']) ? $_POST['classe'] : null;
    $children_usernames = isset($_POST['children_usernames']) ? explode(',', $_POST['children_usernames']) : [];

    // Vérifie si le nom d'utilisateur existe déjà
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user_exists = $stmt->fetchColumn();

    if ($user_exists) {
        // Affiche un message d'erreur si le nom d'utilisateur existe déjà
        $error_message = "Le nom d'utilisateur existe déjà. Veuillez en choisir un autre.";
    } else {
        // Rechercher les IDs des enfants à partir de leurs noms d'utilisateur
        $children_ids = [];
        foreach ($children_usernames as $child_username) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([trim($child_username)]);
            $child = $stmt->fetch();
            if ($child) {
                $children_ids[] = $child['id'];
            }
        }

        // Insère le nouvel utilisateur dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, classe) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $role, $classe]);
        $parent_id = $pdo->lastInsertId();

        // Sauvegarde les relations parent-enfant
        foreach ($children_ids as $child_id) {
            $stmt = $pdo->prepare("INSERT INTO parent_child (parent_id, child_id) VALUES (?, ?)");
            $stmt->execute([$parent_id, $child_id]);
        }

        // Redirige vers la page de connexion
        header('Location: ../login/index.php');
        exit();
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style/style.css">
    <script>
        // Fonction pour afficher ou masquer les champs en fonction du rôle sélectionné
        function toggleChildrenUsernames() {
            var role = document.getElementById('role').value;
            var childrenUsernamesContainer = document.getElementById('children_usernames_container');
            var classContainer = document.getElementById('class_container');
            if (role === 'parent') {
                childrenUsernamesContainer.style.display = 'block';
                classContainer.style.display = 'none';
            } else {
                childrenUsernamesContainer.style.display = 'none';
                classContainer.style.display = 'block';
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
                            <!-- Affiche un message d'erreur si le nom d'utilisateur existe déjà -->
                            <?php if ($error_message): ?>
                                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                            <?php endif; ?>
                            <!-- Formulaire d'inscription -->
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
                                <div id="class_container" style="display:none;">
                                    <label for="classe">Classe:</label>
                                    <select id="classe" name="classe">
                                        <option value="CP">CP</option>
                                        <option value="CE1">CE1</option>
                                        <option value="CE2">CE2</option>
                                        <option value="CM1">CM1</option>
                                        <option value="CM2">CM2</option>
                                    </select>
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
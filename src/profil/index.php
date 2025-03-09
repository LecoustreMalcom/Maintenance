<?php
// Inclut le fichier bdd.php pour la connexion à la base de données
require '../bdd.php';
// Inclut le fichier header.php
require '../header.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ../login/index.php');
    exit();
}

$user_id = (int)$_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur a été trouvé
if (!$user) {
    echo "Utilisateur non trouvé.";
    exit();
}

// Récupérer les statistiques des exercices
$stats = [];
$exercises = ['addition', 'soustraction', 'multiplication', 'dictee', 'conjugaison_verbe', 'conjugaison_phrase'];
if ($user['role'] !== 'parent' && $user['role'] !== 'enseignant') {
    foreach ($exercises as $exercise) {
        // Prépare et exécute une requête pour récupérer les résultats de l'utilisateur pour chaque exercice
        $stmt = $pdo->prepare("SELECT id, correct, total, created_at, history_link FROM results WHERE user_id = ? AND exercise = ? ORDER BY created_at ASC");
        $stmt->execute([$user_id, $exercise]);
        $stats[$exercise] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Si l'utilisateur est un parent, récupérer les enfants et leurs statistiques
$children_stats = [];
if ($user['role'] === 'parent') {
    // Récupère les IDs des enfants de l'utilisateur
    $stmt = $pdo->prepare("SELECT child_id FROM parent_child WHERE parent_id = ?");
    $stmt->execute([$user_id]);
    $children_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($children_ids as $child_id) {
        // Récupère le nom d'utilisateur de chaque enfant
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$child_id]);
        $child_username = $stmt->fetchColumn();

        $child_stats = [];
        foreach ($exercises as $exercise) {
            // Prépare et exécute une requête pour récupérer les résultats de chaque enfant pour chaque exercice
            $stmt = $pdo->prepare("SELECT id, correct, total, created_at, history_link FROM results WHERE user_id = ? AND exercise = ? ORDER BY created_at ASC");
            $stmt->execute([$child_id, $exercise]);
            $child_stats[$exercise] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $children_stats[$child_username] = $child_stats;
    }
}

// Si l'utilisateur est un enseignant, récupérer les enfants de sa classe et leurs statistiques
$class_children_stats = [];
$class_children = [];
if ($user['role'] === 'enseignant') {
    // Récupère les enfants de la classe de l'enseignant
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE classe = ? AND role = 'enfant'");
    $stmt->execute([$user['classe']]);
    $class_children = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['selected_child'])) {
        $selected_child_id = $_POST['selected_child'];
        // Récupère le nom d'utilisateur de l'enfant sélectionné
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ? AND role = 'enfant'");
        $stmt->execute([$selected_child_id]);
        $selected_child_username = $stmt->fetchColumn();

        $child_stats = [];
        foreach ($exercises as $exercise) {
            // Prépare et exécute une requête pour récupérer les résultats de l'enfant sélectionné pour chaque exercice
            $stmt = $pdo->prepare("SELECT id, correct, total, created_at, history_link FROM results WHERE user_id = ? AND exercise = ? ORDER BY created_at ASC");
            $stmt->execute([$selected_child_id, $exercise]);
            $child_stats[$exercise] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $class_children_stats[$selected_child_username] = $child_stats;
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" href="../style/header.css">
    <link rel="stylesheet" href="../style/profil.css">
</head>
<body>
    <main>
        <h1>Profil de <?php echo htmlspecialchars($user['username']); ?></h1>

        <?php if ($user['role'] !== 'parent' && $user['role'] !== 'enseignant'): ?>
            <h2>Statistiques des exercices</h2>
            <?php foreach ($stats as $exercise => $attempts): ?>
                <h3><?php echo ucfirst($exercise); ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Essai</th>
                            <th>Note</th>
                            <th>NoteMax</th>
                            <th>Historique</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attempts as $index => $attempt): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $attempt['correct']; ?></td>
                                <td><?php echo $attempt['total']; ?></td>
                                <td><a href="affiche_historique.php?file=<?php echo urlencode($attempt['history_link']); ?>" target="_blank">Lien</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($user['role'] === 'parent'): //Si l'user a le rôle parent, affiche ses enfants ?>
            <h2>Statistiques des enfants</h2>
            <?php foreach ($children_stats as $child_username => $child_stats): ?>
                <h3>Enfant: <?php echo htmlspecialchars($child_username); ?></h3>
                <?php foreach ($child_stats as $exercise => $attempts): ?>
                    <h4><?php echo ucfirst($exercise); ?></h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Essai</th>
                                <th>Note</th>
                                <th>NoteMax</th>
                                <th>Historique</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attempts as $index => $attempt): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $attempt['correct']; ?></td>
                                    <td><?php echo $attempt['total']; ?></td>
                                    <td><a href="affiche_historique.php?file=<?php echo urlencode($attempt['history_link']); ?>" target="_blank">Lien</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($user['role'] === 'enseignant'): //Si l'user a le rôle enseignant, peut choisir parmis les enfants de sa classe pour afficher le résultat ?>
            <h2>Statistiques des enfants de la classe</h2>
            <form method="post">
                <label for="selected_child">Choisir un élève:</label>
                <select id="selected_child" name="selected_child">
                    <?php foreach ($class_children as $child): ?>
                        <option value="<?php echo $child['id']; ?>"><?php echo htmlspecialchars($child['username']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Soumettre</button>
            </form>

            <?php if (!empty($class_children_stats)): ?>
                <?php foreach ($class_children_stats as $child_username => $child_stats): ?>
                    <h3>Enfant: <?php echo htmlspecialchars($child_username); ?></h3>
                    <?php foreach ($child_stats as $exercise => $attempts): ?>
                        <h4><?php echo ucfirst($exercise); ?></h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Essai</th>
                                    <th>Note</th>
                                    <th>NoteMax</th>
                                    <th>Historique</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attempts as $index => $attempt): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $attempt['correct']; ?></td>
                                        <td><?php echo $attempt['total']; ?></td>
                                        <td><a href="affiche_historique.php?file=<?php echo urlencode($attempt['history_link']); ?>" target="_blank">Lien</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>
</html>
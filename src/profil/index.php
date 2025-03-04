<?php
require '../bdd.php';
require '../header.php';

if (!isset($_SESSION['username'])) {
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
if ($user['role'] !== 'parent') {
    foreach ($exercises as $exercise) {
        $stmt = $pdo->prepare("SELECT id, correct, total, created_at, history_link FROM results WHERE user_id = ? AND exercise = ? ORDER BY created_at ASC");
        $stmt->execute([$user_id, $exercise]);
        $stats[$exercise] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Si l'utilisateur est un parent, récupérer les enfants et leurs statistiques
$children_stats = [];
if ($user['role'] === 'parent') {
    $stmt = $pdo->prepare("SELECT child_id FROM parent_child WHERE parent_id = ?");
    $stmt->execute([$user_id]);
    $children_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($children_ids as $child_id) {
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$child_id]);
        $child_username = $stmt->fetchColumn();

        $child_stats = [];
        foreach ($exercises as $exercise) {
            $stmt = $pdo->prepare("SELECT id, correct, total, created_at, history_link FROM results WHERE user_id = ? AND exercise = ? ORDER BY created_at ASC");
            $stmt->execute([$child_id, $exercise]);
            $child_stats[$exercise] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $children_stats[$child_username] = $child_stats;
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" href="../style/header.css">
</head>
<body>
    <main>
        <h1>Profil de <?php echo htmlspecialchars($user['username']); ?></h1>

        <?php if ($user['role'] !== 'parent'): ?>
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

        <?php if ($user['role'] === 'parent'): ?>
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
    </main>
</body>
</html>
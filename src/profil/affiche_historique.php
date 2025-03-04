<?php
// filepath: /s:/taff_mal/But3/SAE/les-devoirs-de-primaire-main/les-devoirs-de-primaire/src/profil/affiche_historique.php
session_start();
require '../bdd.php';
require '../header.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../login/index.php');
    exit();
}

if (!isset($_GET['file'])) {
    echo "Aucun fichier spécifié.";
    exit();
}

$file = $_GET['file'];
$file_path = '../addition/resultats/' . basename($file);

if (!file_exists($file_path)) {
    echo "Fichier non trouvé.";
    exit();
}

$content = file_get_contents($file_path);

// Parse the content
$lines = explode("\n", trim($content));
$rows = [];
foreach ($lines as $line) {
    if (strpos($line, '********') === 0) {
        $parts = explode('=', $line);
        $question = trim($parts[0], '*');
        $answers = explode(';', $parts[1]);
        $given_answer = isset($answers[0]) ? trim($answers[0]) : '';
        $correct_answer = isset($answers[1]) ? trim($answers[1]) : '';
        $rows[] = ['question' => $question, 'given_answer' => $given_answer, 'correct_answer' => $correct_answer];
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Historique</title>
    <link rel="stylesheet" href="../style/header.css">
    <link rel="stylesheet" href="../style/historique.css">
</head>
<body>
    <main>
        <h1>Historique</h1>
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Réponse donnée</th>
                    <th>Bonne réponse</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['question']); ?></td>
                        <td><?php echo htmlspecialchars($row['given_answer']); ?></td>
                        <td><?php echo htmlspecialchars($row['correct_answer']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
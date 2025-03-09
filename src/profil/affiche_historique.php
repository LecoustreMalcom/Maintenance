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

// Vérifie si un fichier a été spécifié
if (!isset($_GET['file'])) {
    echo "Aucun fichier spécifié.";
    exit();
}

$file = $_GET['file'];
$basename = basename($file);

// Extraire le type d'exercice du nom de fichier
$parts = explode('-', $basename);
if (count($parts) < 2) {
    echo "Nom de fichier invalide.";
    exit();
}
$exercise_type = $parts[1];

$file_path = "../$exercise_type/resultats/" . $basename;

// Vérifie si le fichier existe
if (!file_exists($file_path)) {
    echo "Fichier non trouvé.";
    exit();
}

$content = file_get_contents($file_path);

// Parse le contenu du fichier
$lines = explode("\n", trim($content));
$rows = [];
foreach ($lines as $line) {
    // Ignorer les lignes vides et la note à la fin du fichier
    if (empty(trim($line)) || is_numeric(trim($line))) {
        continue;
    }

    // Traite les lignes en fonction du type d'exercice
    if (strpos($line, '********') === 0 || strpos($line, '******') !== false || $exercise_type === 'conjugaison_phrase' || $exercise_type === 'dictee') {
        if ($exercise_type === 'conjugaison_verbe') {
            $parts = explode(';', $line);
            $question = trim($parts[0], '*');
            $given_answer = isset($parts[0]) ? trim($parts[0], '*') : '';
            $correct_answer = isset($parts[1]) ? trim($parts[1]) : '';
            $rows[] = ['question' => $question, 'given_answer' => $given_answer, 'correct_answer' => $correct_answer];
        } elseif ($exercise_type === 'conjugaison_phrase') {
            $parts = explode(';', $line);
            $question = trim($parts[0]);
            $given_answer = isset($parts[1]) ? trim($parts[1]) : '';
            $correct_answer = ''; // Pas de bonne réponse dans le fichier
            $is_correct = strpos($line, '******') === false;
            $rows[] = ['question' => $question, 'given_answer' => $given_answer, 'correct_answer' => $correct_answer, 'is_correct' => $is_correct];
        } elseif ($exercise_type === 'dictee') {
            $parts = explode(';', $line);
            $question = ''; // Pas de question dans le fichier de dictée
            $given_answer = isset($parts[0]) ? trim($parts[0], '*') : '';
            $correct_answer = isset($parts[1]) ? trim($parts[1]) : '';
            $is_correct = strpos($parts[0], '********') === false;
            $rows[] = ['question' => $question, 'given_answer' => $given_answer, 'correct_answer' => $correct_answer, 'is_correct' => $is_correct];
        } else {
            $parts = explode('=', $line);
            $question = trim($parts[0], '*');
            $answers = explode(';', $parts[1]);
            $given_answer = isset($answers[0]) ? trim($answers[0]) : '';
            $correct_answer = isset($answers[1]) ? trim($answers[1]) : '';
            $rows[] = ['question' => $question, 'given_answer' => $given_answer, 'correct_answer' => $correct_answer];
        }
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
                    <th>Correction</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['question']); ?></td>
                        <td><?php echo htmlspecialchars($row['given_answer']); ?></td>
                        <td><?php echo htmlspecialchars($row['correct_answer']); ?></td>
                        <td>
                            <?php if ($exercise_type === 'conjugaison_phrase' || $exercise_type === 'dictee'): ?>
                                <?php if ($row['is_correct']): ?>
                                    <span class="checkmark-positive">&#10004;</span>
                                <?php else: ?>
                                    <span class="checkmark-negative">&#10008;</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if (empty($row['correct_answer']) || $row['given_answer'] === $row['correct_answer']): ?>
                                    <span class="checkmark-positive">&#10004;</span>
                                <?php else: ?>
                                    <span class="checkmark-negative">&#10008;</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
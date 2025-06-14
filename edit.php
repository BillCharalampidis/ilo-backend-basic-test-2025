<?php

header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');

if (mb_strlen($title, 'UTF-8') < 3) {
    echo json_encode(['success' => false, 'error' => 'Ο τίτλος πρέπει να έχει τουλάχιστον 3 χαρακτήρες.']);
    exit;
}

$file = 'tasks.json';
$tasks = [];

if (file_exists($file)) {
    $json = file_get_contents($file);
    $tasks = json_decode($json, true);
    if (!is_array($tasks)) {
        $tasks = [];
    }
}
$updated = false;

foreach ($tasks as &$task) {
    if ((int)$task['id'] === $id) {
        $task['title'] = $title;
        $task['description'] = $description;
        $updated = true;
        break;
    }
}
unset($task);

// Αποθήκευση αν έγινε ενημέρωση
if ($updated) {
    file_put_contents($file, json_encode($tasks, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
    exit;
} else {
    echo json_encode(['success' => false, 'error' => 'Task δεν βρέθηκε.']);
    exit;
}

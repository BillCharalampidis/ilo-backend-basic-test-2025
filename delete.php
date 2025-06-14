<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$file = 'tasks.json';
$tasks = [];

if (file_exists($file)) {
    $json = file_get_contents($file);
    $tasks = json_decode($json, true);
}

$tasks = array_filter($tasks, function ($task) use ($id) {
    return $task['id'] !== $id;
});

// Ανακατασκευή πίνακα για συνεχή indexes
$tasks = array_values($tasks);

file_put_contents($file, json_encode($tasks, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

header('Content-Type: application/json');
echo json_encode(['success' => true, 'id' => $id]);

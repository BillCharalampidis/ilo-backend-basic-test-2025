<?php
//Λήψη ID από το URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$file = 'tasks.json';
$tasks =[];
//Aνάγνωση δεδομένων από το αρχείο Json
if (file_exists($file)){
    $json = file_get_contents($file);
    $tasks = json_decode($json, true);
}
//Αλλαγή του Is_Done για το συγκεκριμένο task
foreach($tasks as &$task){
    if ($task['id'] === $id){
        $task['is_done'] = !$task['is_done'];
        break;
    }
}
unset($task);

file_put_contents($file, json_encode($tasks,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
//Επιστροφή του ενημερωμένου task ως JSON
header('Content-Type: application/json');
echo json_encode(['success' => true,'id' => $id]);
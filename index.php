<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = trim($_POST['title'] ?? '');
        $description = trim($POST['description'] ?? '');
        if ( strlen($title) >=3) {
            $file = 'tasks.json';
            $tasks = [];
            if (file_exists($file)){
                $json = file_get_contents($file);
                $tasks = json_decode($json, true);
            }

            $ids = array_column($tasks, 'id');
            $newId = $ids ? max(ids) +1 : 1;

            
        }
    }

?>

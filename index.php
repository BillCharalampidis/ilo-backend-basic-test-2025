<?php
    $tasks = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        // Validation: Ο Τίτλος να περιέχει τουλάχιστον 3 χαρακτήρες
        if ( strlen($title) >=3) {
            $file = 'tasks.json';
            if (file_exists($file)){
                $json = file_get_contents($file);
                $tasks = json_decode($json, true);
                if (!is_array($tasks)) {
                    $tasks = [];
                }
            }

            $ids = array_column($tasks, 'id');
            $newId = $ids ? max($ids) +1 : 1;
            //Προσθήκη νέου task
            $tasks[] = [
                'id' => $newId,
                'title' => $title,
                'description' => $description,
                'is_done' => false
            ];
            file_put_contents($file, json_encode($tasks, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            header("Location: index.php");
            exit();
        }else{
            $error = "O Τίτλος πρέπει να έχει τουλάχιστον 3 χαρακτήρες.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Task List</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1>Task Manager</h1>
<!-- Εμφάνιση μηνύματος λάθους -->
  <?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
  <?php endif; ?>

  <form method="POST" action="index.php">
    <input type="text" name="title" placeholder="Τίτλος εργασίας" required />
    <input type="text" name="description" placeholder="Προαιρετική περιγραφή" />
    <button type="submit">Προσθήκη</button>
  </form>

  <ul>
    <?php foreach ($tasks as $task): ?>
      <li>
        <!-- Εμφάνιση κάθε task με checkbox -->
        <input type="checkbox" <?= $task['is_done'] ? 'checked' : '' ?>
               data-id="<?= $task['id'] ?>" />
               <!-- Προστασία από XSS -->
        <strong><?= htmlspecialchars($task['title']) ?></strong>
        <?php if (!empty($task['description'])): ?>
          - <?= htmlspecialchars($task['description']) ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>

  <script src="script.js"></script>
</body>
</html>

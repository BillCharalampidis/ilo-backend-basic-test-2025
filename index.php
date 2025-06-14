<?php
    $tasks = [];
    $file = 'tasks.json';
    $error = '';
    if (file_exists($file)){
        $json = file_get_contents($file);
        $tasks = json_decode($json, true);
        if (!is_array($tasks)) {
            $tasks = [];
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        // Validation: Ο Τίτλος να περιέχει τουλάχιστον 3 χαρακτήρες
        if ( mb_strlen($title, 'UTF-8') >=3) {
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
            //Redirect σε index.php
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
  <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST" action="index.php">
    <input type="text" name="title" placeholder="Τίτλος εργασίας" required />
    <input type="text" name="description" placeholder="Προαιρετική περιγραφή" />
    <button type="submit">Προσθήκη</button>
  </form>
  <?php 
?>
  <ul>
    <?php foreach ($tasks as $task): ?>
      <li data-id="<?= $task['id'] ?>">
        <!-- Εμφάνιση κάθε task με checkbox -->
        <input type="checkbox" <?= $task['is_done'] ? 'checked' : '' ?>
               data-id="<?= $task['id'] ?>" />             
               <!-- Προστασία από XSS -->
               <strong class="title"><?= htmlspecialchars($task['title']) ?></strong>
               <?php if (!empty($task['description'])): ?>
              <span class="description"><?= htmlspecialchars($task['description']) ?></span>
               <?php endif; ?>

        <!-- Κουμπί για edit task -->
        <button class="edit-btn" data-id="<?= $task['id'] ?>">✏️</button>
         <!-- Κουμπί για διαγραφή task -->
        <button class="delete-btn" data-id="<?= $task['id'] ?>">✖️</button>
         <!--Φόρμα για edit task-->
        <form class="edit-form" style="display:none;">
      <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required />
      <input type="text" name="description" value="<?= htmlspecialchars($task['description']) ?>" />
      <input type="hidden" name="id" value="<?= $task['id'] ?>">
      <button type="submit">Save</button>
      <button type="button" class="cancel-btn">Cancel</button>
    </form>
      </li>
    <?php endforeach; ?>
  </ul>

<script src="script.js"></script>
</body>

</html>

<?php
include 'db.php'; // Menghubungkan ke database

// Menambahkan tugas baru
if (isset($_POST['save_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $query = "INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $description, $status]);

    // Redirect setelah menambahkan tugas
    header('Location: index.php');
    exit();
}

// Menghapus tugas berdasarkan ID
if (isset($_GET['delete_id'])) {
    $task_id = $_GET['delete_id'];
    $query = "DELETE FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$task_id]);

    // Redirect setelah menghapus tugas
    header('Location: index.php');
    exit();
}

// Mengupdate tugas berdasarkan ID
if (isset($_POST['update_task'])) {
    $task_id = $_POST['task_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $query = "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $description, $status, $task_id]);

    // Redirect setelah mengupdate tugas
    header('Location: index.php');
    exit();
}

// Mengambil data tugas
$query = "SELECT * FROM tasks";
$stmt = $pdo->query($query);
$tasks = $stmt->fetchAll();

// Mengambil tugas yang akan diedit berdasarkan ID
if (isset($_GET['edit_id'])) {
    $task_id = $_GET['edit_id'];
    $query = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$task_id]);
    $task_to_edit = $stmt->fetch();
}
?>
